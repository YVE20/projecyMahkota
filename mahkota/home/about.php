<?php
include "KoneksiHome.php";

$sql2 = "select * from license where id='1'";
$query2 = mysqli_query($con, $sql2);
$res = mysqli_fetch_array($query2);

$namausaha = $res['nama'];
$icon = $res['icon'];



?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="viewport" content="initial-scale=1, maximum-scale=1">
   <title><?php echo $namausaha; ?></title>
   <meta name="keywords" content="">
   <meta name="description" content="">
   <meta name="author" content="">
   <link rel="stylesheet" href="css/bootstrap.min.css">
   <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="css/responsive.css">
   <link rel="shortcut icon" href="asset/img/<?php echo $_SESSION['icon']; ?>">
   <link rel="stylesheet" href="css/jquery.mCustomScrollbar.min.css">
   <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">
</head>
<!-- body -->

<body class="main-layout">
   <header class="">
      <!-- header inner -->
      <div class="header">
         <div class="container-fluid">
            <div class="row">
               <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col logo_section">
                  <div class="full">
                     <div class="center-desk">
                        <div class="logo">
                           <a href="index.php"><img src="../asset/img/<?= $icon ?>" alt="#" style="width: 130px;height:70px;" /></a>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9">
                  <nav class="navigation navbar navbar-expand-md" style="color:black">
                     <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                     </button>
                     <div class="collapse navbar-collapse" id="navbarsExample04">
                        <ul class="navbar-nav mr-auto">
                           <li class="nav-item active">
                              <a class="nav-link" href="index.php">Home</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="about.php">About</a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" href="contact.php">Contact Us</a>
                           </li>
                           <li class="nav-item d_none" onclick="viewKeranjang()">
                              <a class="nav-link" href="#">
                                 <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                 <div id="qtyKeranjang" style="margin-top: -30px;margin-left:20px;"> 0 </div>
                              </a>
                           </li>
                           <?php
                           if ($_SESSION['iduser'] == "") {
                           ?>
                              <li class="nav-item d_none" id="loginText">
                                 <a class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Login</a>
                              </li>
                           <?php
                           } else {
                           ?>
                              <li class="nav-item">
                                 <div class="btn-group">
                                    <a href="javascript:void(0)" class="nav-link dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"> <i class="fa fa-user" aria-hidden="true"></i> </a>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                       <a class="dropdown-item" href="profile.php"> <i class="fa fa-cog" aria-hidden="true"></i> Profile </a>
                                       <a class="dropdown-item" href="logout.php"> <i class="fa fa-sign-out" aria-hidden="true"></i> Log Out </a>
                                    </div>
                                 </div>
                              </li>
                           <?php
                           }
                           ?>
                        </ul>
                     </div>
                  </nav>
               </div>
            </div>
         </div>
      </div>
   </header>
   <!-- about section -->
   <div class="about">
      <div class="container">
         <?php
         if ($_GET['kode_barang'] == "") {
         ?>
            <div class="row d_flex">
               <div class="col-md-5">
                  <div class="titlepage">
                     <h3> <b> Indomie Goreng 1 Dus </b> </h3>
                     <h5> Pangan </h5>
                     <p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
                     <button onclick="minus('1')" class="btn"> - </button>
                     <input type="text" id="qty" value="1" style="width:30px;text-align: center;border:none;" readonly>
                     <button onclick="plus('1')" class="btn"> + </button>
                     <button class="btn w-25" onclick="beli()"> Beli</button>
                  </div>
               </div>
               <div class="col-md-7">
                  <div class="about_img">
                     <figure><img src="images/indomie-dus.jpg" alt="#" style="height:70%;width:70%" /></figure>
                  </div>
               </div>
            </div>
            <?php
         } else {
            $sql3 = "select * from tbproduk where kode_barang='" . $_GET['kode_barang'] . "'";
            $query3 = mysqli_query($con, $sql3);

            while ($re = mysqli_fetch_array($query3)) {
            ?>
               <div class="row d_flex">
                  <div class="col-md-5">
                     <div class="titlepage">
                        <h3> <b> <?= $re['nama'] ?> </b> </h3>
                        <h5> <?= $re['kategori'] ?> (Rp.<?= number_format($re['harga_dk'], 0, ',', '.') ?>) </h5>
                        <p> <?= $re['deskripsi'] != null ? $re['deskripsi'] : "Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat." ?> </p>
                        <button onclick="minusAbout('1')" class="btn"> - </button>
                        <input type="text" id="qty" value="1" style="width:30px;text-align: center;border:none;" readonly>
                        <button onclick="plusAbout('1')" class="btn"> + </button>
                        <button class="btn w-25" onclick="beli()"> Beli</button>
                     </div>
                  </div>
                  <div class="col-md-7 mt-5">
                     <div class="about_img">
                        <figure>
                           <?php
                           if ($re['img_url'] == "") { ?>
                              <i><img src="../pictures/noimage.jpg" alt="#" style="height:70%;width:70%"></i>
                           <?php } else { ?>
                              <i><img src="../pictures/<?= $re['img_url'] ?>" alt="#" style="height:70%;width:70%"></i>
                           <?php } ?>
                        </figure>
                     </div>
                  </div>
            <?php
            }
         }
            ?>
               </div>
      </div>
      <div class="three_box">
         <div class="container">
            <div class="row">
               <?php
               $sql3 = "select * from tbproduk order by rand() LIMIT 4";
               $query3 = mysqli_query($con, $sql3);

               while ($re = mysqli_fetch_array($query3)) {
               ?>
                  <div class="col-md-3">
                     <div class="box_text">
                        <?php
                        if ($re['img_url'] == "") { ?>
                           <i><img src="../pictures/noimage.jpg" alt="#" style="margin-top:-30px"></i>
                        <?php } else { ?>
                           <i><img src="../pictures/<?= $re['img_url'] ?>" alt="#" style="margin-top:-30px;height:10rem;width:10rem"></i>
                        <?php } ?>
                        <div style="text-align: left;margin-left:10px">
                           <h5> <b> <?= strtoupper($re['nama']) ?> </b> <sub> (<?= $re['satuan'] ?>) </sub> </h5>
                           <font> <?= "Rp. " . number_format($re['harga_dk'], 0, ',', '.'); ?> </font> <sub> Stock : <?= $re['jumlah'] ?> </sub>
                        </div>
                        <button class="btn" onclick="beliSekarang('<?= $re['kode_barang'] ?>')"> Beli sekarang </button>
                        <button class="btn" onclick="keranjang('<?= $re['kode_barang'] ?>')"> <img src="images/keranjang.png" alt="#"> </button>
                     </div>
                  </div>
               <?php
               }
               ?>
            </div>
         </div>
      </div>
      <!-- end about section -->
      <!--  footer -->
      <footer class="mt-5">
         <div class="footer">
            <div class="container">
               <div class="row">
                  <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                     <img class="logo1" src="../asset/img/<?= $icon ?>" alt=" #" style="height:50%;width:50%" />
                     <ul class="social_icon">
                        <li><a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                     </ul>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                     <h3>About Us</h3>
                     <ul class="about_us">
                        <li> Jln. Patimura No 71 D, <br> Kota Pontianak, <br> Provinsi Kalimantan Barat  </li>
                     </ul>
                  </div>
                  <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                     <h3>Contact Us</h3>
                     <ul class="conta">
                        <li> <i class="fa fa-envelope" aria-hidden="true"></i>   mahkotapontianak@gmail.com </li>
                        <li> <i class="fa fa-phone" aria-hidden="true"></i> 0214178 </li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="copyright">
               <div class="container">
                  <div class="row">
                     <div class="col-md-12">
                        <p>© 2023 Mahkota Pontianak </a></p>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </footer>
      <!-- Login Modal -->
      <div class="modal fade" style="margin-top: 100px;" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-lg-12">
                        <center>
                           <h2> <b> LOGIN </b> </h2>
                        </center>
                     </div>
                     <div class="col-lg-12 mt-3">
                        <input type="text" name="no_hp" id="no_hp" class="form-control" placeholder="Masukkan No HP">
                     </div>
                     <div class="col-lg-11 mt-3">
                        <input type="password" id="pass" name="pass" class="form-control" placeholder="*********">
                     </div>
                     <div class="col-lg-1 col-1">
                        <input type="checkbox" onclick="showPasswordLogin()" style="height:200%;width:200%;margin-top: -20px;margin-left:-15px">
                     </div>
                     <div class="col-lg-12 mt-3">
                        <center>
                           <button class="btn btn-primary w-50" onclick="ceklogin()"> <i class="fa fa-sign-in" aria-hidden="true"></i> Login </button> <br>
                           Belum punya akun ? <a href="javascript:void(0)" onclick="registerModal()"> Klik disini </a>
                        </center>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Register Modal -->
      <div class="modal fade" style="margin-top: 100px;" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
         <div class="modal-dialog" role="document">
            <div class="modal-content">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-lg-12">
                        <center>
                           <h2> <b> REGISTER </b> </h2>
                        </center>
                     </div>
                     <div class="col-lg-12 col-12 mt-3">
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama">
                     </div>
                     <div class="col-lg-12 col-12 mt-3">
                        <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukkan alamat anda" style="resize:none;"></textarea>
                     </div>
                     <div class="col-lg-12 col-12 mt-3">
                        <input type="text" name="no_hp_register" id="no_hp_register" class="form-control" placeholder="Masukkan No HP">
                     </div>
                     <div class="col-lg-11 col-11 mt-3">
                        <input type="password" id="password" name="password" class="form-control" placeholder="*********">
                     </div>
                     <div class="col-lg-1 col-1">
                        <input type="checkbox" onclick="showPassword()" style="height:200%;width:200%;margin-top: -20px;margin-left:-15px">
                     </div>
                     <div class="col-lg-12 mt-3">
                        <center>
                           <button class="btn btn-primary w-50" onclick="register()"> <i class="fa fa-sign-in" aria-hidden="true"></i> Daftar Sekarang </button>
                        </center>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Keranjang Modal Kosong -->
      <div class="modal fade" style="margin-top: 100px;" id="keranjangModalKosong" tabindex="-1" role="dialog" aria-labelledby="keranjangModalKosongLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
               <div class="modal-body">
                  <div class="row">
                     <div class="col-lg-12">
                        <center>
                           <h2> <b> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Keranjang </b> </h2>
                        </center>
                     </div>
                     <div class="col-lg-12 mt-3">
                        <table class="table">
                           <colgroup>
                              <col style="width:5%">
                              <col style="width:35%">
                              <col style="width:20%">
                              <col style="width:17.5%">
                              <col style="width:17.5%">
                              <col style="width:5%;">
                           </colgroup>
                           <thead>
                              <tr>
                                 <th> # </th>
                                 <th> Barang </th>
                                 <th> Qty </th>
                                 <th> Harga </th>
                                 <th> SubTotal </th>
                                 <th> Action </th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr>
                                 <th colspan="6">
                                    <center> Belum ada barang nih dikeranjangmu &#128521; <br> Ayo buruan belanja sekarang </center>
                                 </th>
                              </tr>
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Checkout </button>
               </div>
            </div>
         </div>
      </div>
      <!-- Keranjang Modal Isi -->
      <div class="modal fade" style="margin-top: 100px;" id="keranjangModal" tabindex="-1" role="dialog" aria-labelledby="keranjangModalLabel" aria-hidden="true">
         <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
               <form action="#" method="POST" enctype="multipart/form-data">
                  <input type="hidden" name="page" value="About">
                  <div class="modal-body">
                     <div class="row">
                        <div class="col-lg-12">
                           <center>
                              <h2> <b> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Keranjang </b> </h2>
                           </center>
                        </div>
                        <div class="col-lg-12 mt-3">
                           <table class="table">
                              <colgroup>
                                 <col style="width:5%">
                                 <col style="width:35%">
                                 <col style="width:20%">
                                 <col style="width:17.5%">
                                 <col style="width:17.5%">
                                 <col style="width:5%;">
                              </colgroup>
                              <thead>
                                 <tr>
                                    <th> # </th>
                                    <th> Barang </th>
                                    <th> Qty </th>
                                    <th> Harga </th>
                                    <th> SubTotal </th>
                                    <th> Action </th>
                                 </tr>
                              </thead>
                              <tbody class="isiDataKeranjang">

                              </tbody>
                           </table>
                        </div>
                     </div>
                  </div>
                  <div class="modal-footer">
                     <button type="button" onclick="beliByKeranjang()" class="btn btn-primary"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> Checkout </button>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- End of modal -->
   <!-- end footer -->
   <!-- Javascript files-->
   <script src="js/jquery.min.js"></script>
   <script src="js/popper.min.js"></script>
   <script src="js/bootstrap.bundle.min.js"></script>
   <script src="js/jquery-3.0.0.min.js"></script>
   <!-- sidebar -->
   <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
   <script src="js/custom.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
   <script>
      $(document).ready(function() {
         countKeranjang();
         viewDataKeranjang();
      });

      function showPassword() {
         var x = document.getElementById("password");
         if (x.type === "password") {
            x.type = "text";
         } else {
            x.type = "password";
         }
      }

      function showPasswordLogin() {
         var x = document.getElementById("pass");
         if (x.type === "password") {
            x.type = "text";
         } else {
            x.type = "password";
         }
      }

      function plus(satu) {
         var qty = $('#qtyJumlahKeranjang').val();
         var harga = $('#harga').val();
         var hasil = parseInt(qty) + parseInt(satu);
      
         var formatedHarga = harga.replace(/\./g, "");
         var hitungSubTotal = hasil * formatedHarga;
         
         $('#qtyJumlahKeranjang').val(hasil);
         $('#subTotal').val(hitungSubTotal.toLocaleString());
      }

      function minus(satu) {
         var qty = $('#qtyJumlahKeranjang').val();
         var harga = $('#harga').val();
         var hasil = parseInt(qty) - parseInt(satu);

         var formatedHarga = harga.replace(/\./g, "");
         var hitungSubTotal = hasil * formatedHarga;
         if (hasil <= 0) {
            Swal.fire({
               icon: 'error',
               title: 'Peringatan',
               text: 'Jumlah barang tidak dapat kurang dari 1',
               showConfirmButton: false,
               timer: 1500
            })
            $('#qtyJumlahKeranjang').val(1);
         } else {
            $('#qtyJumlahKeranjang').val(hasil);
            $('#subTotal').val(hitungSubTotal.toLocaleString());
         }
      }

      function minusAbout(satu){
         var qty = $('#qty').val();
         var hasil = parseInt(qty) - parseInt(satu);

         if (hasil <= 0) {
            Swal.fire({
               icon: 'error',
               title: 'Peringatan',
               text: 'Jumlah barang tidak dapat kurang dari 1',
               showConfirmButton: false,
               timer: 1500
            })
            $('#qty').val(1);
         } else {
            $('#qty').val(hasil);
         }
      }

      function plusAbout(satu){
         var qty = $('#qty').val();
         var hasil = parseInt(qty) + parseInt(satu);

         $('#qty').val(hasil);
      }

      function viewDataKeranjang() {
         var iduser = '<?= $_SESSION['iduser'] ?>';
         $.post("cekkeranjang.php", {
            iduser: iduser,
            typeKeranjang: "dataKeranjang"
         }).done(function(data) {
            $('.isiDataKeranjang').html(data);
         })
      }

      function countKeranjang() {
         var iduser = '<?= $_SESSION['iduser'] ?>';
         $.post("cekkeranjang.php", {
               iduser: iduser,
               typeKeranjang: "count"
            })
            .done(function(data) {
               if (data == "kosong") {
                  $('#qtyKeranjang').html(0);
               } else {
                  $('#qtyKeranjang').html(data);
               }
            });
      }

      function beliSekarang(kode_barang) {
         location.href = "about.php?kode_barang=" + kode_barang;
      }

      function keranjang(kode_barang) {
         var iduser = '<?= $_SESSION['iduser'] ?>';
         if (iduser != null) {
            $.post("cekkeranjang.php", {
                  iduser: iduser,
                  typeKeranjang: "add",
                  kode_barang: kode_barang,
                  qty: 1
               })
               .done(function(data) {
                  if (data == "success") {
                     Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Barang berhasil ditambahkan ke keranjang',
                        showConfirmButton: false,
                        timer: 1500
                     });
                     countKeranjang();
                  }else if(data == "minus"){
                     Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Stock tidak mencukupi',
                        showConfirmButton: false,
                        timer: 1500
                     });
                  }
               });
         }
      }

      function registerModal() {
         $('#loginModal').modal('hide');
         $('#registerModal').modal('show');
      }

      function viewKeranjang() {
         var iduser = '<?= $_SESSION['iduser'] ?>';
         $.post("cekkeranjang.php", {
               iduser: iduser,
               typeKeranjang: "view"
            })
            .done(function(data) {
               if (data == "kosong") {
                  $('#keranjangModalKosong').modal('show');
               } else {
                  $('#keranjangModal').modal('show');
                  viewDataKeranjang();
               }
            });
      }

      function register() {
         $.post("register.php", {
            nama: $('#nama').val(),
            alamat: $('#alamat').val(),
            no_hp: $('#no_hp_register').val(),
            password: $('#password').val(),
            page: "About"
         }).done(function(data) {
            if (data == "sukses") {
               Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: 'Akun anda berhasil dibuat',
                  showConfirmButton: false,
                  timer: 2500
               });
               $('#loginModal').modal('show');
               $('#registerModal').modal('hide');
               clearRegisForm();
            } else if (data == "gagal") {
               Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: 'Akun dengan no HP ' + $('#no_hp_register').val() + 'sudah pernah terdaftar',
                  showConfirmButton: false,
                  timer: 2500
               });
            }
         });
      }

      function ceklogin() {
         $.post("ceklogin.php", {
               no_hp: $('#no_hp').val(),
               pass: $('#pass').val()
            })
            .done(function(data) {
               if (data == "kosong") {
                  //Akun ada tapi data keranjang 0
                  $('#qtyKeranjang').html("0");
                  $('#loginModal').modal('hide');
                  $('#loginText').css('display', 'none');
                  location.reload();
               } else if (data == "invalid") {
                  //Akun tidak ada
                  Swal.fire({
                     icon: 'error',
                     title: 'Gagal',
                     text: 'Anda belum memiliki akun',
                     showConfirmButton: false,
                     timer: 2500
                  });
               } else {
                  //Akun ada dan data keranjang tidak kosong
                  Swal.fire({
                     icon: 'success',
                     title: 'Welcome',
                     showConfirmButton: false,
                     timer: 2500
                  });
                  $('#qtyKeranjang').html(data);
                  location.reload();
               }
            });
      }

      function beliByKeranjang() {
         var formData = new FormData();
         formData.append('page', 'About');

         $.ajax({
            url: "cekstockout.php",
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(data) {
               if (data == "kosong") {
                  Swal.fire({
                     icon: 'error',
                     title: 'Gagal',
                     text: 'Barang tidak ditemukan',
                     showConfirmButton: false,
                     timer: 1500
                  });
               } else if (data == "minus" || data == "nol") {
                  Swal.fire({
                     icon: 'error',
                     title: 'Gagal',
                     text: 'Stock tidak mencukupi',
                     showConfirmButton: false,
                     timer: 1500
                  });
               } else if (data == "") {
                  Swal.fire({
                     icon: 'success',
                     title: 'Berhasil',
                     text: 'Barang berhasil dibeli',
                     showConfirmButton: false,
                     timer: 1500
                  });
                  setTimeout(autoLoad, 1500);
               }
            }
         });
      }

      function autoLoad() {
         location.href = "index.php";
      }

      function beli() {
         var qty = $('#qty').val();
         var kode_barang = "<?= $_GET['kode_barang'] ?>";
         var iduser = '<?= $_SESSION['iduser'] ?>';
         Swal.fire({
            title: 'Perhatian',
            text: "Anda yakin ingin membeli barang tersebut ? Barang akan dibayar dengan sistem COD",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, beli !',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.isConfirmed) {
               if (iduser === "") {
                  Swal.fire({
                     icon: 'error',
                     title: 'Batal',
                     text: 'Harap login terlebih dahulu',
                     showConfirmButton: false,
                     timer: 1500
                  });
                  $('#loginModal').modal('show');
               } else {
                  $.post("cekdatabarang.php", {
                        qty: qty,
                        kode_barang: kode_barang,
                        page: "About",
                        iduser: iduser
                     })
                     .done(function(data) {
                        if (data == "kosong") {
                           Swal.fire({
                              icon: 'error',
                              title: 'Gagal',
                              text: 'Barang tidak ditemukan',
                              showConfirmButton: false,
                              timer: 1500
                           });
                        } else if (data == "minus") {
                           Swal.fire({
                              icon: 'error',
                              title: 'Gagal',
                              text: 'Stock tidak mencukupi',
                              showConfirmButton: false,
                              timer: 1500
                           });
                        } else if (data == "sukses") {
                           Swal.fire({
                              icon: 'success',
                              title: 'Berhasil',
                              text: 'Barang berhasil dibeli',
                              showConfirmButton: false,
                              timer: 1500
                           });
                           location.href = "index.php";
                        }
                     });
               }
            } else {
               Swal.fire({
                  icon: 'error',
                  title: 'Batal',
                  text: 'Barang batal dibeli',
                  showConfirmButton: false,
                  timer: 1500
               });
            }
         })
      }
      function clearRegisForm(){
         $('#nama').val("");
         $('#alamat').val("");
         $('#no_hp_register').val("");
         $('#password').val("");
      }
      function deleteCartItems(idKeranjang){
         var iduser = '<?= $_SESSION['iduser'] ?>';
         $.post("cekkeranjang.php", {
            iduser: iduser,
            idKeranjang : idKeranjang,
            typeKeranjang: "deleteKeranjangItems"
         }).done(function(data) {
            if(data == "kosong"){
               Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: 'Barang tidak ditemukan di keranjang',
                  showConfirmButton: false,
                  timer: 1500
               });
            }else if(data == "deleted"){
               Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: 'Barang dikeranjang berhasil dihapus',
                  showConfirmButton: false,
                  timer: 1500
               });
            }
            viewDataKeranjang();
            countKeranjang();
         })
      }
   </script>
</body>

</html>