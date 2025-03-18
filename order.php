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
                'amount' => (int) $amount,
            ];
        }
    }

    // Store the entire order as a separate group with the timestamp
    if (!empty($order)) {
        $_SESSION['orders'][] = [
            'time' => $orderTime,
            'prepTime' => 0,
            'items' => $order
        ];
    }
}

?>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<h1 class="text-4xl font-bold underline p-4">Bestel</h1>

<!--Button to redirect to the order overview-->
<form action="index.php">
        <button class="border-2 border-lime-500 rounded-xl m-2 ml-4 p-1 w-1/2">Terug naar overzicht</button>
</form>

<!--Order form-->
<form action="#" method="post">
    <?php 
        // Displays the available dishes + input field for the amount
        foreach ($dishes as $dish) {
            echo "<div class='flex w-1/2 m-2 ml-4'>
                    <div class='flex flex-wrap justify-start w-1/2'>$dish</div>
                    <div class='flex flex-wrap justify-end W-1/2'>
                        <input type='number' name='amount[$dish]' placeholder='hoeveel'>
                    </div>
                    </div>";
        }
    ?>
    <div class="flex justify-center w-1/2 mt-5">
        <input class="border-2 border-lime-500 rounded-xl ml-4 p-1 w-1/2" type="submit" value="Bestellen">
        <input class="border-2 border-lime-500 rounded-xl ml-4 p-1 w-1/2" type="reset" value="Reset">
    </div>
</form>
