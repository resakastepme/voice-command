const recordBtn = document.querySelector("#record"),
    result = document.querySelector("#result")

let SpeechRecognition =
    window.SpeechRecognition || window.webkitSpeechRecognition,
    recognition,
    recording = false;

function soundcloud(text) {
    $.ajax({
        url: '/voice',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            text: text
        }, success: function (response) {
            if (response.result == 'ID tidak ditemukan.') {
                console.log('ID tidak ditemukan.');
            } else {
                console.log('berhasil');
                $('#iframe').html('');
                $('#iframe').html('<iframe width="100%" height="500" scrolling="no" frameborder="no" allow="autoplay"\
                src="https://w.soundcloud.com/player/?url=https%3A//api.soundcloud.com/tracks/'+ response.result + '&color=%23ff5500&auto_play=true\
                &visual=true"></iframe>');
            }
        }
    })

}

function speechToText() {
    try {
        recognition = new SpeechRecognition();
        recognition.lang = 'id';
        recognition.interimResults = true;
        recordBtn.classList.add("recording");
        recordBtn.querySelector("p").innerHTML = "Mendengar...";
        $('#mendengarkanIcon').show();
        $('#standbyIcon').hide();
        $('#hiddenOutput').val('');
        recognition.start();
        recognition.onresult = (event) => {
            const speechResult = event.results[0][0].transcript;
            $('#result').html('');
            result.innerHTML += " " + speechResult;
            $('#hiddenOutput').val(speechResult);
            // downloadBtn.disabled = false;
        };
        recognition.onspeechend = () => {
            speechToText();
        };
        recognition.onerror = (event) => {
            stopRecording();
            if (event.error === "no-speech") {
                console.log("Tidak ada kata terdengar, berhenti mendengar...");
                $('#result').html('');
                if ($('#hiddenOutput').val() != '') {
                    soundcloud($('#hiddenOutput').val());
                }
                $('#standbyIcon').show();
                $('#mendengarkanIcon').hide();
            } else if (event.error === "audio-capture") {
                alert("Microphone tidak terdeteksi.");
                $('#result').html('');
                $('#standbyIcon').show();
                $('#mendengarkanIcon').hide();
            } else if (event.error === "not-allowed") {
                alert("Akses microphone tidak diberikan.");
                $('#result').html('');
                $('#standbyIcon').show();
                $('#mendengarkanIcon').hide();
            } else if (event.error === "aborted") {
                console.log('Berhenti mendengar..');
                $('#result').html('');
                if ($('#hiddenOutput').val() != '') {
                    soundcloud($('#hiddenOutput').val());
                }
                $('#standbyIcon').show();
                $('#mendengarkanIcon').hide();
            } else {
                alert("Error: " + event.error);
                $('#result').html('');
                $('#standbyIcon').show();
                $('#mendengarkanIcon').hide();
            }
        };
    } catch (error) {
        recording = false;

        console.log(error);

        $('#standbyIcon').show();
        $('#mendengarkanIcon').hide();
    }
}

// $(document).ready(function () {
//     setTimeout( ()=>{
//         $('#record').click();
//     }, 1000)
// })

recordBtn.addEventListener("click", () => {
    if (!recording) {
        speechToText();
        recording = true;
    } else {
        stopRecording();
    }
});

function stopRecording() {
    recognition.stop();
    recordBtn.querySelector("p").innerHTML = "Mulai dengarkan";
    recordBtn.classList.remove("recording");
    recording = false;
}
