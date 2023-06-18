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
        <!-- page content -->
<?php include "Footer.php";?>

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
</script>
