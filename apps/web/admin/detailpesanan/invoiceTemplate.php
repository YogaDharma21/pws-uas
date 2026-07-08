<?php

$html = '
<h2 align="center">TECHNO ZONE</h2>
<h3 align="center">INVOICE</h3>

<hr>

<table width="100%" cellpadding="5">
    <tr>
        <td width="30%"><strong>ID Pesanan</strong></td>
        <td>: '.$data['id_pesanan'].'</td>
    </tr>

    <tr>
        <td><strong>Nama Customer</strong></td>
        <td>: '.$data['nama'].'</td>
    </tr>

    <tr>
        <td><strong>Email</strong></td>
        <td>: '.$data['email'].'</td>
    </tr>

    <tr>
        <td><strong>No HP</strong></td>
        <td>: '.$data['no_hp'].'</td>
    </tr>

    <tr>
        <td><strong>Alamat</strong></td>
        <td>: '.$data['alamat'].'</td>
    </tr>

</table>

<br>

<table border="1" width="100%" cellspacing="0" cellpadding="8">
    <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Jumlah</th>
        <th>Subtotal</th>
    </tr>
';

    while($row = $detail->fetch_assoc()){
    $html .= '
        <tr>
            <td>'.$row['nama_produk'].'</td>
            <td>Rp '.number_format($row['harga_satuan'],0,",",".").'</td>
            <td>'.$row['jumlah'].'</td>
            <td>Rp '.number_format($row['subtotal'],0,",",".").'</td>
        </tr>
    ';
    }
    
$html .= '

</table>

    <br>
    <h3 align="right">
        Total : Rp '.number_format($data['total_harga'],0,",",".").'
    </h3>

    <hr>

    <p align="center">
        Terima kasih telah berbelanja di TECHNO ZONE
    </p>

';