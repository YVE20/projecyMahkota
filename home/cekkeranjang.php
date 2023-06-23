<?php

session_start();
include "KoneksiHome.php";

if ($_POST['typeKeranjang'] == "count" || $_POST['typeKeranjang'] == "view") {
    $iduser = $_POST['iduser'];

    $sql = "select *from tbkeranjang where id_user = '$iduser' ";
    $query = mysqli_query($con, $sql);
    $row = mysqli_num_rows($query);

    if ($row == 0) {
        echo "kosong";
    } else {
        echo $row;
    }
} else if ($_POST['typeKeranjang'] == "add") {
    //Add data ke tbkeranjang
    $iduser = $_POST['iduser'];
    $kode_barang = $_POST['kode_barang'];
    $jumlah = $_POST['qty'];

    //Logic Check Stock
    $sqlCheckStock = "SELECT *FROM tbproduk WHERE kode_barang = '$kode_barang' ";
    $queryCheckStock = mysqli_query($con,$sqlCheckStock);

    while ($resultCheckStock = mysqli_fetch_array($queryCheckStock)) {
        $hitung = $resultCheckStock['jumlah'] - $jumlah;
        //Stock : 10; Beli : 11 == 10 - 11

        if ($hitung <= 0) {
            echo "minus";
        }else{
            //Logic cek data double
            $sql4 = "select *from tbkeranjang where kode_barang = '$kode_barang' and id_user='$iduser'";
            $query4 = mysqli_query($con, $sql4);
            $row4 = mysqli_num_rows($query4);

            if ($row4 == 0) {
                //Cek harga di tbproduk
                $sql3 = "select *from tbproduk where kode_barang = '$kode_barang' ";
                $query3 = mysqli_query($con, $sql3);

                $subTotal = 0;
                while ($re = mysqli_fetch_array($query3)) {
                    $subTotal = $re['harga_jual'] * $jumlah;
                }

                //Isi data baru
                $sql2 = "insert into tbkeranjang (kode_barang,subtotal,jumlah,id_user) values ('$kode_barang','$subTotal','$jumlah','$iduser')";
                $query2 = mysqli_query($con, $sql2);

                echo "success";
            } else {
                //Cek harga di tbproduk
                $sql3 = "select *from tbproduk where kode_barang = '$kode_barang' ";
                $query3 = mysqli_query($con, $sql3);

                $hargaSatuan = 0;
                while ($re = mysqli_fetch_array($query3)) {
                    $hargaSatuan = $re['harga_jual'];
                }

                //Get jumlah dari tbkeranjang
                $sql6 = "select *from tbkeranjang where kode_barang = '$kode_barang' ";
                $query6 = mysqli_query($con, $sql6);
                $jumlahBarang = 0;
                $subTotal = 0;

                while ($re6 = mysqli_fetch_array($query6)) {
                    $jumlahBarang = $re6['jumlah'] + $jumlah;
                    $subTotal = $hargaSatuan * $jumlahBarang;
                }

                //Update data
                $sql5 = "update tbkeranjang set jumlah = '$jumlahBarang', subtotal ='$subTotal' where kode_barang = '$kode_barang' ";
                $query5 = mysqli_query($con, $sql5);

                echo "success";
            }
        }
    }
} else if ($_POST['typeKeranjang'] == "dataKeranjang") {
    $iduser = $_POST['iduser'];
    $sql4 = "SELECT tbkeranjang.id AS 'idKeranjang', tbproduk.nama AS 'namaBarang', tbkeranjang.jumlah AS 'jumlahBarang', tbkeranjang.subtotal AS 'subTotal' FROM tbkeranjang INNER JOIN tbproduk ON tbkeranjang.kode_barang = tbproduk.kode_barang WHERE tbkeranjang.id_user = '$iduser'";
    $query4 = mysqli_query($con, $sql4);
    $num_rows4 = mysqli_num_rows($query4);

    $isi = '';
    if($num_rows4 != 0){
        $row = 1; $dataIdKeranjang = "";
        while ($re4 = mysqli_fetch_array($query4)) {
            $isi .= '
                <tr>
                    <td>' . $row++ . '</td>
                    <td>' . $re4['namaBarang'] . '</td>
                    <td> 
                        <button class="btn" type="button" onclick="minus(1,`'.$re4["idKeranjang"].'`)"> - </button> 
                        <input type="text" name="qtyJumlahKeranjang" id="qtyJumlahKeranjang_'.$re4['idKeranjang'].'" value="' . $re4['jumlahBarang'] . '" style="width:30px;text-align: center;border:none;" readonly>
                        <button class="btn" type="button" onclick="plus(1,`'.$re4["idKeranjang"].'`)"> + </button> 
                    </td>
                    <td>
                        Rp. <input type="text" id="harga_'.$re4['idKeranjang'].'"  value="' . number_format($re4['subTotal'] / $re4['jumlahBarang'], 0, ',', '.') . '" style="width:70%;text-align: center;border:none;" readonly> 
                    </td>
                    <td> 
                        Rp. <input type="text" id="subTotal_'.$re4['idKeranjang'].'" value="' . number_format($re4['subTotal'], 0, ',', '.') . '" style="width:70%;text-align: center;border:none;" readonly> 
                    </td>
                    <td>
                        <i class="fa fa-trash" style="font-size:1.3em;cursor:pointer;color:Red;" aria-hidden="true" onclick="deleteCartItems(`'.$re4['idKeranjang'].'`)"></i>
                    </td>
                </tr>
            ';
            $dataIdKeranjang .= $re4['idKeranjang']."|";
        }
        $isi .='###';
        $isi .=$dataIdKeranjang;
    }else{
        $isi .='
            <tr>
                <th colspan="6">
                    <center> Belum ada barang nih dikeranjangmu &#128521; <br> Ayo buruan belanja sekarang </center>
                </th>
            </tr>
        ';
        $isi .='###NULL';
    }
    echo $isi;
} else if($_POST['typeKeranjang'] == "deleteKeranjangItems"){
    $idKeranjang = $_POST['idKeranjang'];
    $idUser = $_POST['iduser'];

    $sqlCheckData = "SELECT *FROM tbkeranjang WHERE id = '$idKeranjang' AND id_user = '$idUser'";
    $queryCheckData = mysqli_query($con,$sqlCheckData);

    if($queryCheckData != null){
        $sqlDelete = "DELETE FROM tbkeranjang WHERE id = '$idKeranjang' AND id_user = '$idUser' ";
        $queryDelete = mysqli_query($con,$sqlDelete);   

        echo "deleted";
    }else{
        echo "kosong";
    }
}
