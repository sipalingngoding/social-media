<div class="container my-3">
    <a class="btn btn-outline-primary" href="index.php"> <-Home</a>
    <h1>Add Todo</h1>
    <div class="row">
        <div class="col-lg-8">
            <?php flash(); ?>
            <form method="post">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Inputkan todo anda" id="floatingTextarea2" style="height: 100px" name="todo"></textarea>
                    <label for="floatingTextarea2">Masukan Todo Anda</label>
                </div>
                <div class="form-group">
                    <label for="time">Akan dilakukan pada</label>
                    <input type="datetime-local" class="form-control" id="time" name="time">
                </div>
                <button type="submit" class="btn btn-success btn-block form-control mt-2">Add</button>
            </form>
        </div>
    </div>
</div>
