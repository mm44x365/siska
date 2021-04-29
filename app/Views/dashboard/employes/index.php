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
            <small>| Informasi karyawan, dan ubah detail</small>
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
                                    <th>NIP</th>
                                    <th>Nama Lengkap</th>
                                    <th>Alamat</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>NIP</th>
                                    <th>Nama Lengkap</th>
                                    <th>Alamat</th>
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
                    <input type="hidden" name="id_employe">
                    <div class="form-group">
                        <label for="nip">NIP</label>
                        <input type="text" name="nip" class="form-control" value="">
                        <span id="tnip" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="fullname">Nama Lengkap</label>
                        <input type="text" name="fullname" class="form-control" value="">
                        <span id="tfullname" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea class="form-control" name="address" rows="3"></textarea>
                        <span id="taddress" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="position">Jabatan</label>
                        <select class="form-control" name="position">
                            <option value="KEPALA DINAS">KEPALA DINAS</option>
                            <option value="SEKRETARIS DINAS">SEKRETARIS DINAS</option>
                            <option value="SUBBAGIAN PERENCANAAN DAN KEUANGAN">SUBBAGIAN PERENCANAAN DAN KEUANGAN</option>
                            <option value="SUBBAGIAN PERENCANAAN DAN KEUANGAN">SUBBAGIAN PERENCANAAN DAN KEUANGAN</option>
                            <option value="BIDANG PELAYANAN PENDAFTARAN PENDUDUK">BIDANG PELAYANAN PENDAFTARAN PENDUDUK</option>
                            <option value="BIDANG PIAK DAN PEMANFAATAN DATA">BIDANG PIAK DAN PEMANFAATAN DATA</option>
                            <option value="BIDANG PPELAYANAN PENCATATAN SIPIL">BIDANG PPELAYANAN PENCATATAN SIPIL</option>
                            <option value="SEKSI IDENTITAS PENDUDUK">SEKSI IDENTITAS PENDUDUK</option>
                            <option value="SEKSI PENGELOLAAN INFORMASI ADM KEPENDUDUKAN">SEKSI PENGELOLAAN INFORMASI ADM KEPENDUDUKAN</option>
                            <option value="SEKSI KELAHIRAN DAN KEMATIAN">SEKSI KELAHIRAN DAN KEMATIAN</option>
                            <option value="SEKSI PINDAH DATANG DAN PENDATAAN PENDUDUK">SEKSI PINDAH DATANG DAN PENDATAAN PENDUDUK</option>
                            <option value="SEKSI KERJASAMA DAN INOVASI PELAYANAN">SEKSI KERJASAMA DAN INOVASI PELAYANAN</option>
                            <option value="SEKSI PERKAWINAN, PERCERAIAN, PERUBAHAN STATUS ANAK DAN KEWARGANEGARAAN">SEKSI PERKAWINAN, PERCERAIAN, PERUBAHAN STATUS ANAK DAN KEWARGANEGARAAN</option>
                        </select>
                        <span id="tagama" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="year">Tahun Masuk</label>
                        <input type="text" name="year" class="form-control" value="">
                        <span id="tyear" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <select class="form-control" name="agama">
                            <option value="ISLAM">ISLAM</option>
                            <option value="KRISTEN">KRISTEN</option>
                            <option value="KATOLIK">KATOLIK</option>
                            <option value="HINDU">HINDU</option>
                            <option value="BUDHA">BUDHA</option>
                            <option value="KONGHUCU">KONGHUCU</option>
                        </select>
                        <span id="tagama" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="photo">Pilih Foto (File berekstensi .png, .jpg, .jpeg)</label>
                        <input type="file" class="form-control" name="photo" id="photo">
                        <span id="tphoto" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="photo">Pratinjau Foto</label>
                        <div class="thumbnail">
                            <img src="/img/default.png" id="preview-photo" alt="Lights">
                        </div>
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

    $(document).ready(function() {
        table = $('#myTable').DataTable({
            "order": [],
            "serverSide": true,
            "ajax": {
                "url": '<?= base_url('Employe/fetchAll') ?>',
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
            url = "<?= base_url('employe/save/') ?>";
        } else {
            url = "<?= base_url('employe/update/') ?>";
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
                    sweetalert2('Gagal, penipsa kembali isian anda', 'error');
                    $('div').removeClass("has-error");
                    $('#tnip').text('');
                    $('#tfullname').text('');
                    $('#temail').text('');
                    $('#taddress').text('');
                    $('#tposition').text('');
                    $('#tyear').text('');
                    $('#tagama').text('');
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
            url: '<?= base_url("employe/edit"); ?>/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(data) {
                $('[name="id_employe"]').val(data.id_employe);
                $('[name="nip"]').val(data.nip);
                $('[name="fullname"]').val(data.fullname);
                $('[name="address"]').val(data.address);
                $('[name="position"]').val(data.position);
                $('[name="year"]').val(data.year);
                $('[name="agama"]').val(data.agama);
                $("#preview-photo").attr("src", "img/" + data.img);
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
                    url: '<?= base_url('employe/delete') ?>/' + id,
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