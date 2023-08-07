<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Detail Pembelian </title>
    <style type="text/css">
		html{
			margin:30px;
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
<body>
    <?php 
        include "Koneksi.php";
        include "asset/function/function.php";
        date_default_timezone_set("Asia/Jakarta");
        setlocale(LC_TIME, "id_ID");

        $idPembelian = $_GET['idPembelian'];

        $sqlDetailPembelian = "SELECT *FROM tbpembeliandetil tbdt INNER JOIN tbproduk tp ON tbdt.id_produk = tp.id INNER JOIN tbpembelian tbp ON tbdt.id_pembelian = tbp.id_pembelian WHERE tbdt.id_pembelian = '$idPembelian' ";
        $queryDetailPembelian = mysqli_query($con,$sqlDetailPembelian);

        $sqlPembelian = "select *from tbpembelian where id_pembelian = '$idPembelian'";
        $queryPembelian = mysqli_query($con,$sqlPembelian);
        $data = mysqli_fetch_array($queryPembelian);
    ?>
        <div>
            <h3> Invoice Pembelian </h3>
        </div>
        <center> 
            <font> <strong> <?= $_SESSION['nama_perusahaan']." Pontianak"?> </strong> </font> <br> 
            <font> Jln. Jln. Patimura No 71 D, Kota Pontianak, Provinsi Kalimantan Barat </font>  <br><br>
        </center>
        <hr>
        <table style="text-align: left;">
            <thead>
                <tr>
                    <th> No Pembelian  </th>
                    <td> : <?= $idPembelian ?> </td>
                </tr>
                <tr>
                    <th> No Invoice  </th>
                    <td> : <?= $data['noInvoice'] ?> </td>
                </tr>
                <tr>
                    <th> Tanggal Cetak </th>
                    <td> : <?= date('d M Y H:i:s \G\M\T') ?> </td>
                </tr>
            </thead>
        </table>
        <table class="table" style="margin-top: 10px;">
            <thead>
                <tr>
                    <th> # </th>
                    <th> Produk </th>
                    <th> Qty </th>
                    <th> Harga </th>
                    <th> Diskon </th>
                    <th> Pajak </th>
                    <th> Sub Total </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $row = 1; $hitung = 0;
                    while($re = mysqli_fetch_array($queryDetailPembelian)){
                        $hitung += $re[9];
                        echo 
                        "<tr>
                            <td> ".$row++." </td>
                            <td> ".$re['nama']." </td>
                            <td> ".$re[3]." </td>
                            <td> Rp. ".number_format($re['harga'],0,',','.')." </td>
                            <td> Rp. ".number_format($re['jlhdiskon'],0,',','.')." </td>
                            <td> Rp. ".number_format($re['jlhpajak'],0,',','.')." </td>
                            <td> Rp. ".number_format($re[9],0,',','.')." </td>
                        </tr>";
                    }
                ?>
            </tbody>
            <tfoot>
                <?php 
                    echo 
                    "<tr>
                        <th colspan='6'> <center> Total </center> </th>
                        <th> Rp ".number_format($hitung,0,',','.')." </th>
                    </tr>";
                ?>
            </tfoot>
        </table>
</body>
<script>
    window.print();
    onafterprint = function () {
        window.location.href = "frmlistpembelian.php";
    }
</script>
</html>