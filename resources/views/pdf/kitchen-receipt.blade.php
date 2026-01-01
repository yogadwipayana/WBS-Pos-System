<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kitchen Order - {{ $order->order_number }}</title>
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
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        
        .header h1 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 16px;
            color: #666;
        }
        
        .order-info {
            background: #f5f5f5;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .order-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
        }
        
        .info-label {
            font-weight: bold;
            color: #333;
        }
        
        .info-value {
            color: #666;
        }
        
        .order-number {
            font-size: 24px;
            font-weight: bold;
            color: #f05a28;
            text-align: center;
            margin: 15px 0;
            padding: 10px;
            background: #fff3e0;
            border-radius: 8px;
        }
        
        .items-section {
            margin-top: 25px;
        }
        
        .items-header {
            background: #333;
            color: white;
            padding: 10px;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        .items-table th {
            background: #f5f5f5;
            padding: 12px;
            text-align: left;
            font-weight: bold;
            border-bottom: 2px solid #ddd;
        }
        
        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
        }
        
        .items-table tr:last-child td {
            border-bottom: none;
        }
        
        .item-name {
            font-weight: bold;
            font-size: 15px;
        }
        
        .item-qty {
            font-size: 18px;
            font-weight: bold;
            color: #f05a28;
            text-align: center;
        }
        
        .notes-section {
            margin-top: 25px;
            padding: 15px;
            background: #fffbea;
            border-left: 4px solid #f05a28;
            border-radius: 4px;
        }
        
        .notes-label {
            font-weight: bold;
            margin-bottom: 5px;
            color: #333;
        }
        
        .notes-content {
            color: #666;
            font-style: italic;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            border-top: 2px dashed #ccc;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
        
        .priority-badge {
            display: inline-block;
            padding: 5px 15px;
            background: #ff5252;
            color: white;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-left: 10px;
        }
        
        .table-badge {
            display: inline-block;
            padding: 8px 20px;
            background: #4caf50;
            color: white;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .takeaway-badge {
            display: inline-block;
            padding: 8px 20px;
            background: #2196f3;
            color: white;
            border-radius: 25px;
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>WARUNG BALI SANGEH</h1>
        <p>Kitchen Order</p>
    </div>
    
    <div class="order-number">
        ORDER #{{ $order->order_number }}
    </div>
    
    <div class="order-info">
        <div class="order-info-grid">
            <div class="info-item">
                <span class="info-label">Pelanggan:</span>
                <span class="info-value">{{ $order->customer_name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tanggal:</span>
                <span class="info-value">{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Tipe Order:</span>
                <span class="info-value">{{ ucfirst($order->order_type) }}</span>
            </div>
            @if($order->order_type === 'dine-in' && $order->table_number)
            <div class="info-item">
                <span class="info-label">No. Meja:</span>
                <span class="info-value">
                    <span class="table-badge">MEJA {{ $order->table_number }}</span>
                </span>
            </div>
            @endif
            @if($order->order_type === 'takeaway')
            <div class="info-item">
                <span class="info-label"></span>
                <span class="info-value">
                    <span class="takeaway-badge">TAKEAWAY</span>
                </span>
            </div>
            @endif
        </div>
    </div>
    
    <div class="items-section">
        <div class="items-header">
            ITEMS TO PREPARE
        </div>
        
        <table class="items-table">
            <thead>
                <tr>
                    <th style="width: 10%;">QTY</th>
                    <th style="width: 60%;">ITEM</th>
                    <th style="width: 30%;">CATEGORY</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td class="item-qty">{{ $item->quantity }}x</td>
                    <td class="item-name">{{ $item->product->name }}</td>
                    <td>{{ $item->product->category->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    @if($order->notes)
    <div class="notes-section">
        <div class="notes-label">📝 CATATAN KHUSUS:</div>
        <div class="notes-content">{{ $order->notes }}</div>
    </div>
    @endif
    
    <div class="footer">
        <p>Printed: {{ now()->format('d/m/Y H:i:s') }}</p>
        <p>Thank you for your service! 🍽️</p>
    </div>
</body>
</html>
