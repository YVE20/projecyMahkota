<?php

    include "Koneksi.php";
    include "asset/function/function.php";
    date_default_timezone_set("Asia/Jakarta");


    $tombol = $_POST['tombol'];
    $idjual = $_POST['idjual'];
    $idjual_awal = $_POST['idjual_awal'];
    $idjual_ganti = $_POST['idjual_ganti'];
    $id = $_POST['id'];
    $idkonsumen = $_POST['idkonsumen'];
    $value_status = $_POST['value'];
    $tgltransaksi = $_POST['tgltransaksi'];
    
    $produk = $_POST['produk'];
    $metodepembayaran = $_POST['metodepembayaran'];
    $jatuhtempo = $_POST['jatuhtempo'];
    $namatabnya = $_POST['tabnya'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $total = $_POST['total'];
    $act = $_POST['act'];
    $idkaryawan = $_POST['idkaryawan'];
    $meja = $_POST['meja'];
    $subtotal = $_POST['subtotal'];
    $diskon = $_POST['diskon'];
    $pajak = $_POST['pajak'] == "" ? 0 : $_POST['pajak'];
    $jlhdiskon = $_POST['jlhdiskon'];
    $jlhpajak = $_POST['jlhpajak'];
    $grandtotal = $_POST['grandtotal'];
    $note = $_POST['note'];
    $shiftkaryawan = $_POST['shiftkaryawan'];
    $alasan = $_POST['alasan'];
    $subtotal_ = $harga * $jumlah;
    $subtotaldetil = $jumlah * (($harga-$jlhdiskon)+$jlhpajak);
    $kategori = $_POST['kategori'];
    $cash = $_POST['cash'];
    $kembalian = $_POST['kembalian'];
    $printer_kat = $_POST['printer_kat'];

    $tanggal = $_POST['tanggal'];

    $totalSementara = "";

    // untuk fungsi pencarian
    $tab = $_POST['tab'];
    $value_cari = $_POST['value'];

    $minus = "Y";
    $iduser = $_SESSION['iduser'];
    $role_ = $_SESSION['status'];
    
    if ($tombol == "simpan") {
        if($idkonsumen == "-"){
            echo "noKonsumen";
        }else{
            $harga = $_POST['harga'];
            $total = $_POST['total'];
            $diskon = $_POST['diskon'];
            $jlhdiskon = $_POST['jlhdiskon'];
            $total = $subtotal_ - $jlhdiskon;

            $sql1 = "SELECT * FROM tempjualdetil WHERE idjual='$idjual' AND idproduk='$produk'";
            $query1 = mysqli_query($con, $sql1);
            $num1 = mysqli_num_rows($query1);

            if ($num1 == 0) {
                $sqlmenu = "SELECT * FROM tbproduk where id='$produk'";
                $querymenu = mysqli_query($con, $sqlmenu);
                $cekjumlah = mysqli_fetch_assoc($querymenu);
                
                //Cek Jumlah Stock Barang
                if($cekjumlah['jumlah'] >= $jumlah){
                    $sql = "INSERT INTO tempjualdetil (idjual,idkonsumen,idproduk,iduser,jumlah,harga,total,pajak,jlhpajak,diskon,jlhdiskon,subtotal,note)  VALUES ('$idjual','$idkonsumen','$produk','$iduser','$jumlah','$harga','$total','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotal_','$note')";
                    $query = mysqli_query($con, $sql) or die($sql);

                    echo "sukses";
                }else{
                    echo "kosong";
                }
            } else { 
                echo "sudah ada";
            }
        }

    } elseif ($tombol == "edit") {
        if ($_POST['action'] =="edit") {
            $sqlmenu = "SELECT * FROM tbproduk where id='$produk'";
            $querymenu = mysqli_query($con, $sqlmenu);
            $cekjumlah = mysqli_fetch_assoc($querymenu);

            if ($cekjumlah['jumlah'] >= $jumlah) {
                $sql = "UPDATE tbjualdetil SET jumlah='$jumlah',harga='$harga',total='$subtotaldetil',diskon='$diskon',jlhdiskon='$jlhdiskon',subtotal='$subtotal_',note='$note' WHERE id='$id'  AND idproduk='$produk'";
                $query = mysqli_query($con, $sql) or die($sql);

                echo "sukses";
            } else {
                echo "kosong";
            }
        } else {
            $subtotaldetil = $total + $jlhpajak -$jlhdiskon;
            $sqlmenu = "SELECT * FROM tbproduk where id='$produk'";
            $querymenu = mysqli_query($con, $sqlmenu);
            $cekjumlah = mysqli_fetch_assoc($querymenu);

            if ($cekjumlah['jumlah'] >= $jumlah) {
                $sql = "UPDATE tempjualdetil SET idkonsumen='$idkonsumen',iduser='$iduser',jumlah='$jumlah',harga='$harga',total='$subtotaldetil',pajak='$pajak',jlhpajak='$jlhpajak',diskon='$diskon',jlhdiskon='$jlhdiskon',subtotal='$subtotal_',note='$note' WHERE id='$id' AND idproduk='$produk'";
                $query = mysqli_query($con, $sql) or die($sql);

                echo "sukses";
            } else {
                echo "kosong";
            }        
        }
    } else if ($tombol == "proses") {
        
        if($_POST['action'] == "edit"){
            $sqlcek = "SELECT *FROM tbjualdetil WHERE idjual='$idjual'";
        }else{
            $sqlcek = "SELECT *FROM tempjualdetil WHERE idjual='$idjual'";
        }

        $querycek = mysqli_query($con, $sqlcek);
        $numcek = mysqli_num_rows($querycek);

        $totalDiskon = 0; $subTotalAkhir = 0;  $idkonsumen = "";
        while($res = mysqli_fetch_array($querycek)){
            $totalDiskon += $res['jlhdiskon'];
            $subTotalAkhir += $res['subtotal'];
            $idkonsumen = $res['idkonsumen'];
        }
        
        $grandTotalAkhir = $subTotalAkhir - $totalDiskon;

        $idKonsumen = $_POST['idKonsumen'];
        //Check Alamat
        $sqlCheckAlamat = "SELECT *FROM tbkonsumen WHERE id='$idKonsumen' ";
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

        if ($numcek > 0) {
            if ($act == "edit") {
                $sql = "UPDATE tbjual SET subtotal='$subTotalAkhir',grandtotal='$grandTotalAkhir' WHERE id='$idjual'";
                $query = mysqli_query($con, $sql);
            }
            if ($act == "new") {
                    $sql = "INSERT INTO tbjual (id,iduser,idkonsumen,alamat,tanggal,subtotal,diskon,grandtotal,cash,status_antar) VALUES ('$idjual','$iduser','$idkonsumen','$alamat','$tgltransaksi','$subtotal','$totalDiskon','$grandTotalAkhir','1','selesai')";
                    $query = mysqli_query($con, $sql);       
            }
            if ($act == "bayar") {
                $sql = "UPDATE tbjual SET iduser='$iduser',idkonsumen='$idkonsumen',jatuh_tempo='$jatuhtempo',subtotal='$subtotal',diskon='$totalDiskon',grandtotal='$grandTotalAkhir', cash ='$cash',status_antar = 'selesai' WHERE id='$idjual'";
                $query = mysqli_query($con, $sql);
            }
            // end if act

            if($_POST['action'] == "edit"){
                // Select data dari tbjualdetil
                $sql2 = "SELECT * FROM tbjualdetil WHERE idjual='$idjual'";
            }else{
                // Select data dari tempjualdetil
                $sql2 = "SELECT * FROM tempjualdetil WHERE idjual='$idjual'";
            }

            $query2 = mysqli_query($con, $sql2) or die($sql2);
            while ($res2 = mysqli_fetch_array($query2)) {
                $id = $res2['id'];
                // $jual = $res2['idjual'];
                $idproduk = $res2['idproduk'];
                $iduser = $res2['iduser'];
                $jumlah = $res2['jumlah'];
                $harga = $res2['harga'];
                $diskon = $res2['diskon'];
                $jlhdiskon = $res2['jlhdiskon'];
                $total = $res2['total'];
                $subtotaldetil = $res2['subtotal'];
                $note = $res2['note'];

                // Mendapatkan jumlah tbjualdetil
                $sqljumlahdetil = "SELECT * FROM tbjualdetil WHERE idjual='$idjual' AND idproduk = '$res2[idproduk]'";
                $queryjumlahdetil = mysqli_query($con, $sqljumlahdetil);
                $resjumlahdetil = mysqli_fetch_array($queryjumlahdetil);

                $selisihjumlah = (int) $jumlah - (int) $resjumlahdetil['jumlah'];
                // echo $jumlah.' - '.$resjumlahdetil['jumlah'].' ==> '.$selisihjumlah;
                $nilaiselisihjumlah = abs($selisihjumlah);

                // Mendapatkan jumlah
                $sqljumlah = "SELECT * FROM tbproduk WHERE id='$idproduk'";
                $queryjumlah = mysqli_query($con, $sqljumlah);
                $resjumlah = mysqli_fetch_array($queryjumlah);
                $getjumlah = $resjumlah['jumlah'];

                $subtotal_new = (int) $jumlah * (int) $harga;
                $total_new = $subtotal_new + $jlhpajak - $jlhdiskon;

                if ($act == "edit") {
                    $sql = "UPDATE tbjualdetil SET jumlah='$res2[jumlah]', subtotal='$res2[subtotal]',total='$res2[total]' WHERE idjual='$idjual' AND idproduk = '$res2[idproduk]'";
                    $query = mysqli_query($con, $sql)or die($sql);

                    if ($selisihjumlah < 0) {
                        $sqlmenu = "UPDATE tbproduk SET jumlah = jumlah + '$nilaiselisihjumlah' WHERE id = '$idproduk'";
                        $querymenu = mysqli_query($con, $sqlmenu) or die($sql);
    
                        $sql = "INSERT INTO tblogsmenu (idproduk,jumlah,kategori,iduser) VALUES ('$idproduk','$nilaiselisihjumlah','masuk','$iduser')";
                        $query =  mysqli_query($con, $sql) or die($sql);
                    }

                    if ($selisihjumlah > 0) {
                        $sqlmenu = "UPDATE tbproduk SET jumlah = jumlah - '$nilaiselisihjumlah' WHERE id = '$idproduk'";
                        $querymenu = mysqli_query($con, $sqlmenu) or die($sql);
    
                        $sql = "INSERT INTO tblogsproduk (idproduk,jumlah,kategori,iduser) VALUES ('$idproduk','$nilaiselisihjumlah','keluar','$iduser')";
                        $query =  mysqli_query($con, $sql) or die($sql);
                    }
                    
                    if ($metodepembayaran == 'credit') {
                        $sql3 = "SELECT (jumlah - $res2[total]) AS selisih FROM tbpiutang WHERE id_penjualan='$idjual'";
                        $query3 = mysqli_query($con, $sql3) or die($sql3);
                        $res3 = mysqli_fetch_array($query3);

                        $sqlpiutang = "UPDATE tbpiutang SET jumlah ='$res2[total]',sisa = sisa - '$res3[selisih]' WHERE id_penjualan = '$idjual'";
                        $querymenu = mysqli_query($con, $sqlpiutang) or die($sql);
                    }
                } else {
                    // Mengurangi jumlah
                    if ($kodecanvas == '') {
                        $jumlahterpakai = $getjumlah - $jumlah;
                        $sqlupdatejumlah = "UPDATE tbproduk SET jumlah='$jumlahterpakai' WHERE id='$idproduk'";
                        $queryupdatejumlah = mysqli_query($con, $sqlupdatejumlah);
                    }

                    $sql3 = "INSERT INTO tbjualdetil (idjual,idproduk,jumlah,harga,total,diskon,jlhdiskon,subtotal,note) VALUES ('$idjual','$idproduk','$jumlah','$harga','$total_new','$diskon','$jlhdiskon','$subtotal_new','$note')";
                    $query3 = mysqli_query($con, $sql3) or die($sql3);

                    $sql = "INSERT INTO tblogsproduk (idproduk,jumlah,kategori,iduser) VALUES ('$idproduk','$res2[jumlah]','keluar','$iduser')";
                    $query =  mysqli_query($con, $sql) or die($sql);
                }
            }

            $sql4 = "DELETE FROM tempjualdetil WHERE idjual='$idjual'";    
            $query4 = mysqli_query($con, $sql4) or die($sql4);
            echo "sukses";
        } else {
            echo "kosong";
        }
    } elseif ($tombol == "hapus") {
        if ($act == "join") {
            $sql = "SELECT * FROM tbjualdetil where idjual='$idjual' AND idproduk = '$produk'";
            $query = mysqli_query($con, $sql);
            $res = mysqli_fetch_array($query);

            $pajak = $res['jlhpajak'];
            $subtotal = $res['subtotal'];
            $total = $res['total'];
            $diskon = $res['jlhdiskon'];

            $sql = "SELECT * FROM tbjual where id='$idjual'";
            $query = mysqli_query($con, $sql);
            $res = mysqli_fetch_array($query);

            $pajak_ = $res['pajak'] - $pajak;
            $subtotal_ = $res['subtotal'] - $subtotal;
            $grandtotal_ = $res['grandtotal'] - $total;
            $diskon_ = $res['diskon'] - $diskon;

            // print_r($grandtotal_);
            $sqldelupdate = "UPDATE tbjual SET subtotal = '$subtotal_', diskon = '$diskon_',pajak = '$pajak_', grandtotal = '$grandtotal_'  where id='$idjual'";
            $query = mysqli_query($con, $sqldelupdate) or die($sqldelupdate);

            $sql = "delete from tbjualdetil where id='$id'";
            $query = mysqli_query($con, $sql) or die($sql);
        }
        
        if($_POST['action'] == "edit"){
            $sql = "delete from tbjualdetil where id='$id'";
        }else{
            $sql = "delete from tempjualdetil where id='$id'";
        }

        $query = mysqli_query($con, $sql) or die($sql);
    } elseif ($tombol == "edittransaksi") {
        $sqlhapus = "DELETE FROM tempjualdetil WHERE idjual='$idjual'";
        $queryhapus = mysqli_query($con, $sqlhapus);

        $sql3 = "SELECT * FROM tbjual WHERE id='$idjual'";
        $query3 = mysqli_query($con, $sql3);
        $res3 = mysqli_fetch_array($query3);
        $idkonsumen = $res3['idkonsumen'];


        $sql1 = "SELECT * FROM tbjualdetil WHERE idjual='$idjual'";
        $query1 = mysqli_query($con, $sql1);
        while ($res1 = mysqli_fetch_array($query1)) {
            $idproduk = $res1['idproduk'];
            $jumlah = $res1['jumlah'];
            $harga = $res1['harga'];
            $pajak = $res1['pajak'];
            $jlhpajak = $res1['jlhpajak'];
            $diskon = $res1['diskon'];
            $jlhdiskon = $res1['jlhdiskon'];
            $subtotal = $res1['subtotal'];
            $total = $res1['total'];

            $sql2 = "INSERT INTO tempjualdetil (idjual,idproduk,idkonsumen,iduser,jumlah,harga,pajak,jlhpajak,diskon,jlhdiskon,subtotal,total) VALUES ('$idjual','$idproduk','$idkonsumen','$iduser','$jumlah','$harga','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotal','$total')";
            $query2 = mysqli_query($con, $sql2);
        }

        
        echo "|".$idkonsumen."|".$idsales."|";
    } elseif ($tombol == "hapustransaksi") {
        // Menambah kembali jumlah bahan
        $sqlseldet = "SELECT * FROM tbjualdetil where idjual='$idjual'";
        $queryseldet = mysqli_query($con, $sqlseldet);
        while ($resseldet = mysqli_fetch_array($queryseldet)) {
            $idproduk = $resseldet['idproduk'];
            $jumlahproduk = $resseldet['jumlah'];

            $sqlmenu = "UPDATE tbproduk SET jumlah = jumlah + '$resseldet[jumlah]' WHERE id = '$resseldet[idproduk]'";
            $querymenu = mysqli_query($con, $sqlmenu) or die($sql);

            $sql = "INSERT INTO tblogsproduk (idproduk,jumlah,kategori,iduser) VALUES ('$resseldet[idproduk]','$resseldet[jumlah]','masuk','$iduser')";
            $query =  mysqli_query($con, $sql) or die($sql);
        }

        // Masukkan ke trashjualdetil
        $sqlseldetil = "SELECT * FROM tbjualdetil where idjual='$idjual'";
        $queryseldetil = mysqli_query($con, $sqlseldetil);
        while ($resseldetil = mysqli_fetch_array($queryseldetil)) {
            $idjualdetil = $resseldetil['idjual'];
            $idprodukdetil = $resseldetil['idproduk'];
            $jumlahprodukdetil = $resseldetil['jumlah'];
            $hargadetil = $resseldetil['harga'];
            $totaldetil = $resseldetil['total'];
            $diskon = $resseldetil['diskon'];
            $jlhdiskon = $resseldetil['jlhdiskon'];
            $pajak = $resseldetil['pajak'] == "" ? 0 : $resseldetil['pajak'];
            $jlhpajak = $resseldetil['jlhpajak'] == "" ? 0 : $resseldetil['jlhpajak'];
            $subtotal = $resseldetil['subtotal'];

            $sqltrashdetil = "insert into trashjualdetil (idjual,idproduk,iduser,jumlah,harga,total,diskon,jlhdiskon,pajak,jlhpajak,subtotal) values ('$idjualdetil','$idprodukdetil','$iduser','$jumlahprodukdetil','$hargadetil','$totaldetil','$diskon','$jlhdiskon','$pajak','$jlhpajak','$subtotal')";
            $querytrashdetil = mysqli_query($con, $sqltrashdetil);

        }

        // Masukkan ke trashjual
        $sqlseljual = "SELECT * FROM tbjual where id='$idjual'";
        $queryseljual = mysqli_query($con, $sqlseljual);
        while ($resseljual = mysqli_fetch_array($queryseljual)) {
            $idkaryawanjual = $resseljual['idkaryawan'];
            $tanggaljual = $resseljual['tanggal'];
            $shiftjual = $resseljual['shift'];
            $mejajual = $resseljual['meja'];
            $subtotaljual = $resseljual['subtotal'];
            $diskonjual = $resseljual['diskon'];
            $pajakjual = $resseljual['pajak'] == "" ? 0 : $resseljual['pajak'];
            $grandtotaljual = $resseljual['grandtotal'];
            $cashjual = $resseljual['cash'];
            $kembalianjual = $resseljual['kembalian'] == "" ? 0 : $resseljual['kembalian'];

            $sqltrashjual = "insert into trashjual (id,iduser,tanggal,subtotal,diskon,pajak,grandtotal,cash,kembalian,alasan) values ('$idjual','$iduser','$tanggaljual','$subtotaljual','$diskonjual','$pajakjual','$grandtotaljual','$cashjual','$kembalianjual','$alasan')";
            $querytrashjual = mysqli_query($con, $sqltrashjual);
        }


        // Hapus data tbjualdetil
        $sqldel = "DELETE FROM tbjualdetil WHERE idjual='$idjual'";
        $querydel = mysqli_query($con, $sqldel);

        // Hapus data tbjual
        $sqldel2 = "DELETE FROM tbjual WHERE id='$idjual'";
        $querydel2 = mysqli_query($con, $sqldel2);
    } elseif ($tombol == "hapustransaksi_table") {
        // Hapus data tbjualdetil
        $sqldel = "delete from tempjualdetil where idjual='$idjual'";
        $querydel = mysqli_query($con, $sqldel);

        // Hapus data tbjual
        $sqldel2 = "delete from tbjual where id='$idjual'";
        $querydel2 = mysqli_query($con, $sqldel2);
    } elseif ($tombol == "periksapenjualan") {
        // if(strlen($idjual) == 4) {
        //     $sqlid = "SELECT id FROM tbjual WHERE id='$idjual'";
        //     $queryid = mysqli_query($con, $sqlid);
        //     $resid = mysqli_fetch_array($queryid);
        //     $idjual = $resid['id'];
        // }

        $sql = "SELECT * FROM tbjual WHERE id='$idjual'";
        $query = mysqli_query($con, $sql);
        $num = mysqli_num_rows($query);
        if ($num == "0") {
            echo "no|";
        } else {
            echo "yes|".$idjual;
        }
    } elseif ($tombol == "loadreview") {
        $sql = "select SUM(jlhpajak) as pajak, SUM(jlhdiskon) as diskon, SUM(subtotal) as subtotal, SUM(total) as total from tempjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query);


            
        $subtotal = $res['subtotal'];
        $diskon = $res['diskon'];
        $pajak = $res['pajak'];
        $grandtotal = $res['total'];
        // $meja = $res['meja'];

        $sql = "select meja from tbjual where id='$idjual'";
        $query = mysqli_query($con, $sql);
        $ress = mysqli_fetch_array($query);
        echo "|".$subtotal."|".$diskon."|".$pajak."|".$grandtotal."|".$ress['meja']."|";
    } elseif ($tombol == "tampilreview") {
        ?>
<table class="table table-review table-striped" style="display:block; table-layout: fixed;border-collapse: collapse;">
    <thead>
        <tr>
            <th style="width:8px;">No</th>
            <th style="width:170px;">Produk</th>
            <th style="width:60px;">Harga</th>
            <th style="width:35px;">Qty</th>
            <th class="pri-2" style="width:90px;">Diskon</th>
            <th class="pri-2" style="width:90px;">Pajak</th>

            <th>Subtotal</th>
        </tr>
    </thead>
    <tbody style="display:block;min-height: 300px;overflow-y: auto;overflow-x: hidden;">
        <?php
                    $no=1;
        $sqlreview = "select tempjualdetil.*,tbproduk.nama from tempjualdetil join tbproduk ON tempjualdetil.idproduk=tbproduk.id where idjual = '$idjual' order by tbproduk.nama asc";
        $queryreview = mysqli_query($con, $sqlreview);
        while ($res = mysqli_fetch_array($queryreview)) {
            ?>
        <tr>
            <td style="width:8px;"><?php echo $no++ ?>
            </td>
            <td style="width:170px;"><?php echo $res['nama'] ?>
            </td>
            <td style="width:60px;"><?php echo uang($res['harga']) ?>
            </td>
            <td style="width:40px;"><?php echo $res['jumlah'] ?>
            </td>
            <td class="pri-2" style="width:90px;"><?php echo $res['diskon'] ?>% (Rp.
                <?php echo(($res['diskon']/100) * $res['harga']); ?>)
            </td>
            <td class="pri-2" style="width:90px;"><?php echo $res['pajak'] ?>% (Rp.
                <?php echo(($res['jlhpajak'])); ?>)
            </td>
            <td style="width:90px;"><?php echo uang($res['total']); ?>
            </td>
        </tr>
        <?php
        } ?>
    </tbody>
    <tfoot style="display:block;">
        <?php
                    $sql = "select sum(subtotal) from tempjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query); ?>
    </tfoot>
</table>
<?php
    } elseif ($tombol == "tampiledit") {

        if($_POST['action'] == "edit"){
            $sql = "SELECT tbjualdetil.*,tbproduk.satuan FROM tbjualdetil LEFT JOIN tbproduk ON tbjualdetil.idproduk = tbproduk.id WHERE tbjualdetil.id='$id'";
        }else{
            $sql = "SELECT tempjualdetil.*,tbproduk.satuan FROM tempjualdetil LEFT JOIN tbproduk ON tempjualdetil.idproduk = tbproduk.id WHERE tempjualdetil.id='$id'";
        }
        
        $query = mysqli_query($con, $sql) or die($sql);

        $re = mysqli_fetch_array($query);
        $produk = $re['idproduk'];
        $idkonsumen = $re['idkonsumen'];
        $jumlah = $re['jumlah'];
        $harga = $re['harga'];
        $total = $re['total'];
        $diskon = $re['diskon'];
        $jlhdiskon = $re['jlhdiskon'];
        $pajak = $re['pajak'];
        $jlhpajak = $re['jlhpajak'];
        $note = $re['note'];
        $satuan = $re['satuan'];

        echo "|".$id."|".$produk."|".$idkonsumen."|".$jumlah."|".$harga."|".$total."|".$diskon."|".$jlhdiskon."|".$pajak."|".$jlhpajak."|".$note."|".$satuan."|";
    } elseif ($tombol == "hitungtotal") {

        if($_POST['action'] == "edit"){
            $sql = "select sum(total), sum(jlhdiskon), sum(subtotal) from tbjualdetil where idjual='$idjual'";
        }else{
            $sql = "select sum(total), sum(jlhdiskon), sum(subtotal) from tempjualdetil where idjual='$idjual'";
        }
        
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query);
        $totalharga = $res[0];
        $totaldiskon = $res[1];
        $totalsubtotal = $res[2];
        $totalSementara = $res[2];
        echo $totalharga."|".$totaldiskon."|".$totalsubtotal;
    } elseif ($tombol == "hitungtotaltbjual") {
        $sql = "select sum(total), sum(jlhdiskon), sum(jlhpajak), sum(subtotal) from tbjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query);
        $totalharga = $res[0];
        $totaldiskon = $res[1];
        $totalpajak = $res[2];
        $totalsubtotal = $res[3];
        $totalSementara = $res[3];
        echo $totalharga."|".$totaldiskon."|".$totalpajak."|".$totalsubtotal;
    } elseif ($tombol == "cancel") {
        $sql = "delete from tempjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        echo mysqli_error($con);
    } elseif ($tombol == "cekkonsumen") {
        $sql = "SELECT * FROM tbkonsumen WHERE id=$idkonsumen";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query);
        $nama = $res['nama'];
        $wilayah = $res['wilayah'];
        $kategori = $res['kategori'];
        $rate_pajak = $res['rate_pajak'];
        $max_hutang = $res['max_hutang'];

        echo "|".$nama."|".$wilayah."|".$kategori."|".$rate_pajak."|".$max_hutang;
    } elseif ($tombol == "tampilproduk") {
        $sql = "SELECT * FROM tbproduk where id='$produk'";
        $query = mysqli_query($con, $sql) or die($sql);
  
        $re = mysqli_fetch_array($query);
        $id = $re['id'];
        $produk = $re['nama'];
        $wilayah = $re['wilayah'];
        $jenis = $re['jenis_market'];
        $hargajual = $re['harga_jual'];
        $hargalk = $re['harga_lk'];
        $hargadepo = $re['harga_depo'];
        $hargamodern = $re['harga_modern'];
        $hargatradisional = $re['harga_tradisional'];
        $hargaagen = $re['harga_agen'];
        $hargauser = $re['harga_user'];
        $diskon = $re['diskon'];
        $pajak = $re['pajak'];
        $satuan = $re['satuan'];
        $kategori = $re['kategori'];
        $jumlah = $re['jumlah'];
        
        echo $id."|".$produk."|".$hargajual."|".$satuan."|".$kategori."|".$jumlah;
    } elseif ($tombol == "tampidetailcanvas") {
    } elseif ($tombol == "tampiljoinview") {
        ?>
<table id="datatable-fixed-header" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th><span style="display: none;">a</span></th>
            <th>No</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th><span style="display: none;"></span></th>
        </tr>
    </thead>

    <tbody>
        <?php
          if ($act == "join") {
              $trash = "";
          } else {
              $trash = "";
          }
        $no = 1;
        $sqlsel = "select tbjualdetil.*,tbproduk.nama from tbjualdetil left join tbproduk on tbjualdetil.idproduk=tbproduk.id where idjual='$idjual'";
        $querysel = mysqli_query($con, $sqlsel);
        while ($res = mysqli_fetch_array($querysel)) {
            $id = $res['id'];
            $idproduk_ = $res['idproduk'];
            $produk = $res['nama'];
            $jumlah = $res['jumlah'];
            $harga = $res['harga'];
            $total = $res['total'];
            $diskon = $res['diskon'];
            $jlhdiskon = $res['jlhdiskon'];
            $pajak = $res['pajak'];
            $jlhpajak = $res['jlhpajak'];
            $subtotal = $res['subtotal'];
            $note = $res['note']; ?>
        <tr id="<?php echo $no; ?>">
            <td rowspan='2' class='align-middle'><button <?php echo $trash; ?> type='button' class='btn
                    btn-circle
                    btn-mn btn-danger'
                    onclick='f_hapus("<?php echo $no; ?>","<?php echo $id; ?>","<?php echo $idproduk_; ?>")'><span style='font-size:10px'
                        class='oi oi-trash'></span></button></td>
            <td rowspan='2' class='align-middle'><?php echo $no; ?>
            </td>
            <td class=''><?php echo $produk; ?>
            </td>
            <td class=''><?php echo "Rp ".uang($harga); ?>
            </td>
            <td rowspan='2' class='align-middle text-center'>
                <!-- <span style='font-size: 2rem' id='qty<?php //echo $no;?>'
                class='badge badge-primary'><?php //echo $jumlah;?></span> -->
                <input
                    style="width: 50px;height: 50px;font-size: 2rem;padding: 0px;text-align: center; background-color:#f4f4f4 ;border:none"
                    type="text" id="qty<?php echo $no; ?>" name="qty"
                    value="<?php echo $jumlah; ?>">
            </td>
            <td rowspan='2' class='align-middle'>
                <div class='btn-group-vertical'>
                    <button type='button' id="btnPlus"
                        onclick='tambahQty("<?php echo $no; ?>","<?php echo $harga; ?>","<?php echo $id; ?>")'
                        class='btn btn-circle btn-mn btn-primary'><span style='font-size:10px'
                            class='oi oi-plus'></span></button>
                    <button type='button' id="btnMin"
                        onclick='kurangQty("<?php echo $no; ?>","<?php echo $harga; ?>","<?php echo $id; ?>")'
                        class='btn btn-circle  btn-mn btn-primary'><span style='font-size:10px'
                            class='oi oi-minus'></span></button>
                </div>
            </td>
        </tr>
        <tr id="<?php //echo $no;?>" style="display: none;"></tr>
        <tr id="<?php echo $no; ?>_ch">
            <td style="display: none;"></td>
            <td style="display: none;"></td>
            <td colspan='2' class='align-middle text-center' style='padding-left:0px;padding-right:0px;'>
                <div class='row'>
                    <button onclick='diskon("<?php echo $id; ?>")'
                        class='btn btn-outline btn-primary btn-sm col-4'><small>Disc</small><span
                            class='badge badge-primary'><?php echo $diskon."%"; ?></span></small></button>

                    <button
                        onclick='hitungpajak("<?php echo $id; ?>")'
                        class='btn btn-outline btn-success btn-sm col-3'><small>Pajak</small><span
                            class='badge badge-success'><?php echo $pajak." %"; ?></span></button>
                    <button onclick='note("<?php echo $id; ?>")'
                        class='btn btn-outline btn-default btn-sm col-4'><small>Note</small></button>
                </div>
            </td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
        </tr>
        <?php
            $no++;
        } ?>
    </tbody>
</table>
<script>
    $('#datatable-fixed-header').DataTable({
        fixedHeader: true,
        "searching": false, // Search Box will Be Disabled
        //"ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled
        "info": true, // Will show "1 to n of n entries" Text at bottom
        "paging": false,
        "lengthChange": false // Will Disabled Record number per page
    });
</script>
<?php
    } elseif ($tombol == "tampil") {
        ?>
<table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
    width="100%">
    <thead>
        <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php
            
            if($_POST['action'] == "edit"){
                $sqlsel = "SELECT tbjualdetil.*,tbproduk.nama,tbproduk.kode_barang FROM tbjualdetil LEFT JOIN tbproduk ON tbjualdetil.idproduk=tbproduk.id WHERE idjual='$idjual'";
            }else{
                $sqlsel = "SELECT tempjualdetil.*,tbproduk.nama,tbproduk.kode_barang FROM tempjualdetil LEFT JOIN tbproduk ON tempjualdetil.idproduk=tbproduk.id WHERE idjual='$idjual'";
            }

            $querysel = mysqli_query($con, $sqlsel);

            while ($res = mysqli_fetch_array($querysel)) {
                $id = $res['id'];
                $produk = $res['nama'];
                $kodebarang = $res['kode_barang'];
                $jumlah = $res['jumlah'];
                $harga = $res['harga'];
                $total = $res['total']; 
        ?>
            <tr>
                <td><?php echo $kodebarang." - ".$produk; ?>
                </td>
                <td><?php echo $jumlah; ?>
                </td>
                <td><?php echo "Rp ".uang($harga); ?>
                </td>
                <td><?php echo "Rp ".uang($total); ?>
                </td>
                <td>
                    <button class="btn btn-xs btn-warning"
                        onclick="f_edit('<?php echo $id; ?>')">Edit</button>
                    <button class="btn btn-xs btn-danger"
                        onclick="f_hapus('<?php echo $id; ?>')">Hapus</button>
                </td>
            </tr>
        <?php
            } 
        ?>
    </tbody>
</table>
<script>
    $('#datatable-fixed-header').DataTable({
        fixedHeader: true,
        "searching": false, // Search Box will Be Disabled
        "paging": false,
        "info": false, // Will show "1 to n of n entries" Text at bottom
        "lengthChange": false // Will Disabled Record number per page
    });
</script>
<?php
    } elseif ($tombol == "print_faktur") {
        $sql = "SELECT * FROM tbstatprinter where kategori_printer='$printer_kat'";
        $query = mysqli_query($con, $sql) or die($sql);
  
        $re = mysqli_fetch_array($query);
        $stat = $re['status_printer'];
        $ip = $re['ip_printer'];
        echo "|".$stat."|".$ip."|";
    } elseif ($tombol == "print_faktur1") {
        $sql = "SELECT * FROM tbstatprinter where kategori_printer='$printer_kat'";
        $query = mysqli_query($con, $sql) or die($sql);
  
        $re = mysqli_fetch_array($query);
        $stat = $re['status_printer'];
        $ip = $re['ip_printer'];
        echo "|".$stat."|".$ip."|";
    } elseif ($tombol == 'awal') {
        $sqlmenu = "SELECT * FROM tbproduk where kategori != 'Paket' order by nama asc";
        $querymenu = mysqli_query($con, $sqlmenu);
        while ($res = mysqli_fetch_array($querymenu)) {
            // echo $res['harga'];?>
<div class="col-md-6" style="padding:10px;"
    onclick="myPesan('<?php echo $res['id']; ?>','<?php echo $res['nama']; ?>','<?php echo $res['harga']; ?>')">
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:0px">
            <?php
                            $img_url=$res['img_url'];
            // cek gambar kosong
            if (empty($img_url)) {
                $img_url="dummy.jpeg";
            } else {
                $img_url=$res['img_url'];
            } ?>
            <img src="asset/img/<?php echo $img_url; ?>"
                class="card-img img-responsive" alt="Cinque Terre">
            <div class="card-img-overlay">
                <h4 class="card-title text-wrap text-left"><span class="label label-primary"><?php echo $res['nama'] ?></span>
                </h4>

                <h3 class="card-text"><span class="label label-warning">
                        Rp. <?php echo uang($res['harga']); ?></span>
                    <?php
                                                if ($res['diskon'] !=  0) {
                                                    echo "<span class='badge badge-danger'> Disc ".$res['diskon']."%</span>";
                                                } ?>
                </h3>
            </div>
        </div>
    </div>
</div>
<?php
        }
        // end while
    } elseif ($tombol == 'awalPaket') {
        $sqlmenu = "SELECT * FROM tbproduk where kategori = '$namatabnya' order by nama asc";
        $querymenu = mysqli_query($con, $sqlmenu);
        while ($res = mysqli_fetch_array($querymenu)) {
            // echo $res['harga'];?>
<div class="col-md-6" style="padding:10px;"
    onclick="myPesan('<?php echo $res['id']; ?>','<?php echo $res['nama']; ?>','<?php echo $res['harga']; ?>')">
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:0px">
            <?php
                            $img_url=$res['img_url'];
            // cek gambar kosong
            if (empty($img_url)) {
                $img_url="dummy.jpeg";
            } else {
                $img_url=$res['img_url'];
            } ?>
            <img src="asset/img/<?php echo $img_url; ?>"
                class="card-img img-responsive" alt="Cinque Terre">
            <div class="card-img-overlay">
                <h4 class="card-title text-wrap text-left">
                    <span class="label label-primary"><?php echo $res['nama'] ?>
                </h4>
                <h3 class="card-text"><span class="label label-warning">
                        Rp. <?php echo uang($res['harga']) ?></span>
                    <?php
                                                if ($res['diskon'] !=  0) {
                                                    echo "<span class='badge badge-danger'> Disc ".$res['diskon']."%</span>";
                                                } ?>

                    <h3>
            </div>
        </div>
    </div>
</div>
<?php
        }
        // end while
    } elseif ($tombol == 'awalPromo') {
        $sqlmenu = "SELECT * FROM tbproduk where diskon != '0' order by nama asc";
        $querymenu = mysqli_query($con, $sqlmenu);
        while ($res = mysqli_fetch_array($querymenu)) {
            // echo $res['harga'];?>

<div class="col-md-6" style="padding:10px;"
    onclick="myPesan('<?php echo $res['id']; ?>','<?php echo $res['nama']; ?>','<?php echo $res['harga']; ?>')">
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:0px">
            <?php
                            $img_url=$res['img_url'];
            // cek gambar kosong
            if (empty($img_url)) {
                $img_url="dummy.jpeg";
            } else {
                $img_url=$res['img_url'];
            } ?>
            <img src="asset/img/<?php echo $img_url; ?>"
                class="card-img img-responsive" alt="Cinque Terre">
            <div class="card-img-overlay">
                <h4 class="card-title text-wrap text-left">
                    <span class="label label-primary"><?php echo $res['nama'] ?>
                </h4>
                <h3 class="card-text"><span class="label label-warning">
                        Rp. <?php echo uang($res['harga']) ?></span>
                    <span class="badge badge-danger"> Disc
                        <?php echo $res['diskon']; ?>%</span>
                    <h3>
            </div>
        </div>
    </div>
</div>

<?php
        }
        // end while
    } elseif ($tombol == "cari") {
        if ($tab == "All") {
            //  Pencarian Produk
            $sqlmenu = "SELECT * FROM tbproduk where nama like '%$value_cari%' and kategori != 'Paket'";
            $querymenu = mysqli_query($con, $sqlmenu);
            while ($res = mysqli_fetch_array($querymenu)) {
                ?>
<div class="col-md-6" style="padding:10px;"
    onclick="myPesan('<?php echo $res['id']; ?>','<?php echo $res['nama']; ?>','<?php echo $res['harga']; ?>')">
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:0px">
            <?php
                        $img_url=$res['img_url'];
                // cek gambar kosong
                if (empty($img_url)) {
                    $img_url="dummy.jpeg";
                } else {
                    $img_url=$res['img_url'];
                } ?>
            <img src="asset/img/<?php echo $img_url; ?>"
                class="card-img img-responsive" alt="Cinque Terre">
            <div class="card-img-overlay">
                <h4 class="card-title text-wrap text-left">
                    <span class="label label-primary"><?php echo $res['nama'] ?>
                </h4>
                <h3 class="card-text"><span class="label label-warning">
                        Rp. <?php echo uang($res['harga']) ?></span>

                    <?php
                                    if ($res['diskon']!='0') {
                                        echo '<span class="badge badge-danger"> Disc '.$res['diskon'].'</span>';
                                    } ?>
                    <h3>
            </div>
        </div>
    </div>
</div>
<?php
            }
        } else {
            // Pencarian Paket
            $sqlmenu = "SELECT * FROM tbproduk where kategori='$tab' and nama like '%$value_cari%'";
            $querymenu = mysqli_query($con, $sqlmenu);
            while ($res = mysqli_fetch_array($querymenu)) {
                ?>
<div class="col-md-6" style="padding:10px;"
    onclick="myPesan('<?php echo $res['id']; ?>','<?php echo $res['nama']; ?>','<?php echo $res['harga']; ?>')">
    <div class="panel panel-default" style="margin-bottom:10px;">
        <div class="panel-body" style="padding:0px">
            <?php
                        $img_url=$res['img_url'];
                // cek gambar kosong
                if (empty($img_url)) {
                    $img_url="dummy.jpeg";
                } else {
                    $img_url=$res['img_url'];
                } ?>
            <img src="asset/img/<?php echo $img_url; ?>"
                class="card-img img-responsive" alt="Cinque Terre">
            <div class="card-img-overlay">
                <h4 class="card-title text-wrap text-left">
                    <span class="label label-primary"><?php echo $res['nama'] ?>
                </h4>
                <h3 class="card-text"><span class="label label-warning">
                        Rp. <?php echo uang($res['harga']) ?></span>
                    <h3>
            </div>
        </div>
    </div>
</div>
<?php
            }
        }
    } elseif ($tombol == "load_detail_firebase") {
        if ($value_status == "bayar") {
            $sql = "SELECT tbproduk.kategori FROM tbjualdetil JOIN tbproduk ON tbjualdetil.idproduk=tbproduk.id where tbjualdetil.idjual='$idjual' GROUP BY tbproduk.kategori ORDER BY tbproduk.kategori ASC";
            $query = mysqli_query($con, $sql);
            while ($res_j_det = mysqli_fetch_array($query)) {
                $kategori = $res_j_det['kategori'];

                $sql2 = "SELECT tbjualdetil.*,tbproduk.nama FROM tbjualdetil JOIN tbproduk ON tbjualdetil.idproduk=tbproduk.id where tbjualdetil.idjual='$idjual' AND tbproduk.kategori ='$kategori' ORDER BY tbproduk.nama ASC";
                $query2 = mysqli_query($con, $sql2);
                while ($res_j = mysqli_fetch_array($query2)) {
                    $detail .= $res_j['nama'].'#'.$res_j['harga'].'#'.$res_j['jumlah'].'#'.$res_j['subtotal'].'#'.$res_j['note']."_";
                }

                substr($detail, 0, -1);
                $detail.= "%";
            }
            // end while
        } else {
            $sql = "SELECT tbproduk.kategori FROM tempjualdetil JOIN tbproduk ON tempjualdetil.idproduk=tbproduk.id where tempjualdetil.idjual='$idjual' GROUP BY tbproduk.kategori ORDER BY tbproduk.kategori ASC";
            $query = mysqli_query($con, $sql);
            while ($res_j_det = mysqli_fetch_array($query)) {
                $kategori = $res_j_det['kategori'];

                $sql2 = "SELECT tempjualdetil.*,tbproduk.nama FROM tempjualdetil JOIN tbproduk ON tempjualdetil.idproduk=tbproduk.id where tempjualdetil.idjual='$idjual' AND tbproduk.kategori ='$kategori' ORDER BY tbproduk.nama ASC";
                $query2 = mysqli_query($con, $sql2);
                while ($res_j = mysqli_fetch_array($query2)) {
                    $detail .= $res_j['nama'].'#'.$res_j['harga'].'#'.$res_j['jumlah'].'#'.$res_j['subtotal'].'#'.$res_j['note']."_";
                }
                substr($detail, 0, -1);
                $detail.= "%";
            }
            // end while
        }
        // end if cek status pembayaran bayar atau simpan

        $sql_tbjual = "SELECT tbjual.*, tbuser.nama, tbkaryawan.nama AS nama_k FROM tbjual JOIN tbuser ON tbjual.iduser=tbuser.iduser JOIN tbkaryawan ON tbjual.idkaryawan = tbkaryawan.id where tbjual.id='$idjual'";
        $query_tbjual = mysqli_query($con, $sql_tbjual);
        $resJual = mysqli_fetch_assoc($query_tbjual);

        echo "|".$detail."|".$resJual['subtotal']."|".$resJual['diskon']."|".$resJual['pajak']."|".$resJual['grandtotal']."|".$resJual['cash']."|".$resJual['kembalian']."|".$resJual['nama_k']."|".$resJual['meja']."|".$resJual['nama']."|";

    // END tombol load_detail_firebase
    } elseif ($tombol == "loaddetail") {
        $sql = "select tbjual.*, tbuser.nama from tbjual join tbuser ON tbjual.iduser=tbuser.iduser where id='$idjual'";
        $query = mysqli_query($con, $sql);
        $resJual = mysqli_fetch_array($query); ?>

<div class="row" style="margin-bottom:30px;">
    <div class="col-xs-6">
        <h5>No. Transaksi</h5>
        <h5 style="font-style:italic;"><span class="fas fa-hand-holding-usd"
                style="margin-right:10px;"></span><strong>#<?php echo $resJual['id'] ?></strong>
        </h5>
        <h5>User</h5>
        <p><span class="fas fa-user" style="margin-right:10px;"></span><?php echo $resJual['nama'] ?>
        </p>
    </div>
    <div class="col-xs-6">
        <h5>Tanggal</h5>
        <p><span class="fas fa-calendar-alt" style="margin-right:10px;"></span><?php echo $resJual['tanggal'] ?>
        </p>

        <h5>Meja</h5>
        <h4 class="label label-primary" style="font-size:2rem;font-style:italic;"><?php echo $resJual['meja'] ?>
        </h4>
    </div>
</div>

<table id="table_detail" class="table display" style="width:100%">
    <thead>
        <tr>
            <th>No</th>
            <th>Produk</th>
            <th>Harga</th>
            <th>Qty</th>
            <th>Diskon</th>
            <th>Subtotal</th>
        </tr>
        <div class="clearfix"></div>
    </thead>
    <tbody>
        <?php
                    $no=1;
        $sqlreview = "select tbjualdetil.*,tbproduk.nama from tbjualdetil join tbproduk ON tbjualdetil.idproduk=tbproduk.id where idjual = '$idjual' order by tbproduk.nama asc";
        $queryreview = mysqli_query($con, $sqlreview);
        while ($res = mysqli_fetch_array($queryreview)) {
            ?>
        <tr>
            <td><?php echo $no++ ?>
            </td>
            <td><?php echo $res['nama'] ?>
            </td>
            <td><?php echo uang($res['harga']) ?>
            </td>
            <td><?php echo $res['jumlah'] ?>
            </td>
            <td><?php echo $res['diskon'] ?>%
                (Rp. <?php echo(($res['diskon']/100) * $res['harga']); ?>)
            </td>
            <td><?php echo uang($res['subtotal']); ?>
            </td>
        </tr>
        <?php
        } ?>
    </tbody>

    <tfoot>
        <?php
                    $sql = "select sum(subtotal) from tbjualdetil where idjual='$idjual'";
        $query = mysqli_query($con, $sql);
        $res = mysqli_fetch_array($query); ?>

    </tfoot>
</table>
<script>
    $('#table_detail').DataTable({
        "scrollY": "50vh",
        "scrollCollapse": true,
        "paging": false,
        "fixedHeader": false,
        "searching": false
    });
</script>
<?php
    } elseif ($tombol == "joinbill") {
        ?>
<table class="table table-striped" id="tablejoinbill">
    <thead>
        <tr>
            <th></th>
            <th>ID</th>
            <th>User</th>
            <th>Meja</th>
            <th>Total</th>

        </tr>
    </thead>
    <tbody>
        <?php
        $sqlreview = "SELECT * FROM tbjual where statbayar = 'belum' AND id!='$idjual'";
        $queryreview = mysqli_query($con, $sqlreview);
        while ($res = mysqli_fetch_array($queryreview)) {
            $id = $res['id'];
            $user = $res['iduser'];
            $meja = $res['meja'];
            $grandtotal = $res['grandtotal']; ?>
        <tr>
            <td></td>
            <td><?php echo $id ?>
            </td>
            <td><?php echo $user ?>
            </td>
            <td><?php echo $meja ?>
            </td>
            <td><?php echo uangRp($grandtotal) ?>
            </td>
        </tr>
        <?php
        } ?>
    </tbody>
</table>

<script>
    var table = $('#tablejoinbill').DataTable({
        columnDefs: [{
            orderable: false,
            className: 'select-checkbox',
            targets: 0
        }],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        order: [
            [1, 'asc']
        ],

        "searching": false, // Search Box will Be Disabled
        //"ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled
        "info": true, // Will show "1 to n of n entries" Text at bottom
        "paging": false,
        "lengthChange": false // Will Disabled Record number per page
    });

    //  var rows_selected = table.column(0).checkboxes.selected();

    $('#tablejoinbill tbody').on('click', 'tr', function() {
        var datas = table.row(this).data();
        idJual_join = datas[1];

        reviewbill(idJual_join);
    });
</script>
<?php
    } elseif ($tombol == "prosesjoinbill") {
        // print_r($_POST);
        $sqljoin = "SELECT * FROM tempjualdetil where idjual='$idjual_ganti'";
        $queryjoin = mysqli_query($con, $sqljoin);
        while ($res = mysqli_fetch_array($queryjoin)) {
            //   $data[] = $res;
            $idtempjual_ganti = $res['id'];
            // echo($idtempjual_ganti);
            $sqljoinupdate = "UPDATE tempjualdetil SET idjual = '$idjual_awal' where id='$idtempjual_ganti'";
            $query = mysqli_query($con, $sqljoinupdate) or die($sqljoinupdate);
        }

        // echo "1".mysqli_error($con);

        // select idjual yang akan dihapus/diganti
        $sqljoin = "SELECT * FROM tbjual where id='$idjual_ganti'";
        $query = mysqli_query($con, $sqljoin);
        $resjoin = mysqli_fetch_array($query);
        $subtotal_ganti =$resjoin['subtotal'];
        $diskon_ganti =$resjoin['diskon'];
        $pajak_ganti =$resjoin['pajak'];
        $grandtotal_ganti =$resjoin['grandtotal'];

        // select idjual yang dijoin bill
        $sqlawal = "SELECT * FROM tbjual where id='$idjual_awal'";
        $query = mysqli_query($con, $sqlawal);
        $resawal = mysqli_fetch_array($query);
        $subtotal_awal =(int)$resawal['subtotal'] + (int)$subtotal_ganti;
        $diskon_awal =(int)$resawal['diskon'] + (int)$diskon_ganti;
        $pajak_awal =(int)$resawal['pajak'] + (int)$pajak_ganti;
        $grandtotal_awal =(int)$resawal['grandtotal'] + (int)$grandtotal_ganti;

        //update diskon,pajak,subtotal,grandtotal tbjual
        $sqljualupdate = "UPDATE tbjual SET subtotal = '$subtotal_awal',diskon = '$diskon_awal', pajak = '$pajak_awal',grandtotal = '$grandtotal_awal' where id='$idjual_awal'";
        $query = mysqli_query($con, $sqljualupdate) or die($sqljualupdate);

        //Delete from tbjual where idjual yang lama
        $sqljualdelete = "DELETE FROM tbjual where id='$idjual_ganti'";
        $query = mysqli_query($con, $sqljualdelete) or die($sqljualdelete);
        

    // print_r($data);
    } elseif ($tombol == "cekstok") {
        $sqlmenu = "SELECT * FROM tbproduk where id='$produk'";
        $querymenu = mysqli_query($con, $sqlmenu);
        $resmenu = mysqli_fetch_array($querymenu);

        if ($kategori == "Paket") {
            $sqlmenu = "SELECT * FROM tbdetailpaket where id_paket='$produk'";
            $querymenu = mysqli_query($con, $sqlmenu);
            $y = 0;
            while ($resmenu = mysqli_fetch_array($querymenu)) {
                $id_produk = $resmenu['id_produk'];
                $jumlah_paket = $resmenu['jumlah'];

                $sqlbahan = "SELECT * FROM tbresep where idproduk='$id_produk'";
                $querybahan = mysqli_query($con, $sqlbahan);
                
                while ($resbahan = mysqli_fetch_array($querybahan)) {
                    $idbahan = $resbahan['idbahan'];
                    $jumlahbahan = $resbahan['jumlah'];

                    $jumlahterpakai = $jumlah * ($jumlah_paket * $jumlahbahan);
                    $sqlcekbahan = "select jumlah-$jumlahterpakai from tbbahan where id='$idbahan'";
                    $querycekbahan = mysqli_query($con, $sqlcekbahan);
                    $rescek = mysqli_fetch_array($querycekbahan);
                    $hasilperiksa = $rescek[0];
                    if ($hasilperiksa<0) {
                        $y++;
                    }
                }
            }
        } else {
            $sqlbahan = "SELECT * FROM tbresep where idproduk='$produk'";
            $querybahan = mysqli_query($con, $sqlbahan);
            $y = 0;
            while ($resbahan = mysqli_fetch_array($querybahan)) {
                $idbahan = $resbahan['idbahan'];
                $jumlahbahan = $resbahan['jumlah'];

                $jumlahterpakai = $jumlah * $jumlahbahan;
                $sqlcekbahan = "select jumlah-$jumlahterpakai from tbbahan where id='$idbahan'";
                $querycekbahan = mysqli_query($con, $sqlcekbahan);
                $rescek = mysqli_fetch_array($querycekbahan);
                $hasilperiksa = $rescek[0];
                if ($hasilperiksa<0) {
                    $y++;
                }
            }
        }
        // end if kategori paket
    } elseif ($tombol == "print_faktur_recta") {
        $sql_license = "select * from license where id='1'";
        $query_license = mysqli_query($con, $sql_license);
        $res = mysqli_fetch_array($query_license);

        $nama_perusahaan = $res['nama'];
        $alamat_perusahaan = $res['alamat'];
        $telp_perusahaan = $res['telp'];
        $icon = $res['icon'];
        $minus = $res['minus'];
        $shift1 = $res['shift1'];
        $shift2 = $res['shift2'];
        $shift3 = $res['shift3'];
        $idtoko = $res['idtoko'];
        $printer = $res['printer'];
        $instagram = $res['instagram'];

        $sqljual = "select * from tbjual where id='$idjual'";
        $queryjual = mysqli_query($con, $sqljual);
        $resjual = mysqli_fetch_array($queryjual);

        echo $sqljual;

        $subtotal = $resjual['subtotal'];
        $diskon = $resjual['diskon'];
        $pajak = $resjual['pajak'];
        $grandtotal = $resjual['grandtotal'];
        $meja = $resjual['meja'];
        $idkaryawan = $resjual['idkaryawan'];

        $sqlkaryawan = "select * from tbkaryawan where id='$idkaryawan'";
        $querykaryawan = mysqli_query($con, $sqlkaryawan);
        $reskaryawan = mysqli_fetch_array($querykaryawan);

        $namakaryawan = $reskaryawan['nama'];

        $detil = "";
        $detil2 = "";

        $idKonsumen = $resjual['idkonsumen'];
        $sqlKonsumen = "select *from tbkonsumen where id = '$idKonsumen'";
        $queryKonsumen = mysqli_query($con,$sqlKonsumen);
        $resKonsumen = mysqli_fetch_array($queryKonsumen);

        $noTransaksi = $resjual['id'];
        $namaCustomer = $resKonsumen['nama'];
        $totalHargaJual = $resjual['subtotal'];
        $diskonHargaJual = $resjual['diskon'];
        $totalSemuaJual = $resjual['grandtotal'];
        
        $sqlsel = "select tbjualdetil.*,tbproduk.nama from tbjualdetil left join tbproduk on tbjualdetil.idproduk=tbproduk.id where idjual = '$idjual'";
        $querysel = mysqli_query($con,$sqlsel);
        // $res_sela = mysqli_fetch_array($querysel);

        // print_r($res_sela);
        while($res = mysqli_fetch_array($querysel)) {
            $id = $res['id'];
            $produk = $res['nama'];
            $jumlah = $res['jumlah'];
            $harga = $res['harga'];
            $total = $res['total'];

            $detil .= $produk."#".$jumlah."#".uang($harga)."#".uang($total)."*";
            $detil2 .= $produk."#";
        }

        echo "|".$printer."|".$nama_perusahaan."|".date("d M Y  H:i:s")."|".$meja."|".$namakaryawan."|".$detil."|".uang($grandtotal)."|".$instagram."|".$alamat_perusahaan."|".$telp_perusahaan."|".$detil2."|".$noTransaksi."|".$namaCustomer."|".$totalHargaJual."|".$diskonHargaJual."|".$totalSemuaJual;


    } elseif ($tombol == "cekpiutang") {
        $sqljual = "SELECT * FROM `tbpiutang` LEFT JOIN tbjual ON tbpiutang.id_penjualan=tbjual.id WHERE tbpiutang.sisa > 0 AND tbjual.idkonsumen = '$idkonsumen'";
        $query = mysqli_query($con, $sqljual);
        $num = mysqli_num_rows($query);
        
        echo $num;
    } elseif ($tombol == "tampillistpenjualan") {
        ?>
<table id="datatable-fixed-header" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>No</th>
            <th>ID Penjualan</th>
            <th>Tanggal</th>
            <th>User Input</th>
            <!-- <th>Sales</th> -->
            <th>Konsumen</th>
            <th>Grandtotal</th>
            <th>Status Pengantaran</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>
        <?php
        
            $no = 1;

            //$sqlsel = "SELECT tbjual.*, tbkonsumen.nama AS nama_konsumen, tbuser.nama AS nama_user FROM tbjual LEFT JOIN tbuser ON tbjual.iduser=tbuser.iduser LEFT JOIN tbkonsumen ON tbjual.idkonsumen=tbkonsumen.id WHERE DATE(tbjual.tanggal) = '2023-02-08' ORDER BY tbjual.created_at DESC;";
            $month = date('m');
            $sqlsel = "SELECT tbjual.*, tbkonsumen.nama AS nama_konsumen, tbuser.nama AS nama_user FROM tbjual LEFT JOIN tbuser ON tbjual.iduser=tbuser.iduser LEFT JOIN tbkonsumen ON tbjual.idkonsumen=tbkonsumen.id WHERE month(tbjual.tanggal) = '$month' ORDER BY tbjual.created_at DESC;";
 
        $querysel = mysqli_query($con, $sqlsel);

        while ($res = mysqli_fetch_array($querysel)) {
            
            $id = $res['id'];
            $idjual = $res['id'];
            $supplier = $res['nama_sales'];
            $user = $res['nama_user'] == null ? "Processed by FO" : $res['nama_user'];
            $referensi = $res['nama_konsumen'] == null ? "Processed by BO" : $res['nama_konsumen'];
            $metodepembayaran = $res['metode_pembayaran'];
            $jatuhtempo = $res['jatuh_tempo'];
            $grandtotal = $res['grandtotal'];
            $status = $res['status_antar'];
            $tanggal = $res['tanggal']; ?>
        <tr>
            <td> <?php echo $no;?>. </td>
                <?php 
                    if($_SESSION['status'] != "Admin" && $_SESSION['status'] !="Owner"){
                ?>
                    <td> <?= $idjual ?> </td>
                <?php
                    }else{
                ?>
                    <td> <a href="javascript:void(0)" onclick="detailPenjualan('<?= $idjual ?>')" style="text-decoration: none;color:#0581f5;"> <?= $idjual ?> </a> </td>
                <?php
                    }
                ?>    
            <td> <?php echo date("d-m-Y", strtotime($tanggal)); ?> </td>
            <td> <?php echo $user; ?> </td>
            <!-- <td> <?php echo $supplier; ?> </td>--> 
            <td> <?php echo $referensi; ?></td>
            <td> <?php echo "Rp. ".number_format($grandtotal, 0, ',', '.'); ?>
            </td>
            <td>
                <select name="status_pengantaran" id="status_pengantaran" onchange="gantiStatus('<?= $idjual ?>')">
                    <?php 
                    $statusArray = array("disiapkan","diantar","selesai","dibatalkan");
                    foreach($statusArray as $se){
                        if($status == $se){
                    ?>
                            <option value="<?= $status ?>" selected> <?= $status ?> </option>
                    <?php    
                        }
                    }
                    $reSE = array_diff($statusArray, array($status));
                    foreach($reSE as $rSE){
                    ?>
                        <option value="<?= $rSE ?>"> <?= $rSE ?> </option>';
                    <?php
                    }
                    ?>
                </select>
            </td>
            <td>
                <button class="btn btn-sm btn-success" data-toggle="tooltip" data-placement="top" title="Print"
                    onclick="f_print('<?php echo $id; ?>')"><span
                        class="fa fa-print"></span></button>
                <?php
                        if ($role_ == 'Owner' || $role_ == 'Admin') {
                            ?>
                <button class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit Penjualan"
                    onclick="location.href='frmpenjualan.php?act=edit&id=<?php echo $id; ?>'"><span
                        class="fa fa-reply"></span></button>
                <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus"
                    onclick="location.href='frmpenjualan.php?act=hapus&id=<?php echo $id; ?>'"><span
                        class="fa fa-trash-o"></span></button>
                <?php
                        } ?>
            </td>
        </tr>
        <?php
                $no++;
        } ?>
    </tbody>
</table>
<script>
    $('#datatable-fixed-header').DataTable({
        fixedHeader: true,
        "searching": true, // Search Box will Be Disabled
        "info": true, // Will show "1 to n of n entries" Text at bottom
        "paging": true,
        "lengthChange": true // Will Disabled Record number per page
    });
</script>
<?php
    } elseif ($tombol == "prosesretur") {

        // if ($kelayakanretur == 'layak') {
        // $sqlmenu = "UPDATE tbproduk SET jumlah = jumlah + '$jlhretur' WHERE id = '$menu'";
        // $querymenu = mysqli_query($con, $sqlmenu) or die ($sql);
        $sqlmenu = "INSERT INTO tbretur (idjual,idproduk,iduser,jumlah,kelayakan) VALUES ('$idjual','$produk','$iduser','$jlhretur','$kelayakanretur')";
        $querymenu = mysqli_query($con, $sqlmenu) or die($sql);
        // }
        
        $sqljualdetil = "SELECT * FROM tempjualdetil WHERE idjual='$idjual' AND idproduk = '$produk'";
        $querydetil = mysqli_query($con, $sqljualdetil);
        $result_temp = mysqli_fetch_assoc($querydetil);
        
        $jumlah = $result_temp['jumlah'] - $jlhretur;
        $subtotal = $result_temp['harga'] * $jumlah;
        $total = $subtotal + $result_temp['jlhpajak'] - $result_temp['jlhdiskon'];

        $sql = "UPDATE tempjualdetil SET jumlah=jumlah - '$jlhretur',subtotal = '$subtotal', total = '$total' WHERE idjual='$idjual' AND idproduk='$produk'";
        $query = mysqli_query($con, $sql) or die($sql);

        echo "sukses";
    } else if ($tombol == "tampilprodukcanvas") {
        if ($kodecanvas) {
            ?>
            <div class="form-group" style="margin-top:10px;">
                <label style="top:-10px;">Produk</label>
                <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-focus-off="true"
                    data-size="5" name="cmbproduk" id="cmbproduk" onchange="loadproduk()" <?php if ($act == 'edit') {
                            echo 'disabled';
                        } ?>>
                    <option value="" disabled selected> --Pilih Produk-- </option>
                    <?php
                        $sqlmenu = "SELECT tbcanvasdetil.*,tbproduk.kode_barang,tbproduk.nama FROM tbcanvasdetil LEFT JOIN tbproduk ON tbcanvasdetil.idbarang = tbproduk.id WHERE kodecanvas = '$kodecanvas' ORDER BY nama ASC";
                        $querymenu = mysqli_query($con, $sqlmenu);

                        while ($res = mysqli_fetch_array($querymenu)) {
                            $id = $res['idbarang'];
                            $kodebarang = $res['kode_barang'];
                            $nama = $res['nama']; ?>
                    <option value="<?php echo $id; ?>"> <?php echo $kodebarang; ?> - <strong><?php echo $nama; ?></strong> </option>
                    <?php
                        } ?>
                </select>
            </div>
    <?php
        } else {
    ?>
            <div class="form-group" style="margin-top:10px;">
                <label style="top:-10px;">Produk</label>
                <select class="form-control col-md-7 col-xs-12 combobox selectpicker" data-live-search="true" data-focus-off="true"
                    data-size="5" name="cmbproduk" id="cmbproduk" onchange="loadproduk()" <?php if ($act == 'edit') {
                            echo 'disabled';
                        } ?>>
                    <option value="" disabled selected> --Pilih Produk-- </option>
                    <?php
                        $sqlmenu = "select * from tbproduk order by nama asc";
                        $querymenu = mysqli_query($con, $sqlmenu);
                        while ($res = mysqli_fetch_array($querymenu)) {
                            $id = $res['id'];
                            $kodebarang = $res['kode_barang'];
                            $nama = $res['nama']; ?>
                    <option value="<?php echo $id; ?>"
                        id="<?php echo $kodebarang; ?>"> <?php echo $kodebarang; ?> - <strong><?php echo $nama; ?></strong>
                    </option>
                    <?php
                        } ?>
                </select>
            </div>
    <?php
        }
    } elseif ($tombol == "tampildatacanvas") {
        $sqljual = "SELECT * FROM tbcanvas WHERE kodecanvas = '$kodecanvas'";
        $query = mysqli_query($con, $sqljual);
        $canvas=json_encode(mysqli_fetch_assoc($query));
        
        echo "|".$canvas."|";
    } elseif ($tombol == "tampildataprodukcanvas") {
        $sqljual = "SELECT * FROM tbcanvasdetil WHERE kodecanvas = '$kodecanvas' AND idbarang = '$produk'";
        $query = mysqli_query($con, $sqljual);
        $canvas=json_encode(mysqli_fetch_assoc($query));
        
        echo "|".$canvas."|";
    }else if($tombol == "pilihhargaproduk"){
        $idproduk = $_POST['idproduk'];
        $sqlharga = "select *from tbproduk where id = '$idproduk'";
        $queryharga = mysqli_query($con,$sqlharga);
        
        $hasil = json_encode(mysqli_fetch_assoc($queryharga));

        echo $hasil;
    }else if($tombol == "ubahstatuspengantaran"){
        $statusAntar = $_POST['statusAntar'];
        $idjual = $_POST['idjual'];
        try{
            $sqljual = "update tbjual set status_antar = '$statusAntar' where id = '$idjual'";
            $queryjual = mysqli_query($con,$sqljual);
            
            echo "success";
        }catch(Exception $ex){
            echo "error";
        }
    }else if($tombol == "detailPenjualan"){
        $idPenjualan = $_POST['idPenjualan'];

        $sqlDetailpenjualan = "SELECT *FROM tbjualdetil tbdt INNER JOIN tbproduk tp ON tbdt.idproduk = tp.id 
        INNER JOIN tbjual tbp ON tbdt.idjual = tbp.id WHERE tbdt.idjual = '$idPenjualan' ";
        $queryDetailpenjualan = mysqli_query($con,$sqlDetailpenjualan);

        $isi = "";
        $row = 1;
        $hitung = 0; $alamat = "";
        while($re = mysqli_fetch_array($queryDetailpenjualan)){
            $hitung += $re['total'];
            $alamat = $re['alamat'];
            $isi .="
                <tr>
                    <td> ".$row++." </td>
                    <td> ".$re['nama']." </td>
                    <td> ".$re[3]." </td>
                    <td> Rp. ".number_format($re['harga'],0,',','.')." </td>
                    <td> Rp. ".number_format($re['jlhdiskon'],0,',','.')." </td>
                    <td> Rp. ".number_format($re[7],0,',','.')." </td>
                    <td> Rp. ".number_format($re['total'],0,',','.')." </td>
                </tr>
            ";
        }
        $isi .="
            <tr>
                <th colspan='6'> <center> Total </center> </th>
                <th> Rp ".number_format($hitung,0,',','.')." </th>
            </tr>
        ";
        $isi .='###'.$alamat;
        echo $isi;
    }else if($tombol == "checkListAlamat"){
        $idKonsumen = $_POST['idKonsumen']; 
        $sqlCheckAlamat = "SELECT *FROM tbkonsumen WHERE id='$idKonsumen' ";
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
                        <div class='col-md-6' onclick='changeAlamat(`".$pisah[0]."`,`".$action."`)'>
                            <div style='border:1px solid black;padding: 20px 0px 10px 20px;margin-top:20px;cursor:pointer'>
                                <b> ".strtoupper($result['nama'])."</b> <button class='w-25 btn-success'> AKTIF </button> <br>
                                ".$result['no_hp']." <br>
                                ".$pisah[0]."
                            </div>
                        </div>";
                }else{
                    echo "
                    <div class='col-md-6' onclick='changeAlamat(`".$pisah[0]."`,`".$action."`)'>
                        <div style='border:1px solid black;padding: 20px 0px 10px 20px;margin-top:20px;cursor:pointer'>
                            <b> ".strtoupper($result['nama'])." </b> <br>
                            ".$result['no_hp']." <br>
                            ".$pisah[0]."
                        </div>
                    </div>";
                }
            }
        }else{
            //Tidak ada
            $isi .="
            <div class='col-md-6' onclick='changeAlamat(`".$result['alamat']."`,`".$action."`)'>
                <div style='border:1px solid black;padding: 20px 0px 10px 20px;margin-top:20px;cursor:pointer'>
                    <b> ".strtoupper($result['nama'])." </b> <br>
                    ".$result['no_hp']." <br>
                    ".$result['alamat']."
                </div>
            </div>";
        }
        echo $isi;
    }
    else if($tombol == "changeAlamat"){
    
        $action = $_POST['action'];
        $alamat = $_POST['alamat'];
        $idKonsumen = $_POST['iduser']; 

        $sqlCheckAlamat = "SELECT *FROM tbkonsumen WHERE id='$idKonsumen' ";
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
            $sqlUpdateAlamat = "UPDATE tbkonsumen set alamat ='$kumpulanAlamat' WHERE id='$idKonsumen' ";
            $queryUpdateAlamat = mysqli_query($con,$sqlUpdateAlamat);
        
            echo "success";
        }
    }
