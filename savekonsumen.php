<?php

    include "Koneksi.php";
    include "asset/function/function.php";

    $tombol = $_POST['tombol'];
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $nohp = $_POST['no_hp'];
    $email = $_POST['email'];

    if ($tombol == "simpan") {
        $sql = "INSERT INTO tbkonsumen (nama,alamat,no_hp,email) VALUES ('$nama','$alamat','$nohp','$email')";
        $query = mysqli_query($con, $sql) or die($sql);

        echo $sql;
    }
    else if($tombol == "edit"){
        $sql = "UPDATE tbkonsumen SET nama='$nama', alamat='$alamat', no_hp='$nohp', email='$email' where id='$id'";
        $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
      $sql = "DELETE FROM tbkonsumen WHERE id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
      $sql = "SELECT * FROM tbkonsumen WHERE id='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);

      $re = mysqli_fetch_array($query);
      $id = $re['id'];
      $nama = $re['nama'];
      $alamat = $re['alamat'];
      $nohp = $re['no_hp'];
      $email = $re['email'];

      echo "|".$id."|".$nama."|".$alamat."|".$nohp."|".$email;
    }
    else if($tombol == "tampil"){
    ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
          <thead>
            <tr>
              <th>No</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>No HP</th>
              <th>Email</th>
              <th>Action</th>
            </tr>
          </thead>

          <tbody>
          <?php
            $no = 1;
            $sqlsel = "SELECT * FROM tbkonsumen ORDER BY nama DESC";
            $querysel = mysqli_query($con,$sqlsel);
            while($res = mysqli_fetch_array($querysel)){
              $id = $res['id'];
              $nama = $res['nama'];
              $alamat = $res['alamat'];
              $nohp = $res['no_hp'];
              $email = $res['email'];
              
              ?>
                <tr>
                  <td><?php echo $no++;?></td>
                  <td><?php echo $nama;?></td>
                  <td><?php echo $alamat;?></td>
                  <td><?php echo $nohp;?></td>
                  <td><?php echo $email;?></td>
                  <td>
                    <button class="btn btn-sm btn-warning" onclick="f_edit('<?php echo $id;?>')"><span class="fa fa-pencil"></span></button>
                    <button class="btn btn-sm btn-danger" onclick="f_hapus('<?php echo $id;?>')"><span class="fa fa-times"></span></button>
                  </td>
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