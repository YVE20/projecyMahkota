<?php
/**
 * Created By :    
 * User: Welly
 * Date: 11/02/2018
 * Time: 12:45
 */
    include "Koneksi.php";

    session_start();

    $tombol = $_POST['tombol'];
    $id = $_POST['id'];
    $kategori = $_POST['kategori'];
    $produk = $_POST['produk'];
    $jumlah = $_POST['jumlah'];
    $iduser = $_SESSION['iduser'];

    if($tombol == "simpan"){
        $sql = "INSERT INTO tblogsproduk (idproduk,jumlah,kategori,iduser) VALUES ('$produk','$jumlah','$kategori','$iduser')";
        $query =  mysqli_query($con,$sql) or die ($sql);

        $sqlbahan = "SELECT jumlah FROM tbproduk WHERE id='$produk'";
        $querybahan = mysqli_query($con,$sqlbahan);
        $resbahan = mysqli_fetch_array($querybahan);
        //   $jlhbahan = $resbahan['jumlah'];
        $jlhproduk = $resbahan['jumlah'] + $jumlah;

        $sqlupdate = "UPDATE tbproduk set jumlah='$jlhproduk' WHERE id='$produk'";
        $queryupdate = mysqli_query($con,$sqlupdate);
    }
    else if($tombol == "tampil"){
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>produk</th>
              <th>Jumlah</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $sqlsel = "SELECT * FROM tbproduk WHERE id='$produk'";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
              $id = $res['id'];
              $jumlah = $res['jumlah'];
              $namaproduk = $res['nama'];
              $satuanproduk = $res['satuan'];
              ?>
                <tr>
                  <td><?php echo $namaproduk;?></td>
                  <td><?php echo $jumlah." ".$satuanproduk;?></td>
                </tr>
              <?php
            }
          ?>
          </tbody>
        </table>
        <script>

            $('#datatable-fixed-header').DataTable({
                fixedHeader: true
            });

        </script>
        <?php
    }