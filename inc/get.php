<?php global $colors ?>
<?php if(!isset($error)) { ?>
    <form method="post">
        <h1>Pilih warna</h1>
        <label for="color">Background Color:</label>
        <select name="color" id="color">
            <option value="">Pilih warna</option>
            <?php foreach ($colors as $color) { ?>
                <option value="<?= $color?>"><?= ucfirst($color) ?></option>
            <?php } ?>
        </select>
        <div style="margin-top: 1.1rem">
            <button type="submit">Submit</button>
        </div>
    </form>
<?php } else { ?>
    <p><?= $error ?></p>
    <a href="">Lanjutkan Memilih</a>
<?php } ?>
