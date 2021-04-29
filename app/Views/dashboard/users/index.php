<!-- extend template index -->
<?= $this->extend('dashboard/templates/index'); ?>

<!-- ini adalah section dengan nama content yang akan diload pada template auth/templates/index -->
<?= $this->section('dashboard-content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= $title; ?>
            <small>| Informasi profil admin, ubah detail, dan password</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Daftar <?= $title; ?></h3>
                        <div class="box-tools pull-right">
                            <a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="showForm()"><i class="fa fa-fw fa-plus-circle"></i> Tambah Data</a>
                            <a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="reloadTable()"><i class="fa fa-fw fa-retweet"></i> Reload Tabel</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Lengkap</th>
                                    <th>Email</th>
                                    <th>Nomor Telepon</th>
                                    <th>Aksi</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="box-footer">
                        <div class="pull-left">
                            <a href="/dashboard" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-angle-left"></i> Kembali</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- section berakhir disini -->

<!-- MODAL ADD DATA -->
<div class="modal fade" id="modal-form" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-form-title" id="modal-form-title">Modal Title</h4>
            </div>
            <form action="#" id="form">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_user">
                    <div class="form-group">
                        <label for="fullname">Nama Lengkap</label>
                        <input type="text" name="fullname" class="form-control" value="">
                        <span id="tfullname" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control" value="">
                        <span id="tphone" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Surel</label>
                        <input type="email" name="email" class="form-control" value="">
                        <span id="temail" class="help-block"></span>
                    </div>
                    <div class="form-group" id="formPassword">
                        <label for="password">Kata Sandi</label>
                        <input type="password" name="password" class="form-control" value="">
                        <span id="tpassword" class="help-block"></span>
                    </div>
                    <div class="form-group" id="formRePassword">
                        <label for="repassword">Ketik Ulang Kata Sandi</label>
                        <input type="password" name="repassword" class="form-control" value="">
                        <span id="trepassword" class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm pull-left" onclick="close_modal()"><i class=" fa fa-fw fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="saveData()"><i class="fa fa-fw fa-paper-plane"></i> Simpan</button>
                </div>

            </form>
        </div>
    </div>
</div>
<script>
    var method;
    var table;
    var url;

    $(document).ready(function() {
        table = $('#myTable').DataTable({
            "order": [],
            "serverSide": true,
            "ajax": {
                "url": '<?= base_url('User/fetchAll') ?>',
                "type": "POST"
            }
        });
    });

    function reloadTable() {
        table.ajax.reload(null, false);
        sweetalert2('Berhasil memuat ulang tabel');
    }

    function showForm() {
        method = 'save';
        $('#modal-form').modal({
            backdrop: 'static',
        });
        $('#modal-form-title').text('Tambah Data');
    }

    function close_modal() {
        $('#modal-form').modal('hide');
        $("#modal-form").load(location.href + " #modal-form>*", "");
    }

    function saveData() {
        if (method == 'save') {
            url = "<?= base_url('user/save/') ?>";
        } else {
            url = "<?= base_url('user/update/') ?>";
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: new FormData($('#form')[0]),
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status) {
                    $('#form')[0].reset()
                    $('#modal-form').modal('hide');
                    $("#modal-form").load(location.href + " #modal-form>*", "");
                    table.ajax.reload(null, false);
                    sweetalert2('Berhasil mengubah data');
                } else {
                    sweetalert2('Gagal, periksa kembali isian anda', 'error');
                    $('div').removeClass("has-error");
                    $('#tfullname').text('');
                    $('#temail').text('');
                    $('#tphone').text('');
                    $('#tpassword').text('');
                    $('#trepassword').text('');
                    $.each(data, function(i, val) {
                        $('[name="' + val.error.inputerror + '"]').parent().addClass('has-error');
                        $('[name="' + val.error.inputerror + '"]').next().text(val.error.error_string);
                    })
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                sweetalert2('Gagal', 'error');
            }
        });
    }

    function editData(id) {
        method = 'update';
        $.ajax({
            url: '<?= base_url("user/edit"); ?>/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('[name="id_user"]').val(data.id_user);
                $('[name="fullname"]').val(data.fullname);
                $('[name="phone"]').val(data.phone);
                $('[name="email"]').val(data.email);
                $('[id="formPassword"]').hide();
                $('[id="formRePassword"]').hide();

                $('#modal-form').modal({
                    backdrop: 'static',
                });
                $('#modal-form-title').text('Edit Data | ' + data.fullname);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                sweetalert2('Gagal', 'error');
            }
        });
    }

    function confirmResetPassword(id) {
        Swal.fire({
            animation: true,
            title: 'Reset kata Sandi',
            text: "Anda akan mereset ulang kata sandi akun ini, password akan diubah menjadi '12345678', yakin?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Saya yakin',
            cancelButtonText: 'Batal',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('user/reset') ?>/' + id,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status) {
                            sweetalert2('Berhasil mereset kata sandi');
                            table.ajax.reload(null, false);
                        } else {
                            sweetalert2('Gagal reset kata sandi', 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        sweetalert2('Gagal', 'error');
                    }
                });
            } else {
                sweetalert2('Tidak ada kata sandi yang direset', 'warning');
            }
        });
    }

    function confirmDelete(id) {
        Swal.fire({
            animation: true,
            title: 'Hapus',
            text: "Anda akan menghapus data ini, yakin?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Saya yakin',
            cancelButtonText: 'Batal',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('user/delete') ?>/' + id,
                    type: 'POST',
                    dataType: 'JSON',
                    success: function(data) {
                        if (data.status) {
                            sweetalert2('Berhasil menghapus data');
                            table.ajax.reload(null, false);
                        } else {
                            sweetalert2('Gagal menghapus data', 'error');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        sweetalert2('Gagal', 'error');
                    }
                });
            } else {
                sweetalert2('Tidak ada data yang dihapus', 'warning');
            }
        });
    }
</script>
<?= $this->endSection(); ?>