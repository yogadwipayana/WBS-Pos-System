<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            padding: 20px;
            font-size: 14px;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            border-bottom: 2px dashed #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: uppercase;
        }

        .header p {
            font-size: 14px;
            color: #666;
        }

        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info-group {
            margin-bottom: 10px;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
            color: #444;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .items-table th {
            text-align: left;
            border-bottom: 2px solid #ddd;
            padding: 10px 5px;
            font-size: 12px;
            text-transform: uppercase;
        }

        .items-table td {
            padding: 10px 5px;
            border-bottom: 1px solid #eee;
        }

        .items-table .qty-col {
            width: 10%;
            text-align: center;
        }

        .items-table .item-col {
            width: 50%;
        }

        .items-table .price-col {
            width: 20%;
            text-align: right;
        }

        .items-table .total-col {
            width: 20%;
            text-align: right;
        }

        .totals-section {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            margin-top: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        .total-row {
            display: flex;
            justify-content: flex-end;
            width: 100%;
            margin-bottom: 5px;
        }

        .total-label {
            font-weight: bold;
            margin-right: 20px;
            text-align: right;
        }

        .total-value {
            width: 120px;
            text-align: right;
        }

        .grand-total {
            font-size: 18px;
            font-weight: bold;
            color: #000;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 2px dashed #000;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #888;
            border-top: 1px dotted #ccc;
            padding-top: 20px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            background: #eee;
            border-radius: 12px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            margin-left: 10px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Warung Bali Sangeh</h1>
        <p>Jl. Raya Sangeh No. 123, Abiansemal</p>
        <p>Telp: (0361) 123456</p>
    </div>

    <div class="receipt-info">
        <div>
            <div class="info-group">
                <span class="info-label">Order No:</span>
                <span>#{{ $order->order_number }}</span>
            </div>
            <div class="info-group">
                <span class="info-label">Date:</span>
                <span>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</span>
            </div>
        </div>
        <div style="text-align: right;">
            <div class="info-group">
                <span class="info-label">Customer:</span>
                <span>{{ $order->customer_name }}</span>
            </div>
            <div class="info-group">
                <span class="info-label">Type:</span>
                <span style="text-transform: capitalize;">{{ $order->order_type }}</span>
            </div>
        </div>
    </div>

    <table class="items-table">
        <thead>
            <tr>
                <th class="qty-col">Qty</th>
                <th class="item-col">Item</th>
                <th class="price-col">Price</th>
                <th class="total-col">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->orderItems as $item)
                <tr>
                    <td class="qty-col">{{ $item->quantity }}</td>
                    <td class="item-col">
                        <div style="font-weight: bold;">{{ $item->product_name }}</div>
                    </td>
                    <td class="price-col">{{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="total-col">{{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals-section">
        <div class="total-row grand-total">
            <span class="total-label">Total Amount:</span>
            <span class="total-value">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
        <div class="total-row" style="margin-top: 5px; font-size: 12px; color: #666;">
            <span class="total-label">Payment Status:</span>
            <span style="width: 120px; text-align: right; text-transform: uppercase;">PAID</span>
        </div>
    </div>

    <div class="footer">
        <p>Thank you for your visit!</p>
        <p>Please come again.</p>
        <p style="margin-top: 10px; font-size: 10px;">Generated on {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</body>

</html>
