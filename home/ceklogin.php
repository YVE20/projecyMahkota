<?php 

session_start();
include "KoneksiHome.php";
    // include "";
include "../asset/function/function.php";

$no_hp = $_POST['no_hp'];
$password = $_POST['pass'];
$password = encryptIt($password);

$sql = "select * from tbkonsumen where no_hp='$no_hp' and password='$password'";
$query = mysqli_query($con,$sql);
$row = mysqli_num_rows($query);

if($row == 0){
    echo "invalid";
}else {
    while($re = mysqli_fetch_array($query)){
        $_SESSION['iduser'] = $re['id'];
        $id_user = $re['id'];
        //Cek tbkeranjang
        $sql2 = "select *from tbkeranjang where id_user ='$id_user'";
        $query2 = mysqli_query($con,$sql2);
        $row2 = mysqli_num_rows($query2);

        if($row2 == 0){
            echo "kosong";
        }else{
            echo $row2;
        }
    }
}

?>