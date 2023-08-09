<form method="post">
    <?php if(isset($error)) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $error ?>
        </div>
    <?php } ?>
    <div>
        <label for="email">Email:</label>
        <input id="email" type="text" name="email" placeholder="Enter your email" value="<?= $inputs['email'] ?? '' ?>" class="<?php isset($errors['email']) && print 'error' ?>" />
        <small><?= $errors['email'] ?? '' ?></small>
    </div>

    <div>
        <label for="password">Password:</label>
        <input id="password" type="password" name="password" placeholder="Enter your password" class="<?php isset($errors['password']) && print 'error' ?>"/>
        <small><?= $errors['password'] ?? '' ?></small>
    </div>

    <div>
        <label for="confPassword">Confirm Password:</label>
        <input id="confPassword" type="password" name="confPassword" placeholder="Enter your confirm password" class="<?php isset($errors['confPassword']) && print 'error' ?>"/>
        <small><?= $errors['confPassword'] ?? '' ?></small>
    </div>

    <div>
        <button type="submit">Register</button>
    </div>
</form>
