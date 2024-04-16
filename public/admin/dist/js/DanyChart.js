const ctx = document.getElementById('mychart').getContext('2d');

const barchart = new Chart(ctx, {
    type : "bar",
    data : {

        //LE LABELS POUR LES ABSCISSES DU GRAPHE
        /*labels: ['JANVIER', 'FEVRIER', 'MARS', 'AVRIL', 'MAI', 'JUIN', 'JUILLET', 'AOUT', 'SEPTEMBRE', 'OCTOBRE', 'NOVEMBRE', 'DECEMBRE'],
        datasets: [{
            label: 'Recettes',
            data: @json($data),
            backgroundColor: ["crimson", "lightgreen", "lightblue", "blue", "crimson", "lightgreen", "lightblue", "blue", "crimson", "lightgreen", "lightblue", "blue"],
        }]*/
    }
})