<div class="container mt-5 mb-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="text-center">Registration</h3>
                </div>
                <div class="card-body">
                    <?php use SipalingNgoding\MVC\libs\Flash;
                    use SipalingNgoding\MVC\libs\Helper;

                    Flash::flash(); ?>
                    <?php $data = Helper::session_flash('errors_register','inputs_register' );
                        if(isset($data['errors_register'])) {
                            $errors = $data['errors_register'];
                            $css = array_map(function ($key){
                                $css[$key]= 'err';
                                return $css;
                            },array_keys($errors));
                        }
                        if(isset($data['inputs_register'])) $inputs = $data['inputs_register'];
                    ?>
                    <form method="post" action="/register">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control <?= $css['email'] ?? "" ?>" id="email" name="email" value="<?=$inputs['email'] ?? "" ?>">
                            <small><?= $errors['email'] ?? "" ?></small>
                        </div>
                        <div class="form-group">
                            <label for="full_name">Full Name</label>
                            <input type="text" class="form-control <?= $css['full_name'] ?? "" ?>" id="full_name" name="full_name" value="<?=$inputs['full_name'] ?? "" ?>">
                            <small><?= $errors['full_name'] ?? "" ?></small>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control <?= $css['address'] ?? "" ?>" id="address" name="address" value="<?=$inputs['address'] ?? "" ?>">
                            <small><?= $errors['full_name'] ?? "" ?></small>
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
                        <a href="/login">Login disini</a>
                        <button type="submit" class="btn btn-primary btn-block form-control mt-2">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
