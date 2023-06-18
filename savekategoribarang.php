<?php 

include "Koneksi.php";

if($_POST['action'] == "show"){

    $sqlKategoriBarang = "SELECT *FROM tbkategori";
    $queryKategoriBarang = mysqli_query($con,$sqlKategoriBarang);

    $isi = "";

    if(mysqli_num_rows($queryKategoriBarang)){
        while($re = mysqli_fetch_array($queryKategoriBarang)){
            $isi .="
                <tr>
                    <td> ".$re['id_kategori']." </td>
                    <td> ".$re['kategori']." </td>
                    <td>
                        <button class='btn btn-xs btn-warning' type='button' onclick='showEditKategori(`".$re['id_kategori']."`)'> Edit </button>
                        <button class='btn btn-xs btn-danger' type='button' onclick='deleteKategori(`".$re['id_kategori']."`)'>Hapus</button>
                    </td>
                </tr>
            ";
        }
    }else{
        $isi .="
            <tr>
                <th colspan='3'> <center> Belum ada data </center> </th>
            </tr>
        ";
    }
    echo $isi;
} else if($_POST['action'] == "save") {

    $kategoriBarang =  $_POST['kategoriBarang'];

    $sqlKategoriBarang = "INSERT INTO tbkategori (kategori) values ('$kategoriBarang')";
    $queryKategoriBarang = mysqli_query($con,$sqlKategoriBarang);

    echo "success";
} else if($_POST['action'] == "edit"){
    
    $kategoriBarang = $_POST['kategoriBarang'];
    $idKategori = $_POST['idKategori'];

    //Cek data di DB

    $sqlKategoriBarang = "SELECT *FROM tbkategori WHERE id_kategori='$idKategori' ";
    $queryKategoriBarang = mysqli_query($con,$sqlKategoriBarang);
    $rows = mysqli_num_rows($queryKategoriBarang);

    if($rows == 0){
        echo "kosong";
    }else{
        $sqlUpdateKategoriBarang = "UPDATE tbkategori SET kategori='$kategoriBarang' WHERE id_kategori='$idKategori' ";
        $queryUpdateKategoriBarang = mysqli_query($con,$sqlUpdateKategoriBarang);

        echo "success";
    }
}else if($_POST['action'] == "showDataEdit"){

    $idKategori = $_POST['idKategori'];

    $sqlKategoriBarang = "SELECT *FROM tbkategori WHERE id_kategori='$idKategori' ";
    $queryKategoriBarang = mysqli_query($con,$sqlKategoriBarang);
    $resultKategoriBarang = mysqli_fetch_array($queryKategoriBarang);
    
    echo $resultKategoriBarang['kategori']."|".$resultKategoriBarang['id_kategori'];
}else if($_POST['action'] == "delete"){

    $idKategori = $_POST['idKategori'];

    $sqlKategoriBarang = "SELECT *FROM tbkategori WHERE id_kategori='$idKategori' ";
    $queryKategoriBarang = mysqli_query($con,$sqlKategoriBarang);
    $rows = mysqli_num_rows($queryKategoriBarang);

    if($rows == 0){
        echo "kosong";
    }else{
        $sqlDeleteKategoriBarang = "DELETE FROM tbkategori WHERE id_kategori='$idKategori' ";
        $queryDeleteKategoriBarang = mysqli_query($con,$sqlDeleteKategoriBarang);

        echo "success";
    }
}


?>