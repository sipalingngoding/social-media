<div class="container p-5">
    <h3>Hallo <?= $user['full_name'] ?? "" ?></h3>
    <div class="d-flex justify-content-between">
        <div class="div">
            <a href="/beranda" class="btn btn-secondary btn-sm">Beranda</a>
            <a href="/addPhoto" class="btn btn-primary btn-sm">AddPhoto</a>
            <a href="/profile" class="btn btn-success btn-sm">Profile</a>
        </div>
        <a href="/logout" class="btn btn-sm btn-outline-danger">Logout</a>
    </div>
    <hr>
    <h3 class="text-center">All My Photos</h3>
<!--    <button class="my-2 btn btn-primary" id="my">My Photo</button>-->
    <div class="col-lg-2 my-3">
        <select class="form-select" id="select" aria-label="Default select example">
            <option selected>Select</option>
            <option value="desc">New</option>
            <option value="asc">Old</option>
        </select>
    </div>
    <?php \SipalingNgoding\MVC\libs\Flash::flash(); ?>
    <div class="row" id="photos">
        <?php require_once __DIR__."/../../ajax/photo.php"?>
    </div>
</div>
