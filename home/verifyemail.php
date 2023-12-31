<?php 

session_start();
include "KoneksiHome.php";

include "../asset/function/function.php";

$getEmail = $_GET['email'];
$getRetry = $_GET['retry'];
$getAction = $_GET['action'];
$getExpiredDate = $_GET['expiredDate'];

$urlEcomm = "http://".$_SERVER['SERVER_NAME']."/home/index.php";


if($getAction == "register"){
    $getAction = encryptIt("register");
}

if(decryptIt($getAction) == "register"){
    if($getRetry == 'true'){
        //Check Email di DB
        $sqlCheck = "SELECT *FROM tbkonsumen WHERE email='$getEmail'";
        $queryCheck = mysqli_query($con,$sqlCheck);
        $rows = mysqli_num_rows($queryCheck);
        $result = mysqli_fetch_array($queryCheck);
    
        if($rows == 0){
            $_SESSION['verified'] = "not";
            header('Location: '.$urlEcomm);
        }else{
            //Update Status
            $idKonsumen = $result['id'];
            $sqlUpdateVerified = "Update tbkonsumen set verified='1', auth='', token='' WHERE id='$idKonsumen'";
            $queryUpdateVerified = mysqli_query($con,$sqlUpdateVerified);
    
            $_SESSION['verified'] = "yes";
            header('Location: '.$urlEcomm);
        }
    
    }else{
        $getToken = $_GET['token'];
    
        //Check Token dengan email
        $sqlCheck = "SELECT *FROM tbkonsumen WHERE token ='$getToken' AND email='$getEmail'";
        $queryCheck = mysqli_query($con,$sqlCheck);
        $rows = mysqli_num_rows($queryCheck);
        $result = mysqli_fetch_array($queryCheck);
    
        if($rows == 0){
            $_SESSION['verified'] = "not";
            header('Location: '.$urlEcomm);
        }else{
            //Check Expired Token
            $expiredDateAuth = $getExpiredDate;
            $today = date("Y-m-d H:i:s");
            if($today > date('Y-m-d H:i:s', strtotime($expiredDateAuth. ' + 1 days'))){
                //   
                 $_SESSION['verified'] = "expired";
                 header('Location: '.$urlEcomm);
            }else{
                 //Update Status
                $idKonsumen = $result['id'];
                $sqlUpdateVerified = "Update tbkonsumen set verified='1', auth='', token='' WHERE id='$idKonsumen'";
                $queryUpdateVerified = mysqli_query($con,$sqlUpdateVerified);
        
                $_SESSION['verified'] = "yes";
                header('Location: '.$urlEcomm);
            }
        }
    }
}else if(decryptIt($getAction) == "forgetPassword"){
?>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <!-- sidebar -->
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $(document).ready(function(){
            Swal.fire({
                title: 'Perhatian',
                text : "Tuliskan passwordmu",
                input: 'password',
                inputAttributes: {
                autocapitalize: 'off'
                },
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-plus" aria-hidden="true"></i>  Simpan',
                cancelButtonText : 'Batal',
                showLoaderOnConfirm: true,
                preConfirm: (password) => {
                    //Proses kirim email
                    $.post("verifyemail.php", {
                        password : password,
                        email : '<?= $getEmail ?>',
                        action : "updateForgetPassword",
                        expiredDate : '<?= $getExpiredDate ?>'
                    }).done(function(data) {
                        if(data == "success"){
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Password berhasil diupdate, silahkan login',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(autoLoad, 1500);
                        }else if(data =="notFound") {
                            Swal.fire({
                                icon: 'error',
                                title: 'Peringatan',
                                text: 'Email tidak ditemukan',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(autoLoad, 1500);
                        }else if(data == "expired"){
                            Swal.fire({
                                icon: 'error',
                                title: 'Peringatan',
                                text: 'Token sudah expired, silahkan request ulang',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(autoLoad, 1500);
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Peringatan',
                                text: 'Penggunaan password yang sama dengan saat ini tidak diijinkan',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(autoLoad, 1500);
                        }
                    })
                }
            })
        }); 

        function autoLoad(){
            location.href = '<?= $urlEcomm ?>';
        }
    </script>
<?php
}else if($_POST['action'] == "updateForgetPassword"){
    //Check Email di DB
    $email = $_POST['email'];
    $sqlCheck = "SELECT *FROM tbkonsumen WHERE email='$email'";
    $queryCheck = mysqli_query($con,$sqlCheck);
    $rows = mysqli_num_rows($queryCheck);
    $result = mysqli_fetch_array($queryCheck);

    $password = encryptIt($_POST['password']);
    if($rows == 0){
        echo "notFound";
    }else{
        //Check Token dan Auth masih valid atau engga
        $expiredDateAuth = $_POST['expiredDate'];
        $today = date("Y-m-d H:i:s");
        if($today > date('Y-m-d H:i:s', strtotime($expiredDateAuth. ' + 1 days'))){
            echo "expired";
        }else{
            //Check password lama dan baru
            if($password == $result['password']){
                echo "same";
            }else{
                //Update Status
                $idKonsumen = $result['id'];
                $sqlUpdateVerified = "Update tbkonsumen set password ='$password', auth='', token='' WHERE id='$idKonsumen'";
                $queryUpdateVerified = mysqli_query($con,$sqlUpdateVerified);

                echo "success";
            }
        }
    }
}

?>