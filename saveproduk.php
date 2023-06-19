<?php
include "Koneksi.php";
include "asset/function/function.php";

$tombol = $_POST['tombol'];
$id = $_POST['id'];
$kodebarang = $_POST['kode_barang'];
$nama = $_POST['nama'];
$gambar = $_FILES['img_url']['name'];
$gambar_temp = $_FILES['img_url']['tmp_name'];
$hargadalam = $_POST['hargadalam'];
$satuan = $_POST['satuan'];
$kategori = $_POST['kategori'];
$deskripsi = $_POST['deskripsi'];
//$gambarUpdate = $_FILES['imgupload'];


if ($tombol == "simpan") {
  $sql = "INSERT INTO tbproduk (kode_barang,nama,harga_dk,img_url,satuan,kategori,jumlah,deskripsi) VALUES ('$kodebarang','$nama','$hargadalam','$gambar','$satuan','$kategori','0','$deskripsi')";

  if (mysqli_query($con, $sql)) {
    move_uploaded_file($_FILES['img_url']['tmp_name'], "pictures/$gambar");
  }
} else if ($tombol == "edit") {
  //Cek data Dari DB
  $sqlFoto = "select img_url from tbproduk where id = '$id'";
  $queryFoto = mysqli_query($con, $sqlFoto);

  $isiFoto = mysqli_fetch_array($queryFoto);
  $urlGambar = "";

  if ($isiFoto[0] == null) {
    if ($gambar == null) {
      $urlGambar = null;
    } else {
      $urlGambar = $gambar;
    }
  } else {
    $urlGambar = $isiFoto[0];
  }

  $sql = "UPDATE tbproduk SET kode_barang='$kodebarang', nama='$nama',harga_dk='$hargadalam',satuan='$satuan',kategori='$kategori',img_url='$urlGambar', deskripsi='$deskripsi' WHERE id='$id'";
  $query = mysqli_query($con, $sql) or  die($sql);
} else if ($tombol == "hapus") {
  $sql = "DELETE FROM tbproduk WHERE id='$id'";
  $query = mysqli_query($con, $sql) or die($sql);
} else if ($tombol == "tampiledit") {
  $sql = "SELECT * FROM tbproduk WHERE id='$id'";
  $query = mysqli_query($con, $sql) or die($sql);

  $re = mysqli_fetch_array($query);
  $id = $re['id'];
  $kodebarang = $re['kode_barang'];
  $nama = $re['nama'];
  $gambar = $re['img_url'];
  $hargadalam = $re['harga_dk'];
  $satuan = $re['satuan'];
  $kategori = $re['kategori'];
  $deskripsi = $re['deskripsi'];

  if ($gambar == null) {
    $gambar = "NULL";
  }

  echo "|" . $id . "|" . $kodebarang . "|" . $nama . "|" . $gambar . "|" . $hargadalam . "|" . $satuan . "|" . $kategori . "|" . $deskripsi . "|";
} else if ($tombol == "tampil") {
?>
  <table id="datatable-fixed-header" class="table table-striped table-bordered nowrap" cellspacing="0" width="100%">
    <colgroup>
      <col style="width: 10%;">
      <col style="width: 20%;">
      <col style="width: 15%;">
      <col style="width: 10%;">
      <col style="width: 10%;">
      <col style="width: 10%;">
      <col style="width: 15%;">
      <col style="width: 10%;">
    </colgroup>
    <thead>
      <tr>
        <th>Kode</th>
        <th>Nama</th>
        <th>Harga Jual</th>
        <th>Satuan</th>
        <th>Kategori</th>
        <th>Stok</th>
        <th>Gambar</th>
        <th>Action</th>
      </tr>
    </thead>

    <tbody>
      <?php
      $no = 1;
      $sqlsel = "SELECT * FROM tbproduk ORDER BY nama DESC";
      $querysel = mysqli_query($con, $sqlsel);
      while ($res = mysqli_fetch_array($querysel)) {
        $id = $res['id'];
        $kodebarang = $res['kode_barang'];
        $nama = $res['nama'];
        $hargadalam = $res['harga_dk'];
        $satuan = $res['satuan'];
        $kategori = $res['kategori'];
        $stok = $res['jumlah'];
        $gambar = $res['img_url'];

      ?>
        <tr>
          <td><?php echo $kodebarang; ?></td>
          <td><?php echo $nama; ?></td>
          <td><?php echo "Rp " . uang($hargadalam); ?></td>
          <td><?php echo $satuan; ?></td>
          <td><?php echo $kategori; ?></td>
          <td><?php echo $stok; ?></td>
          <td>
            <img src="pictures/<?= $gambar ?>" alt="Gambar" style="height:30%;width:30%">
          </td>
          <td>
            <button class="btn btn-sm btn-warning" onclick="f_edit('<?php echo $id; ?>')"><span class="fa fa-pencil"></span></button>
            <button class="btn btn-sm btn-danger" onclick="f_hapus('<?php echo $id; ?>')"><span class="fa fa-times"></span></button>
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
      "scrollX": true,
    });
  </script>
<?php
}
