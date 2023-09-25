<div class="container my-5">
    <a href="/">Kembali</a>
    <div class="d-flex mb-4">
        <div class="w-50 m-auto">
            <img class="" src="uploads/user/<?= $user['photo'] ?? 'nopicture.jpg' ?>" alt="" style="max-width: 60%">
        </div>
    </div>
    <div class="row">
        <?php \SipalingNgoding\MVC\libs\Flash::flash(); ?>
        <div class="col-lg-6">
            <form method="post" action="/updateProfile" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input name="email" type="email" class="form-control" id="email" value="<?= $user['email'] ?>">
                </div>
                <div class="mb-3">
                    <label for="full_name" class="form-label">FullName</label>
                    <input type='text' class="form-control" id="full_name" name="full_name" value="<?= $user['full_name'] ?>">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type='text' class="form-control" id="address" name="address" value="<?= $user['address'] ?>">
                </div>
                <div class="mb-3">
                    <label for="photo" class="form-label">Photo</label>
                    <input name="photo" type="file" class="form-control" id="photo">
                </div>
                <button type="submit" class="btn btn-success form-control">Update</button>
            </form>
        </div>
        <div class="col-lg-6 ">
            <form method="post" action="/updatePassword">
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
