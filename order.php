<?php

// Array of dishes
$dishes = ['pasta carbonara', 'pasta pesto', 'lasagne', 'pizza hawaï', 'pizza 4 kazen'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start(); // Ensure session is started

    if (!isset($_SESSION['orders'])) {
        $_SESSION['orders'] = [];
    }

    $order = []; // Store all submitted dishes for this order
    $orderTime = date('Y-m-d H:i:s'); // Store the current timestamp

    foreach ($_POST['amount'] as $dishName => $amount) {
        if ($amount > 0) { // Only add items with a quantity > 0
            $order[] = [
                'name' => $dishName,
                'amount' => (int) $amount
            ];
        }
    }

    // Store the entire order as a separate group with the timestamp
    if (!empty($order)) {
        $_SESSION['orders'][] = [
            'time' => $orderTime,
            'items' => $order
        ];
    }
}

?>

<h1>Bestel</h1>

<!--Button to redirect to the order overview-->
<form action="index.php">
        <button>Terug naar overzicht</button>
</form>

<!--Order form-->
<form action="#" method="post">
    <?php 
        // Displays the available dishes + input field for the amount
        foreach ($dishes as $dish) {
            echo "$dish
                    <br>
                    <input type='number' name='amount[$dish]' placeholder='hoeveel'>
                    <br>
                    <br>";
        }
    ?>
    <input type="submit">
    <input type="reset">
</form>
