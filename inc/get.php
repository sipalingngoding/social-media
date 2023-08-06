<form method="post">
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
        <button type="submit">Login</button>
    </div>
</form>
