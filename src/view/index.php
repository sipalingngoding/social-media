<div class="container my-4">
    <div class="d-flex mb-3">
        <img class="rounded-circle" src="<?php $user['photo'] ? print "uploads/".$user['photo'] : print "uploads/nopicture.jpg" ?>" alt="" style="max-width: 5%">
        <h1>Hello <?= $user['username'] ?></h1>
    </div>
    <a href="addtodo.php" class="btn btn-primary">add todo</a>
    <a href="profile.php" class="btn btn-outline-info">Profile</a>
    <a href="logout.php" class="btn btn-danger">logout</a>
    <hr>
    <h3 class="text-center">My Todo List</h3>
    <div class="row mb-3">
        <div class="col-lg-3">
            <select class="form-select" id="select" aria-label="Default select example">
                <option selected value="">Filter</option>
                <option value="yes">Sudah dilakukan</option>
                <option value="no">Belum dilakukan</option>
                <option value="false">Telat dilakukan</option>
            </select>
        </div>
        <div class="col-lg-4">
            <form class="d-flex" role="search">
                <input class="form-control me-2" id="search" type="search" placeholder="Search" aria-label="Search">
            </form>
        </div>
    </div>
    <div class="row" id="todolist">
        <?php flash(); ?>
        <?php require_once __DIR__ . "/../ajax/todolist.php" ?>
    </div>
</div>
