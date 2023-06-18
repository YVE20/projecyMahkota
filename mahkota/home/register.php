<?php 

session_start();
include "KoneksiHome.php";
    // include "";
include "../asset/function/function.php";

$nama = $_POST['nama'];
$alamat = $_POST['alamat'];
$no_hp = $_POST['no_hp'];
$password = $_POST['password'];
$passEncrypt = encryptIt($password);


if($_POST['page'] == "Index" || $_POST['page'] == "About" || $_POST['page'] == "Profile"){
    //Cek data ada atau tidak
    $sqlCekData = "select *from tbkonsumen where no_hp = '$no_hp'";
    $queryCekData = mysqli_query($con,$sqlCekData);
    $row = mysqli_num_rows($queryCekData);

    if($row == 0){
        $sqlInsert = "insert into tbkonsumen (nama,alamat,no_hp,password) values ('$nama','$alamat','$no_hp','$passEncrypt')";
        $queryInsert = mysqli_query($con,$sqlInsert);

        echo "sukses";
    }else{
        echo "gagal";
    }
}else if($_POST['page'] == "ProfileUpdateNoHP"){
    $noHP = $_POST['noHP'];
    $iduser = $_POST['iduser'];
    $sqlUpdateNoHP = "update tbkonsumen set no_hp = '$noHP' where id='$iduser' ";
    $queryUpdateNoHP = mysqli_query($con,$sqlUpdateNoHP);

    echo "sukses"; 
}else if($_POST['page'] == "ProfileUpdateAlamat"){
    $alamat = $_POST['alamat'];
    $iduser = $_POST['iduser'];
    $sqlUpdateAlamat = "update tbkonsumen set alamat = '$alamat' where id='$iduser' ";
    $queryUpdateAlamat = mysqli_query($con,$sqlUpdateAlamat);

    echo "sukses"; 
}




?>