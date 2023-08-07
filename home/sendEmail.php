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
        <html>
            <head>
                <meta charset='UTF-8'>
                <meta http-equiv='X-UA-Compatible' content='IE=edge'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title> Verifikasi Email </title>
            </head>
            <body style='background-color:#f7f7f7;'>
                <br>
                <center>
                    <div style='width:80%;'>
                        <div style='text-align:justify;background-color:#e3e3e3;padding:30px'>
                            <h2> Hello </h2>
                            <p> Tekan link dibawah ini untuk melakukan proses verifikasi email.  </p> <br>
                            <div>
                                <center> <button style='width:250px;height:50px;background-color:#6e6e6e;border:none;'> <a href='".$auth."' style='text-decoration:none;color:white;'>  Verifikasi Email  </a> </button> </center>
                            </div>
                            <br><br>

                            <p> Hormat kami, </p>
                            <font> Mahkota Stationery </font>
                        </div>
                    </div>
                </center>
            </body>
        </html>
        ";

        sendEmail($email,$auth,$nama,$body,$subject);

        echo "sukses";
}else if($_POST['type'] == "ForgetPassword"){

    $email = $_POST['email'];
    $token = bin2hex(random_bytes(64));
    $action = encryptIt("forgetPassword");
    $expiredDate = date("Y-m-d H:i:s");
    $auth = "http://".$_SERVER['SERVER_NAME']."/home/verifyemail.php?email=$email&token=$token&retry=false&action=$action&expiredDate=$expiredDate";

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
                <title> Password Change Request </title>
            </head>
            <body style='background-color:#f7f7f7;'>
                <br>
                <center>
                    <div style='width:80%'>
                        <div style='text-align:justify'>
                            <center>
                                <h2> Permintaan Perubahan Password </h2>
                            </center>
                            <p> Kami mendapatkan request untuk perubahan <b> password </b> pada akun mu. </p>
                            <p>
                                Link ini akan expired dalam kurun waktu 24 jam. Jika kamu tidak membuat request ini, mohon abaikan email ini dan tidak akan ada perubahan pada akun mu.
                            </p><br><br>
                        </div>
                        <center>
                            <div style='width:90%;height:380px;background-color:#e3e3e3;'>
                                <br><font> <b> ".strtoupper($nama)." </b> </font><br><br>
                                <p>
                                    Untuk melakukan perubahan email, tekan link dibawah : <br> ".$auth." <br><br>
                                    
                                    atau menekan tombol dibawah ini. <br> <br>
                                    <button style='width:250px;height:50px;background-color:#6e6e6e;border:none;'> <a href='".$auth."' style='text-decoration:none;color:white;'>  Klik disini untuk </a> </button> <br><br>
                                    
                                    Hormat Kami, <br>
                                    
                                    Mahkota Stationery 
                                </p>
                            </div>
                        </center>
                    </div>
                </center>
            </body>
        </html>";
        sendEmail($email,$auth,$nama,$body,$subject);
    }else{
        echo "notFound";
    }
}else if($_POST['type'] == "contactUs"){
    $name = $_POST['emailName'];
    $email = $_POST['email'];
    $phoneNumber = $_POST['emailPhoneNumber'];
    $message = $_POST['emailMessage'];

    $insertContactUs = "insert into tbcontactus (name,email,phoneNumber,message) value ('$name','$email','$phoneNumber','$message')";
    $queryInsertContactUs = mysqli_query($con,$insertContactUs);

    $subject = "Contact Us";

    sendEmail($email,null,$name,$message,$subject);
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
        echo "errorEmail";
    } else {
        echo "sukses";
    }
}




?>