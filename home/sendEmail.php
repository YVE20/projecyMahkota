<?php 

//Php Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

$auth = $_POST['auth'];
$email = $_POST['email'];
$nama = $_POST['nama'];

$body = "
    <!DOCTYPE html>
        <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title> Verifikasi Email </title>
            </head>
            <body style='width:50%'>
                <div>
                    <h2> Hello </h2>
                    <p> Mohon tekan tombol dibawah ini untuk memverifikasi emailmu </p>
                    <div>
                        <center> <button style='width:250px;height:50px;background-color:#3489eb;border:none;'> <a href='".$auth."' style='text-decoration:none;color:white;'> Verify Email Anda </a> </button> </center>
                    </div>
                </div>
                <br>
                <div>
                    <p> Apabila anda merasa tidak membuat akun , silahkan abaikan proses ini </p>
                </div>
                <br><br>
                <p> Hormat kami, </p>
                <br>
                <font> Mahkota Stationery </font>
            </body>
        </html>
        ";

        //PHP Mailer
        $mail = new PHPMailer;
        //$mail->isSMTP(); 
        $mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
        $mail->Host = "smtp.gmail.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
        $mail->Port = 465; // TLS only
        //$mail->SMTPSecure = 'tls'; // ssl is depracated
        $mail->SMTPAuth = true;
        $mail->Username = "joshuanatan199@gmail.com";
        $mail->Password = "qcypgifhjblyniyx";
        $mail->setFrom("joshuanatan199@gmail.com", "Mahkota Stationery");
        $mail->addReplyTo('joshuanatal199@gmail.com', 'Mahkota Stationery');
        $mail->addAddress($email, $nama);
        $mail->Subject = 'Verifikasi Email';
        $mail->IsHTML(true);
        $mail->Body = $body;	

        if (!$mail->send()) {
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            echo "errorEmail";
        } else {
            echo "sukses";
        }


?>