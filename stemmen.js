// script.js

// Initialisatie van stemresultaten
let stemmen = {
    partijA: 0,
    partijB: 0,
    partijC: 0,
    partijD: 0,
    partijE: 0,
    partijF: 0,
    partijG: 0,
    partijH: 0,
    partijI: 0,
    partijJ: 0,
    partijK: 0,
};

// Functie om te stemmen
function vote(partij) {
    stemmen[partij]++;
    updateResults();
}

// Functie om de resultaten bij te werken
function updateResults() {
    document.getElementById('partijA').innerText = stemmen.partijA;
    document.getElementById('partijB').innerText = stemmen.partijB;
    document.getElementById('partijC').innerText = stemmen.partijC;
    document.getElementById('partijD').innerText = stemmen.partijD;
    document.getElementById('partijE').innerText = stemmen.partijE;
    document.getElementById('partijF').innerText = stemmen.partijF;
    document.getElementById('partijG').innerText = stemmen.partijG;
    document.getElementById('partijH').innerText = stemmen.partijH;
    document.getElementById('partijI').innerText = stemmen.partijI;
    document.getElementById('partijJ').innerText = stemmen.partijJ;
    document.getElementById('partijK').innerText = stemmen.partijK;
}