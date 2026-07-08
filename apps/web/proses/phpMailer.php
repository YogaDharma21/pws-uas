<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require '../vendor/autoload.php';

$mail = new PHPMailer(true);

try {

    $mail->SMTPDebug = SMTP::DEBUG_OFF;                    
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                       
    $mail->SMTPAuth   = true;                                   
    $mail->Username   = 'putrawibawa5566@gmail.com';                 
    $mail->Password   = 'dwyr uhbs ezls bbyl';                  
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
    $mail->Port       = 587;                                    

    
    $mail->setFrom('email_kamu@gmail.com', 'TECHNO ZONE OFFICIAL');
    
    $email_pelanggan = $_SESSION['email'] ?? 'pelanggan@example.com';
    $nama_pelanggan  = $_SESSION['nama'] ?? 'Pelanggan Setia';
    $mail->addAddress($email_pelanggan, $nama_pelanggan);       

    $mail->isHTML(true);                                  

    $mail->Subject = 'Pesanan Anda di TECHNO ZONE Berhasil!';
    
    $mail->Body    = "
    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e2e8f0; border-radius: 8px;'>
        <div style='background-color: #1e293b; padding: 15px; text-align: center; border-radius: 6px 6px 0 0;'>
            <h2 style='color: #3b82f6; margin: 0;'>TECHNO ZONE</h2>
        </div>
        <div style='padding: 20px; color: #334155; line-height: 1.6;'>
            <p>Halo, <strong>" . htmlspecialchars($nama_pelanggan) . "</strong></p>
            <p>Terima kasih telah berbelanja di Techno Zone. Transaksi pemesanan gadget/laptop Anda telah berhasil diproses oleh sistem kami.</p>
            
            <div style='background-color: #f8fafc; border-left: 4px solid #3b82f6; padding: 15px; margin: 20px 0;'>
                <p style='margin: 0 0 5px 0;'><strong>Status Transaksi:</strong> <span style='color: #10b981; font-weight: bold;'>LUNAS / BERHASIL</span></p>
                <p style='margin: 0;'>Detail pesanan lengkap dan invoice resmi Anda dapat dilihat langsung pada dashboard riwayat akun Anda.</p>
            </div>
            
            <p>Jika Anda memiliki pertanyaan lebih lanjut mengenai pengiriman unit, silakan hubungi tim support teknis kami.</p>
            <br>
            <p style='margin-bottom: 0;'>Salam hangat,</p>
            <p style='margin-top: 5px; font-weight: bold;'>Manajemen Techno Zone</p>
        </div>
        <div style='background-color: #f1f5f9; padding: 10px; text-align: center; font-size: 11px; color: #64748b; border-radius: 0 0 6px 6px;'>
            Email ini dikirimkan secara otomatis oleh sistem aplikasi PW-UAS Techno Zone.
        </div>
    </div>";

    $mail->AltBody = "Halo " . $nama_pelanggan . ", Terima kasih telah berbelanja di Techno Zone. Transaksi pemesanan Anda telah berhasil diproses.";

    $mail->send();
    
    echo "<script>
            alert('Email notifikasi pesanan telah berhasil dikirim ke email anda!');
            window.location.href = 'proses_sukses.php';
          </script>";

} catch (Exception $e) {
    
    $error_message = addslashes($mail->ErrorInfo);
    
    echo "<script>
            alert('Gagal mengirim email. Error: " . $error_message . "');
            window.location.href = '../index.php';
          </script>";
}
?>