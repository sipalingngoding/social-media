<div class="container p-4">
    <div class="row">
        <a class="" onclick="history.back()" style="cursor: pointer">Kembali</a>
        <div class="col-lg-6">
            <div class="d-flex">
                <img class="m-auto rounded-circle" src="/uploads/<?= $photo['image'] ?>" alt="" height="300px">
            </div>
            <?php if ($photo['userId'] !== $user['id']) { ?>
                <div style="text-align: right">
                    <a href="/user?id=<?= $photo['user']['id'] ?>"><?= $photo['user']['full_name'] ?></a><strong> (Pemilik)</strong>
                </div>
            <?php } ?>
            <hr>
            <h4>Title</h4>
            <h6><?= $photo['title'] ?></h6>
            <h4>Description</h4>
            <h6 class="mb-3"><?= $photo['description'] ?></h6>
            <h6 style="text-align: right">Diupload pada <?= $photo['createdAt'] ?></h6>
            <?php if ($user['id'] ===  $photo['userId']) { ?>
                <a class="btn btn-primary form-control" href="/update?id=<?= $photo['id'] ?>">Update Photo</a>
            <?php } ?>
        </div>
        <div class="col-lg-6 align-self-center">
            <h2>Comment</h2>
            <?php \SipalingNgoding\MVC\libs\Flash::flash(); ?>
            <form action="/comment?id=<?= $photo['id'] ?>" method="POST">
                <div class="d-flex">
                    <input type="text" class="form-control" placeholder="masukan comment anda" name="comment">
                    <button class="btn btn-secondary mx-2">comment</button>
                </div>
            </form>
            <hr>
            <div class="comment">
                <?php foreach ($comments as $comment) { ?>
                    <div class="d-flex">
                        <strong  onclick="location.href='/user?id=<?= $comment['userId'] ?>'" style="margin-right: 5px; cursor: pointer"><?= $comment['full_name'] ?></strong>
                        <?php if ($comment['userId'] === $user['id']) { ?>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#updateComment<?= $comment['id'] ?>">update</button>
                        <?php }?>
                        <?php if ($comment['userId'] === $user['id'] || $photo['userId'] === $user['id']) { ?>
                            <button class="mx-2 btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteComment<?= $comment['id'] ?>">delete</button>
                        <?php }?>
                    </div>
                    <p><?= $comment['comment'] ?></p>


                    <!-- Modal -->
                    <div class="modal fade" id="deleteComment<?= $comment['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h4>Yakin ingin menghapus comment ini??</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <a href="/deleteComment?id=<?= $comment['id'] ?>" class="btn btn-danger">Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>



                    <!-- Modal -->
                    <div class="modal fade" id="updateComment<?= $comment['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Comment</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="/updateComment?id=<?= $comment['id'] ?>" method="post">
                                        <label for="comment" class="form-label">Comment</label>
                                        <input type="text" id="comment" name="comment" class="form-control" value="<?= $comment['comment'] ?>">
                                        <button class="mt-2 btn btn-primary form-control">Update</button>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
