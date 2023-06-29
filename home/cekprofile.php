<?php 

session_start();
include "KoneksiHome.php";
    // include "";
include "../asset/function/function.php";

$idUser = $_POST['iduser'];

if($_POST['type'] == "checkAlamat"){

    $sqlCheckAlamat = "SELECT *FROM tbkonsumen WHERE id='$idUser' ";
    $queryCheckAlamat = mysqli_query($con,$sqlCheckAlamat);
    $result = mysqli_fetch_array($queryCheckAlamat);

    //Check Alamat lebih dari 1 atau tidak
    if(strpos($result['alamat'], '|')){
        //Ada
        $split = explode("|",substr($result['alamat'],0,-1));
        foreach($split as $listAlamat){
            $pisah = explode("_",$listAlamat);
            if($pisah[1] == "1"){
                echo $pisah[0];
            }
        }
    }else{
        //Tidak ada
        echo $result['alamat'];
    }
}else if($_POST['type'] == "checkListAlamat"){
    
    $sqlCheckAlamat = "SELECT *FROM tbkonsumen WHERE id='$idUser' ";
    $queryCheckAlamat = mysqli_query($con,$sqlCheckAlamat);
    $result = mysqli_fetch_array($queryCheckAlamat);
    $action = $_POST['action'];

    $isi = "";
    //Check Alamat lebih dari 1 atau tidak
    if(strpos($result['alamat'], '|')){
        //Ada
        $split = explode("|",substr($result['alamat'],0,-1));
        foreach($split as $listAlamat){
            $pisah = explode("_",$listAlamat);
            if($pisah[1] == "1"){
                echo "
                    <div class='col-lg-6 mt-2' onclick='changeAlamat(`".$pisah[0]."`,`".$action."`)'>
                        <div class='card'>
                            <div class='card-body'>
                                <b> ".strtoupper($result['nama'])."</b> <button class='w-25 btn-success'> AKTIF </button> <br>
                                ".$result['no_hp']." <br>
                                ".$pisah[0]."
                            </div>
                        </div>
                    </div>";
            }else{
                echo "
                <div class='col-lg-6 mt-2' onclick='changeAlamat(`".$pisah[0]."`,`".$action."`)'>
                    <div class='card'>
                        <div class='card-body'>
                            <b> ".strtoupper($result['nama'])." </b> <br>
                            ".$result['no_hp']." <br>
                            ".$pisah[0]."
                        </div>
                    </div>
                </div>";
            }
        }
    }else{
        //Tidak ada
        $isi .="
        <div class='col-lg-6 mt-2' onclick='changeAlamat(`".$result['alamat']."`,`".$action."`)'>
            <div class='card'>
                <div class='card-body'>
                    <b> ".strtoupper($result['nama'])." </b> <br>
                    ".$result['no_hp']." <br>
                    ".$result['alamat']."
                </div>
            </div>
        </div>";
    }
    echo $isi;
}else if($_POST['type'] == "changeAlamat"){
    
    $action = $_POST['action'];
    $alamat = $_POST['alamat'];
    $sqlCheckAlamat = "SELECT *FROM tbkonsumen WHERE id='$idUser' ";
    $queryCheckAlamat = mysqli_query($con,$sqlCheckAlamat);
    $result = mysqli_fetch_array($queryCheckAlamat);

    //Check Alamat
    $split = explode("|",substr($result['alamat'],0,-1));

    if($action == "choose"){
        $kumpulanAlamat = ""; 
        foreach($split as $listAlamat){
            $pisah = explode("_",$listAlamat);
            if($pisah[0] == $alamat){
                $pisah[1] = 1;
                $kumpulanAlamat .= $pisah[0]."_".$pisah[1]."|";
            }else{
                if($pisah[0]){
                    $pisah[1] = 0;
                    $kumpulanAlamat .= $pisah[0]."_".$pisah[1]."|";
                }
            }
        }
        $sqlUpdateAlamat = "UPDATE tbkonsumen set alamat ='$kumpulanAlamat' WHERE id='$idUser' ";
        $queryUpdateAlamat = mysqli_query($con,$sqlUpdateAlamat);
    
        echo "success";
    }else if($action == "edit"){
        $kumpulanAlamat = "";
        foreach($split as $listAlamat){
            $pisah = explode("_",$listAlamat);
            if($pisah[0] == $alamat){
                echo $pisah[0];
            }
        }
    }
}else if($_POST['type'] == "editAlamat"){
    $alamat = $_POST['alamat'];
    
    $sqlCheckAlamat = "SELECT *FROM tbkonsumen WHERE id='$idUser' ";
    $queryCheckAlamat = mysqli_query($con,$sqlCheckAlamat);
    $result = mysqli_fetch_array($queryCheckAlamat);

    $split = explode("|",substr($result['alamat'],0,-1));

    foreach($split as $listAlamat){
        $pisah = explode("_",$listAlamat);
        if($pisah[0] == $alamat){
            echo "
                <div class='col-lg-12'>
                    <input type='text' class='form-control' name='alamatEdited' id='alamatEdited' value='".$pisah[0]."'>
                    <input type='hidden' class='form-control' name='alamatBeforeEdited' id='alamatBeforeEdited' value='".$pisah[0]."'>
                </div>
            ";
        }
    }
}else if($_POST['type'] == "confirmEditAlamat"){
    $alamat = $_POST['alamatEdited'];
    $alamatBefore = $_POST['alamatBeforeEdited'];

    $sqlCheckAlamat = "SELECT *FROM tbkonsumen WHERE id='$idUser' ";
    $queryCheckAlamat = mysqli_query($con,$sqlCheckAlamat);
    $result = mysqli_fetch_array($queryCheckAlamat);

    $split = explode("|",substr($result['alamat'],0,-1));

    $kumpulanAlamat = ""; 
    foreach($split as $listAlamat){
        $pisah = explode("_",$listAlamat);
        if($pisah[0] == $alamatBefore){
            $pisah[0] = $alamat;
            $kumpulanAlamat .= $pisah[0]."_".$pisah[1]."|";
        }else{
            if($pisah[0]){
                $kumpulanAlamat .= $pisah[0]."_".$pisah[1]."|";
            }
        }
    }
    $sqlUpdateAlamat = "UPDATE tbkonsumen set alamat ='$kumpulanAlamat' WHERE id='$idUser' ";
    $queryUpdateAlamat = mysqli_query($con,$sqlUpdateAlamat);

    header("location:profile.php");
}


?>