<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <title> VOICE COMMAND </title>
</head>

<body>

    <div class="container mt-5 mb-5">

        <h3 id="titleHeader"> CARI LAGU APA? </h3>
        {{-- <button id="button"> click </button> --}}
        <hr>
        <button class="btn record" id="record">
            <div class="icon">
                <ion-icon name="mic-outline" style="display: block" id="standbyIcon"></ion-icon>
                <img src="{{ asset('bars.svg') }}" alt="no image" id="mendengarkanIcon" style="display: none; height: 40px;"/>
            </div>
            <p class="mt-3 ms-2">Mulai dengarkan</p>
        </button>

        <h4 class="mt-5 mb-5" spellcheck="false" id="result"></h4>
        <input type="hidden" id="hiddenOutput">

        <small style="font-size: 11px; font-style: italic;"> saran: </small>
        <ul>
            <li style="font-size: 13px;"> putar lagu justin bieber baby </li>
        </ul>

    </div>

    <section id="iframe">

    </section>

</body>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="module" src="{{ asset('js/ionicons.esm.js') }}"></script>
<script nomodule src="{{ asset('js/ionicons.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main.js') }}"></script>

</html>
