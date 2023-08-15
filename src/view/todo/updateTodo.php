<div class="container my-3">
    <a class="btn btn-outline-primary" href="index.php"> <-Home</a>
    <h1>Update Todo</h1>
    <div class="row">
        <div class="col-lg-8">
            <?php flash(); ?>
            <form method="post">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Inputkan todo anda" id="floatingTextarea2" style="height: 100px" name="todo"><?= $todo['todo'] ?></textarea>
                </div>
                <div class="form-group">
                    <label for="time">Akan dilakukan pada</label>
                    <input type="datetime-local" class="form-control" id="time" name="time" value="<?= $todo['time']?>">
                </div>
                <button type="submit" class="btn btn-outline-primary btn-block form-control mt-2">Update</button>
            </form>
        </div>
    </div>
</div>
