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
   <!-- header -->
   <header>
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
                  <div class="col-lg-4 col-12 float-right" id="goToProfile" onclick="location.href='profile.php'" style="z-index: 999;background-color: #c2c7cf;border-radius: 0px 0px 10px 10px;color:black;cursor:pointer"> Alamat : <span id="isiAlamat"> Indonesia </span> </div>
                  <div class="float-right col-lg-12" style="margin-top:-35px;"> 
                     <nav class="navigation navbar navbar-expand-md" style="color:black">
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
                           <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarsExample04" >
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
      </div>
   </header>
   <!-- end header inner -->
   <!-- end header -->
   <!--  contact -->
   <div class="contact">
      <div class="container mt-5">
         <div class="row">
            <div class="col-md-12">
               <div class="titlepage">
                  <h2>Contact Now</h2>
               </div>
            </div>
         </div>
         <div class="row">
            <div class="col-md-10 offset-md-1">
               <form id="request" class="main_form">
                  <div class="row">
                     <div class="col-md-12 ">
                        <input class="contactus" placeholder="Name" type="type" name="Name">
                     </div>
                     <div class="col-md-12">
                        <input class="contactus" placeholder="Email" type="type" name="Email">
                     </div>
                     <div class="col-md-12">
                        <input class="contactus" placeholder="Phone Number" type="type" name="Phone Number">
                     </div>
                     <div class="col-md-12">
                        <textarea class="textarea" placeholder="Message" type="type" Message="Name">Message </textarea>
                     </div>
                     <div class="col-md-12">
                        <button class="send_btn">Send</button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- end contact -->
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
                           Belum punya akun ? <a href="javascript:void(0)" onclick="registerModal()"> Klik disini </a> <br>
                        <a href="javascript:void(0)" style="color:#4f83d6" onclick="lupaPassword()"> Lupa password </a>
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
                     <input type="email" name="email" required id="email" class="form-control" placeholder="Masukkan Email">
                  </div>
                  <div class="col-lg-12 col-12 mt-3">
                     <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukkan Nama" required>
                  </div>
                  <div class="col-lg-12 col-12 mt-3">
                     <textarea name="alamat" id="alamat" required class="form-control" placeholder="Masukkan alamat anda" style="resize:none;"></textarea>
                  </div>
                  <div class="col-lg-12 col-12 mt-3">
                     <input type="text" name="no_hp_register" id="no_hp_register" class="form-control" placeholder="Masukkan No HP">
                  </div>
                  <div class="col-lg-11 col-11 mt-3">
                     <input type="password" id="password" required name="password" class="form-control" placeholder="*********">
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
   <!-- Keranjang Modal Ada Isi -->
   <div class="modal fade" style="margin-top: 100px;" id="keranjangModal" tabindex="-1" role="dialog" aria-labelledby="keranjangModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
         <div class="modal-content ">
            <form action="#" method="POST" enctype="multipart/form-data">
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
   <input type="hidden" id="checkVerified" value="<?= $_SESSION['verified']?>"> 
   <input type="text" id="listIdKeranjang"> 
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

      function checkEmailVerified(){
         var verifiedStatus = $('#checkVerified').val();
         if(verifiedStatus == "yes"){
            Swal.fire({
               icon: 'success',
               title: 'Berhasil',
               text : 'Selamat akun anda sudah aktif',
               showConfirmButton: false,
               timer: 3500
            })
            deleteSession();
         }else if(verifiedStatus == "not"){
            Swal.fire({
               icon: 'error',
               title: 'Gagal',
               text: 'Akun belum di verifikasi',
               showConfirmButton: false,
               timer: 3500
            });
         }
      }

      $(document).ready(function() {
         countKeranjang();
         viewDataKeranjang();
         checkEmailVerified();
         deleteSession();
         checkAlamat();
      });

      function deleteSession(){
         sessionStorage.removeItem('verified');
         <?php unset($_SESSION['verified']) ?>
      }

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

      function plus(satu,idKeranjang) {
         var qty = $('#qtyJumlahKeranjang_'+idKeranjang).val();
         var harga = $('#harga_'+idKeranjang).val();
         var hasil = parseInt(qty) + parseInt(satu);
      
         var formatedHarga = harga.replace(/\./g, "");
         var hitungSubTotal = hasil * formatedHarga;
         
         $('#qtyJumlahKeranjang_'+idKeranjang).val(hasil);
         $('#subTotal_'+idKeranjang).val(hitungSubTotal.toLocaleString());
         countTotalHargaKeranjang();
      }

      function minus(satu,idKeranjang) {
         var qty = $('#qtyJumlahKeranjang_'+idKeranjang).val();
         var harga = $('#harga_'+idKeranjang).val();
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
            $('#qtyJumlahKeranjang_'+idKeranjang).val(1);
         } else {
            $('#qtyJumlahKeranjang_'+idKeranjang).val(hasil);
            $('#subTotal_'+idKeranjang).val(hitungSubTotal.toLocaleString());
         }
         countTotalHargaKeranjang();
      }


      function viewDataKeranjang() {
         var iduser = '<?= $_SESSION['iduser'] ?>';
         $.post("cekkeranjang.php", {
            iduser: iduser,
            typeKeranjang: "dataKeranjang"
         }).done(function(data) {
            var split = data.split('###');
            $('.isiDataKeranjang').html(split[0]);
            $('#listIdKeranjang').val(split[1]);
            countTotalHargaKeranjang();
         })
      }

      function countTotalHargaKeranjang(){
         var iduser = '<?= $_SESSION['iduser'] ?>';
         var idKeranjang = $('#listIdKeranjang').val();
         var slice = idKeranjang.slice(0,-1);
         var splitIDKeranjang = slice.split("|");

         var totalHarga = 0;
         splitIDKeranjang.forEach(function(item){
            var harga = $('#subTotal_'+item).val();
            if(harga.indexOf(".") !== -1){
               var formatedHarga = harga.replace(/\./g, "");
            }else{
               var formatedHarga = harga.replace(",", "");
            }          
            
            totalHarga = parseInt(totalHarga) + parseInt(formatedHarga);    
         });
         $('#totalHarga').html(totalHarga.toLocaleString());         
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

      function keranjang(kode_barang) {
         var iduser = '<?= $_SESSION['iduser'] ?>';
         if (iduser != "") {
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
                  }
               });
         } else {
            $('#loginModal').modal('show');
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
            email : $('#email').val(),
            page: "Index"
         }).done(function(data) {
            var split = data.split("|");
            console.log(data);
            if (split[0] == "sukses") {
               $.post("sendEmail.php",{
                  auth : split[1],
                  email : split[2],
                  nama : split[3]
               }).done(function(data){
                  console.log(data);
                     Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Mohon tunggu sebentar',
                        showConfirmButton: false,
                        timer: 5500
                     });
                  if(data == "sukses"){
                     Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Akun anda berhasil dibuat, silahkan melakukan verifikasi email',
                        showConfirmButton: false,
                        timer: 2500
                     });
                  }
               });
               $('#loginModal').modal('hide');
               $('#registerModal').modal('hide');
               clearRegisForm();
            } else if (split[0] == "gagal") {
               Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: 'Akun dengan no HP ' + $('#no_hp_register').val() + ' sudah pernah terdaftar',
                  showConfirmButton: false,
                  timer: 2500
               });
            }else if(split[0] == "errorEmail"){
               Swal.fire({
                  icon: 'error',
                  title: 'Gagal',
                  text: 'Terdapat permasalahan pada saat mengirim email',
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
               } else if(data == "!verified"){
                  //Akun belum di verified
                  Swal.fire({
                     icon: 'error',
                     title: 'Gagal',
                     html : '<font style="font-size:0.9em"> Akun anda belum aktif, segera cek email anda </font>',
                     footer : '<a href="javascript:void()" onclick="checkEmail()" style="color:#3489eb"> Klik disini untuk verifikasi email </a>',
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
      function checkEmail(){
         $('#loginModal').modal('hide');
         Swal.fire({
            title : 'Perhatian',
            text: 'Tuliskan email yang digunakan untuk mendaftar',
            input: 'text',
            inputAttributes: {
               autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Kirim',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
               location.href="verifyemail.php?email="+login+"&retry=true&action=register";
            }
         })
      }

      function beliByKeranjang() {
         var listIdKeranjang = $('#listIdKeranjang').val();
         var removeLastChar = listIdKeranjang.substring(0, listIdKeranjang.length - 1);
         var dataIdKeranjang = removeLastChar.split("|");

         var dataQty = "";

         dataIdKeranjang.forEach(function(item){
            var qty = $('#qtyJumlahKeranjang_'+item).val();
            dataQty += qty+"|"+item+"_";
         });

         var formData = new FormData();
         var qtyDalamKeranjang = $('#qtyJumlahKeranjang').val();
         formData.append('page', 'Index');
         formData.append('dataQty', dataQty);

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
         location.href = "contact.php";
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
      function checkAlamat(){
         var iduser = '<?= $_SESSION['iduser'] ?>';
         $.post("cekprofile.php", {
            iduser: iduser,
            type: "checkAlamat"
         }).done(function(data) {
            if(data != ""){
               $('#isiAlamat').html(data);
            }else{
               $('#isiAlamat').click(function(){
                  $('#goToProfile').attr('onclick','#');
                  $('#loginModal').modal('show');
               });
            }
         })
      }
      function lupaPassword(){
         $('#loginModal').modal('hide');
         Swal.fire({
            title: 'Perhatian',
            text : "Tuliskan emailmu yang terdaftar pada sistem",
            input: 'email',
            inputAttributes: {
               autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: '<i class="fa fa-paper-plane" aria-hidden="true"></i> Kirim',
            cancelButtonText : 'Batal',
            showLoaderOnConfirm: true,
            preConfirm: (email) => {
               //Proses kirim email
               $.post("sendEmail.php", {
                  email : email,
                  type: "ForgetPassword"
               }).done(function(data) {
                  console.log(data);
               })
            }
         })
      }
   </script>
</body>

</html>