<?php

    include "Koneksi.php";

    $tombol = $_POST['tombol'];
    $id = $_POST['id'];
    $kategori = $_POST['kategori'];
    // $kategori = $_POST['kategori'];
    // $satuan = $_POST['satuan'];

    if($tombol == "simpan"){
      $sql = "insert into tbkategori (kategori) values ('$kategori')";
      $query =  mysqli_query($con,$sql) or die ($sql);

      // $sqlselect = "select * from tbkategori order by created_at asc limit 0,1";
      // $queryselect = mysqli_query($con,$sqlselect);
      // $resselect = mysqli_fetch_array($queryselect);
      // echo $resselect['id_kategori'];
    //   echo mysql_error($con);
    }
    else if($tombol == "edit"){
      $sql = "update tbkategori set kategori='$kategori' where id_kategori='$id'";
      $query = mysqli_query($con,$sql) or  die ($sql);
    }
    else if($tombol == "hapus"){
      $sql = "delete from tbkategori where id_kategori='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);
    }
    else if($tombol == "tampiledit"){
      $sql = "select * from tbkategori where id_kategori='$id'";
      $query = mysqli_query($con,$sql) or die ($sql);

      $re = mysqli_fetch_array($query);
      $id = $re['id_kategori'];
      $kategori = $re['kategori'];

      echo "|".$id."|".$kategori."|";
    }
    else if($tombol == "tampil"){
    ?>
    <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
        width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Kategori</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>
            <?php
                $sqlsel = "select tbkategori.* from tbkategori order by id_kategori asc";
                $querysel = mysqli_query($con,$sqlsel);
                $no=1;
                while($res = mysqli_fetch_array($querysel)){
                $id = $res['id_kategori'];
                $kategori = $res['kategori'];
                
                //   $kategori = $res['kategori'];
                //   $satuan = $res['satuan'];
                ?>
            <tr>
                <td><?php echo $no;?></td>
                <td><?php echo $kategori;?></td>

                <td>
                    <button class="btn btn-sm btn-warning" onclick="f_edit('<?php echo $id;?>')"><span class="fa fa-pencil"></span></button>
                    <button class="btn btn-sm btn-danger" onclick="f_hapus('<?php echo $id;?>')"><span class="fa fa-times"></span></button>
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
            fixedHeader: true
        });
    </script>
    <?php
        }