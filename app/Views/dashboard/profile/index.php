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
            <small>| Informasi profil, ubah detail, password dan foto profil</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/dashboard"><i class="fa fa-dashboard"></i> Dashboard</a></li>
            <li class="active"><?= $title; ?></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail <?= $title; ?></h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                                <i class="fa fa-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="col-md-4" id="detail-photo">
                            <div class="thumbnail">
                                <a href="/img/<?= $dataProfile['img']; ?>" target="_blank">
                                    <img src="/img/<?= $dataProfile['img']; ?>" alt="Lights">
                                    <div class="caption">
                                        <center>
                                            <a href="javascript:void(0)" class="btn btn-default btn-sm" onclick="show_modal('edit-photo')"><i class="fa fa-fw fa-upload"></i> Ubah Foto Profil</a>
                                        </center>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-7" id="detail-profile">
                            <p>
                                Nama Lengkap : <?= $dataProfile['fullname']; ?><br>
                                Alamat Surel : <?= $dataProfile['email']; ?><br>
                                Nomor Telepon : <?= $dataProfile['phone']; ?><br>
                                Role : <?= roleIs($dataProfile['role']) ?><br>
                                <hr>
                                <small class="pull-right"><i>Terdaftar sejak <?= format_indo($dataProfile['created_at']); ?></i></small>
                            </p>
                        </div>
                    </div>
                    <div class="box-footer">
                        <div class="pull-left">
                            <a href="/dashboard" class="btn btn-primary btn-sm"><i class="fa fa-fw fa-angle-left"></i> Kembali</a>
                        </div>
                        <div class="pull-right">
                            <a href="javascript:void(0)" class="btn btn-info btn-sm" onclick="show_modal('edit-profile')"><i class="fa fa-fw fa-edit"></i> Ubah Profil</a>
                            <a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="show_modal('edit-password')"><i class="fa fa-fw fa-key"></i> Ubah Password</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<!-- MODAL CHANGE PHOTO -->
<div class="modal fade" id="modal-edit-photo" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-edit-photo-title" id="modal-edit-photo-title">Modal Title</h4>
            </div>
            <form action="#" id="form-edit-photo">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="photo">Pilih Foto (File berekstensi .png, .jpg, .jpeg)</label>
                        <input type="file" class="form-control" name="photo" id="photo">
                        <span id="tphoto" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="photo">Pratinjau</label>
                        <div class="thumbnail">
                            <img src="/img/<?= $dataProfile['img']; ?>" id="preview-photo" alt="Lights">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm pull-left" onclick="close_modal('edit-photo')"><i class=" fa fa-fw fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="edit_photo()"><i class="fa fa-fw fa-paper-plane"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL CHANGE PROFILE -->
<div class="modal fade" id="modal-edit-profile" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-edit-profile-title" id="modal-edit-profile-title">Modal Title</h4>
            </div>
            <form action="#" id="form-edit-profile">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="fullname">Nama Lengkap</label>
                        <input type="text" name="fullname" class="form-control" value="<?= $dataProfile['fullname']; ?>">
                        <span id="tfullname" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="email">Alamat Surel</label>
                        <input type="email" name="email" class="form-control" value="<?= $dataProfile['email']; ?>">
                        <span id="temail" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="phone">Nomor Telepon</label>
                        <input type="text" name="phone" class="form-control" value="<?= $dataProfile['phone']; ?>">
                        <span id="tphone" class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm pull-left" onclick="close_modal('edit-profile')"><i class=" fa fa-fw fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="edit_profile()"><i class="fa fa-fw fa-paper-plane"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- MODAL CHANGE PASSWORD -->
<div class="modal fade" id="modal-edit-password" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-edit-password-title" id="modal-edit-password-title">Modal Title</h4>
            </div>
            <form action="#" id="form-edit-password">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <div class="form-group">
                        <label for="oldpassword">Kata Sandi Lama</label>
                        <input type="password" name="oldpassword" class="form-control">
                        <span id="toldpassword" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="password">Kata Sandi Baru</label>
                        <input type="password" name="password" class="form-control">
                        <span id="tpassword" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="repassword">Ulangi Kata Sandi Baru</label>
                        <input type="password" name="repassword" class="form-control">
                        <span id="trepassword" class="help-block"></span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-sm pull-left" onclick="close_modal('edit-password')"><i class="fa fa-fw fa-times"></i> Tutup</button>
                    <button type="button" class="btn btn-success btn-sm" onclick="edit_pass()"><i class="fa fa-fw fa-paper-plane"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // pratinjau saat pilih foto
    $(document).ready(function() {
        $('#photo').change(function(e) {
            readURL(this);
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview-photo').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

    })

    function show_modal(method) {
        switch (method) {
            case "edit-photo":
                $('#modal-edit-photo').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#modal-edit-photo-title').text('Ubah Foto');
                break;
            case "edit-profile":
                $('#modal-edit-profile').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#modal-edit-profile-title').text('Ubah Profil');
                break;

            case "edit-password":
                $('#modal-edit-password').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#modal-edit-password-title').text('Ubah Password');
                break;

            default:
                break;
        }
    }

    function close_modal(method) {
        switch (method) {
            case "edit-photo":

                $('#modal-edit-photo').modal('hide');
                break;
            case "edit-profile":
                $('#form-edit-profile')[0].reset()
                $('#modal-edit-profile').modal('hide');
                $('div').removeClass("has-error");
                $('#tfullname').text('');
                $('#temail').text('');
                $('#tphone').text('');
                break;

            case "edit-password":
                $('#form-edit-password')[0].reset()
                $('#modal-edit-password').modal('hide');
                $('div').removeClass("has-error");
                $('#toldpassword').text('');
                $('#tpassword').text('');
                $('#trepassword').text('');
                break;

            default:
                break;
        }
    }

    function edit_photo() {
        $.ajax({
            url: "<?= base_url('/profile/doEditPhoto') ?>",
            type: 'POST',
            data: new FormData($('#form-edit-photo')[0]),
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status) {
                    $('#form-edit-photo')[0].reset()
                    $('#modal-edit-photo').modal('hide');
                    $("#detail-photo").load(location.href + " #detail-photo>*", "");
                    $('div').removeClass("has-error");
                    $('#tphoto').text('');
                    sweetalert2('Berhasil mengubah profil');
                } else {
                    sweetalert2('Gagal, periksa kembali isian anda', 'error');
                    $('div').removeClass("has-error");
                    $('#tphoto').text('');
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

    function edit_profile() {
        $.ajax({
            url: "<?= base_url('/profile/doEditProfile') ?>",
            type: 'POST',
            data: new FormData($('#form-edit-profile')[0]),
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status) {
                    $('#form-edit-profile')[0].reset()
                    $('#modal-edit-profile').modal('hide');
                    $("#detail-profile").load(location.href + " #detail-profile>*", "");
                    $("#modal-edit-profile").load(location.href + " #modal-edit-profile>*", "");
                    sweetalert2('Berhasil mengubah profil');
                } else {
                    sweetalert2('Gagal, periksa kembali isian anda', 'error');
                    $('div').removeClass("has-error");
                    $('#tfullname').text('');
                    $('#temail').text('');
                    $('#tphone').text('');
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

    function edit_pass() {
        $.ajax({
            url: "<?= base_url('/profile/doEditPass') ?>",
            type: 'POST',
            data: new FormData($('#form-edit-password')[0]),
            dataType: 'JSON',
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.status) {
                    $('#form-edit-password')[0].reset()
                    $('#modal-edit-password').modal('hide');
                    sweetalert2('Berhasil mengubah password');
                    $('div').removeClass("has-error");
                    $('#toldpassword').text('');
                    $('#tpassword').text('');
                    $('#trepassword').text('');
                } else {
                    sweetalert2('Gagal, periksa kembali isian anda', 'error');
                    $('div').removeClass("has-error");
                    $('#toldpassword').text('');
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
</script>
<!-- section berakhir disini -->
<?= $this->endSection(); ?>