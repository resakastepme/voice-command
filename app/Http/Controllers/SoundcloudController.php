<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SoundcloudController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function filterSearchKeywords($text)
    {
        $filteredWords = array(',', '.', 'putar lagu', 'terbaru');
        $text = preg_replace('/\s+/', ' ', $text);
        $text = strtolower($text);
        foreach ($filteredWords as $word) {
            $text = str_ireplace($word, '', $text);
        }
        $text = trim($text);
        return $text;
    }

    function searchSoundCloud($filteredResult)
    {
        $apiKey = "0085b5768fmsh3c25bba1b4e1ef4p1dafcbjsn722daefdb749";
        $apiUrl = "https://soundcloud-scraper.p.rapidapi.com/v1/search/tracks?term=" . urlencode($filteredResult);
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: soundcloud-scraper.p.rapidapi.com",
                "X-RapidAPI-Key: $apiKey"
            ],
        ]);
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);
        $responseData = json_decode($response, true);
        if (isset($responseData['tracks']['items'][0]['id'])) {
            return $responseData['tracks']['items'][0]['id'];
        } else {
            return "ID tidak ditemukan.";
        }
    }

    public function idvoice()
    {
        $speechToTextResult = $_POST['text'];
        $filteredResult = $this->filterSearchKeywords($speechToTextResult);
        // echo "Hasil Setelah Disaring: " . $filteredResult;
        $trackId = $this->searchSoundCloud($filteredResult);
        // echo "<br>ID dari hasil pencarian: " . $trackId;
        return response()->json([
            'result' => $trackId
        ]);
    }
}
