<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email </title>
</head>
<style>
</style>
<body style="font-family: 'Trebuchet MS'" >
    <h3>Detail perjalanan dinas anda</h3>
    <p>Yth. {{$nama}} </p>
    <p>Anda akan melakukan perjalanan dinas dengan detail sebagai berikut : </p>
    <table>
        <tr>
            <td  >Keperluan </td>
            <td > : </td>
            <td  >{{$kep}}</td>
        </tr>
        <tr>
            <td  >Keberangkatan </td>
            <td > : </td>
            <td  > {{$tgl}} pada jam {{$jam}}</td>
        </tr>
        <tr>
            <td  >Driver </td>
            <td > : </td>
            <td  >{{$driver}}</td>
        </tr>
        <tr>
            <td  >Mobil yang digunakan </td>
            <td > : </td>
            <td  >{{$mobil}} | {{$nopol}}</td>
        </tr>
        <tr>
            <td  >Kota Tujuan </td>
            <td > : </td>
            <td  >{{$tj}}</td>
        </tr>
        <tr>
            <td  >Kota Asal</td>
            <td > : </td>
            <td  >{{$asal}}</td>
        </tr>
    </table>

</body>
</html>