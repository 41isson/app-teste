<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Monitoramento do tempo</title>
</head>
<body>
    <header>
        <div class="breadcrumb">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="geolocalizacao.php">GeoLocalização</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Tempo</li>
                </ol>
            </nav>
        </div>
    </header>

    <main>
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" id="openModal" data-toggle="modal" data-target="#exampleModal">
            Abrir modal
        </button>
        <div>
            <canvas id="myChart"></canvas>
        </div>
    </main>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Informações climatológicas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Adicionamos uma tabela aqui -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Data</th>
                                <th>Temperatura Máxima</th>
                                <th>Temperatura Mínima</th>
                            </tr>
                        </thead>
                        <tbody id="data-table-body">
                            <!-- As linhas da tabela serão inseridas aqui dinamicamente -->
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <script>
        var myChart = null;
        var chartData = {dates: [], tempMax: [], tempMin: []}; // Armazena dados do gráfico

        function carregaDash(dates, tempMax, tempMin) {
            var elemento = document.getElementById("myChart");

            if (elemento) {
                if (myChart) {
                    myChart.destroy();
                }

                chartData = {dates, tempMax, tempMin}; // Atualiza dados do gráfico

                const data = {
                    labels: dates,
                    datasets: [{
                        label: 'Temperatura Máxima',
                        backgroundColor: 'rgba(255, 99, 132, 0.5)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1,
                        data: tempMax,
                        barPercentage: 0.5,
                        categoryPercentage: 0.8
                    }, {
                        label: 'Temperatura Mínima',
                        backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        data: tempMin,
                        barPercentage: 0.5,
                        categoryPercentage: 0.8
                    }]
                };

                myChart = new Chart(elemento, {
                    type: 'bar',
                    data: data,
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                stacked: true,
                                title: {
                                    display: true,
                                    text: 'Datas'
                                }
                            },
                            y: {
                                stacked: true,
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Temperatura (°C)'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.dataset.label + ': ' + tooltipItem.raw;
                                    }
                                }
                            }
                        },
                        onClick: function(event) {
                            const points = myChart.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);
                            if (points.length) {
                                const firstPoint = points[0];
                                const dataIndex = firstPoint.index;
                                const date = myChart.data.labels[dataIndex];
                                const tempMax = myChart.data.datasets[0].data[dataIndex];
                                const tempMin = myChart.data.datasets[1].data[dataIndex];
                                mostrarDadosNoModal(date, tempMax, tempMin);
                            }
                        }
                    }
                });
            } else {
                console.error("Elemento com ID 'myChart' não encontrado.");
            }
        }

        async function getApiData() {
            const url = "http://localhost/api/public/tempo";
            try {
                const response = await fetch(url);

                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }

                const data = await response.json();
                const forecast = data.results.forecast;
                const dates = forecast.map(f => f.date);
                const tempMax = forecast.map(f => f.max);
                const tempMin = forecast.map(f => f.min);
                
                carregaDash(dates, tempMax, tempMin);
                return data.results;
                
            } catch (error) {
                console.error("Erro ao buscar dados:", error.message);
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            getApiData();
        });

        function mostrarDadosNoModal(date, tempMax, tempMin) {
            const dataElement = document.getElementById('data-table-body');
            dataElement.innerHTML = '';

            // Criar uma linha da tabela para os dados
            const row = document.createElement('tr');

            // Criar células da tabela
            const dateCell = document.createElement('td');
            dateCell.textContent = date;
            row.appendChild(dateCell);

            const maxCell = document.createElement('td');
            maxCell.textContent = tempMax;
            row.appendChild(maxCell);

            const minCell = document.createElement('td');
            minCell.textContent = tempMin;
            row.appendChild(minCell);

            // Adicionar a linha ao corpo da tabela
            dataElement.appendChild(row);

            // Mostrar o modal
            $('#exampleModal').modal('show');
        }
    </script>
</body>
</html>
