<div class="container">
    <h1>Halaman Home</h1>

    <h3>Hallo <?= $user['full_name'] ?? "" ?></h3>

    <?php \SipalingNgoding\MVC\libs\Flash::flash(); ?>

    <a href="/logout" class="btn btn-sm btn-outline-danger">Logout</a>

</div>
