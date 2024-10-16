// script.js

// Initialisatie van stemresultaten
let stemmen = {
    partijA: 0,
    partijB: 0,
    partijC: 0
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
}