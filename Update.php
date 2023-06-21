<?php


include "Koneksi.php";

$sql = "";
$query = mysqli_query($con,$sql);

header("location:Login.php");