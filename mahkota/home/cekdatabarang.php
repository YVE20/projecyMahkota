<?php
include "KoneksiHome.php";
include "../asset/function/function.php";


if ($_POST['page'] == "About") {
    $qty = $_POST['qty'];
    $kode_barang = $_POST['kode_barang'];

    //Cek Kode Barang
    $sql = "select *from tbproduk where kode_barang = '$kode_barang'";
    $query = mysqli_query($con, $sql);
    $num = mysqli_num_rows($query);

    if ($num == 0) {
        echo "kosong";
    } else {
        $qty = $_POST['qty'];
        $kode_barang = $_POST['kode_barang'];
        $sql2 = "Select *from tbproduk where kode_barang = '$kode_barang'";
        $query2 = mysqli_query($con, $sql2);

        while ($res2 = mysqli_fetch_array($query2)) {
            if ($res2['jumlah'] == 0) {
                echo "kosong";
            } else {
                $hitung = $res2['jumlah'] - $qty;
                //Stock : 10; Beli : 11 == 10 - 11
                if ($hitung <= 0) {
                    echo "minus";
                } else {
                    $qty = $_POST['qty'];
                    $kode_barang = $_POST['kode_barang'];
                    //Stock : 10, beli 3 == 10 - 3
                    $sql3 = "update tbproduk set jumlah = '$hitung' where kode_barang = '$kode_barang'";
                    $query3 = mysqli_query($con, $sql3);

                    //Isi tblogsmenu
                    //Notes : 0 => Konsumen diluar
                    $idmenu = $res2['id'];
                    $sql4 = "INSERT INTO tblogsmenu (idmenu,jumlah,kategori,iduser) VALUES ('$idmenu','$qty','keluar','0')";
                    $query4 =  mysqli_query($con, $sql4);

                    //ISI tb Penjualan
                    $ip = get_ip();
                    $sqlsum = "select max(SUBSTRING_INDEX(id,'-',-1)) from tbjual where YEAR(tanggal)=YEAR(CURDATE())";
                    $querysum = mysqli_query($con, $sqlsum) or die($sqlsum);
                    $ressum = mysqli_fetch_array($querysum);
                    $maxno = $ressum[0] + 1;
                    $tanggal = date("Ymd");
                    $judul = "Penjualan";

                    if ($ip == "::1") {
                        $ip = "1";
                    } else {
                        $pecah = explode('.', $ip);
                        $ip = $pecah[3];
                    }

                    $iduser = $_POST['iduser'];

                    $idtransaksi = "J-" . $tanggal . "-" . $ip . "-" . $iduser . "-" . pad_left($maxno, 0, 5);
                    $tgltransaksi = date("y-m-d");
                    $metodepembayaran = "COD";

                    $sql6 = "SELECT *FROM tbproduk where kode_barang = '$kode_barang'";
                    $query6 = mysqli_query($con, $sql6);

                    $subtotal = 0;
                    $idproduk = "";
                    $harga = 0;
                    while ($re6 = mysqli_fetch_array($query6)) {
                        //Hitung Stock
                        $subtotal = $re6['harga_dk'] * $qty;
                        $idproduk = $re6['id'];
                        $harga = $re6['harga_dk'];
                    }

                    $diskon = 0;
                    $pajak = 0;
                    $grandtotal = $subtotal - ($diskon + $pajak);


                    $sql5 = "INSERT INTO tbjual (id,kodecanvas,iduser,idkonsumen,idsales,tanggal,subtotal,diskon,grandtotal,cash,status_antar) VALUES ('$idtransaksi','','0','$iduser','','$tgltransaksi','$subtotal','$diskon','$grandtotal','0','disiapkan')";
                    $query5 = mysqli_query($con, $sql5);

                    //Isi Tbdetail Penjualan
                    $sql7 = "INSERT INTO tbjualdetil (idjual,idmenu,jumlah,harga,total,diskon,jlhdiskon,subtotal,note) VALUES ('$idtransaksi','$idproduk','$qty','$harga','$subtotal','$diskon','0','$subtotal','-')";
                    $query7 = mysqli_query($con, $sql7) or die($sql7);

                    //Hapus Table Keranjang
                    $sql10 = "DELETE FROM tbkeranjang WHERE id_user = '$iduser'";
                    $query10 = mysqli_query($con, $sql10);

                    echo "sukses";
                }
            }
        }
    }
} else if ($_POST['page'] == "Index") {
    $iduser = $_POST['iduser'];
    $sql = "select *from tbkeranjang where id_user ='$iduser' ";
    $query = mysqli_query($con, $sql);
    $subtotalPenjualan = 0;

    while ($re = mysqli_fetch_array($query)) {
        //Kurangin stock
        $kode_barang = $re['kode_barang'];
        $sql5 = "select *from tbproduk where kode_barang = '$kode_barang'";
        $query5 = mysqli_query($con, $sql5);
        $hitung = 0;

        $idproduk = "";
        $harga = 0;
        while ($re5 = mysqli_fetch_array($query5)) {
            $hitung = $re5['jumlah'] - $re['jumlah'];
            $idproduk = $re5['id'];
            $harga = $re5['harga_dk'];
        }

        try {
            //Update tbproduk
            $sql6 = "update tbproduk set jumlah ='$hitung' where kode_barang = '$kode_barang'";
            $query6 = mysqli_query($con, $sql6);

            //Insert tblogs
            $idmenu = $re['id'];
            $qtyKeranjang = $re['jumlah'];
            $sql4 = "INSERT INTO tblogsmenu (idmenu,jumlah,kategori,iduser) VALUES ('$idmenu','$qtyKeranjang','keluar','0')";
            $query4 =  mysqli_query($con, $sql4);

            //ISI tb Penjualan
            $ip = get_ip();
            $sqlsum = "select max(SUBSTRING_INDEX(id,'-',-1)) from tbjual where YEAR(tanggal)=YEAR(CURDATE())";
            $querysum = mysqli_query($con, $sqlsum) or die($sqlsum);
            $ressum = mysqli_fetch_array($querysum);
            $maxno = $ressum[0] + 1;
            $tanggal = date("Ymd");
            $judul = "Penjualan";

            if ($ip == "::1") {
                $ip = "1";
            } else {
                $pecah = explode('.', $ip);
                $ip = $pecah[3];
            }

            $iduser = $_POST['iduser'];

            $idtransaksi = "J-" . $tanggal . "-" . $ip . "-" . $iduser . "-" . pad_left($maxno, 0, 5);
            $tgltransaksi = date("y-m-d");
            $metodepembayaran = "COD";

            //Hitungan
            $subtotalPenjualan += $re['subtotal'];

            $subtotalDetil = $re['subtotal'];

            $diskon = 0;
            $pajak = 0;
            $grandtotal = $subtotalPenjualan - ($diskon + $pajak);
            $qty = $re['jumlah'];

            //Isi Tbdetail Penjualan
            $sql9 = "INSERT INTO tbjualdetil (idjual,idmenu,jumlah,harga,total,diskon,jlhdiskon,subtotal,note) VALUES ('$idtransaksi','$idproduk','$qty','$harga','$subtotalDetil','$diskon','0','$subtotalDetil','-')";
            $query9 = mysqli_query($con, $sql9) or die($sql9);

            //Hapus tbkeranjang by id
            $sql7 = "delete from tbkeranjang where id_user ='$iduser'";
            $query7 = mysqli_query($con, $sql7);

            echo "sukses";
        } catch (Exception $ex) {
            echo $ex;
        }
    }
    $sql8 = "INSERT INTO tbjual (id,kodecanvas,iduser,idkonsumen,idsales,tanggal,subtotal,diskon,grandtotal,cash,status_antar) VALUES ('$idtransaksi','','0','$iduser','','$tgltransaksi','$subtotalPenjualan','$diskon','$grandtotal','0','disiapkan')";
    $query8 = mysqli_query($con, $sql8);
} else if ($_POST['page'] == "Profile") {
    $iduser = $_POST['iduser'];
    $idjual = $_POST['id_jual'];

    $sql = "select tbproduk.nama as 'namaBarang', tbjualdetil.jumlah as 'jumlahBarang', tbjualdetil.harga as 'Harga', tbjualdetil.subtotal as 'subTotal' from tbjual inner join tbjualdetil on tbjual.id = tbjualdetil.idjual inner join tbproduk on tbjualdetil.idmenu = tbproduk.id  where tbjual.idkonsumen = '$iduser' and tbjualdetil.idjual = '$idjual'";
    $query = mysqli_query($con, $sql);

    $isi = '';
    $row = 1;
    $isi .= '
        <table class="table">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Barang </th>
                    <th> Qty </th>
                    <th> Harga </th>
                    <th> SubTotal </th>
                </tr>
            </thead>
            <tbody>
        ';
    $hitungSubTotal = 0;
    while ($re = mysqli_fetch_array($query)) {
        $isi .= '
            <tr>
                <td>' . $row++ . '</td>
                <td>' . $re['namaBarang'] . '</td>
                <td>' . $re['jumlahBarang'] . '</td>
                <td> Rp.' . number_format($re['Harga'], 0, ',', '.') . '</td>
                <td> Rp.' . number_format($re['subTotal'], 0, ',', '.') . '</td>
            </tr>
        ';
        $hitungSubTotal += $re['subTotal'];
    }
    $isi .= '
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4"> <center> Total  </center>  </th>
                    <th> Rp. ' . number_format($hitungSubTotal, 0, ',', '.') . ' </th>
                </tr>
            </tfoot>
        </table>';

    echo $isi;
}
