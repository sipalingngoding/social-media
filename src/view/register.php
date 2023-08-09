<div class="container mt-5 mb-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Registration</h3>
                </div>
                <div class="card-body">
                    <?php flash(); ?>
                    <form method="post">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control <?= $css['username'] ?? "" ?>" id="username" name="username" value="<?= $inputs['username'] ?? "" ?>">
                            <small><?= $errors['username'] ?? "" ?></small>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control <?= $css['email'] ?? "" ?>" id="email" name="email" value="<?=$inputs['email'] ?? "" ?>">
                            <small><?= $errors['email'] ?? "" ?></small>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control <?= $css['password'] ?? "" ?>" id="password" name="password">
                            <small><?= $errors['password'] ?? "" ?></small>
                        </div>
                        <div class="form-group">
                            <label for="confPassword">Confirm Password</label>
                            <input type="password" class="form-control <?= $css['confPassword'] ?? "" ?>" id="confPassword" name="confPassword">
                            <small><?= $errors['confPassword'] ?? "" ?></small>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="agree" id="flexCheckDefault" name="agree">
                            <label class="form-check-label d-block" for="flexCheckDefault">
                                I accept the <span style="color: red">Term Service</span>
                            </label>
                            <small><?= $errors['agree'] ?? "" ?></small>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block form-control mt-2">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
