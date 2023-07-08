<?php
    $menu_head = "penjualan";
    include "Header.php";

    $act = $_GET['act'];
    $idget = $_GET['id'];

if ($act=="new") {
    $ip = get_ip();
    $sqlsum = "select max(SUBSTRING_INDEX(id,'-',-1)) from tbjual where YEAR(tanggal)=YEAR(CURDATE())";
    $querysum = mysqli_query($con, $sqlsum) or die($sqlsum);
    $ressum = mysqli_fetch_array($querysum);
    $maxno = $ressum[0] + 1;
    $tanggal = date("Ymd");
    $judul = "Penjualan";

    if ($ip == "::1") {
        $ip = "1";
    } else {
        $pecah = explode('.', $ip);
        $ip = $pecah[3];
    }

    $idtransaksi = "J-" . $tanggal . "-" . $ip . "-" . $_SESSION['iduser'] . "-" . pad_left($maxno, 0, 5);


    $waktusekarang = date("H:i");
//        $waktusekarang = "08:21";
    
} elseif ($act=="edit") {
    $idtransaksi = $idget;
}
?>
<!-- page content -->
<div id="content">
    <div class="panel box-shadow-none content-header">
    </div>
    <div class="form-element">
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="col-md-12 panel">
                    <div class="col-md-12 panel-heading">
                        <input type="hidden" name="idKonsumenCheckAlamat" id="idKonsumenCheckAlamat">
                        <h4>Form Penjualan
                        </h4>
                        <span> ID Transaksi : <?php echo $idtransaksi;?></span>
                        <!-- <div id="shiftkaryawan"> Shift : <?php echo $shiftkaryawan;?>
                    </div> -->
                    <input type="hidden" name="txtidtransaksi" id="txtidtransaksi"
                        value="<?php echo $idtransaksi;?>" />
                    <input type="hidden" name="txtshiftkaryawan" id="txtshiftkaryawan"
                        value="<?php echo $shiftkaryawan;?>" />
                </div>
                <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                    <div class="col-md-3">
                        <div class="form-group form-element">
                            <label style="top:-10px;">Konsumen</label>
                            <select class="form-control col-md-7 col-xs-12 combobox selectpicker" onchange="pilihAlamat(this.value)" data-live-search="true" data-size="5" name="cmbkonsumen" id="cmbkonsumen" 
                                <?php if ($act == 'edit') {
                                    echo 'disabled';
                                } ?> >
                                <option value="-">-- Pilih Konsumen --</option>
                                <?php
                                    $sqlmenu = "SELECT * FROM tbkonsumen where id!='0' ORDER BY nama ASC";
                                    $querymenu = mysqli_query($con, $sqlmenu);
                                    while ($res = mysqli_fetch_array($querymenu)) {
                                        $id = $res['id'];
                                        $nama = $res['nama'];
                                        $alamat = $res['alamat']; ?>
                                    <option value="<?php echo $id; ?>"> <?php echo $nama; ?> </option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3" style="margin-top:10px;padding-right:0px;">
                        <div class="form-group form-animate-text">
                            <input type="date" class="form-text" id="txttgltransaksi" name="txttgltransaksi" <?php if ($act == 'edit') {
                                            echo 'readonly';
                                        } ?>
                            >
                            <span class="bar"></span>
                            <label style="top:-10px">Tanggal Penjualan</label>
                        </div>
                    </div>
                    <div class="col-md-12 panel" style="margin-top:20px;">
                        <form class="cmxform" id="frm" method="get" action="">
                            <input type="hidden" name="txtid" id="txtid" />

                            <div id="produknormal" name="produknormal" class="col-md-3">
                            </div>

                            <div class="col-md-7">
                                <div class="col-md-2">
                                    <div class="form-group form-animate-text">
                                        <label
                                            style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Jumlah</label>
                                        <input type="text" <?php if ($act == 'edit') {
                                            //echo 'disabled';
                                        } ?>
                                        class="form-text" id="txtjumlah" name="txtjumlah" value="1"
                                        onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id);hitungharga()">
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-animate-text">
                                        <label
                                            style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Harga</label>
                                        <input type="text" <?php if ($act == 'edit') {
                                            // echo 'disabled';
                                        } ?>
                                        class="form-text" id="txtharga" name="txtharga" readonly onfocus="f_tonumber(this.id)"
                                        onblur="f_tocurrency(this.id);hitungharga()" value="0" >
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                
                                <div class="col-md-2">
                                    <div class="form-group form-animate-text">
                                        <label
                                            style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Diskon (%)</label>
                                        <input type="text" <?php if ($act == 'edit') {
                                            // echo 'disabled';
                                        } ?>
                                        class="form-text" id="txtdiskon" name="txtdiskon" value="0"
                                        onfocus="f_tonumber(this.id)" onblur="f_tocurrency(this.id);hitungharga()"> 
                                        <input type="hidden" id="txtjlhdiskon" name="txtjlhdiskon" value="0" />
                                        <span class="bar"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group form-animate-text">
                                        <label
                                            style="top:-10px;color:#918C8C;font-size:13px !important;font-weight:400;">Total</label>
                                        <input type="text" class="form-text" id="txttotal" name="txttotal" value="0"
                                            readonly>
                                        <span class="bar"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2" style="margin-top:25px;">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?php
                                                        if ($act=='edit') {
                                                            ?>
                                            <button type="button" class="submit btn btn-info" name="simpan" id="simpan"
                                                value="edit" onclick="f_simpan(); return false;"> Save
                                            </button>
                                            <!-- <button type="button" class="submit btn btn-info" name="kurang" id="kurang"
                                                value="kurang" onclick="f_pilihretur('kurang'); return false;"> Retur
                                            </button> -->
                                            <?php
                                                        } else {
                                                            ?>
                                            <button type="button" class="submit btn btn-info" name="simpan" id="simpan"
                                                value="simpan" onclick="f_simpan(); return false;"> Save
                                            </button>
                                            <?php
                                                        }
                                                    ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <?php
                                                    if ($act=='edit') {
                                                        ?>
                                            <button type="button" class="submit btn btn-warning" name="reset" id="reset"
                                                value="simpan" style="display:none;" disabled onclick="f_bersih();">
                                                Reset </button>
                                            <!-- <button type="button" class="submit btn btn-info" name="tambah"
                                                        id="tambah" value="tambah" onclick="f_pilihretur('tambah'); return false;"> Tambah
                                                    </button> -->
                                            <?php
                                                    } else {
                                                        ?>
                                            <button type="button" class="submit btn btn-warning" name="reset" id="reset"
                                                value="simpan" onclick="f_bersih();"> Reset </button>
                                            <?php
                                                    }
                                                ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="col-md-12" id="table" name="table">
                        </div>
                    </div>
                    <div class="col-md-4 col-md-offset-8">
                        <div class="row">
                            <div class="col-md-3" style="padding-top:10px;padding-left:10px;">
                                <label style="color:#918C8C;font-weight:bold;font-size:17px;">Subtotal</label>
                            </div>
                            <div class="col-md-9 form-group form-animate-text"
                                style="margin-top:0px !important;margin-bottom:0px !important;">
                                <input type="text" class="form-text text-right" id="txtsubtotal" name="txtsubtotal"
                                    value="0" readonly>
                                <span class="bar"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="padding-top:10px;padding-left:10px;">
                                <label style="color:#918C8C;font-weight:bold;font-size:17px;">Diskon</label>
                            </div>
                            <div class="col-md-9 form-group form-animate-text"
                                style="margin-top:0px !important;margin-bottom:0px !important;">
                                <input type="text" class="form-text text-right" id="txttotaldiskon"
                                    name="txttotaldiskon" value="0" onblur="hitungtotal()">
                                <span class="bar"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="padding-top:10px;padding-left:10px;" hidden>
                                <label style="color:#918C8C;font-weight:bold;font-size:17px;">Pajak</label>
                            </div>
                            <div class="col-md-9 form-group form-animate-text"
                                style="margin-top:0px !important;margin-bottom:0px !important;" hidden>
                                <input type="text" class="form-text text-right" id="txttotalpajak" name="txttotalpajak"
                                    value="0" onblur="hitungtotal()">
                                <span class="bar"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3" style="padding-top:10px;padding-left:10px;">
                                <label style="color:#918C8C;font-weight:bold;font-size:17px;">Grandtotal</label>
                            </div>
                            <div class="col-md-9 form-group form-animate-text"
                                style="margin-top:0px !important;margin-bottom:0px !important;">
                                <input type="text" class="form-text text-right" id="txtgrandtotal" name="txtgrandtotal"
                                    value="0" readonly>
                                <span class="bar"></span>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px;">
                            <button type="button" class="submit pull-right btn btn-primary" name="proses" id="proses"
                                value="simpan" onclick="f_proses();"> Proses </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal -->
<!-- <div class="modal fade" id="modalRetur" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Retur</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6 form-group form-animate-text">
                                <input type="number" class="form-text" id="txtjlhretur" name="txtjlhretur" value="1">
                                <span class="bar"></span>
                                <label for="">Jumlah Retur (Per PCS <strong><span
                                            id="txtjlhpersatuan"></span></strong>)</label>
                            </div>
                            <div class="col-md-6 form-group form-animate-text">
                                <input type="number" class="form-text" id="txtisipersatuan" name="txtisipersatuan"
                                    readonly onfokus="" value="0">
                                <span class="bar"></span>
                                <label for="">Isi Per Kemasan <span id="txtsatuan"></span></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="rdkelayakan" id="rdkelayakan1" value="layak" checked> Layak
                            </label>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="radio">
                            <label>
                                <input type="radio" name="rdkelayakan" id="rdkelayakan2" value="tidaklayak"> Tidak Layak
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="f_prosesretur()">Proses</button>
            </div>
        </div>
    </div>
</div> -->

<!-- page content -->
<?php include "Footer.php";?>

<!-- Alamat Modal -->
<div class="modal fade" style="margin-top: 100px;" id="alamatModal" tabindex="-1" role="dialog" aria-labelledby="alamatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel"> <i class="fa fa-bars" aria-hidden="true"></i> List Alamat </h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row" id="isiListAlamat">  
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    var act = "<?php echo $act;?>";
    var idget = "<?php echo $idget;?>";

    // VARIABEL UNTUK DETAIL PENJUALAN
    var $id = $("#txtid");
    var $produk = $("#cmbproduk");
    var $jumlah = $("#txtjumlah");
    var $harga = $("#txtharga");
    var $total = $("#txttotal");
    var $idjual = $("#txtidtransaksi");
    var $diskon = $("#txtdiskon");
    var $jlhdiskon = $("#txtjlhdiskon");
    var $pajak = $("#txtpajak");
    var $jlhpajak = $("#txtjlhpajak");
    var $tiperetur;
    var $rdkelayakan = $("input[name=rdkelayakan]:checked");
    // VARIABEL UNTUK PROSES PENJUALAN
    var $idkonsumen = $("#cmbkonsumen");
    var $subtotal = $("#txtsubtotal");
    var $totaldiskon = $("#txttotaldiskon");
    var $totalpajak = $("#txttotalpajak");
    var $grandtotal = $("#txtgrandtotal");
    var $satuan = $("#txtsatuan");
    var $jlhpersatuan = $("#txtjlhpersatuan");
    var $isisatuan = $("#txtisipersatuan");
    var $tgltransaksi = $("#txttgltransaksi");

    var pajak_global = 0;
    var $simpan = $("#simpan");

    alertify.minimalDialog || alertify.dialog('minimalDialog', function() {
        return {
            main: function(content) {
                this.setHeader('Please Wait');
                this.setContent('<h4 style="margin-top:20px;">Transaksi sedang diproses</h4>');
            }
        }
    });

    // function metodebayar(param) {
    //     if (param == "Cash") {
    //         $("#jatuhtempo").css('display', 'none');
    //     } else {
    //         $("#jatuhtempo").css('display', 'block');
    //     }
    // }

    function f_simpan() {
        // Swal.showLoading();
        var tombol = $("#simpan").val();
        var action = '<?= $_GET['act'] ?>';

        if ($produk.val() != "" && $jumlah.val() != "") {
            $.post("savepenjualan.php", {
                    tombol: tombol,
                    idjual: $idjual.val(),
                    id: $id.val(),
                    idkonsumen: $idkonsumen.val(),
                    produk: $produk.val(),
                    jumlah: $jumlah.val(),
                    harga: accounting.unformat($harga.val(), ','),
                    total: accounting.unformat($total.val(), ','),
                    diskon: $diskon.val(),
                    jlhdiskon: accounting.unformat($jlhdiskon.val(), ','),
                    pajak: $pajak.val(),
                    jlhpajak: accounting.unformat($jlhpajak.val(), ','),
                    action : action
                })
                .done(function(data) {
                    if (data == "sukses") {
                        loaddata();
                        $("#reset").click();
                    } else if (data == "kosong") {
                        Swal.fire({
                            type: 'error',
                            title: 'Stok untuk Produk ini tidak mencukupi'
                        })
                    } else if (data == "sudah ada") {
                        Swal.fire({
                            type: 'error',
                            title: 'Produk ini sudah diinput, silahkan diedit'
                        })
                    } else if(data == "noKonsumen"){
                        Swal.fire({
                            type: 'error',
                            title: 'Harap pilih konsumen terlebih dahulu'
                        })
                    }
                });
        } else {
            Swal.fire({
                type: 'error',
                title: 'Produk Belum dipilih'
            })
        }
    }

    function f_proses() {
        if ($idkonsumen.val() != "" && $grandtotal.val() != 0) {
            $.post("savepenjualan.php", {
                    tombol: "proses",
                    act: act,
                    idjual: $idjual.val(),
                    tgltransaksi: $tgltransaksi.val(),
                    subtotal: accounting.unformat($subtotal.val(), ','),
                    diskon: $diskon.val(),
                    pajak: $pajak.val(),
                    grandtotal: accounting.unformat($grandtotal.val(), ','),
                    idKonsumen : $('#idKonsumenCheckAlamat').val(),
                    action : '<?= $_GET['act'] ?>'
                })
                .done(function(data) {
                    if (data == "kosong") {
                        Swal.fire({
                            type: 'error',
                            title: 'Tambahkan Produk terlebih dahulu'
                        })
                    }
                    if (data == "Sudah Ada") {
                        Swal.fire({
                            type: 'error',
                            title: 'No Penjualan Sudah Ada'
                        })
                    }else {
                        f_print($idjual.val());
                    }
                });
        } else {
            Swal.fire({
                type: 'error',
                title: 'Data Masih Kosong'
            })
        }
    }

    // function f_pilihretur(tipe) {
    //     if ($produk.val() != '') {
    //         $tiperetur = tipe;
    //         $('#modalRetur').modal('show')
    //     }
    // }

    // function f_prosesretur() {
    //     $("input[name=rdkelayakan]").change(function() {
    //         $("input[name=rdkelayakan]:checked").val()
    //     });

    //     if ($("input[name=rdkelayakan]:checked").val() == 'tidaklayak') {
    //         $jlhretur.val(0);
    //     }

    //     $.post("savepenjualan.php", {
    //             tombol: "prosesretur",
    //             act: act,
    //             idjual: idget,
    //             produk: $produk.val(),
    //             tipe: 'kurang',
    //             jlhretur: $jlhretur.val(),
    //             kelayakan: $("input[name=rdkelayakan]:checked").val(),
    //         })
    //         .done(function(data) {
    //             $('#modalRetur').modal('hide')
    //             Swal.fire(
    //                 'Berhasil',
    //                 'Berhasil Retur',
    //                 'success'
    //             )

    //         }).fail(function() {
    //             Swal.fire(
    //                 'Gagal',
    //                 'Gagal Retur',
    //                 'warning'
    //             )
    //         })
    //     f_bersih()
    //     loaddata()
    //     hitungtotal()
    // }

    function f_bersih() {
        $simpan.val("simpan");
        $produk.val("");
        $produk.prop("disabled", false);
        $jumlah.val("0");
        $harga.val("0");
        $total.val("0");
        $diskon.val("0");
        $jlhdiskon.val("0");
        $pajak.val("0");
        $jlhpajak.val("0");
        document.getElementById('txttgltransaksi').valueAsDate = new Date();
        $('.selectpicker').selectpicker('refresh');
        $("#txtjumlah").blur();
        $('#txttotal').focus();
    }

    function f_cancel() {
        $.post("savepenjualan.php", {
                tombol: "cancel",
                idjual: $idjual.val(),
            })
            .done(function(data) {
                location.href = "frmpenjualan.php?act=new&id=";
            });
    }

    function loaddata() {
        var action = '<?= $_GET['act'] ?>';
        $.post("savepenjualan.php", {
                tombol: "tampil",
                idjual: $idjual.val(),
                action : action
            })
            .done(function(data) {
                $("#table").html(data);
                hitungtotal();
                loadcanvas();

                if(action == "edit"){
                    $('#proses').html("Proses Edit");
                }

            });
    }

    function f_edit(id) {
        var action = '<?= $_GET['act'] ?>';
        $("#reset").click();
        $.post("savepenjualan.php", {
                tombol: "tampiledit",
                id: id,
                action : action
            })
            .done(function(data) {
                var pecah = data.split("|");
                $id.val(pecah[1]);
                $produk.val(pecah[2]);
                $jumlah.val(pecah[4]);
                $harga.val(accounting.formatNumber(pecah[5], 0, '.', ','));
                $total.val(accounting.formatNumber(pecah[6], 0, '.', ','));
                $diskon.val(pecah[7]);
                $jlhdiskon.val(accounting.formatNumber(pecah[8], 0, '.', ','));
                $pajak.val(pecah[9]);
                $jlhpajak.val(accounting.formatNumber(pecah[10], 0, '.', ','));
                $isisatuan.val(pecah[11]);
                $satuan.text(pecah[12]);
                $jlhpersatuan.text(1 / parseInt(pecah[13]));

                $('.selectpicker').selectpicker('refresh');
                $produk.prop("disabled", true);
                $simpan.val("edit");
                $simpan.html("Edit");
            });
    }

    function loadproduk() {
        $.post("savepenjualan.php", {
                tombol: "cekkonsumen",
                idkonsumen: $idkonsumen.val(),
            })
            .done(function(data) {
                var pecah = data.split("|");
                let wilayah = pecah[2];
                let kategori_konsumen = pecah[3];
                let pajak_ = pecah[4];
                pajak_global = pecah[4];
                $pajak.val(0);

                $.post("savepenjualan.php", {
                        tombol: "tampilproduk",
                        produk: $produk.val()
                    })
                    .done(function(data) {
                        $jumlah.val(1)
                        var pecahProduk = data.split("|");
                        $harga.val(accounting.formatNumber(pecahProduk[2], 0, '.', ','));
                        hitungharga();
                    });
            });
    }

    function loadcanvas() {
        $.post("savepenjualan.php", {
                tombol: "tampilprodukcanvas",
            })
            .done(function(data) {
                $("#produknormal").html(data);
                $('.selectpicker').selectpicker('refresh');
                $produk = $("#cmbproduk");
            });
    }
    function hitungharga() {
        var jumlah = parseInt($jumlah.val());
        var total = parseInt(accounting.unformat($total.val(), ','));
        var harga = parseInt(accounting.unformat($harga.val(), ','));
        var pajak = parseInt($pajak.val());
        var diskon = parseInt($diskon.val());
        var jlhpajak = 0;
        var jlhdiskon = 0;


        if (diskon == "" || diskon == "0" || diskon <= 0) {
            diskon = 0;
            jlhdiskon = 0;
        } else {
            jlhdiskon = (jumlah * harga) * diskon / 100;
        }

        if (pajak == "" || pajak == "0" || pajak <= 0) {
            pajak = 0;
            jlhpajak = 0;
        } else {
            jlhpajak = ((jumlah * harga) - jlhdiskon) * pajak / 100;
        }

        var totalharga = (jumlah * harga) - jlhdiskon + 0;
        $total.val(accounting.formatNumber(totalharga, 0, '.', ','));
        $pajak.val(String(pajak));
        $jlhpajak.val(accounting.formatNumber(jlhpajak, 0, '.', ','));
        $diskon.val(String(diskon));
        $jlhdiskon.val(accounting.formatNumber(jlhdiskon, 0, '.', ','));

    }

    function hitungtotal() {
        $.post("savepenjualan.php", {
                tombol: "hitungtotal",
                idjual: $idjual.val(),
                action : '<?= $_GET['act'] ?>'
            })
            .done(function(data) {
                var pecah = data.split("|");
                for (var i = 0; i < pecah.length; i++) {
                    if (pecah[i] == "" || pecah[i] == null) {
                        pecah[i] = 0;
                    }
                }
                var subtotal = parseInt(pecah[2]);
                var diskon = parseInt(pecah[1]);
                var grandtotal = parseInt(pecah[0]);

                $subtotal.val(accounting.formatNumber(subtotal, 0, '.', ','));
                $totaldiskon.val(accounting.formatNumber(diskon, 0, '.', ','));
                $grandtotal.val(accounting.formatNumber(grandtotal, 0, '.', ','));
            });
    }

    function f_hapus(id) {

        Swal.fire({
            title: 'Yakin Akan Dihapus?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.value) {
                Swal.showLoading()

                $.post("savepenjualan.php", {
                        tombol: "hapus",
                        id: id,
                        action : '<?= $_GET['act'] ?>'
                    })
                    .done(function(data) {
                        loaddata();
                        Swal.hideLoading()

                    });
                Swal.fire(
                    'Terhapus',
                    'Sudah Dihapus.',
                    'success'
                )
            }
        })
        f_bersih();
    }

    $(document).ready(function() {
        f_bersih();
        if (act == "edit") {
            if (idget == "") {
                alertify.prompt('Perhatian', 'Masukkan ID Transaksi yang akan diedit:', '',
                    // OK
                    function(evt, value) {
                        var idjual = value;
                        $.post("savepenjualan.php", {
                                tombol: "periksapenjualan",
                                idjual: idjual
                            })
                            .done(function(data) {
                                var pecah = data.split("|");
                                if (pecah[0] == "no") {
                                    alertify.alert("Peringatan",
                                        "Maaf, ID Transaksi tersebut tidak terdaftar").setting({
                                        'onok': function() {
                                            location.href = "frmpenjualan.php?act=new&id=";
                                        }
                                    }).show();
                                } else if (pecah[0] == "yes") {
                                    location.href = "frmpenjualan.php?act=edit&id=" + pecah[1];
                                }
                            });
                    },
                    // Cancel
                    function() {
                        location.href = "frmpenjualan.php?act=new&id=";
                    });
            } else {
                // var idjual = $("#txtidtransaksi").val();
                $.post("savepenjualan.php", {
                        tombol: "edittransaksi",
                        idjual: $idjual.val(),
                    })
                    .done(function(data) {
                        var pecah = data.split("|");
                        $idkonsumen.val(pecah[1]);
                        $('.selectpicker').selectpicker('refresh');
                    });
            }
        } else if (act == "hapus") {
            // OK
            // var idjual = value;
            $.post("savepenjualan.php", {
                    tombol: "periksapenjualan",
                    idjual: idget
                })
                .done(function(data) {
                    var pecah = data.split("|");
                    if (pecah[0] == "no") {
                        alertify.alert("Peringatan", "Maaf, ID Transaksi tersebut tidak terdaftar")
                            .setting({
                                'onok': function() {
                                    location.href = "frmpenjualan.php?act=new&id=";
                                }
                            }).show();
                    } else if (pecah[0] == "yes") {
                        alertify.prompt('Perhatian', 'Masukkan Alasan kenapa transaksi dihapus:', '',
                            // OK
                            function(evt, value) {
                                var alasan = value;
                                $.post("savepenjualan.php", {
                                        tombol: "hapustransaksi",
                                        idjual: pecah[1],
                                        alasan: alasan
                                    })
                                    .done(function(data) {
                                        alertify.alert("Sukses",
                                                "Transaksi tersebut telah berhasil dihapus")
                                            .setting({
                                                'onok': function() {
                                                    location.href =
                                                        "frmpenjualan.php?act=new&id=";
                                                }
                                            }).show();
                                    });
                            },
                            // Cancel
                            function() {
                                location.href = "frmpenjualan.php?act=new&id=";
                            });
                    }
                });
        }

        loaddata();
        $('.selectpicker').selectpicker('refresh');

    });

    document.onkeyup = function(e) {
        if (e.ctrlKey && e.shiftKey && e.which == 65) {
            $('#txtjumlah').focus();
        } else if (e.ctrlKey && e.shiftKey && e.which == 90) {
            $('#simpan').click();
        }
    };


    let code = "";
    let reading = false;
    document.addEventListener('keypress', e => {
        //usually scanners throw an 'Enter' key at the end of read
        code += e.key; //while this is not an 'enter' it stores the every key            

        if (code.length > 5) {
            document.getElementById(code).selected = true;
            $('.selectpicker').selectpicker('refresh');
            loadproduk();
            setTimeout(() => {
                $('#txtjumlah').focus();
            }, 100);
            code = "";
        }
        //run a timeout of 200ms at the first read and clear everything
        if (!reading) {
            reading = true;
            setTimeout(() => {
                code = "";
                reading = false;
            }, 100);
        } //200 works fine for me but you can adjust it

    });

    $("#txtjumlah").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $("#txtjumlah").blur();
            $('#txttotal').focus();

            $('#simpan').click();
            // $('#txttotal').focus();
        }
    });

    function autoLoad() {
        location.href = "frmpenjualan.php?act=new&id=";
    }

    function pilihAlamat(idKonsumen){
        $('#alamatModal').modal('show');
        $.post("savepenjualan.php",{
            idKonsumen : idKonsumen,
            tombol : "checkListAlamat",
            action : "choose"
        }).done(function(data){
            $('#idKonsumenCheckAlamat').val(idKonsumen);
            $('#isiListAlamat').html(data);
        });
    }
    function changeAlamat(alamat,action){
        var iduser = $('#idKonsumenCheckAlamat').val();

        $.post("savepenjualan.php", {
            iduser: iduser,
            tombol: "changeAlamat",
            alamat : alamat,
            action : action
        }).done(function(data) {
            if(data == "success"){
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Alamat berhasil diganti',
                    showConfirmButton: false,
                    timer: 1500
                });
                $('#alamatModal').modal('hide');
            }
        })
    }
</script>