<div class="container">
    <div class="row mt-5">
        <a class="" onclick="history.back()" style="cursor: pointer">Kembali</a>
        <h3>Update Photo</h3>
        <?php use SipalingNgoding\MVC\libs\Flash;

        Flash::flash(); ?>
        <div class="col-lg-6">
            <form action="/update?id=<?= $photo['id'] ?>" method="POST" enctype="multipart/form-data">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control" value="<?= $photo['title'] ?>">
                <div class="form-floating my-3">
                    <textarea class="form-control" placeholder="add description" id='description' style="height: 100px" name="description"><?= $photo['description'] ?></textarea>
                    <label for="description">Description</label>
                </div>
                <label for="image">Image (image only)</label>
                <input type="file" class="form-control" name="photo">
                <button class="btn btn-primary form-control mt-3">Update</button>
            </form>
        </div>
        <div class="col-lg-6">
            <div class="d-flex">
                <img class="m-auto" src="/uploads/<?= $photo['image'] ?>" alt="" style="max-width: 90%">
            </div>
        </div>
    </div>
</div>
