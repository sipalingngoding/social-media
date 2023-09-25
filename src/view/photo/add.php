<div class="container">
    <div class="row mt-5">
        <a class="" onclick="history.back()" style="cursor: pointer">Kembali</a>
        <h3>Add Photo</h3>
        <?php \SipalingNgoding\MVC\libs\Flash::flash(); ?>
        <div class="col-lg-6">
            <form action="/addPhoto" method="POST" enctype="multipart/form-data">
                <label for="title" class="form-label">Title</label>
                <input type="text" id="title" name="title" class="form-control">
                <div class="form-floating my-3">
                    <textarea class="form-control" placeholder="add description" id='description' style="height: 100px" name="description"></textarea>
                    <label for="description">Description</label>
                </div>
                <label for="image">Image (image only)</label>
                <input type="file" class="form-control" name="photo">
                <button class="btn btn-primary form-control mt-3">Add</button>
            </form>
        </div>
    </div>
</div>
