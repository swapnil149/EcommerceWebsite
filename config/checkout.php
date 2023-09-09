<!-- checkout.php -->
<?php
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the itemList is not empty
    if (!empty($_POST['itemList'])) {
        $itemListData = $_POST['itemList'];
        // Parse the JSON data into an array using json_decode
        $itemList = json_decode($itemListData, true);
        // Get the current date in the format YYYY-MM-DD
        $ordered_date = date('Y-m-d');

        // Insert the order into the order_table
        $query = "INSERT INTO Order_table (ordered_date) VALUES ('$ordered_date')";
        mysqli_query($conn, $query);

        // Get the auto-generated ordered_id from the last insert operation
        $order_id = mysqli_insert_id($conn);
        // Loop through the itemList and save the corresponding ordered_id, item_id, and item_quantity in the order_item table
        foreach ($itemList as $item) {
            $item_id = intval($item['itemId']);
            $item_quantity = intval($item['quantity']);

            // Insert the item into the order_item table along with the corresponding ordered_id
            $query = "INSERT INTO Order_item (order_id, item_id, item_quantity) 
                    VALUES ('$order_id', '$item_id', '$item_quantity')";
            mysqli_query($conn, $query);
        }
    }
}
?>