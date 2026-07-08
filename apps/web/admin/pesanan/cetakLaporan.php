<?php
    
    require_once '../../vendor/autoload.php';

    use Dompdf\Dompdf;

    require_once '../../classes/pesanan.php';

    $pesanan = new Pesanan();
    $data = $pesanan->read();

    require 'laporanTemplate.php';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4','portrait');
    $dompdf->render();

    $dompdf->stream(
        "Laporan-Pesanan.pdf",
        ["Attachment" => false]
    );
?>