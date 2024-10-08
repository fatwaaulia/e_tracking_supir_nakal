<section>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <h5 class="my-4"><?= isset($title) ? $title : '' ?></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <form action="<?= $base_route . '/create' ?>" method="post" enctype="multipart/form-data">
                        <?= csrf_field(); ?>
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="d-flex">
                                        <div class="position-relative">
                                            <img src="<?= base_url('assets/uploads/user-default.png') ?>" class="wh-150 img-style rounded-circle <?= validation_show_error('foto_profil') ? 'border border-danger' : '' ?>" id="frame">
                                            <div class="position-absolute" style="bottom:0px;right:0px">
                                                <button class="btn btn-secondary rounded-circle" style="padding:8px 10px" type="button" onclick="document.getElementById('foto_profil').click()">
                                                    <i class="fa-solid fa-camera fa-lg"></i>
                                                </button>
                                                <input type="file" class="form-control d-none" id="foto_profil" name="foto_profil" accept=".png,.jpg,.jpeg" onchange="preview()">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('foto_profil')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control <?= validation_show_error('nama') ? 'is-invalid' : '' ?>" id="nama" name="nama" value="<?= old('nama') ?>" placeholder="masukkan nama lengkap">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('nama')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                                    <select class="form-select <?= validation_show_error('jenis_kelamin') ? 'is-invalid' : '' ?>" id="jenis_kelamin" name="jenis_kelamin">
                                        <option value="">pilih</option>
                                        <?php
                                        $jenis_kelamin = ['Laki-laki', 'Perempuan'];
                                        $selected = old('jenis_kelamin');
                                        foreach ($jenis_kelamin as $v) :
                                        ?>
                                        <option value="<?= $v ?>" <?= $selected == $v ? 'selected' : '' ?>>
                                            <?= $v ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('jenis_kelamin')) ?>
                                    </div>
                                    <div class="mb-3">
                                    <label for="id_role" class="form-label">Role</label>
                                    <select class="form-select" id="id_role" disabled>
                                        <option>Admin</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="no_ponsel" class="form-label">No. Ponsel</label><span class="text-secondary"> (opsional)</span>
                                    <input type="number" class="form-control <?= validation_show_error('no_ponsel') ? "is-invalid" : '' ?>" id="no_ponsel" name="no_ponsel" value="<?= old('no_ponsel') ?>" placeholder="6285xxx">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('no_ponsel')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control <?= validation_show_error('email') ? 'is-invalid' : '' ?>" id="email" name="email" value="<?= old('email') ?>" placeholder="name@gmail.com">
                                    <div class="invalid-feedback">
                                        <?= cutString(validation_show_error('email')) ?>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="mb-2 position-relative">
                                        <input type="password" class="form-control <?= validation_show_error('password') ? 'is-invalid' : '' ?>" id="password" name="password" value="<?= old('password') ?>" placeholder="Password">
                                        <div class="invalid-feedback">
                                            <?= cutString(validation_show_error('password')) ?>
                                        </div>
								        <img src="<?= base_url('assets/icon/show.png') ?>" class="position-absolute" id="eye_password">
                                    </div>
                                    <div class="position-relative">
                                        <input type="password" class="form-control <?= validation_show_error('passconf') ? 'is-invalid' : '' ?>" id="passconf" name="passconf" value="<?= old('passconf') ?>" placeholder="Confirm password">
                                        <div class="invalid-feedback">
                                            <?= cutString(validation_show_error('passconf')) ?>
                                        </div>
								        <img src="<?= base_url('assets/icon/show.png') ?>" class="position-absolute" id="eye_passconf">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3 float-end">Tambahkan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<script>
function toggleVisibility(inputElement, eyeElement) {
    const showIcon = "<?= base_url('assets/icon/show.png') ?>";
    const hideIcon = "<?= base_url('assets/icon/hide.png') ?>";
    inputElement.type = inputElement.type === 'password' ? 'text' : 'password';
    eyeElement.src = inputElement.type === 'password' ? showIcon : hideIcon;
}

const eyePassword = document.getElementById('eye_password');
const password = document.getElementById('password');
eyePassword.addEventListener('click', () => {
    toggleVisibility(password, eyePassword);
});

const eyePassconf = document.getElementById('eye_passconf');
const passconf = document.getElementById('passconf');
eyePassconf.addEventListener('click', () => {
    toggleVisibility(passconf, eyePassconf);
});
</script>