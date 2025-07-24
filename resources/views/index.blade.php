<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fruit Voting System</title>
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
            margin-bottom: 20px;
            font-size: 24px;
        }
        .container {
            display: flex;
            justify-content: space-between;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        .form-container, .results-container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 45%; /* Adjust width for side-by-side */
        }
        .form-container {
            flex: 1;
        }
        .results-container {
            flex: 1;
        }
        .form-container input, .form-container select, .form-container button {
            width: 100%;
            padding: 8px;
            margin: 8px 0;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        .form-container button {
            background-color: #4CAF50;
            color: white;
            border: none;
        }
        .form-container button:hover {
            background-color: #45a049;
        }
        .results-container table {
            width: 100%;
            border-collapse: collapse;
        }
        .results-container table th, .results-container table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
        }
        .results-container table th {
            background-color: #4CAF50;
            color: white;
        }
        .results-container table td {
            background-color: #f9f9f9;
        }
        .chart-container {
            width: 100%;
            height: 250px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
            .form-container, .results-container {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<h1>Vote for Your Favorite Fruit (1-5)</h1>

<div class="container">
    <!-- Form container -->
    <div class="form-container">
        @if(session('error'))
        <div style="color: red; text-align: center; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
        @endif
        <form method="POST" action="{{ route('submit') }}">
            @csrf
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required><br><br>

            @foreach($fruits as $fruit)
                <label>{{ $fruit }}:</label>
                <select name="votes[{{ $fruit }}]" required>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                </select><br><br>
            @endforeach

            <button type="submit">Submit Vote</button>
        </form>
    </div>

    <!-- Results container -->
    <div class="results-container">
        <h2>Voting Results</h2>
        @if ($results->isEmpty())
            <p style="text-align: center; color: #f44336;">No votes yet!</p>
        @else
            <!-- Chart container -->
            <div class="chart-container">
                <canvas id="resultChart"></canvas>
            </div>

            <h3>Votes by Fruit</h3>
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
        @endif
    </div>
</div>

<script>
    const ctx = document.getElementById('resultChart').getContext('2d');

    const resultData = {
        labels: @json($results->pluck('fruit')),
        datasets: [{
            label: 'Total Score',
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

</body>
</html>
