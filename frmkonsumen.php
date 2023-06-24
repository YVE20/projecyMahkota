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
                            <h4>Form Konsumen</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                            <div class="col-md-12">
                                <form class="cmxform" id="frm" method="post" action="">
                                    <input type="hidden" name="txtid" id="txtid" />
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text">
                                                <input type="text" class="form-text" id="txtnama" name="txtnama" required>
                                                <span class="bar"></span>
                                                <label>Nama</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text" style="">
                                                <input type="text" class="form-text" id="txtalamat" name="txtalamat" required>
                                                <span class="bar"></span>
                                                <label>Alamat</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text" style="">
                                                <input type="text" class="form-text" id="txtnohp" name="txtnohp" required>
                                                <span class="bar"></span>
                                                <label>No HP</label>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group form-animate-text" style="">
                                                <input type="text" class="form-text" id="txtemail" name="txtemail" required>
                                                <span class="bar"></span>
                                                <label>Email</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="display:none">
                                    </div>
                                    
                                    <div class="row">
                                    </div>
                                    <br>
                                    <br>
                                    <div class="form-group form-element">
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
<?php include "Footer.php";?>

<script>
    jQuery('#txtnohp').keypress(function(event){
        if(event.which !=8 && isNaN(String.fromCharCode(event.which))){
            event.preventDefault();
        }
    });
    $("#frm").on('submit', (function (e) {
        e.preventDefault();
        var tombol = $("#simpan").val();
        var id = $("#txtid").val();
        var nama = $("#txtnama").val();
        var alamat = $("#txtalamat").val();
        var nohp = $("#txtnohp").val();
        var email = $("#txtemail").val();

        if (nama != "" && alamat != "" && nohp != "" && email != "") {

            var formData = new FormData();
            formData.append('tombol', tombol);
            formData.append('id', id);
            formData.append('nama', nama);
            formData.append('alamat', alamat);
            formData.append('no_hp', nohp);
            formData.append('email', email);

            $.ajax({
                url: "savekonsumen.php",
                type: "POST",
                data: formData,
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    console.log(data);
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
    }

    function loaddata() {
        $.post("savekonsumen.php", {
                tombol: "tampil"
            })
            .done(function (data) {
                $("#table").html(data);
            });
    }

    function f_edit(id) {
        $("#reset").click();
        $.post("savekonsumen.php", {
                tombol: "tampiledit",
                id: id
            })
            .done(function (data) {
                var pecah = data.split("|");
                $("#txtid").val(pecah[1]);
                $("#txtnama").val(pecah[2]);
                $("#txtalamat").val(pecah[3]);
                $("#txtnohp").val(pecah[4]);
                $("#txtemail").val(pecah[5]);
                $("#simpan").val("edit");

                window.scrollTo(0, 0);
            });
    }

    function f_hapus(id) {
        // if(confirm("Hapus data ini?") == true) {
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
                $.post("savekonsumen.php", {
                        tombol: "hapus",
                        id: id
                    })
                    .done(function (data) {
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

    $(document).ready(function () {
        loaddata();
    });
</script>
