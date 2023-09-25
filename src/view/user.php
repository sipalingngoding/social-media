<div class="container p-4">
    <div class="d-flex">
        <img width="70px" src="/uploads/user/<?= $userPhoto['photo'] ?? "nopicture.jpg" ?>" alt="">
        <h2 class="mt-3"><?= $userPhoto['full_name'] ?></h2>
    </div>
    <hr>
    <a class="" onclick="history.back()" style="cursor: pointer">Kembali</a>
    <h3 class="text-center">All Photos</h3>
    <div class="row content">
        <?php require_once __DIR__."/../ajax/photo.php" ?>
    </div>
</div>
