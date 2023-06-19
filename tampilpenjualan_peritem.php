<?php
/**
 * Created By :    
 * User: Welly
 * Date: 11/02/2018
 * Time: 12:45
 */
    include "Koneksi.php";
    include "asset/function/function.php";

    $tombol = $_POST['tombol'];
    $tanggalmulai = $_POST['tanggalmulai'];
    $tanggalselesai = $_POST['tanggalselesai'];
    $produk = $_POST['produk'];

    if($tombol == "tampilcari") {
        $syarat = "";
        $syaratdetil = "";
        if ($tanggalmulai != "" && $tanggalselesai != "") {
            $syarat .= " AND (tj.tanggal BETWEEN '$tanggalmulai' AND '$tanggalselesai')";
        }
        
        if ($produk != "ALL"){
            $syarat .= " AND tjd.idproduk='$produk'";
        }
        $sqlsel = "SELECT SUM(tjd.jumlah) AS 'totaljumlah', SUM(tjd.total) AS 'totalakhir',tm.nama, tm.satuan, tjd.harga FROM tbjualdetil tjd INNER JOIN tbproduk tm ON tjd.idproduk=tm.id INNER JOIN tbjual tj ON tjd.idjual=tj.id WHERE tjd.id!='' $syarat GROUP BY tjd.idproduk";

        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Satuan</th>
                <th>Total</th>
            </tr>
            </thead>

            <tbody>
            <?php
            $querysel = mysqli_query($con, $sqlsel);
            $sumtotalakhir=0;
            while ($res = mysqli_fetch_array($querysel)) {
                $totaljumlah = $res['totaljumlah'];
                $totalakhir = $res['totalakhir'];
                $produk = $res['nama'];
                $satuan = $res['satuan'];
                $harga = $res['harga'];
                ?>
                <tr>
                    <td><?php echo $produk;?></td>
                    <td><?php echo "Rp ".uang($harga);?></td>
                    <td><?php echo $totaljumlah;?></td>
                    <td><?php echo $satuan;?></td>
                    <td><?php echo "Rp ".uang($totalakhir);?></td>
                </tr>
                <?php
                $sumtotalakhir += $totalakhir;
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>Total Akhir</td>
                    <td><?php echo "Rp ".uang($sumtotalakhir);?></td>
                </tr>
            </tfoot>
        </table>
        <script>
            var produk = '<?php echo $_POST['produk']?>';
            var tanggalmulai = '<?php echo $_POST['tanggalmulai']?>';
            var tanggalselesai = '<?php echo $_POST['tanggalselesai']?>';

            $('#datatable-fixed-header').DataTable({
                "ordering": false,
                fixedHeader: true,
                "scrollX": true,
                dom: 'Bfrtip',
                buttons: [
//                    'copy', 'csv', 'excel', 'pdf', 'print'
//                    'pageLength', 'excelFlash', 'print'
                    'pageLength',
                    { extend: 'excelFlash', footer:true},
                    { extend: 'print', footer:true},
                    { 
                        text : 'PDF', 
                        action :function(){
                            window.location.href="cetak_lappenjualan_peritem.php?ts="+tanggalselesai+"&tm="+tanggalmulai+"&produk="+produk;
                        }
                    }
                ],
                lengthMenu: [
                    [10, 25, 50, -1],
                    ['10 rows', '25 rows', '50 rows', 'Show all']
                ],
                iDisplayLength: -1
            });

        </script>
        <?php
    }