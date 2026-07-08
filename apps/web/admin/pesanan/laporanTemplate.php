<?php

$html = '
<h2 align="center">TECHNO ZONE</h2>

<table border="1" width="100%" cellspacing="0" cellpadding="5">
    <tr>
        <th>Id</th>
        <th>Tanggal</th>
        <th>Nama Customer</th>
        <th>Total</th>
        <th>Status Pesanan</th>
        <th>Status Pembayaran</th>
    </tr>
';

    while($row = $data->fetch_assoc()){
        $html .= '
        <tr>
            <td>'.$row['id_pesanan'].'</td>
            <td>'.$row['tanggal_pesanan'].'</td>
            <td>'.$row['nama'].'</td>
            <td>Rp '.number_format($row['total_harga'],0,",",".").'</td>
            <td>'.$row['status_pesanan'].'</td>
            <td>'.$row['status_pembayaran'].'</td>
        </tr>

        ';
    }
    $html .= '

</table>

    <br>
    <h3 align="right">
        Tanggal Dicetak = '.date('d-m-Y H:i:s');'
    </h3>
    <hr>

';