<?php foreach ($photos as $photo) { ?>
    <div class="col-lg-3 mb-2">
        <div class="card">
            <img height="200px" src="/uploads/<?= $photo['image']?>" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title"><?= $photo['title'] ?></h5>
                <p style="text-align: right">Diupload : <?= $photo['createdAt'] ?></p>
                <?php if ($user['id'] === $photo['userId']) { ?>
                    <div class="d-flex">
                        <a href="/photo?id=<?= $photo['id'] ?>" class="btn btn-outline-info mx-2 ">Info</a>
                        <a href="/update?id=<?= $photo['id'] ?>" class="btn btn-outline-primary mx-2">Update</a>
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#delete<?= $photo['id'] ?>">
                            delete
                        </button>
                    </div>
                <?php } else { ?>
                    <div class="d-flex">
                        <a href="/photo?id=<?= $photo['id'] ?>" class="btn btn-info mx-2 text-white">Selengkapnya</a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="delete<?= $photo['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4>Yakin ingin menghapus foto ini??</h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="/deletePhoto?id=<?= $photo['id'] ?>" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
