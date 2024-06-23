<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental Details</title>
    <style>
        body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f4f4f4;
  color: #333;
}
h1 {
  text-align: center;
  margin-top: 20px;
  color: #333;
}
table {
  width: 80%;
  margin: 20px auto;
  border-collapse: collapse;
  background-color: #fff;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  border-radius: 5px;
}
th, td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #ddd;
}
th {
  background-color: #f2f2f2;
  font-weight: bold;
}
img {
  display: block;
  margin: 20px auto;
  max-width: 200px;
}
footer {
  text-align: center;
  margin-top: 20px;
  padding: 10px 0;
  background-color: #eee;
  color: #666;
}
/* Styles pour la version imprimable */
@media print {
  body {
    background-color: #fff;
  }
  table {
    font-size: 12px;
  }
  img {
    max-width: 150px;
  }
  footer {
    position: fixed;
    bottom: 0;
    width: 100%;
  }
}
    </style>
</head>
<body>
    <h1>details de location</h1>

    <table>
        <tr>
            <th>nom du clients:</th>
            <td>{{ $rental->client_name }}</td>
        </tr>
        <tr>
            <th>matricule de la boutique:</th>
            <td>{{ $rental->store_matricule }}</td>
        </tr>
        <tr>
            <th>non de la boutique:</th>
            <td>{{ $rental->store_name }}</td>
        </tr>
        <tr>
            <th>adresse de la boutique:</th>
            <td>{{ $rental->store_address }}</td>
        </tr>
        <tr>
            <th>Periode de location:</th>
            <td>{{ $rental->period_location }}</td>
        </tr>
        <tr>
            <th>jour de location:</th>
            <td>{{ $rental->rental_date }}</td>
        </tr>
        <tr>
            <th>Prix de la boutique:</th>
            <td>{{ $rental->price_store }}</td>
        </tr>
    </table>
 {{-- <img src="{{ asset('$qrCode' ) }}" alt="QR Code"> --}}
</body>
</html>
