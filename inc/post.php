<?php

global $pizza_toppings;
$selected_toppings = filter_input(INPUT_POST,'pizza_toppings',FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);

if(!$selected_toppings){
    $error = "Mohon inputkan order anda minimal satu";
    require_once __DIR__."/get.php";
    exit();
}

$toppings = [];

foreach ($selected_toppings as $topping)
{
    if(!isset($pizza_toppings[$topping])){
        header("Location:index.php");
        exit();
    }
    $toppings[$topping] = $pizza_toppings[$topping];
}

$total = array_reduce($toppings,fn($a,$b)=> $a+$b);


?>
<p><img src="https://www.phptutorial.net/app/multiplecheckboxes/img/pizza.svg" height="72" width="72" title="Pizza Toppings" alt="pizza"></p>
<h1>Order Summary</h1>
<ul>
    <?php foreach ($toppings as $topping=>$price) { ?>
        <li>
            <div>
                <label for="pizza_topping_<?= $topping ?>"><?php echo ucfirst($topping) ?></label>
            </div>
            <span><?= '$' . $price ?></span>
        </li>
    <?php } ?>
    <li class="total"><span>Total</span><span><?php echo '$' . $total ?></span></li>
</ul>

