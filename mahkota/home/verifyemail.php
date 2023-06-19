<?php 

session_start();
include "KoneksiHome.php";

include "../asset/function/function.php";

$getToken = $_GET['token'];
$getEmail = $_GET['email'];

//Check Token dengan email
$sqlCheck = "SELECT *FROM tbkonsumen WHERE token ='$getToken' AND email='$getEmail'";
$queryCheck = mysqli_query($con,$sqlCheck);
$rows = mysqli_num_rows($queryCheck);
$result = mysqli_fetch_array($queryCheck);


$urlEcomm = "http://".$_SERVER['SERVER_NAME']."/mahkota/mahkota/Home/index.php";

if($rows == 0){
    $_SESSION['verified'] = "not";
    header('Location: '.$urlEcomm);
}else{
    //Update Status
    $idKonsumen = $result['id'];
    $sqlUpdateVerified = "Update tbkonsumen set verified='1' WHERE id='$idKonsumen'";
    $queryUpdateVerified = mysqli_query($con,$sqlUpdateVerified);

    $_SESSION['verified'] = "yes";
    header('Location: '.$urlEcomm);
}

?>