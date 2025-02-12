<?php

session_start();

// Array of prep times
include 'preptime.php';
$orders = calculatePrepTime();

print_r ($orders);

?>

<h1>Besteloverzicht</h1>

<!--Button to redirect to the order page-->
<form action="order.php">
    <button>Bestel</button>
</form>


<!--Displays all orders with prep time-->
<div>
    <?php
    if ($orders) {
        // Loops through all orders
        foreach ($orders as $index => $order) {
            echo "<b>Bestelling ".($index + 1)."</b><br>";
            // Loops through the specific order to display each dish and the amount
            foreach ($order['items'] as $item) {
                echo $item['amount']." ".$item['name']."<br>";
            }
            echo "<br>";
            echo "Bestelling geplaatst op: ".$order['time']."<br>";
            // Display the prep time for each order
            echo "Bereidingstijd: ".$order['prepTime']." minuten<br>";

            // Calculate time when ready
            $orderTime = strtotime($order['time']);
            $orderReady = $orderTime + ($order['prepTime'] * 60);

            // Calculate minutes remaining
            $currentTime = time();
            $minutesRemaining = ceil(($orderReady - $currentTime) / 60);

            // Display time 'till ready
            echo "Klaar in: ".$minutesRemaining." minuten<br><br><br>";
        }
    } else {
        echo "No orders found.";
    }
    ?>
</div>