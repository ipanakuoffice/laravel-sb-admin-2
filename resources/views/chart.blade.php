<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chart Dosis vs Tegangan</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div style="width: 80%; margin: 50px auto;">
        <canvas id="myChart"></canvas>
    </div>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line', // Jenis chart (line chart)
            data: {
                labels: @json($tegangan), // Data sumbu X (tegangan)
                datasets: [{
                    label: 'Dosis',
                    data: @json($dosis), // Data sumbu Y (dosis)
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Tegangan (V)'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Dosis (mg)'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
