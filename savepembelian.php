<?php
    include "Koneksi.php";
    include "asset/function/function.php";
    date_default_timezone_set("Asia/Jakarta");
    setlocale(LC_TIME, "id_ID");
    
    $tombol = $_POST['tombol'];
    $idpembelian = $_POST['idpembelian'];
    $act = $_POST['act'];
    $id = $_POST['id'];
    $idsupplier = $_POST['idsupplier'];
    $tanggal = $_POST['tanggal'];
    $subtotalakhir = $_POST['subtotalakhir'];
    $diskonakhir = $_POST['diskonakhir'];
    $pajakakhir = $_POST['pajakakhir'];
    $grandtotalakhir = $_POST['grandtotalakhir'];
    
    $produk = $_POST['produk'];
    $jumlah = $_POST['jumlah'];
    $harga = $_POST['harga'];
    $diskon = $_POST['diskon'];
    $pajak = $_POST['pajak'];
    $jlhdiskon = $_POST['jlhdiskon'];
    $jlhpajak = $_POST['jlhpajak'];
    $subtotal = $_POST['total'];
    
    $iduser = $_SESSION['iduser'];
    
    if($tombol == "simpan"){
        $sql = "insert into temppembeliandetil (id_pembelian,id_produk,jumlah,harga,pajak,jlhpajak,diskon,jlhdiskon,subtotal) values ('$idpembelian','$produk','$jumlah','$harga','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotal')";
        $query = mysqli_query($con,$sql) or die ($sql);
        
        echo "sukses";
    }else if($tombol == "edit"){
        $sql = "update temppembeliandetil set id_produk='$produk',jumlah='$jumlah',harga='$harga',pajak='$pajak',jlhpajak='$jlhpajak',diskon='$diskon',jlhdiskon='$jlhdiskon',subtotal='$subtotal' where id='$id'";
        $query = mysqli_query($con,$sql) or die ($sql);
    
        echo "sukses";
    }else if($tombol == "hapus"){

        if($_POST['action'] == "edit"){
            $sql = "delete from tbpembeliandetil where id='$id'";
        }else{
            $sql = "delete from temppembeliandetil where id='$id'";
        }
        
        $query = mysqli_query($con,$sql) or die ($sql);
    
        echo "sukses";
    }else if($tombol == "tampiledit"){

        if($_POST['action'] == "edit"){
            $sql = "select * from tbpembeliandetil where id='$id'";
        }else{
            $sql = "select * from temppembeliandetil where id='$id'"; 
        }
        $query = mysqli_query($con,$sql) or die ($sql);
    
        $re = mysqli_fetch_array($query);
        $jumlah = $re['jumlah'];
        $idproduk = $re['id_produk'];
        $harga = $re['harga'];
        $total = $re['subtotal'];
        $diskon = $re['diskon'];
        $jlhdiskon = $re['jlhdiskon'];
        $pajak = $re['pajak'];
        $jlhpajak = $re['jlhpajak'];
    
        echo "|".$id."|".$idproduk."|".$jumlah."|".$harga."|".$total."|".$diskon."|".$jlhdiskon."|".$pajak."|".$jlhpajak."|";
    }else if($tombol == "approvetransaksi"){
        $sql = "select * from tbpembelian where id_pembelian='$idpembelian'";
        $query = mysqli_query($con,$sql) or die ($sql);
    
        $re = mysqli_fetch_array($query);
        $supplier = $re['id_supplier'];
        $tanggal = $re['tanggal'];
        $subtotal = $re['subtotal'];
        $diskon = $re['diskon'];
        $pajak = $re['pajak'];
        $grandtotal = $re['grandtotal'];
    
        $sql4 = "delete from temppembeliandetil where id_pembelian='$idpembelian'";
        $query4 = mysqli_query($con, $sql4) or die ($sql4);
        
        // Select data dari tbpembeliandetil
        $sql2 = "select * from tbpembeliandetil where id_pembelian='$idpembelian'";
        $query2 = mysqli_query($con, $sql2) or die ($sql2);
        while ($res2 = mysqli_fetch_array($query2)) {
            $idproduk = $res2['id_produk'];
            $jumlah = $res2['jumlah'];
            $harga = $res2['harga'];
            $diskon = $res2['diskon'];
            $jlhdiskon = $res2['jlhdiskon'];
            $pajak = $res2['pajak'];
            $jlhpajak = $res2['jlhpajak'];
            $subtotaldetil = $res2['subtotal'];
        
            $sql3 = "insert into temppembeliandetil (id_pembelian,id_produk,jumlah,harga,pajak,jlhpajak,diskon,jlhdiskon,subtotal) values ('$idpembelian','$idproduk','$jumlah','$harga','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotaldetil')";
            $query3 = mysqli_query($con, $sql3);
        }
        // end While tbpembeliandetil
    
        echo "|".$supplier."|".$tanggal."|".$referensi."|".$metodepembayaran."|".$jatuhtempo."|".$subtotal."|".$diskon."|".$pajak."|".$grandtotal."|";
    }else if($tombol == "hitungtotal"){
        // load temppembeliandetil

        if($_POST['action'] == "edit"){
            $sql = "select sum(jumlah*harga), sum(jlhdiskon), sum(jlhpajak), sum(subtotal) from tbpembeliandetil where id_pembelian='$idpembelian'";
        }else{
            $sql = "select sum(jumlah*harga), sum(jlhdiskon), sum(jlhpajak), sum(subtotal) from temppembeliandetil where id_pembelian='$idpembelian'";
        }   
        
        $query = mysqli_query($con,$sql);
        $res = mysqli_fetch_array($query);
    
        $totalharga = $res[0];
        $totaldiskon = $res[1];
        $totalpajak = $res[2];
        $totalsubtotal = $res[3];
        echo $totalharga."|".$totaldiskon."|".$totalpajak."|".$totalsubtotal;
    
    }else if($tombol == "proses"){

        //Jagaan jika id supplier kosong
        if($_POST['idsupplier'] == "-" || $_POST['idsupplier'] == ""){
            echo "noSupplier";
        }else{
            $sqlcek = "select * from temppembeliandetil where id_pembelian='$idpembelian'";
            $querycek = mysqli_query($con,$sqlcek);
            $numcek = mysqli_num_rows($querycek);
        
            if($numcek > 0) {
                if ($act == "po") {
                    $noInvoice = $_POST['noInvoice'];
                    $sql = "insert into tbpembelian (id_pembelian,id_user,id_supplier,noInvoice,id_user_approve,tanggal,status,subtotal,diskon,pajak,grandtotal,statusApproved,alasan) 
                    values ('$idpembelian','$iduser','$idsupplier','$noInvoice','$iduser','$tanggal','Pembelian','$subtotalakhir','$diskonakhir','$pajakakhir','$grandtotalakhir','Approved','Penambahan Stock')";

                    $query = mysqli_query($con, $sql);

                    $sql4 = "delete from tbpembeliandetil where id_pembelian='$idpembelian'";
                    $query4 = mysqli_query($con, $sql4) or die ($sql4);
                }
                //else if ($act == "approve") {
                //     $sql = "update tbpembelian set id_user_approve='$iduser',id_supplier='$idsupplier',status='Pembelian',tanggal='$tanggal',subtotal='$subtotalakhir', diskon ='$diskonakhir' ,pajak='$pajakakhir',grandtotal = '$grandtotalakhir', statusApproved ='Approved', alasan = 'Penambahan Stock' where  id_pembelian='$idpembelian'";
                //     $query = mysqli_query($con, $sql);
                    
                //     if($metodepembayaran == "Kredit"){
                //         $sqlhutang = "insert into tbhutang (id_pembelian,jumlah,sisa,jatuh_tempo) values ('$idpembelian','$grandtotalakhir','$grandtotalakhir','$jatuhtempo')";
                //         $queryhutang = mysqli_query($con,$sqlhutang);
                //     }
                    
                //     $sql4 = "delete from tbpembeliandetil where id_pembelian='$idpembelian'";
                //     $query4 = mysqli_query($con, $sql4) or die ($sql4);
                // }
                // end if act
                
            
                // Select data dari temppembeliandetil
                $sql2 = "select * from temppembeliandetil where id_pembelian='$idpembelian'";
                $query2 = mysqli_query($con, $sql2) or die ($sql2);
                while ($res2 = mysqli_fetch_array($query2)) {
                    $idproduk = $res2['id_produk'];
                    $jumlah = $res2['jumlah'];
                    $harga = $res2['harga'];
                    $diskon = $res2['diskon'];
                    $jlhdiskon = $res2['jlhdiskon'];
                    $pajak = $res2['pajak'];
                    $jlhpajak = $res2['jlhpajak'];
                    $subtotaldetil = $res2['subtotal'];
                
                    $sql3 = "insert into tbpembeliandetil (id_pembelian,id_produk,jumlah,harga,pajak,jlhpajak,diskon,jlhdiskon,subtotal) values ('$idpembelian','$idproduk','$jumlah','$harga','$pajak','$jlhpajak','$diskon','$jlhdiskon','$subtotaldetil')";
                    $query3 = mysqli_query($con, $sql3);
        
                    if($act == "po"){
                        $sqlmenu = "select * from tbproduk where id='$idproduk'";
                        $querymenu = mysqli_query($con,$sqlmenu);
                        $resmenu = mysqli_fetch_array($querymenu);
                        $stoklama = $resmenu['jumlah'];
                        
                        $stokbaru = $jumlah + $stoklama;
                        
                        $sqlupdate = "update tbproduk set jumlah='$stokbaru', harga_beli='$harga' where id='$idproduk'";
                        $queryupdate = mysqli_query($con,$sqlupdate);

                        $sql4 = "delete from temppembeliandetil where id_pembelian='$idpembelian'";
                        $query4 = mysqli_query($con, $sql4) or die ($sql4);
                    }
                }
                
                echo "sukses";
            }else{
                echo "kosong";
            }
        }  
    }else if($tombol == "tampil"){
        ?>
        <table id="datatable-fixed-header" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Kode</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Diskon</th>
                <!-- <th>Pajak</th> -->
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            <?php
        
            $no = 1;
            $sqlsel = "select temppembeliandetil.*,tbproduk.nama, tbproduk.kode_barang as kodebarang, tbproduk.satuan from temppembeliandetil left join tbproduk on temppembeliandetil.id_produk=tbproduk.id where id_pembelian='$idpembelian'";
            $querysel = mysqli_query($con,$sqlsel);

            while($res = mysqli_fetch_array($querysel)){
                $id = $res['id'];
                $idproduk_ = $res['idproduk'];
                $produk = $res['nama'];
                $jumlah = $res['jumlah'];
                $satuan = $res['satuan'];
                $harga = $res['harga'];
                $diskon = $res['diskon'];
                $jlhdiskon = $res['jlhdiskon'];
                $pajak = $res['pajak'];
                $jlhpajak = $res['jlhpajak'];
                $subtotal = $res['subtotal'];
                $kodebarang = $res['kodebarang'];
                ?>
                <tr>
                    <td> <?php echo $no;?>. </td>
                    <td> <?php echo $produk;?> </td>
                    <td> <?php echo $kodebarang;?> </td>
                    <td> <?php echo number_format($jumlah,0,',','.');?> </td>
                    <td> <?php echo $satuan;?> </td>
                    <td> <?php echo number_format($harga,0,',','.');?> </td>
                    <td> <?php echo $diskon."% (".number_format($jlhdiskon,0,',','.').")";?> </td>
                    <!-- <td> <?php echo $pajak."% (".number_format($jlhpajak,0,',','.').")";?> </td> -->
                    <td> <?php echo number_format($subtotal,0,',','.');?> </td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="f_edit('<?php echo $id;?>')"><span class="fa fa-pencil"></span></button>
                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="f_hapus('<?php echo $id;?>')"><span class="fa fa-trash"></span></button>
                    </td>
                </tr>
                <?php
                $no++;
            }
            ?>
            </tbody>
        </table>
        <script>

             $('#datatable-fixed-header').DataTable({
                 fixedHeader: true,
                 "searching": false,   // Search Box will Be Disabled
                 //"ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled
                 "info": true,         // Will show "1 to n of n entries" Text at bottom
                 "paging": false,
                 "lengthChange": false // Will Disabled Record number per page
             });

        </script>
        <?php
    }else if($tombol == "tampillistpembelian"){
        ?>
        <table id="datatable-fixed-header" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>No</th>
                <th>ID Pembelian</th>
                <th>No Invoice</th>
                <th>Tanggal</th>
                <th>User Input</th>
                <th>Supplier</th>
                <!-- <th>Referensi</th> -->
                <!-- <th>Pembayaran</th> -->
                <th>Grandtotal</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            <?php
        
            $no = 1;
            $sqlsel = "select tbpembelian.*,tbsupplier.nama as nama_supplier, tbuser.nama as nama_user from tbpembelian inner join tbsupplier on tbpembelian.id_supplier=tbsupplier.id inner join tbuser on tbpembelian.id_user=tbuser.iduser where tbpembelian.created_at >= now()-interval 3 month order by tbpembelian.created_at desc";
            $querysel = mysqli_query($con,$sqlsel);

            //Get User Status
            $sqlUser = "SELECT *FROM  tbuser WHERE iduser='$iduser'";
            $queryUser = mysqli_query($con,$sqlUser);
            $resultUser = mysqli_fetch_array($queryUser);

            while($res = mysqli_fetch_array($querysel)){
                $id = $res['id'];
                $idpembelian = $res['id_pembelian'];
                $supplier = $res['nama_supplier'];
                $user = $res['nama_user'];
                $referensi = $res['referensi'];
                $metodepembayaran = $res['metode_pembayaran'];
                $jatuhtempo = $res['jatuh_tempo'];
                $grandtotal = $res['grandtotal'];
                $status = $res['status'];
                $tanggal = $res['tanggal'];
                $noInvoice = $res['noInvoice'];
                ?>
                <tr>
                    <td> <?php echo $no;?>. </td>
                    <?php 
                        if($_SESSION['status'] != "Admin" && $_SESSION['status'] !="Owner"){
                    ?>
                        <td> <?= $idpembelian ?> </td>
                    <?php
                        }else{
                    ?>
                        <td> <a href="javascript:void(0)" onclick="detailPembelian('<?= $idpembelian ?>')" style="text-decoration: none;color:#0581f5;"> <?= $idpembelian ?> </a> </td>
                    <?php
                        }
                    ?>
                    <td> <?= $noInvoice != null ? $noInvoice : "-"; ?> </td>
                    <td> <?php echo date("d-m-Y", strtotime($tanggal));?> </td>
                    <td> <?php echo $user;?> </td>
                    <td> <?php echo $supplier;?> </td>
                    <!-- <td> <?php echo $referensi;?> </td> -->
                    <!-- <td> <?php echo (($metodepembayaran == "Cash" ? 'Cash'  : 'Kredit ('.date("d-m-Y", strtotime($jatuhtempo)).')'));?> </td> -->
                    <td> <?php echo "Rp. ".number_format($grandtotal,0,',','.');?> </td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editPembelian('<?= $idpembelian ?>')"> <span class="fa fa-pencil"></span> Edit </button>
                        <button class="btn btn-sm btn-danger" onclick="deletePembelian('<?= $idpembelian ?>')"> <span class="fa fa-times"></span> Delete </button>
                        <button class="btn btn-primary" onclick="printPembelian('<?= $idpembelian ?>')"> <i class="fa fa-print" aria-hidden="true"></i> Print </button>
                    </td>
                </tr>
                <?php
                $no++;
            }
            ?>
            </tbody>
        </table>
        <script>

             $('#datatable-fixed-header').DataTable({
                 fixedHeader: true,
                 "searching": true,   // Search Box will Be Disabled
                 //"ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled
                 "info": true,         // Will show "1 to n of n entries" Text at bottom
                 "paging": true,
                 "lengthChange": true // Will Disabled Record number per page
             });

        </script>
        <?php
    }else if($tombol == "approvePO"){
        $idPembelian = $_POST['idPembelian'];
        
        //Get Data Pembelian
        $sqlPembelian = "SELECT *FROM tbpembelian WHERE id = '$idPembelian' ";
        $queryPembelian = mysqli_query($con,$sqlPembelian);
        $resultPembelian = mysqli_fetch_array($queryPembelian);

        $idTransaksi = $resultPembelian['id_pembelian'];

        //Get Data Detail Pembelian
        $sqlDetailPembelian = "SELECT temppembeliandetil.*,tbproduk.nama, tbproduk.kode_barang AS kodebarang, tbproduk.satuan 
        FROM temppembeliandetil LEFT JOIN tbproduk ON temppembeliandetil.id_produk=tbproduk.id WHERE id_pembelian='$idTransaksi' ";
        $queryDetailPembelian = mysqli_query($con,$sqlDetailPembelian);

        $tanggal = date("Y-m-d H:i:s");
        $subtotalakhir = 0; $diskonakhir = 0; $pajakakhir = 0;
        while($resultDetailPembelian = mysqli_fetch_array($queryDetailPembelian)){
            $subtotalakhir += $resultDetailPembelian['subtotal'];
            $diskonakhir += $resultDetailPembelian['jlhdiskon'];
            $pajakakhir += $resultDetailPembelian['jlhpajak'];
        }

        $grandtotalakhir = $subtotalakhir - ($diskonakhir + $pajakakhir);

        //Update table pembelian
        $sqlUpdatePembelian = "UPDATE tbpembelian set id_user_approve='$iduser',status='Pembelian',tanggal='$tanggal',subtotal='$subtotalakhir', diskon ='$diskonakhir' ,pajak='$pajakakhir',grandtotal = '$grandtotalakhir', statusApproved = 'Approved', alasan='Penambahan stock' WHERE  id='$idPembelian'";
        $queryUpdatePembelian = mysqli_query($con, $sqlUpdatePembelian);

        //Delete Temp Pembelian
        $sqlDeleteTempPembelian = "delete from tbpembeliandetil where id_pembelian='$idTransaksi'";
        $queryDeleteTempPembelian = mysqli_query($con, $sqlDeleteTempPembelian) or die ($sqlDeleteTempPembelian);

        echo "success";
    }else if($tombol == "rejectPO"){
        $idPembelian = $_POST['idPembelian'];
        $alasan = $_POST['alasan'];
        
        //Get Data Pembelian
        $sqlPembelian = "SELECT *FROM tbpembelian WHERE id = '$idPembelian' ";
        $queryPembelian = mysqli_query($con,$sqlPembelian);
        $resultPembelian = mysqli_fetch_array($queryPembelian);

        $idTransaksi = $resultPembelian['id_pembelian'];

        //Get Data Detail Pembelian
        $sqlDetailPembelian = "SELECT temppembeliandetil.*,tbproduk.nama, tbproduk.kode_barang AS kodebarang, tbproduk.satuan 
        FROM temppembeliandetil LEFT JOIN tbproduk ON temppembeliandetil.id_produk=tbproduk.id WHERE id_pembelian='$idTransaksi' ";
        $queryDetailPembelian = mysqli_query($con,$sqlDetailPembelian);

        $tanggal = date("Y-m-d H:i:s");
        $subtotalakhir = 0; $diskonakhir = 0; $pajakakhir = 0;
        while($resultDetailPembelian = mysqli_fetch_array($queryDetailPembelian)){
            $subtotalakhir += $resultDetailPembelian['subtotal'];
            $diskonakhir += $resultDetailPembelian['jlhdiskon'];
            $pajakakhir += $resultDetailPembelian['jlhpajak'];
        }

        $grandtotalakhir = $subtotalakhir - ($diskonakhir + $pajakakhir);

        //Update table pembelian
        $sqlUpdatePembelian = "UPDATE tbpembelian set id_user_approve='$iduser',status='Pembelian',tanggal='$tanggal',subtotal='$subtotalakhir', diskon ='$diskonakhir' ,pajak='$pajakakhir',grandtotal = '$grandtotalakhir', statusApproved = 'Rejected', alasan = '$alasan' WHERE  id='$idPembelian'";
        $queryUpdatePembelian = mysqli_query($con, $sqlUpdatePembelian);

        //Delete Temp Pembelian
        $sqlDeleteTempPembelian = "delete from tbpembeliandetil where id_pembelian='$idTransaksi'";
        $queryDeleteTempPembelian = mysqli_query($con, $sqlDeleteTempPembelian) or die ($sqlDeleteTempPembelian);

        echo "success";
    }else if($tombol == "detailPembelian"){
        $idPembelian = $_POST['idPembelian'];

        $sqlDetailPembelian = "SELECT *FROM tbpembeliandetil tbdt INNER JOIN tbproduk tp ON tbdt.id_produk = tp.id INNER JOIN tbpembelian tbp ON tbdt.id_pembelian = tbp.id_pembelian WHERE tbdt.id_pembelian = '$idPembelian' ";
        $queryDetailPembelian = mysqli_query($con,$sqlDetailPembelian);

        $isi = "";
        $row = 1;
        $hitung = 0; $statusApproved = "";
        while($re = mysqli_fetch_array($queryDetailPembelian)){
            $hitung += $re[9];
            $statusApproved = $re['statusApproved'];
            $isi .="
                <tr>
                    <td> ".$row++." </td>
                    <td> ".$re['nama']." </td>
                    <td> ".$re[3]." </td>
                    <td> Rp. ".number_format($re['harga'],0,',','.')." </td>
                    <td> Rp. ".number_format($re['jlhdiskon'],0,',','.')." </td>
                    <td> Rp. ".number_format($re['jlhpajak'],0,',','.')." </td>
                    <td> Rp. ".number_format($re[9],0,',','.')." </td>
                </tr>
            ";
        }
        $isi .="
            <tr>
                <th colspan='6'> <center> Total </center> </th>
                <th> Rp ".number_format($hitung,0,',','.')." </th>
            </tr>
        ";
        $isi .="###".$statusApproved;
        echo $isi;
    }else if($tombol == "hapusPembelian"){

        $idPembelian = $_POST['idPembelian'];
        //Delete Pembelian
        $sqlDeletePembelian = "DELETE FROM tbpembelian WHERE id_pembelian='$idPembelian'";
        $queryDeletePembelian = mysqli_query($con,$sqlDeletePembelian);

        //Delete Detail Pembelian
        $sqlDeleteDetailPembelian = "DELETE FROM tbpembeliandetil WHERE id_pembelian ='$idPembelian'";
        $queryDeleteDetailPembelian = mysqli_query($con,$sqlDeleteDetailPembelian);
        
        echo "success";
    }else if($tombol == "tampilEditPembelian"){
        $idPembelian = $_POST['idPembelian'];

        //Show Data Pembelian
        $sqlDataPembelian = "SELECT *FROM tbpembelian where id_pembelian='$idPembelian'";
        $queryDataPembelian = mysqli_query($con,$sqlDataPembelian);
        $resultDataPembelian = mysqli_fetch_array($queryDataPembelian);

        echo $resultDataPembelian['id_pembelian']."|".$resultDataPembelian['subtotal']."|".$resultDataPembelian['grandtotal']."|".$resultDataPembelian['diskon']."|".$resultDataPembelian['pajak'];
    }else if($tombol == "tampilDetailPembelian"){
        $idPembelian = $_POST['idpembelian'];
?>
    <table id="datatable-fixed-header" class="table table-striped dt-responsive nowrap" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Kode</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Harga</th>
                <th>Diskon</th>
                <th>Subtotal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php  
                $no = 1;
                $sqlsel = "select tbpembeliandetil.*,tbproduk.nama, tbproduk.kode_barang as kodebarang, tbproduk.satuan from tbpembeliandetil left join tbproduk on tbpembeliandetil.id_produk=tbproduk.id where id_pembelian='$idPembelian'";
                $querysel = mysqli_query($con,$sqlsel);

                while($res = mysqli_fetch_array($querysel)){
                    $id = $res['id'];
                    $idproduk_ = $res['idproduk'];
                    $produk = $res['nama'];
                    $jumlah = $res['jumlah'];
                    $satuan = $res['satuan'];
                    $harga = $res['harga'];
                    $diskon = $res['diskon'];
                    $jlhdiskon = $res['jlhdiskon'];
                    $pajak = $res['pajak'];
                    $jlhpajak = $res['jlhpajak'];
                    $subtotal = $res['subtotal'];
                    $kodebarang = $res['kodebarang'];
            ?>

                <tr>
                    <td> <?php echo $no;?>. </td>
                    <td> <?php echo $produk;?> </td>
                    <td> <?php echo $kodebarang;?> </td>
                    <td> <?php echo number_format($jumlah,0,',','.');?> </td>
                    <td> <?php echo $satuan;?> </td>
                    <td> <?php echo number_format($harga,0,',','.');?> </td>
                    <td> <?php echo $diskon."% (".number_format($jlhdiskon,0,',','.').")";?> </td>
                    <td> <?php echo number_format($subtotal,0,',','.');?> </td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-toggle="tooltip" data-placement="top" title="Edit Data" onclick="f_edit('<?php echo $id;?>')"><span class="fa fa-pencil"></span></button>
                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Hapus Data" onclick="f_hapus('<?php echo $id;?>')"><span class="fa fa-trash"></span></button>
                    </td>
                </tr>
            <?php
                    $no++;
                }
            ?>
        </tbody>
    </table>
    <script>
        $('#datatable-fixed-header').DataTable({
            fixedHeader: true,
                "searching": false,   // Search Box will Be Disabled
                 //"ordering": false,    // Ordering (Sorting on Each Column)will Be Disabled
                "info": true,         // Will show "1 to n of n entries" Text at bottom
                "paging": false,
                "lengthChange": false // Will Disabled Record number per page
            });
    </script>
<?php
    }else if($tombol == "EditSemuaPembelian"){

        $id = $_POST['idpembelian'];
        //Get Data Detail
        $sqlDetailPembelian = "select *from tbpembeliandetil where id_pembelian='$id'";
        $queryDetailPembelian = mysqli_query($con,$sqlDetailPembelian);

        $subTotal = 0; $diskon = 0; $pajak = 0; 
        while($re = mysqli_fetch_array($queryDetailPembelian)){
            $subTotal += $re['subtotal'];
            $diskon += $re['diskon'];
            $pajak += $re['pajak'];
        }
        $grandTotal = $subTotal - ($diskon + $pajak);

        $idSupplier = $_POST['idsupplier'];
        if($idSupplier == "-"){
            echo "noSupplier";
        }else{
            $sql = "update tbpembelian set id_supplier='$idSupplier', subtotal='$subTotal', diskon='$diskon', pajak='$pajak', grandtotal='$grandTotal' where id_pembelian='$id'";
            $query = mysqli_query($con,$sql) or die ($sql);
        
            echo "sukses";
        }
    }else if($tombol == "editDetailPembelian"){
        $sql = "update tbpembeliandetil set id_produk='$produk',jumlah='$jumlah',harga='$harga',pajak='$pajak',jlhpajak='$jlhpajak',diskon='$diskon',jlhdiskon='$jlhdiskon',subtotal='$subtotal' where id='$id'";
        $query = mysqli_query($con,$sql) or die ($sql);
    
        echo "sukses";
    }else if($tombol == "tampilSupplier"){
        $idPembelian = $_POST['idPembelian'];

        $sql = "SELECT *FROM tbpembelian WHERE id_pembelian = '$idPembelian' ";
        $query = mysqli_query($con,$sql);
        $res = mysqli_fetch_array($query);

        echo json_encode($res);
        
    }
    
?>