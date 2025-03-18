<?php

session_start();

// Array of prep times
include 'preptime.php';
$orders = calculatePrepTime();

?>
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

<h1 class="text-4xl font-bold underline p-4">
    Besteloverzicht
</h1>

<!--Button to redirect to the order page-->
<form action="order.php">
    <button class="border-2 border-lime-500 rounded-xl m-2 ml-4 p-1 w-1/2">Bestel</button>
</form>


<!--Displays all orders with prep time-->
<div>
    <?php
        if ($orders) {
            // Loops through all orders
            foreach ($orders as $index => $order) {
                echo "<h2 class='text-xl font-bold m-2 ml-4'>Bestelling ".($index + 1)."</h2>
                <div class='m-2 ml-4'>";
                // Loops through the specific order to display each dish and the amount
                foreach ($order['items'] as $item) {
                    echo $item['amount']." ".$item['name']."<br>";
                }
                echo "</div>";
                echo "<div class='flex w-1/2 ml-4'>
                <div class='flex flex-wrap justify-start w-1/2'>Bestelling geplaatst op: </div>
                <div class='flex flex-wrap justify-end W-1/2'>".$order['time']."</div>
                </div>";
                // Display the prep time for each order
                echo "<div class='flex w-1/2 ml-4'>
                <div class='flex flex-wrap justify-start w-1/2'>Bereidingstijd: </div>
                <div class='flex flex-wrap justify-end W-1/2'>".$order['prepTime']." minuten</div>
                </div>";

                // Calculate time when ready
                $orderTime = strtotime($order['time']);
                $orderReady = $orderTime + ($order['prepTime'] * 60);

                // Calculate minutes remaining
                $currentTime = time();
                $minutesRemaining = ceil(($orderReady - $currentTime) / 60);

                // Display time 'till ready
                echo "<div class='flex w-1/2 ml-4'>
                <div class='flex flex-wrap justify-start w-1/2'>Klaar in: </div>
                <div class='flex flex-wrap justify-end W-1/2'>".$minutesRemaining." minuten</div>
                </div>
                </div>
                <hr class='border-1 border-lime-500 w-1/2 m-4'>";
            }
        } else {
            echo "<p class='m-2 ml-4'>No orders found.</p>";
        }
    ?>
</div>

<div class="flex flex-wrap justify-end w-1/2">
    <img src="Images/Food.png">
</div>