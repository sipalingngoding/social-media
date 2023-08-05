<?php global $choices ?>
<?php if(!isset($error)) { ?>
    <form method="post">
        <h1>Pilih metode pendaftaran</h1>
        <ul>
            <?php foreach ($choices as $choice) { ?>
                <li>
                    <div>
                        <input type="radio" name="choice" value="<?= $choice ?>" id="<?= $choice ?>" />
                        <label for="<?= $choice ?>"><?= ucfirst($choice) ?></label>
                    </div>
                </li>
            <?php } ?>
        </ul>
        <div>
            <button type="submit">Submit</button>
        </div>
    </form>
<?php } else { ?>
    <p><?= $error ?></p>
    <a href="">Lanjutkan Memilih</a>
<?php } ?>
