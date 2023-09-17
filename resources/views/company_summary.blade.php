<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/css/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="m-8">
    <div class="flex justify-center my-8">
        <h2 class="pr-8">{{ $name }}: {{ $startDate }} to {{ $endDate }}</h2>
        <a href="/" class="text-blue-500">Change company</a>
    </div>
    <div class="flex mx-auto">
        <canvas id="myChart" style="position: relative; height:40vh; width:80vw">
        </canvas>
    </div>
    <div class="flex mx-auto">
        <div class="overflow-x-auto mx-auto shadow-lg sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Date
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Open
                    </th>
                    <th scope="col" class="px-6 py-3">
                        High
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Low
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Close
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Volume
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($prices as $price)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           {{ $price['date'] }}
                        </th>
                        @foreach(['open', 'high', 'low', 'close', 'volume'] As $field)
                        <td class="px-6 py-4">
                            {{ isset($price[$field]) ? number_format((float)$price[$field], 2, '.', '') : 'N/A'}}
                        </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
<script>
document.addEventListener("DOMContentLoaded", function() {
    var labels = <?php echo json_encode(array_column($prices, 'date')); ?>;
    var high = <?php echo json_encode(array_column($prices, 'high')); ?>;
    var low = <?php echo json_encode(array_column($prices, 'low')); ?>;
    const ctx = document.getElementById('myChart').getContext('2d');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'High',
                data: high,
                borderColor: 'red',
                borderWidth: 1,
                fill: false
            }, {
                label: 'Low',
                data: low,
                borderColor: 'blue',
                borderWidth: 1,
                fill: false
            }]
        }
    });
});
</script>
</body>
</html>



