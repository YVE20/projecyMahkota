<?php 

session_start();
include "KoneksiHome.php";
    // include "";
include "../asset/function/function.php";

//Php Mailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/phpmailer/phpmailer/src/Exception.php';
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';

if($_POST['type'] == "Register"){
    $auth = $_POST['auth'];
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $subject = "Verifikasi Email";

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

        sendEmail($email,$auth,$nama,$body,$subject);
}else if($_POST['type'] == "ForgetPassword"){

    $email = $_POST['email'];
    $token = bin2hex(random_bytes(64));
    $action = encryptIt("forgetPassword");
    $auth = "http://".$_SERVER['SERVER_NAME']."/mahkota/Home/verifyemail.php?email=$email&token=$token&retry=false&action=$action";

    //Check Email in DB
    $sqlCheckEmail = "SELECT *FROM tbkonsumen WHERE email='$email' AND verified='1'";
    $queryCheckEmail = mysqli_query($con,$sqlCheckEmail);
    $numRows = mysqli_num_rows($queryCheckEmail);
    $result = mysqli_fetch_array($queryCheckEmail);
    $idKonsumen = $result['id'];
    $nama = $result['nama'];
    $subject = "Lupa Password";

    if($numRows > 0){
        //Update tbKonsumen
        $updateKonsumen = "UPDATE tbkonsumen SET auth='$auth' , token='$token' WHERE id='$idKonsumen' ";
        $queryUpdateKonsumen = mysqli_query($con,$updateKonsumen);

        $body = "
        <html>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title> Email </title>
            </head>
            <body style='width:50%'>
                <div>
                    <h2> Hello </h2>
                    <p> Mohon tekan tombol dibawah ini untuk mereset passwordmu </p>
                    <div>
                        <center> <button style='width:250px;height:50px;background-color:#3489eb;border:none;'> <a href='".$auth."' style='text-decoration:none;color:white;'> Verify Email Anda </a> </button> </center>
                    </div>
                </div>
                <br>
                <div>
                    <p> Apabila anda merasa tidak melakukan proses request lupa password , silahkan abaikan proses ini </p>
                </div>
                <br><br>
                <p> Hormat kami, </p>
                <br>
                <font> Mahkota Stationery </font>
            </body>
        </html>
        ";
        sendEmail($email,$auth,$nama,$body,$subject);
    }else{
        echo "notFound";
    }
}

function sendEmail($email = null,$auth = null,$nama = null,$body,$subject ){
    //PHP Mailer
    $mail = new PHPMailer;
    $mail->isSMTP(); 
    $mail->SMTPDebug = 2; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
    $mail->Host = "smtp.hostinger.com"; // use $mail->Host = gethostbyname('smtp.gmail.com'); // if your network does not support SMTP over IPv6
    $mail->Port = 465; // TLS only
    $mail->SMTPSecure = 'ssl'; // ssl is depracated
    $mail->SMTPAuth = true;
    $mail->Username = "joshuamahkota@grhadigital.id";
    $mail->Password = "Joshua1928!";
    $mail->setFrom("joshuamahkota@grhadigital.id", "Mahkota Stationery");
    //$mail->addReplyTo('joshuanatal199@gmail.com', 'Mahkota Stationery');
    //$mail->IsMAIL();
    $mail->addAddress($email, $nama);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $body;	

    if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
        echo "../vendor/phpmailer/phpmailer/src/PHPMailer.php'";
        //echo "errorEmail";
    } else {
        echo "sukses";
    }
}
//EH tak ade ye :vlogin kan la
// Ape maok cobe pakai email asli kau dak ? bebas yo coba jak 


?>