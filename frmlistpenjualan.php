<?php
$menu_head = "penjualan";
include "Header.php";
?>
<div id="content">
    <div class="panel box-shadow-none content-header">
    </div>
    <div class="form-element">
        <div class="col-md-12 padding-0">
            <div class="col-md-12">
                <div class="col-md-12 panel">
                    <div class="col-md-12 panel-heading">
                        <h4>Daftar Penjualan</h4>
                    </div>
                    <div class="col-md-12 panel-body" style="padding-bottom:30px;padding-top:30px;">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group form-animate-text">
                                    <label style="top:-10px;font-size:14px;">Tanggal Transaksi</label>
                                    <input type="date" class="form-text" id="txttanggal" name="txttanggal">
                                    <span class="bar"></span>
                                </div>
                            </div>
                            <div class="col-md-4" style="margin-top:35px">
                                <button type="button" class="submit btn btn-info" name="btnsearch" id="btnsearch" value="search" onclick="f_load();"> Search </button>
                            </div>
                            <div class="col-md-4 text-right" style="margin-top:35px">
                                <button class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Buat Transaksi" onclick="f_create_transaction()"><span class="fa fa-plus"></span> Buat Transaksi</button>
                            </div>
                        </div>
                        <div class="col-md-12" id="table" name="table">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "Footer.php"; ?>

<!-- Detail Penjualan -->
<div class="modal fade" id="detailPenjualanModal" tabindex="-1" role="dialog" aria-labelledby="detailPenjualanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPenjualanModalLabel"> Detail Penjualan </h5>
                <p> No Hp : <strong> <span id="noHpPenjualan"></span> </strong>  <br>
                    Alamat : <span id="alamatPenjualan" style="font-weight: bold;"> </span> </p>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -30px;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped dt-responsive nowrap">
                    <thead>
                        <tr>
                            <th> # </th>
                            <th> Produk </th>
                            <th> Qty </th>
                            <th> Harga </th>
                            <th> Diskon </th>
                            <th> Total </th>
                            <th> Sub Total </th>
                        </tr>
                    </thead>
                    <tbody id="isiDetailPenjualan">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                <button type="button" class="btn btn-primary"> <i class="fa fa-upload" aria-hidden="true"></i> </button>
            </div>
        </div>
    </div>
</div>

<!-- Upload Foto -->
<div class="modal fade" id="uploadFotoModal" tabindex="-1" role="dialog" aria-labelledby="uploadFotoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="savepenjualan.php" method="POST" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadFotoModalLabel"> Upload Foto </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -30px;">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type='file' id="uploadPreview" name="uploadPreview" class="form-control" onchange="readURL(this);" />
                    <img id="previewImage" alt="your image" />
                    <input type="hidden" name="idPenjualan" id="idPenjualan">
                    <input type="hidden" name="tombol" value="uploadFO">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
                    <button type="submit" class="btn btn-primary"> <i class="fa fa-upload" aria-hidden="true"></i> Upload  </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#previewImage').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    function f_load() {
        let tanggal = $('#txttanggal').val();
        if (tanggal == "") {
            return Swal.fire({
                type: 'error',
                title: 'Oops... Tanggal Belum Dipilih!',
                text: 'Pilih Tanggal Lebih Dulu.'
            });
        }

        $.post("savepenjualan.php", {
                tombol: "tampillistpenjualan",
                tanggal: tanggal
            })
            .done(function(data) {
                $("#table").html(data);
                return;
            });
    }
    function gantiStatus(idjual){
        var statusAntar = $('#status_pengantaran').val();
        Swal.fire({
            title: 'Apakah anda yakin ?',
            text: "Status pengantaran akan dirubah menjadi '"+statusAntar+"'",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText : 'Tidak'
        }).then((result) => {
            if (result.value) {
                $.post("savepenjualan.php",{
                    tombol : "ubahstatuspengantaran",
                    idjual : idjual,
                    statusAntar : statusAntar
                }).done(function(data){
                    console.log(data);
                    if(data == "success"){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Status pengantaran berhasil diupdate',
                            showConfirmButton: false,   
                            timer: 1500
                        });
                        f_load();   
                    }else if(data == "selesai"){
                        Swal.fire({
                            icon: 'error',
                            title: 'Batal',
                            text: 'Status sudah selesai. Status tidak dapat dirubah.',
                            showConfirmButton: false,   
                            timer: 2500
                        });
                    }else{
                        Swal.fire({
                            icon: 'error',
                            title: 'Batal',
                            text: 'Status pengantaran batal diupdate',
                            showConfirmButton: false,   
                            timer: 1500
                        });
                    }
                });
            }
        })
    }
    function f_create_transaction() {
        location.href = "frmpenjualan.php?act=new&id=";
    }

    $(document).ready(function() {
        document.getElementById('txttanggal').valueAsDate = new Date();
        f_load();
    });

    function detailPenjualan(idPenjualan){
        $.post("savepenjualan.php",
        {
            tombol : "detailPenjualan",
            idPenjualan : idPenjualan,
        }).done(function(data){
            var split = data.split("###");
            $('#isiDetailPenjualan').html(split[0]);
            $('#detailPenjualanModal').modal('show');
            $('#alamatPenjualan').html(split[1] == "" ? "-" : split[1]);
            $('#noHpPenjualan').html(split[2] == "" ? "-" : split[2]);
        });
    }

    function uploadFoto(idPenjualan){
        $.post("savepenjualan.php",
        {
            tombol : "checkUploadFoto",
            idPenjualan : idPenjualan,
        }).done(function(data){
            if(data == "belum"){
                Swal.fire({
                    title: 'Apakah anda yakin ?',
                    text: "Status pengantaran akan dirubah menjadi 'Selesai' jika anda melakukan proses upload",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya',
                    cancelButtonText : 'Tidak'
                }).then((result) => {
                    if (result.value) {
                        $('#uploadFotoModal').modal('show');
                        $('#idPenjualan').val(idPenjualan);
                    }
                })
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Batal',
                    text: 'Foto sudah pernah di upload',
                    showConfirmButton: false,   
                    timer: 1500
                });
            }
        });
    }

</script>