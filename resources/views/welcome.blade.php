<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title>Starbucks API</title>
    <style>
    .center-center {
        margin: auto;
        width: 100%;
        text-align: center;
    }

    img {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 25%;
    }
    </style>
</head>

<body>
    <main class="center-center">
        <h1>✨☕️ Starbucks API ☕️✨</h1>
        <p>This is API only, get out of here.</p>
        <img src="https://upload.wikimedia.org/wikipedia/pt/1/12/Nicki_Minaj_-_Starships.jpg" alt="Starbucks" />
        <p style="font-size: 1.5rem; font-style: italic; color: #666">{{ $quote }}</p>
    </main>
</body>

</html>