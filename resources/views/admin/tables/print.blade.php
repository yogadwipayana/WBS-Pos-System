<!DOCTYPE html>
<html>
<head>
    <title>QR Meja {{ $table->number }}</title>
</head>
<body onload="window.print()">

    <h2>Meja {{ $table->number }}</h2>

    {!! $qrCode !!}

</body>
</html>
