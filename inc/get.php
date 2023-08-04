<?php global $pizza_toppings ?> <p><img src="https://www.phptutorial.net/app/multiplecheckboxes/img/pizza.svg" height="72" width="72" title="Pizza Toppings" alt="pizza"></p>
<?php if(!isset($error)) { ?>
    <form method="post">
        <h1>Please select your pizza toppings</h1>
        <ul>
            <?php foreach ($pizza_toppings as $topping=>$price) { ?>
                <li>
                    <div>
                        <input type="checkbox" name="pizza_toppings[]" value="<?= $topping ?>" id="pizza_topping_<?= $topping ?>" />
                        <label for="pizza_topping_<?= $topping ?>"><?php echo ucfirst($topping) ?></label>
                    </div>
                    <span><?= '$' . $price ?></span>
                </li>
            <?php } ?>
        </ul>
        <div>
            <button type="submit">Order Now</button>
        </div>
    </form>
<?php } else { ?>
    <p><?= $error ?></p>
    <a href="">Lanjutkan Memilih</a>
<?php } ?>
