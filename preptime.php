<?php
// amount gets stored per dish in an array in orders, which is an array of arrays

// calculatePrepTime function takes the order array
// loops through the objects calculating the time for all the dishes in the object, 
// if preptime is past ordertime, it should be removed from the array,
// each futher dish in orders adds $kitchenload +1 so the time gets delayed a little the later your order is placed

function calculatePrepTime() {
    // Array of dishes with prep times
    $dishPreptime = [
        ['pasta carbonara', 15],
        ['pasta pesto', 12],
        ['lasagne', 20],
        ['pizza hawaï', 10],
        ['pizza 4 kazen', 10]
    ];

    // Get orders from session
    if (isset($_SESSION['orders'])) {
        $orders = $_SESSION['orders'];
    } else {
        $orders = [];
    }

    // Current time
    $currentTime = time();
    
    // Array to store updated orders
    $updatedOrders = [];

    // Loops through all orders
    foreach ($orders as $key => $order) {
        // Variable to store the greatest prep time for the current order
        $maxPrepTime = 0;
        // Calculate the total amount of dishes for this order
        $totalAmount = 0;

        // Loop through each item in the order
        foreach ($order['items'] as $item) {
            // Compare each dish with the $dishPreptime array
            foreach ($dishPreptime as $dish) {
                // Compare dish name
                if ($item['name'] == $dish[0]) {
                    // Set the max prep time if it's greater than the previous ones
                    $maxPrepTime = max($maxPrepTime, $dish[1]);
                    // Add the item amount to the total amount of dishes in the order
                    $totalAmount += $item['amount'];
                }
            }
        }

        // If amount of dishes is greater than 5, add 5 minutes
        if ($totalAmount > 5) {
            $maxPrepTime = $maxPrepTime + 5;
        }

        // Kitchenload
        $maxPrepTime = $maxPrepTime + (count($updatedOrders) * 2);

        $orderTime = strtotime($order['time']);
        $orderReady = $orderTime + ($maxPrepTime * 60);

        if ($orderReady > $currentTime) {
            // Create a copy of the order and update its prepTime
            $updatedOrder = $order;
            $updatedOrder['prepTime'] = $maxPrepTime;
            $updatedOrders[] = $updatedOrder;
        }
        // Orders that are ready will be automatically filtered out
    }

    // Update the session with the modified orders
    $_SESSION['orders'] = $updatedOrders;
    
    return $_SESSION['orders'];
}