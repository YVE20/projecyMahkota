<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
		html{
			margin:30px;
            margin: 0;
		}
		.table{
			border-collapse: collapse;
			width: 100%;
		}
		.table th, .table td{
            font-size: 14px;
            padding:4px;
            border:1px solid #bebebe;
            page-break-inside: avoid;
        }
	</style>
</head>
<body style="margin: 0;">
    <div>
        
        <?php session_start();?>
        <img src="asset/img/<?= $_SESSION['icon'] ?>" alt="Gambar" style="height:8em;width:15em">
        <div style="margin-top: -50px;">
            <center>
                <strong> <font style="font-size: 30px;"> Mahkota </font> </strong> <br>
                Jln. Patimura No 71 D, Kota Pontianak, Provinsi Kalimantan Barat . <br>
                Email : mahkotapontianak@gmail.com<br>
                Telp : 0818286025
            </center>
        </div>
    </div>
    <?php 

        include "Koneksi.php";
        include "asset/function/function.php";

        $tombol = $_GET['tombol'];
        $tanggalmulai = $_GET['tanggalmulai'];
        $tanggalselesai = $_GET['tanggalselesai'];
        $produk = $_GET['produk'];
        $user = $_GET['user'];
        $konsumen = $_GET['konsumen'];

        $syarat = "";
        $syaratdetil = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat = " AND (tj.tanggal BETWEEN '$tanggalmulai' AND '$tanggalselesai')";
        }
        if ($user != "ALL") {
            $syarat .= " AND tj.iduser='$user'";
        }
        if ($konsumen != "ALL") {
            $syarat .= " AND tj.idkonsumen='$konsumen'";
        }
        if ($produk != "ALL") {
            $syarat .= " AND tjd.idproduk='$produk'";
            $syaratdetil .= " AND tjd.idproduk='$produk'";
        }
        $sqlsel = "SELECT tj.id,tj.tanggal,tk.nama AS 'namakonsumen',tu.nama AS 'namauser', tj.created_at FROM tbjual tj LEFT JOIN tbuser tu on tj.iduser=tu.iduser LEFT JOIN tbkonsumen tk ON tj.idkonsumen=tk.id INNER JOIN tbjualdetil tjd ON tj.id=tjd.idjual WHERE tj.id!='' $syarat  GROUP BY tjd.idjual ORDER BY tj.created_at DESC";
    ?>
    <table id="datatable-fixed-header" class="table table-striped nowrap" cellspacing="0" style="width:100%;margin-top:30px">
    <thead>
            <tr>
                <th>No.</th>
                <th>ID Transaksi</th>
                <th>Tanggal</th>
                <th>Waktu</th>
                <th>User</th>
                <th>Konsumen</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Diskon</th>
                <th>Subtotal</th>
                <th>Total</th>
            </tr>
        </thead>

        <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $x = 1;
            $sumharga = 0;
            $sumjumlah = 0;
            $sumtotal = 0;
            $sumpajak = 0;
            $sumdiskon = 0;
            $sumsubtotal = 0;
            while ($res = mysqli_fetch_array($querysel)) {
                $idtransaksi = $res['id'];
                $tanggal = tgl_bahasa($res['tanggal']);
                $created_at = $res['created_at'];
                $user = $res['namauser'];
                $karyawan = $res['namakaryawan'];
                $konsumen = $res['namakonsumen'];

            ?>
                <tr>
                    <td><?php echo $x; ?></td>
                    <td><?php echo $idtransaksi; ?></td>
                    <td><?php echo $tanggal; ?></td>
                    <td><?php echo $created_at; ?></td>
                    <td> <?= $user == "" ? "Processed by FO" :  $user ?> </td>
                    <td><?php echo $konsumen; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <!-- <td></td> -->
                    <td></td>
                    <td></td>
                </tr>
                <?php
                $sqldet = "select tjd.jumlah, tjd.harga, tjd.total, tp.nama as 'namaproduk', tjd.diskon, tjd.jlhdiskon,tjd.subtotal from tbjualdetil tjd inner join tbproduk tp on tjd.idproduk=tp.id where tjd.idjual='$idtransaksi' $syaratdetil order by tjd.id";
                $querydet = mysqli_query($con, $sqldet);
                //                echo $sqldet;
                while ($resdet = mysqli_fetch_array($querydet)) {
                    $jumlah = $resdet['jumlah'];
                    $harga = $resdet['harga'];
                    $total = $resdet['total'];
                    $namaproduk = $resdet['namaproduk'];
                    $diskon = $resdet['diskon'];
                    $jlhdiskon = $resdet['jlhdiskon'];
                    $subtotal = $resdet['subtotal'];
                ?>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><?php echo $namaproduk; ?></td>
                        <td><?php echo "Rp " . uang($harga); ?></td>
                        <td><?php echo $jumlah; ?></td>
                        <td><?php echo "$diskon % (" . uang($jlhdiskon) . ")"; ?></td>
                        <td><?php echo "Rp " . uang($subtotal); ?></td>
                        <td><?php echo "Rp " . uang($total); ?></td>
                    </tr>
            <?php
                    $sumharga += $harga;
                    $sumjumlah += $jumlah;
                    $sumtotal += $total;
                    $sumdiskon += $jlhdiskon;
                    $sumsubtotal += $subtotal;
                }
                $x++;

                if ($produk != "ALL") {
                    $col1 = "Rp " . uang($harga);
                    $col2 = $sumjumlah;
                    $col3 = "Rp " . uang($sumdiskon);
                    $col4 = "Rp ";
                    $col5 = "Rp " . uang($sumsubtotal);
                } else {
                    $col1 = "";
                    $col2 = "";
                    $col3 = "";
                    $col4 = "";
                    $col5 = "";
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <!-- <th></th> -->
                <th></th>
                <th></th>
                <th></th>
                <th style="text-align:right;"> Total Akhir </th>
                <th><?php echo $col1; ?></th>
                <th><?php echo $col2; ?></th>
                <th><?php echo $col3; ?></th>
                <!-- <th><?php echo $col4; ?></th> -->
                <th><?php echo $col5; ?></th>
                <th><?php echo "Rp " . uang($sumtotal); ?></th>
            </tr>
        </tfoot>
    </table>
</body>
<script>
    window.print();
    onafterprint = function () {
        window.location.href = "lappenjualan_detil.php";
    }
</script>
</html>