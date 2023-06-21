<?php
$menu_head = "data";
include "Header.php";
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
                        <h4>Form Produk</h4>
                    </div>
                    <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                        <div class="col-md-12">
                            <form class="cmxform" id="frm" method="post" action="" enctype="multipart/form-data">
                                <input type="hidden" name="txtid" id="txtid" />
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-animate-text">
                                            <input type="text" class="form-text" id="txtkodebarang" name="txtkodebarang" required>
                                            <span class="bar"></span>
                                            <label>Kode Produk</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-animate-text">
                                            <input type="text" class="form-text" id="txtnama" name="txtnama" required>
                                            <span class="bar"></span>
                                            <label>Nama</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-element">
                                            <label style="">Kategori</label>
                                            <select class="form-control col-md-7 col-xs-12 combobox" name="cmbkategori" id="cmbkategori" onchange="pilihkategori(this.value)">
                                            <option value="-">-- Pilih Konsumen --</option>
                                            <?php
                                                $sqlmenu = "select * from tbkategori";
                                                $querymenu = mysqli_query($con, $sqlmenu);
                                                while ($res = mysqli_fetch_array($querymenu)) {
                                                    $kategori = $res['kategori'];
                                                ?>
                                                    <option value="<?php echo $kategori; ?>"> <?php echo $kategori; ?> </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-element">
                                            <label style="">Satuan</label>
                                            <select class="form-control col-md-7 col-xs-12 combobox" name="cmbsatuan" id="cmbsatuan">
                                            <option value="-">-- Pilih Konsumen --</option>
                                                <?php
                                                $sqlmenu = "select * from tbsatuan";
                                                $querymenu = mysqli_query($con, $sqlmenu);
                                                while ($res = mysqli_fetch_array($querymenu)) {
                                                    $satuan = $res['satuan'];
                                                ?>
                                                    <option value="<?php echo $satuan; ?>"> <?php echo $satuan; ?> </option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div id="dalam" class="col-md-3">
                                        <div class="form-group form-animate-text">
                                            <input type="text" class="form-text" value="0" id="txthargadalam" name="txthargadalam" required>
                                            <span class="bar"></span>
                                            <label>Harga Jual</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="imgupload">Upload Foto</label>
                                        <input type="file" id="imgupload" name="imgupload">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group form-animate-text">
                                            <textarea name="txtdeskripsi" id="txtdeskripsi" style="resize: none;" cols="30" rows="10" class="form-text"></textarea>
                                            <span class="bar"></span>
                                            <label> Deskripsi </label>
                                        </div>
                                    </div>
                                </div>
                                <br><br>
                                <div class="form-group form-element" style="margin-bottom:5px">
                                    <button type="submit" class="submit btn btn-success" name="simpan" id="simpan" value="simpan"> Save </button>
                                    <button type="reset" class="submit btn btn-primary" name="reset" id="reset" value="simpan" onclick="f_bersih();"> Reset </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-12" id="table" name="table">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page content -->
<?php include "Footer.php"; ?>

<script>
    document.getElementById("imgupload").onchange = function(e) {
        loadImage(
            e.target.files[0],
            function(img) {
                $('#img_profile').remove();
                $(".img-profile").append(img);
            }, {
                maxWidth: 200
            }
        );
    };

    $("#txthargadalam").keyup(function() {
        var hargadalam = $("#txthargadalam");
        $("#txthargadalam").val(formatRupiah(hargadalam.val()));
    });

    $("#frm").on('submit', (function(e) {
        e.preventDefault();
        var tombol = $("#simpan").val();
        var id = $("#txtid").val();
        var kode = $("#txtkodebarang").val();
        var nama = $("#txtnama").val();
        var hargadalam = $("#txthargadalam").val().replace(/\./g, "");
        var satuan = $("#cmbsatuan").val();
        var kategori = $("#cmbkategori").val();
        var gambar = $("#imgupload").val();
        var deskripsi = $('#txtdeskripsi').val();

        if (kode != "" && nama != "") {

            var formData = new FormData();
            formData.append('tombol', tombol);
            formData.append('id', id);
            formData.append('kode_barang', kode);
            formData.append('nama', nama);
            formData.append('hargadalam', hargadalam);
            formData.append('satuan', satuan);
            formData.append('kategori', kategori);
            formData.append('img_url', $('input[type=file]')[0].files[0]);
            formData.append('deskripsi', deskripsi);

            //formData.append('imgurl', $('input[type=file]')[0].files[0]);

            $.ajax({
                url: "saveproduk.php",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    loaddata();
                    $("#reset").click();
                }
            });
        } else {
            Swal.fire({
                type: 'error',
                title: 'Masih Ada Data yang Kosong'
            })
        }
    }));

    function f_bersih() {
        $("#simpan").val("simpan");
        $("#txtkodebarang").val("");
        $("#txtnama").val("");
        $("#txthargadalam").val(0);
        $("#cmbsatuan").val('Stick');
        $("#cmbkategori").val('');
        $('#gambarProduk').attr('src', 'pictures/noimage.jpg');
        $('#txtdeskripsi').val("");
    }

    function loaddata() {
        $.post("saveproduk.php", {
                tombol: "tampil"
            })
            .done(function(data) {
                $("#table").html(data);
                //pilihkategori('Stick');
            });
    }

    function f_edit(id) {
        $("#reset").click();
        $.post("saveproduk.php", {
                tombol: "tampiledit",
                id: id
            })
            .done(function(data) {
                //echo "|".$id."|".$kodebarang."|".$nama."|".$hargadalam."|".$satuan."|";
                var pecah = data.split("|");
                $("#txtid").val(pecah[1]);
                $("#txtkodebarang").val(pecah[2]);
                $("#txtnama").val(pecah[3]);
                $("#txthargadalam").val(formatRupiah(pecah[5]));
                $("#cmbsatuan").val(pecah[6]);
                $("#cmbkategori").val(pecah[7]);
                $("#simpan").val("edit");
                $('#txtdeskripsi').val(pecah[8]);

                if (pecah[4] == "NULL") {
                    $('#gambarProduk').attr('src', 'pictures/noimage.jpg');
                } else {
                    $('#gambarProduk').attr('src', 'pictures/' + pecah[4]);
                }
                $('#imgupload').attr("value", pecah[4]);

                window.scrollTo(0, 0);
            });
    }

    function f_hapus(id) {
        Swal.fire({
            title: 'Hapus Data Ini?',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.value) {
                $.post("saveproduk.php", {
                        tombol: "hapus",
                        id: id
                    })
                    .done(function(data) {
                        loaddata();
                    });

                Swal.fire(
                    'Deleted!',
                    'Data Berhasil Dihapus',
                    'success'
                )
            }
        })
    }

    $(document).ready(function() {
        loaddata();
    });
</script>