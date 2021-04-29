<!-- extend template index -->
<?= $this->extend('auth/templates/index'); ?>

<!-- ini adalah section dengan nama content yang akan diload pada template auth/templates/index -->
<?= $this->section('content'); ?>
<div class="login-box">
    <div class="login-logo">
        <a href="<?= base_url(); ?>/templates/index2.html"><?= $title; ?> <b>SISKA</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <?= form_open('auth/do_login'); ?>
        <?= csrf_field(); ?>
        <div class="form-group has-feedback <?= ($validation->hasError('email')) ? 'has-error' : '' ?>">
            <input type="email" name="email" class="form-control" placeholder="Alamat Surel" value="<?= old('email'); ?>">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <span class="help-block"><?= $validation->getError('email'); ?></span>
        </div>
        <div class="form-group has-feedback  <?= ($validation->hasError('password')) ? 'has-error' : '' ?>">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <span class="help-block"><?= $validation->getError('password'); ?></span>
        </div>
        <div class="row">

            <!-- /.col -->
            <div class="col-xs-4 pull-right">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Masuk</button>
            </div>
            <!-- /.col -->
        </div>
        <?= form_close(); ?>
    </div>
    <!-- /.login-box-body -->
</div>
<!-- section berakhir disini -->
<?= $this->endSection(); ?>