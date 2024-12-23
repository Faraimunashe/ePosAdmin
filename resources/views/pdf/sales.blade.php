<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Canteen Sales Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 2px solid #ddd;
            background-color: #f4f4f4;
        }

        .header h1 {
            font-size: 28px;
            margin: 5px 0;
        }

        .header h2 {
            font-size: 20px;
            margin: 0;
            color: #555;
        }

        .currency-totals {
            display: grid; /* Use grid layout */
            grid-template-columns: repeat(3, 1fr); /* Create three equal-width columns */
            gap: 20px; /* Add spacing between rows and columns */
            margin: 20px;
        }

        .currency-card {
            background-color: #fff;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .currency-card h3 {
            font-size: 18px;
            margin: 5px 0;
            color: #333;
        }

        .currency-card p {
            font-size: 16px;
            margin: 5px 0;
            color: #555;
        }

        .details {
            margin: 20px;
            font-size: 16px;
        }

        .details p {
            margin: 5px 0;
        }

        .details .strong {
            font-weight: bold;
        }

        .report-table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
        }

        .report-table th,
        .report-table td {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 10px;
            text-align: left;
            vertical-align: top;
        }

        .report-table th {
            background-color: #f4f4f4;
            font-size: 10px;
            font-weight: bold;
        }

        .report-table td .items-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .report-table td .items-list li {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .report-table tbody tr:hover {
            background-color: #f9f9f9;
        }

        .footer {
            text-align: right;
            font-size: 14px;
            margin: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            color: #777;
        }

    </style>
</head>
<body>
    <div class="header">
        <h1>Midlands State University</h1>
        <h2>Canteen Sales Report</h2>
    </div>

    <div class="details">
        <p><span class="strong">Report Date Range:</span> {{ $start_date ?? 'N/A' }} - {{ $end_date ?? 'N/A' }}</p>
        <p><span class="strong">Generated By:</span> {{ $generated_by ?? 'System' }}</p>
        <p><span class="strong">Date Generated:</span> {{ now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <div class="currency-totals">
        @foreach ($totals as $total)
            <div class="currency-card">
                <h3>{{ $total->currency }}</h3>
                <p>${{ number_format($total->total_amount, 2) }}</p>
            </div>
        @endforeach
    </div>

    <table class="report-table">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Items</th>
                <th>Amount</th>
                <th>Type</th>
                <th>Cashier</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->reference }}</td>
                    <td>
                        <ul class="items-list">
                            @foreach ($sale->items as $item)
                                <li title="{{ $item->item->name ?? 'Unknown Item' }} ({{ $item->qty }} × {{ $item->unit_price }})">
                                    <strong>{{ $item->item->name ?? 'Unknown Item' }}</strong>
                                    {{ $item->qty }} × {{ $item->unit_price }}
                                </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $sale->currency }} {{ number_format($sale->amount, 2) }}</td>
                    <td>{{ $sale->type }}</td>
                    <td>{{ $sale->name ?? 'N/A' }}</td>
                    <td>{{ $sale->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Generated by Midlands State University Canteen System</p>
    </div>
</body>
</html>
