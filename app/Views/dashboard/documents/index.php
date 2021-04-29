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
                                    <th>Nama Dokumen</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Dokumen</th>
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
            <form action="#" id="form" enctype="multipart/form-data">
                <div class="modal-body">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id_document">
                    <div class="form-group">
                        <label for="title">Nama Dokumen</label>
                        <input type="text" name="title" class="form-control" value="">
                        <span id="ttitle" class="help-block"></span>
                    </div>
                    <div class="form-group">
                        <label for="file">Pilih Dokumen</label>
                        <input type="file" class="form-control" name="file" id="file">
                        <span id="tfile" class="help-block"></span>
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
                "url": '<?= base_url('Document/fetchAll') ?>',
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
        $.ajax({
            url: "<?= base_url('document/save/') ?>",
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
                    sweetalert2('Berhasil menambah data');
                } else {
                    sweetalert2('Gagal, periksa kembali isian anda', 'error');
                    $('div').removeClass("has-error");
                    $('#ttitle').text('');
                    $('#tfile').text('');
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
                    url: '<?= base_url('document/delete') ?>/' + id,
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