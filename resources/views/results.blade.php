<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Results</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #4CAF50;
        }
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        .chart-container {
            width: 300px;
            height: 300px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .results-container {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .results-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .results-container table th, .results-container table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .results-container table th {
            background-color: #4CAF50;
            color: white;
        }
        .results-container table td {
            background-color: #f9f9f9;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: flex-start;
            }
            .chart-container, .results-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <h1>Voting Results</h1>

    @if ($results->isEmpty())
        <p style="text-align: center; color: #f44336;">No votes have been cast yet!</p>
    @else
        <div class="container">
            <!-- Pie chart container -->
            <div class="chart-container">
                <canvas id="resultChart"></canvas>
            </div>

            <!-- Voting results table -->
            <div class="results-container">
                <h3>Votes per Fruit</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Fruit</th>
                            <th>Total Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($results as $result)
                            <tr>
                                <td>{{ $result->fruit }}</td>
                                <td>{{ $result->total_score }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <script>
            const ctx = document.getElementById('resultChart').getContext('2d');

            const resultData = {
                labels: @json($results->pluck('fruit')),
                datasets: [{
                    label: 'Total Votes',
                    data: @json($results->pluck('total_score')),
                    backgroundColor: ['#FF5733', '#FF8C00', '#FFC300', '#28A745', '#007BFF']
                }]
            };

            new Chart(ctx, {
                type: 'pie',
                data: resultData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        </script>
    @endif
</body>
</html>
