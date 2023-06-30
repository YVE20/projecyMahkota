<?php
include "KoneksiHome.php";
include "../asset/function/function.php";


if ($_POST['page'] == "About" || $_POST['page'] == "Index" || $_POST['page'] == "contactUs" || $_POST['page'] == "profile") {
    //Ambil data dari table keranjang by ID User

    $iduser = $_SESSION['iduser'];

    //Split Data
    $deleteLastChar = substr($_POST['dataQty'],0,-1);
    $splitData = explode("_",$deleteLastChar);

    //Update Tb Keranjang
    foreach($splitData as $data){
        $split = explode("|",$data);
        $jumlahData = $split[0];
        $idKeranjang = $split[1];
        $sqlUpdateTableKeranjang = "UPDATE tbkeranjang set jumlah='$jumlahData' WHERE id ='$idKeranjang' ";
        $queryUpdateTableKeranjang = mysqli_query($con,$sqlUpdateTableKeranjang);
    }

    $sqlKeranjangByIDUser = "SELECT *FROM tbkeranjang WHERE id_user='$iduser'";
    $queryKeranjangByIDUser = mysqli_query($con, $sqlKeranjangByIDUser);

    //ISI tb Penjualan
    $ip = get_ip();
    $sqlsum = "select max(SUBSTRING_INDEX(id,'-',-1)) from tbjual where YEAR(tanggal)=YEAR(CURDATE())";
    $querysum = mysqli_query($con, $sqlsum) or die($sqlsum);
    $ressum = mysqli_fetch_array($querysum);
    $maxno = $ressum[0] + 1;
    $tanggal = date("Ymd");
    $judul = "Penjualan";
    $tgltransaksi = date("y-m-d");

    if ($ip == "::1") {
        $ip = "1";
    } else {
        $pecah = explode('.', $ip);
        $ip = $pecah[3];
    }

    $idtransaksi = "J-" . $tanggal . "-" . $ip . "-" . $iduser . "-" . pad_left($maxno, 0, 5);

    $subTotalPenjualan = 0;
    $grandTotalPenjualan = 0;
    while ($re = mysqli_fetch_array($queryKeranjangByIDUser)) {
        //Cek Kode Barang
        $kode_barang = $re['kode_barang'];
        $qty = $re['jumlah'];
        $sql = "select *from tbproduk where kode_barang = '$kode_barang'";
        $query = mysqli_query($con, $sql);
        $num = mysqli_num_rows($query);

        if ($num == 0) {
            echo "kosong";
        } else {
            $sql2 = "Select *from tbproduk where kode_barang = '$kode_barang'";
            $query2 = mysqli_query($con, $sql2);

            while ($res2 = mysqli_fetch_array($query2)) {
                if ($res2['jumlah'] == 0) {
                    echo "nol";
                } else {
                    $hitung = $res2['jumlah'] - $qty;
                    //Stock : 10; Beli : 11 == 10 - 11
                    if ($hitung <= 0) {
                        echo "minus";
                    } else {
                        //Stock : 10, beli 3 == 10 - 3
                        $sql3 = "update tbproduk set jumlah = '$hitung' where kode_barang = '$kode_barang'";
                        $query3 = mysqli_query($con, $sql3);

                        //Isi tblogsproduk
                        //Notes : 0 => Konsumen diluar
                        $idproduk = $res2['id'];
                        $sql4 = "INSERT INTO tblogsproduk (idproduk,jumlah,kategori,iduser) VALUES ('$idproduk','$qty','keluar','$iduser')";
                        $query4 =  mysqli_query($con, $sql4);

                        $metodepembayaran = "COD";

                        $sql6 = "SELECT *FROM tbproduk where kode_barang = '$kode_barang'";
                        $query6 = mysqli_query($con, $sql6);

                        $subtotal = 0;
                        $idproduk = "";
                        $harga = 0;
                        while ($re6 = mysqli_fetch_array($query6)) {
                            //Hitung Stock
                            $subtotal = $re6['harga_jual'] * $qty;
                            $idproduk = $re6['id'];
                            $harga = $re6['harga_jual'];
                        }

                        $diskon = 0;
                        $pajak = 0;
                        $grandtotal = $subtotal - ($diskon + $pajak);

                        //Isi Tbdetail Penjualan
                        $sql7 = "INSERT INTO tbjualdetil (idjual,idproduk,jumlah,harga,total,diskon,jlhdiskon,subtotal,note) VALUES ('$idtransaksi','$idproduk','$qty','$harga','$subtotal','$diskon','0','$subtotal','-')";
                        $query7 = mysqli_query($con, $sql7);

                        //Hapus Table Keranjang
                        $sql10 = "DELETE FROM tbkeranjang WHERE id_user = '$iduser'";
                        $query10 = mysqli_query($con, $sql10);
                        
                    }
                }
            }
        }
        $subTotalPenjualan += $re['subtotal'] * $re['jumlah'];
        $grandTotalPenjualan = $subTotalPenjualan - ($diskon + $pajak);
    }
    if($diskon == "") $diskon = 0;

    //Cek Alamat
    $sqlCheckAlamat = "SELECT *FROM tbkonsumen WHERE id='$iduser' ";
    $queryCheckAlamat = mysqli_query($con,$sqlCheckAlamat);
    $result = mysqli_fetch_array($queryCheckAlamat);

    $alamat = "";
    //Check Alamat lebih dari 1 atau tidak
    if(strpos($result['alamat'], '|')){
        //Ada
        $split = explode("|",substr($result['alamat'],0,-1));
        foreach($split as $listAlamat){
            $pisah = explode("_",$listAlamat);
            if($pisah[1] == "1"){
                $alamat = $pisah[0];
            }
        }
    }else{
        //Tidak ada
        $alamat = $result['alamat'];
    }

    $sql5 = "INSERT INTO tbjual (id,iduser,idkonsumen,alamat,tanggal,subtotal,diskon,grandtotal,cash,status_antar) VALUES ('$idtransaksi','0','$iduser','$alamat','$tgltransaksi','$subTotalPenjualan','$diskon','$grandTotalPenjualan','0','disiapkan')";
    $query5 = mysqli_query($con, $sql5);

}
