<?php
    $menu_head = "pembelian";
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
                            <h4>Daftar Pembelian</h4>
                        </div>
                        <div class="col-md-12 panel-body" style="padding-bottom:30px;padding-top:30px;">
                            <div class="col-md-12" id="table" name="table">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php include "Footer.php";?>


<!-- Detail Pembelian -->
<div class="modal fade" id="detailPembelianModal" tabindex="-1" role="dialog" aria-labelledby="detailPembelianModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailPembelianModalLabel"> Detail Pembelian </h5>
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
                            <th> Pajak </th>
                            <th> Sub Total </th>
                        </tr>
                    </thead>
                    <tbody id="isiDetailPembelian">

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"> Tutup </button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>

    function f_load(){
        $.post("savepembelian.php",{tombol:"tampillistpembelian"})
            .done(function(data){
                $("#table").html(data);
        });
    }

    function f_approvepo(id,statusUser){ 
        if(statusUser == "Admin"){
            location.href = "frmpembelian.php?act=approve&id="+id;
        }else{
            $.post("savepembelian.php",
            {
                tombol : "approvePO",
                idPembelian : id,
            }).done(function(data){
                console.log(data);
                if(data == "success"){
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Pembelian telah disetujui',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
                f_load();
            });
        }
    }
    function f_rejectpo(id,statusUser){
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary m-2',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Alasan Penolakan',
            input: 'text',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Confirm <i class="fas fa-check-circle"> </i>',
            cancelButtonText : 'Batal <i class="fas fa-times-circle"> </i>',
            showLoaderOnConfirm: true,
            preConfirm: (login) => {
                $.post("savepembelian.php",
                {
                    tombol : "rejectPO",
                    idPembelian : id,
                    alasan : login
                }).done(function(data){
                    if(data == "success"){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Pembelian telah ditolak',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                    f_load();
                });
            }
        })
    }
    
    $(document).ready(function(){
        f_load();
    });

    function detailPembelian(idPembelian){
        $.post("savepembelian.php",
        {
            tombol : "detailPembelian",
            idPembelian : idPembelian,
        }).done(function(data){
            var split = data.split('###');
            $('#isiDetailPembelian').html(split[0]);
            $('#detailPembelianModal').modal('show');

            if(split[1] == "Approved"){
                $('#statusApproved').html("Approved");
            }else{
                $('#statusApproved').html("Rejected");
            }
        });
    }
    function deletePembelian(idPembelian){
        Swal.fire({
            title: 'Peringatan',
            text: "Anda yakin ingin menghapus data ini ?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Ya, hapus',
            cancelButtonText : 'Batal',
            }).then((result) => {
            if (result.isConfirmed) {
                $.post("savepembelian.php",
                {
                    idPembelian : idPembelian,
                    tombol : "hapusPembelian",
                }).done(function(data){
                    if(data == "success"){
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil dihapus',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        f_load();
                    }
                });
            }
        })
    }

    function editPembelian(idPembelian){
        location.href="frmpembelian.php?act=edit&idPembelian="+idPembelian;
    }
</script>
