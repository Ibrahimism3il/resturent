<?php
session_start();
include 'db.php';
$user_id = $_SESSION['user_id'];
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM meal WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $meal = mysqli_fetch_assoc($result);

    $meal_name = $meal['name'];
    $meal_id = $meal['ID'];


    $sql = "SELECT * FROM orders WHERE customer_id = $user_id AND meal_id = $meal_id";
    $res = mysqli_query($conn, $sql);
    $current_meal = mysqli_fetch_assoc($res);

    if ($current_meal == null) {
        $sql = "INSERT INTO orders ( customer_id, quantity, meal_id, done ) VALUES ('$user_id' , '1', '$meal_id', false)";
    } else {
        $quantity = $current_meal['quantity'];
        $new_quantity = (float) $quantity + 1;
        $sql = "UPDATE orders SET quantity = $new_quantity WHERE meal_id = $meal_id AND customer_id = $user_id";
    }
    $res = mysqli_query($conn, $sql);
}
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM orders WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
}

if (isset($_GET['cancel'])) {
    $id = $_GET['cancel'];
    $sql = "DELETE FROM table_reservations WHERE ID = '$id'";
    $result = mysqli_query($conn, $sql);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/normaliza.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Open+Sans:ital,wght@0,300;0,400;0,700;0,800;1,300&family=Work+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        .content-table {
            width: 100%;
            border-collapse: collapse;
        }

        .content-table .title th {
            background-color: #191919;
            color: white;
            font-weight: 500;
            padding: 10px 13px;
        }

        .content-table td {
            padding: 12px 15px;
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>
    <div class="cart">
        <div class="container">
            <h2 style="font-weight: 500; text-align: center;">Your Orders </h2>
            <table class="content-table">
                <tr class="title">
                    <th> meal </th>
                    <th> Price </th>
                    <th> Quantity </th>
                    <th> Total </th>
                    <th> Done </th>
                    <th> Delete </th>
                </tr>
                <?php
                $sql = "SELECT orders.ID, meal.name, meal.price, orders.quantity FROM orders JOIN meal ON orders.meal_id = meal.ID  WHERE customer_id = $user_id ";
                $res = mysqli_query($conn, $sql);
                $meal;
                while ($meal = mysqli_fetch_assoc($res)) { ?>
                    <tr style="text-align: center;  ">
                        <td><?= $meal['name'] ?></td>
                        <td><?= $meal['price'] ?>$</td>
                        <td><?= $meal['quantity'] ?></td>
                        <td><?= ((float) $meal['price']) * ((float) $meal['quantity']) ?>$</td>
                        <td><?= isset($meal['done']) ? ($meal['done'] ? "Yes" : "No") : "N/A" ?>
                        <td><button onclick="window.location.href = window.location.origin + window.location.pathname + '?delete=<?= $meal['ID'] ?>' "> <i class="fa-solid fa-square-xmark" style="font-size: 30px; color: #c10000;"></i> </button></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div class="container">
            <h2 style="font-weight: 500; text-align: center;">Your Reservations </h2>
            <table class="content-table">
                <tr class="title">
                    <th> Table Id </th>
                    <th> Number of People </th>
                    <th> Date </th>
                    <th> Delete </th>
                </tr>
                <?php
                $sql = "SELECT * FROM table_reservations  WHERE customer_id = $user_id ";
                $res = mysqli_query($conn, $sql);
                $reservation;
                while ($reservation = mysqli_fetch_assoc($res)) { ?>
                    <tr style="text-align: center;  ">
                        <td><?= $reservation['table_id'] ?></td>
                        <td><?= $reservation['person_count'] ?></td>
                        <td><?= $reservation['date'] ?></td>
                        <td><button onclick="window.location.href = window.location.origin + window.location.pathname + '?cancel=<?= $reservation['ID'] ?>' "> <i class="fa-solid fa-square-xmark" style="font-size: 30px; color: #c10000;"></i> </button></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <?php include 'footer.php'; ?>
    </div>
</body>

</html>