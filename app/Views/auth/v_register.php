<!-- extend template index -->
<?= $this->extend('auth/templates/index'); ?>

<!-- ini adalah section dengan nama content yang akan diload pada template auth/templates/index -->
<?= $this->section('content'); ?>
<div class="register-box">
    <div class="register-logo">
        <a href="<?= base_url(); ?>/templates/index2.html"><b>CI4</b><?= $title; ?></a>
    </div>

    <div class="register-box-body">
        <?= form_open('auth/do_register'); ?>
        <?= csrf_field(); ?>
        <div class="form-group has-feedback <?= ($validation->hasError('fullname')) ? 'has-error' : '' ?>">
            <input type="text" name="fullname" class="form-control" placeholder="Nama Lengkap" value="<?= old('fullname'); ?>">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
            <span class="help-block"><?= $validation->getError('fullname'); ?></span>
        </div>
        <div class="form-group has-feedback <?= ($validation->hasError('phone')) ? 'has-error' : '' ?>">
            <input type="text" name="phone" class="form-control" placeholder="Nomor Telepon" value="<?= old('phone'); ?>">
            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
            <span class="help-block"><?= $validation->getError('phone'); ?></span>
        </div>
        <div class="form-group has-feedback <?= ($validation->hasError('email')) ? 'has-error' : '' ?>">
            <input type="email" name="email" class="form-control" placeholder="Alamat Surel" value="<?= old('email'); ?>">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            <span class="help-block"><?= $validation->getError('email'); ?></span>
        </div>
        <div class="form-group has-feedback <?= ($validation->hasError('password')) ? 'has-error' : '' ?>">
            <input type="password" name="password" class="form-control" placeholder="Kata Sandi">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            <span class="help-block"><?= $validation->getError('password'); ?></span>
        </div>
        <div class="form-group has-feedback <?= ($validation->hasError('repassword')) ? 'has-error' : '' ?>">
            <input type="password" name="repassword" class="form-control" placeholder="Ketik Ulang Kata Sandi">
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            <span class="help-block"><?= $validation->getError('repassword'); ?></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <?= form_checkbox('terms', 'accept', TRUE); ?>I agree to the <a href="#">terms</a>
                        <span class="help-block text-red"><?= $validation->getError('terms'); ?></span>
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
            </div>
            <!-- /.col -->
        </div>
        <?= form_close(); ?>

        <a href="<?= base_url(); ?>/auth/login/" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- section berakhir disini -->
<?= $this->endSection(); ?>