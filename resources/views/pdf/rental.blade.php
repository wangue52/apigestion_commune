<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Details</title>
</head>
<body>
    <h1>Rental Details</h1>

    <table>
        <tr>
            <th>Client Name:</th>
            <td>{{ $rental->client_name }}</td>
        </tr>
        <tr>
            <th>Store Matricule:</th>
            <td>{{ $rental->store_matricule }}</td>
        </tr>
        <tr>
            <th>Store Name:</th>
            <td>{{ $rental->store_name }}</td>
        </tr>
        <tr>
            <th>Store Address:</th>
            <td>{{ $rental->store_address }}</td>
        </tr>
        <tr>
            <th>Period Location:</th>
            <td>{{ $rental->period_location }}</td>
        </tr>
        <tr>
            <th>Rental Date:</th>
            <td>{{ $rental->rental_date }}</td>
        </tr>
        <tr>
            <th>Price Store:</th>
            <td>{{ $rental->price_store }}</td>
        </tr>
    </table>
    <img src="{{ $qrCode }}" alt="Rental QR Code">
</body>
</html>