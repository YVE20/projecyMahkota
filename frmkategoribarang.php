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
                        <h4>Form Kategori Barang</h4>
                    </div>
                    <div class="col-md-12 panel-body" style="padding-bottom:30px;">
                        <div class="col-md-12">
                            <form  method="get" action="">
                                <input type="hidden" name="idKategori" id="idKategori">
                                <div class="form-group form-animate-text">
                                    <input type="text" class="form-text" id="kategoriBarang" name="kategoriBarang" required>
                                    <span class="bar"></span>
                                    <label> Kategori Barang </label>
                                </div>
                                <div class="form-group form-element">
                                    <button type="button" onclick="simpanKategori(); return false;" class="submit btn btn-success" name="action" id="action" value="save"> Save </button>
                                    <button type="reset" class="submit btn btn-primary" name="action" id="action"> Reset </button>
                                </div>
                            </form>

                        </div>
                        <div class="col-md-12">
                            <table id="datatable-fixed-header" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr> 
                                        <td> ID </td>
                                        <td> Kategori Barang </td>
                                        <td> Action </td>
                                    </tr>
                                </thead>
                                <tbody id="isiBodyKategoriBarang">

                                </tbody>
                            </table>
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
    function loaddata() {
        $.post("savekategoribarang.php", {
            action : "show"
        })
        .done(function(data) {
            $("#isiBodyKategoriBarang").html(data);
        });
    }

    function simpanKategori(){
        var action = $('#action').val();
        var idKategori = $('#idKategori').val();

        if(action == "edit"){
            editKategori(idKategori);
        }else{
            $.post("savekategoribarang.php", {
                action : "save",
                kategoriBarang : $('#kategoriBarang').val()
            })
            .done(function(data) {
                if(data == "success"){
                    Swal.fire({
                        type: 'success',
                        title: 'Data berhasil ditambahkan'
                    })
                }
                loaddata();
                cleanData();
            });
        }
    }
    function showEditKategori(idKategori){
        $.post("savekategoribarang.php", {
            action : "showDataEdit",
            idKategori : idKategori
        })
        .done(function(data) {
            var split = data.split("|");
            $('#kategoriBarang').val(split[0]);
            $('#action').html('Edit');
            $('#action').val('edit');
            $('#idKategori').val(split[1]);
            loaddata();
        });
    }
    function editKategori(idKategori){
        $.post("savekategoribarang.php", {
            action : "edit",
            kategoriBarang : $('#kategoriBarang').val(),
            idKategori : idKategori
        })
        .done(function(data) {
            if(data == "success"){
                Swal.fire({
                    type: 'success',
                    title: 'Data berhasil diganti'
                })
            }else if(data == "kosong"){
                Swal.fire({
                    type: 'error',
                    title: 'Data tidak ditemukan'
                })
            }
            cleanData();
            loaddata();
            $('#action').html("Save");
        });
    }
    function deleteKategori(idKategori){
        $.post("savekategoribarang.php", {
            action : "delete",
            idKategori : idKategori
        })
        .done(function(data) {
            if(data == "success"){
                Swal.fire({
                    type: 'success',
                    title: 'Data berhasil diganti'
                })
            }else if(data == "kosong"){
                Swal.fire({
                    type: 'error',
                    title: 'Data tidak ditemukan'
                })
            }
            cleanData();
            loaddata();
        });
    }

    $(document).ready(function() {
        loaddata();
    });

    function cleanData(){
        $('#kategoriBarang').val("");
        $('#idKategori').val("");
    }
</script>