<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landelijke Verkiezingen</title>
    <link rel="stylesheet" href="homepage.css">
</head>
<body>
    <div class="container">
        <h1>Stem op jouw partij - Landelijke Verkiezingen</h1>

        <p>Kies een partij en stem hieronder:</p>

        <div class="vote-section">
            <button class="vote-btn" onclick="vote('partijA')">VVD</button>
            <button class="vote-btn" onclick="vote('partijB')">PVV</button>
            <button class="vote-btn" onclick="vote('partijC')">D66</button>
            <button class="vote-btn" onclick="vote('partijD')">Groenlinks</button>
            <button class="vote-btn" onclick="vote('partijE')">PVDA</button>
            <button class="vote-btn" onclick="vote('partijF')">Denk</button>
            <button class="vote-btn" onclick="vote('partijG')">CDA</button>
            <button class="vote-btn" onclick="vote('partijH')">BBB</button>
            <button class="vote-btn" onclick="vote('partijI')">SP</button>
            <button class="vote-btn" onclick="vote('partijJ')">FVD</button>
            <button class="vote-btn" onclick="vote('partijK')">NSC</button>
            
        </div>

        <div id="results">
            <h2>Stemresultaten</h2>
            <p>VVD <span id="partijA">0</span> stemmen</p>
            <p>PVV: <span id="partijB">0</span> stemmen</p>
            <p>D66: <span id="partijC">0</span> stemmen</p>
            <p>Groenlinks: <span id="partijD">0</span> stemmen</p>
            <p>PVDA: <span id="partijE">0</span> stemmen</p>
            <p>Denk: <span id="partijF">0</span> stemmen</p>
            <p>CDA: <span id="partijG">0</span> stemmen</p>
            <p>BBB: <span id="partijH">0</span> stemmen</p>
            <p>SP: <span id="partijI">0</span> stemmen</p>
            <p>FVD: <span id="partijJ">0</span> stemmen</p>
            <p>NSC: <span id="partijK">0</span> stemmen</p>

            
        </div>
    </div>

    <script src="stemmen.js"></script>
</body>
</html>