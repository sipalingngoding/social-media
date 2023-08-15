<?php foreach ($todoList as $todo) { ?>
    <div class="col-lg-3 mb-2">
        <div class="card">
            <div class="card-body">
                <?php $type = $todo['status'] === 'no' ? "warning" : ($todo['status'] === 'yes'  ? "success" : "danger");
                    $text = $type === 'warning' ? "Belum dilakukan" : ($type === 'success' ? "Sudah dilakukan" : "Telat dilakukan");
                ?>
                <div class="alert alert-<?= $type ?>" role="alert">
                    <?= $text ?>
                </div>
                <p style="font-size: 23px" class="card-text"><?= $todo['todo'] ?></p>
                <h5 class="card-text text-lg-end"><?= date('d-M-y, H:i:s',timestamp(preg_replace("/ /",'T',$todo['time']))) ?></h5>
                <?php if ($type !== 'success' && $type !== 'danger') { ?>
                    <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#modal1<?= $todo['todo_id'] ?>">
                        lakukan
                    </button>
                    <a href="updatetodo.php?todo_id=<?= $todo['todo_id'] ?>" class="btn btn-sm btn-outline-primary">Update</a>
                <?php } ?>
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal2<?= $todo['todo_id'] ?>">
                    delete
                </button>
            </div>
        </div>
    </div>
    <!--  Modal 1 -->
    <div class="modal fade" id="modal1<?= $todo['todo_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Todo: <?= $todo['todo'] ?></h5>
                    <h6>Waktu: <?=date('d-M-y, H:i:s',timestamp(preg_replace("/ /",'T',$todo['time'])))?></h6>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="updatetodo.php?todo_id=<?= $todo['todo_id']?>&status=yes" type="button" class="btn btn-success">Lakukan</a>
                </div>
            </div>
        </div>
    </div>
    <!--  Modal  -->
    <div class="modal fade" id="modal2<?= $todo['todo_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfirmasi</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>Todo: <?= $todo['todo'] ?></h5>
                    <h6>Waktu: <?= date('d-M-y, H:i:s',timestamp(preg_replace("/ /",'T',$todo['time']))) ?></h6>
                    <div class="alert alert-<?= $type ?>" role="alert">
                        <?= $text ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="deletetodo.php?todo_id=<?= $todo['todo_id'] ?>" type="button" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
