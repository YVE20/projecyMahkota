<?php 

session_start();
include "KoneksiHome.php";

include "../asset/function/function.php";

$getEmail = $_GET['email'];
$getRetry = $_GET['retry'];

$urlEcomm = "http://".$_SERVER['SERVER_NAME']."/mahkota/Home/index.php";

if($getRetry == 'true'){
    //Check Email di DB
    $sqlCheck = "SELECT *FROM tbkonsumen WHERE email='$getEmail'";
    $queryCheck = mysqli_query($con,$sqlCheck);
    $rows = mysqli_num_rows($queryCheck);
    $result = mysqli_fetch_array($queryCheck);

    if($rows == 0){
        $_SESSION['verified'] = "not";
        header('Location: '.$urlEcomm);
    }else{
        //Update Status
        $idKonsumen = $result['id'];
        $sqlUpdateVerified = "Update tbkonsumen set verified='1', auth='', token='' WHERE id='$idKonsumen'";
        $queryUpdateVerified = mysqli_query($con,$sqlUpdateVerified);

        $_SESSION['verified'] = "yes";
        header('Location: '.$urlEcomm);
    }

}else{
    $getToken = $_GET['token'];

    //Check Token dengan email
    $sqlCheck = "SELECT *FROM tbkonsumen WHERE token ='$getToken' AND email='$getEmail'";
    $queryCheck = mysqli_query($con,$sqlCheck);
    $rows = mysqli_num_rows($queryCheck);
    $result = mysqli_fetch_array($queryCheck);

    if($rows == 0){
        $_SESSION['verified'] = "not";
        header('Location: '.$urlEcomm);
    }else{
        //Update Status
        $idKonsumen = $result['id'];
        $sqlUpdateVerified = "Update tbkonsumen set verified='1', auth='', token='' WHERE id='$idKonsumen'";
        $queryUpdateVerified = mysqli_query($con,$sqlUpdateVerified);

        $_SESSION['verified'] = "yes";
        header('Location: '.$urlEcomm);
    }
}

?>