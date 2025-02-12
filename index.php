<?php

session_start();

// Array of orders
if (isset($_SESSION['orders'])) {
    $orders = $_SESSION['orders'];
} else $orders = [];

// Array of prep times
include 'preptime.php';
$preptime = calculatePrepTime();

print_r ($preptime);

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
            // Shows the prep time for each order
            echo "Bereidingstijd: ".$preptime[$index]
                    ." minuten<br><br><br>";
        }
    } else {
        echo "No orders found.";
    }
    ?>
</div>