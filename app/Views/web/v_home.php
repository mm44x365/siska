<!-- extend template index -->
<?= $this->extend('web/templates/index'); ?>

<!-- ini adalah section dengan nama content yang akan diload pada template auth/templates/index -->
<?= $this->section('web-content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="container">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?= $title; ?>
                <small> | digunakan untuk mengirim pesan, untuk kemudian ditanggapi oleh admin.</small>
            </h1>
            <ol class="breadcrumb">
                <li class="active"><a href="#"><i class="fa fa-dashboard"></i> Beranda</a></li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="callout callout-info">
                <h4>Hai, Selamat Datang!</h4>

                <p>Aplikasi AKMAIL digunakan kirim terima pesan, sebelum mengirim pesan, silakan terlebih dahulu masuk atau mendaftar.</p>
            </div>
            <?php
            if (session()->get('logged_in')) :
            ?>
                <div class="box box-success">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form <?= $title; ?></h3>
                    </div>
                    <div class="box-body">
                        The great content goes here
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            <?php
            else :
            ?>
                <a href="/auth/login/" class="btn btn-primary btn-sm">Masuk atau Daftar<span class="sr-only">(current)</span></a>
            <?php
            endif;
            ?>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.container -->
</div>
<!-- section berakhir disini -->
<?= $this->endSection(); ?>