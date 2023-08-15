<div class="container my-5">
    <a class="btn btn-outline-primary" href="index.php"> <-Home</a>
    <div class="d-flex">
        <div class="w-50 m-auto">
            <img class="rounded-circle" src="uploads/<?= $user['photo'] ?? 'nopicture.jpg' ?>" alt="" style="max-width: 40%">
        </div>
    </div>
    <?php flash(); ?>
    <div class="row">
        <div class="col-lg-6">
            <form method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type='text' class="form-control" id="username" name="username" value="<?= $user['username'] ?>">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input name="email" type="email" class="form-control" id="email" value="<?= $user['email'] ?>">
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input name="photo" type="file" class="form-control" id="photo">
                </div>
                <button type="submit" class="btn btn-success form-control">Update</button>
            </form>
        </div>
        <div class="col-lg-6 ">
            <form method="post" action="updatePassword.php">
                <div class="mb-3">
                    <label for="oldPassword" class="form-label">Old Password</label>
                    <input type='password' class="form-control" id="oldPassword" name="oldPassword">
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword">
                </div>
                <button type="submit" class="btn btn-outline-primary form-control">Update Password</button>
            </form>
        </div>
    </div>
</div>
