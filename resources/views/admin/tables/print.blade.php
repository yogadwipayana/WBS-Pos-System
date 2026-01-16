<!DOCTYPE html>
<html>

<head>
    <title>QR Meja {{ $table->number }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .print-container {
            background: white;
            width: 350px;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 2px solid #e5e7eb;
        }

        .header {
            margin-bottom: 20px;
        }

        .title {
            font-size: 24px;
            font-weight: 800;
            color: #1f2937;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0;
        }

        .subtitle {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
        }

        .table-number {
            font-size: 48px;
            font-weight: 900;
            color: #111827;
            margin: 20px 0;
            padding: 10px;
            background-color: #f9fafb;
            border-radius: 10px;
            border: 2px dashed #d1d5db;
        }

        .qr-wrapper {
            margin: 30px 0;
            display: flex;
            justify-content: center;
        }

        .instructions {
            margin-top: 30px;
            text-align: left;
            background-color: #fefff5;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .step {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 14px;
            color: #374151;
        }

        .step-icon {
            width: 24px;
            height: 24px;
            background-color: #10b981;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
            font-size: 12px;
            flex-shrink: 0;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }

        @media print {
            body {
                background: white;
            }

            .print-container {
                box-shadow: none;
                border: 1px solid #000;
                width: 100%;
                max-width: 100%;
                border-radius: 0;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>

    <div class="print-container">
        <div class="header">
            <h1 class="title">Scan Menu</h1>
            <p class="subtitle">Order makanan tanpa antri</p>
        </div>

        <div class="table-number">
            MEJA {{ $table->number }}
        </div>

        <div class="qr-wrapper">
            {!! $qrCode !!}
        </div>

        <div class="instructions">
            <div class="step">
                <div class="step-icon">1</div>
                <div>Buka kamera HP anda</div>
            </div>
            <div class="step">
                <div class="step-icon">2</div>
                <div>Scan QR Code di atas</div>
            </div>
            <div class="step">
                <div class="step-icon">3</div>
                <div>Pilih menu & pesan</div>
            </div>
        </div>

        <div class="footer">
            <p>&copy; {{ date('Y') }} E-WBS Resto. Selamat Menikmati.</p>
        </div>
    </div>

    <script>
        // Auto print after a short delay to allow rendering
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>

</html>
