<?php

require_once '../../vendor/autoload.php';

use Dompdf\Dompdf;

require_once '../../classes/pesanan.php';
require_once '../../classes/detailPsn.php';

    $pesanan = new Pesanan();
    $detailPsn = new detailPsn();

    $data = $pesanan->readById($_GET['id']);
    $detail = $detailPsn->readDetail($_GET['id']);

    require_once 'invoiceTemplate.php';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4','portrait');
    $dompdf->render();

    $dompdf->stream(
        "Invoice-".$data['id_pesanan'].".pdf",
        ["Attachment" => false]
    );
?>