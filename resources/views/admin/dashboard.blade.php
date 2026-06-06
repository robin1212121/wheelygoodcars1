@extends('layouts.app')

@section('content')

<div class="container">

    <h1 class="mb-4">📊 Live Dashboard</h1>

    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Totaal auto's</h6>
                    <h2 id="totalCars">0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Verkocht</h6>
                    <h2 id="soldCars">0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Beschikbaar</h6>
                    <h2 id="availableCars">0</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Vandaag toegevoegd</h6>
                    <h2 id="todayCars">0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Aanbieders</h6>
                    <h2 id="totalSellers">0</h2>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <h6>Gemiddeld per aanbieder</h6>
                    <h2 id="avgCars">0</h2>
                </div>
            </div>
        </div>

    </div>

    <div class="card mb-4">
        <div class="card-body">

            <h5>Verkooppercentage</h5>

            <div class="progress" style="height:40px;">
                <div
                    id="progressBar"
                    class="progress-bar bg-success"
                    role="progressbar"
                    style="width:0%">
                    0%
                </div>
            </div>

        </div>
    </div>

    <div class="card">
        <div class="card-body">

            <canvas id="salesChart"></canvas>

        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

let chart;

async function loadDashboard() {

    const response = await fetch('/admin/dashboard-data');
    const data = await response.json();

    document.getElementById('totalCars').innerText = data.totalCars;
    document.getElementById('soldCars').innerText = data.soldCars;
    document.getElementById('availableCars').innerText = data.availableCars;
    document.getElementById('todayCars').innerText = data.todayCars;
    document.getElementById('totalSellers').innerText = data.totalSellers;
    document.getElementById('avgCars').innerText = data.avgCarsPerSeller;

    const bar = document.getElementById('progressBar');

    bar.style.width = data.soldPercent + '%';
    bar.innerText = data.soldPercent + '%';

    if (!chart) {

        chart = new Chart(
            document.getElementById('salesChart'),
            {
                type: 'doughnut',
                data: {
                    labels: ['Verkocht', 'Beschikbaar'],
                    datasets: [{
                        data: [
                            data.soldCars,
                            data.availableCars
                        ]
                    }]
                }
            }
        );

    } else {

        chart.data.datasets[0].data = [
            data.soldCars,
            data.availableCars
        ];

        chart.update();
    }
}

loadDashboard();

setInterval(loadDashboard, 10000);

</script>

@endsection