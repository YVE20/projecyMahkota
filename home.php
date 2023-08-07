<?php
$menu_head = "home";
include "Header.php";
$user = $_SESSION['username'];
$tahun = date("Y");
?>
<!--Include Header End-->

<!--Content-->

<div id="content">
    <div class="panel box-shadow-none content-header">
    </div>
    <div class="form-element">
        <div class="col-md-12 padding-0">

            <div class="row">
                <!-- start col-8 -->
                <div id="col-left" class="col-md-8">
                    <div class="col-md-12">
                        <!-- start panel -->
                        <div class="panel">
                            <div class="panel-body">
                                <div class="col-md-9 col-xs-6">
                                    <h1 class="text-title-heading">Hello</h1>
                                    <h4 class="text-title-ket">Mahkota Pontianak</h4>
                                </div>
                                <div class="col-md-3 col-xs-6 text-center">
                                    <img src="asset/img/index_icon.svg" class="img-responsive" alt="halo">
                                </div>
                            </div>
                        </div>
                        <!-- end panel -->
                    </div>
                    <!-- end banner -->

                    <!-- start col-4 -->
                    <div class="col-md-6">
                        <div class="panel">
                            <div class="panel-body">
                                <?php
                                $sqljual = "select sum(grandtotal) from tbjual where tanggal='$tgl_jak'";
                                $queryjual = mysqli_query($con, $sqljual);
                                $resjual = mysqli_fetch_array($queryjual);
                                $totalpenjualan = $resjual[0];
                                ?>
                                <div class="col-sm-8 col-xs-6">
                                    <h3 class="text-info" style="color:#2196F3;">
                                        <strong><?php echo "Rp " . uang($totalpenjualan); ?></strong>
                                    </h3>
                                    <h5 class="text-left text-info-ket">Total Pendapatan Hari Ini</h5>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <h5 style="font-size:6rem;" class="text-right">
                                        <span style="color:#2196F3;" class="fas fa-hand-holding-usd"></span>
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <!-- start col-4 -->
                    <div class="col-md-6 ">
                        <div class="panel">
                            <div class="panel-body">
                                <?php
                                $bulan = date("m");
                                $sqljual = "select sum(grandtotal) from tbjual where MONTH(tanggal)='$bulan' AND YEAR(tanggal) = '$tahun'";
                                $queryjual = mysqli_query($con, $sqljual);
                                $resjual = mysqli_fetch_array($queryjual);
                                $totalpenjualan = $resjual[0];
                                ?>
                                <div class="col-sm-8 col-xs-6">
                                    <h3 class="text-info" style="color:#2196F3;">
                                        <strong><?php echo "Rp " . uang($totalpenjualan); ?></strong>
                                    </h3>
                                    <h5 class="text-left text-info-ket">Total Pendapatan Bulan Ini</h5>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <h3 style="font-size:6rem;" class="text-right">
                                        <span style="color:#2196F3;" class="fas fa-money-check-alt"></span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 ">
                        <div class="panel">
                            <div class="panel-body">
                                <?php
                                    $sqlCekStock = "select *from tbproduk where jumlah <= 10";
                                    $queryCekStock = mysqli_query($con,$sqlCekStock);
                                    $rows = mysqli_num_rows($queryCekStock);
                                ?>
                                <div class="col-sm-8 col-xs-6">
                                    <h3 class="text-info" style="color:#2196F3;">
                                        <strong> Total : <?= $rows ?> </strong>
                                    </h3>
                                    <h5 class="text-left text-info-ket"> Jumlah Stock Dibawah 10  </h5>
                                    <span>
                                        <ol>
                                            <?php 
                                                if($rows == 0){
                                                    echo "<center> <strong> Tidak ada data </strong> </center>";
                                                }else{
                                                    while($re = mysqli_fetch_array($queryCekStock)){
                                                        echo "<li> ".$re['nama']." </li>";
                                                    }
                                                }
                                            ?>
                                        </ol>
                                    </span>
                                </div>
                                <div class="col-sm-4 col-xs-6">
                                    <h3 style="font-size:6rem;" class="text-right">
                                        <i style="color:#2196F3;" class="fa fa-cubes" aria-hidden="true"></i>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end col-6 -->
                    <div class="clear-fix"></div>
                    

                </div>
                <!-- end col-8 -->

                <!-- start col-4 -->
                <div id="col-right" class="col-md-4">
                    <div class="col-md-12 col-sm-6">
                        <div class="panel">
                            <div class="panel-body" style="padding-bottom:30px;">
                                <div class="">

                                    <h4>Banyak Terjual</h4>
                                    <hr>
                                    <canvas id="chartBarang" height="315"></canvas>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end pie chart -->

                </div>
                <!-- end col-4 -->
            </div>

        </div>
        <!-- end col-12 -->
    </div>
    <!-- end form element -->
</div>

<!--Page Content End-->

<!--Include Footer-->
<?php include "Footer.php"; ?>
<!--Include Footer End-->

<script>
    var timer;

    $(document).ready(function() {
        
        loadpie();
        loadline();
        // chartPie();

    });


    

    function loadpie() {

        $.post("tampilhome.php", {
                tombol: "pie"
            })
            .done(function(data) {
                //  $("#tablebahan").html(data);
                var obj = JSON.parse(data);
                var arr = [];
                var nama_arr = [];
                for (var i = 0; i < obj.length; i++) {
                    var counter = obj[i];
                    nama_arr.push(counter.nama)
                    arr.push(counter.qty);
                }
                chartPie(arr, nama_arr)
            });
    }

    function loadline() {
        var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $.post("tampilhome.php", {
                tombol: "line"
            })
            .done(function(data) {
                //  $("#tablebahan").html(data);
                var obj = JSON.parse(data);
                var total_arr = [];
                var bulan_arr = [];
                for (var i = 0; i < obj.length; i++) {
                    var counter = obj[i];
                    var bulan_ = bulan[counter.Bulan - 1]; // kurang 1 karena array mulai dari 0
                    bulan_arr.push(bulan_)
                    total_arr.push(counter.Grandtotal);
                }
                chartLine(total_arr, bulan_arr)

            });
    }

    function none() {
        window.setInterval(function() {
            $.post("tampilhome.php", {
                    tombol: "tampilbahan"
                })
                .done(function(data) {
                    $("#tablebahan").html(data);
                })
        }, 3000);
    }



    function chartLine(value_arr, label_arr) {
        // Line chart
        var tahun = '<?php echo $tahun ?>';
        var ctx = document.getElementById('myChart');
        var myLineChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: label_arr,
                    datasets: [{
                        label: 'Penjualan ' + tahun,
                        data: value_arr,
                        backgroundColor: '#2196F3',
                        borderColor: '#2196F3',
                        fill: false,
                        showLine: true,
                        pointRadius: 10,
                        pointHoverRadius: 5
                    }]
                },
                options: {
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                let value = data.datasets[0].data[tooltipItem.index];
                                return formatRupiah(parseInt(value).toString());
                                }
                            }
                        },
                        scales: {
                            yAxes: [{
                                ticks: {
                                    callback: function(label, index, labels) {
                                        return formatRupiah(parseInt(label).toString());
                                    }
                                },
                            }]
                        },

                    }
                });
            // end chart function
        }

        function chartPie(value_arr, label_arr) {
            // For a pie chart
            var ctx = document.getElementById('chartBarang');
            var myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: label_arr,
                    datasets: [{
                        data: value_arr,
                        backgroundColor: [
                            "#3498db",
                            "#9b59b6",
                            "#e67e22",
                            "#2ecc71",
                            "#f1c40f"
                        ]
                    }]
                },
                options: {
                    responsive: true,
                }
            });

        }
</script>