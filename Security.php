<?php

    


    session_start();

    if(!isset($_SESSION['ujilogin']))
    {
        echo"
                <script>
                    alert('Anda tidak memiliki hak akses\\nSilahkan login terlebih dahulu!!');
                    location.href = 'Login.php';
                </script>
            ";
    }