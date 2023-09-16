<?php
session_start();
include 'db.php' ;
$msg = "";
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $table_id = $_POST['id'];
        $person_count = $_POST['num'];
        $date = $_POST['date'];
        $customer_id = $_SESSION['user_id'] ;
        if(empty($table_id) || empty($person_count) || empty($date) || empty($customer_id)){
            $msg = "Please fill all fields!";
        }else{
            $sql = "INSERT INTO table_reservations (table_id, customer_id, person_count, date) VALUES ('$table_id', '$customer_id', '$person_count','$date')";
            $result = mysqli_query($conn , $sql);
            $msg = "New Reservation has been added";
        }
    }

?>
<style>
    .items {
        border: 1px solid #999;
        padding: 2rem;
    }
    .item {
        border: 1px solid #999;
        padding: 2rem;
        text-align: center;

    }
    .item > * {
        display: block;
    }
    .item a, button[type="submit"] {
        display: inline-block;
        background: #0099ff;
        padding: 0.2rem 1rem;
        color: #fff;
        border-radius: 1rem;
        border:none;
        cursor: pointer;
    }
    .item form {
        display:flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .item form button {
        display: inline-block;
    }
    .content {
        display: flex;
        gap: 0.5rem;
   }
</style>
<?php include 'header.php' ;?>

<div><?=$msg?></div>
    <div class="text"> 
        <h2>About Our Restaurant </h2>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quis recusandae, tempore possimus commodi quaerat beatae voluptatum at et ipsa tenetur. Molestias recusandae at a rerum nam minus saepe voluptatibus quia?</p>
    </div>

    <div class="items">
        <div class="container">
            <h2>Explore our meals</h2>
            <div class="content">
                <?php
                $sql = "SELECT meal.ID, meal.name, category.name as category_name FROM meal JOIN category ON category.ID = meal.category_id";
                $res = mysqli_query($conn,$sql);
                $meal;
                while($meal = mysqli_fetch_assoc($res)){  ?>
                <div class="item">
                    <h1 class="meal_name"><?=$meal['name']?> </h1>
                    <h4 class="category"><?=$meal['category_name'] ?></h4>
                    <a href="cart.php?id=<?=$meal['ID']?>"> Order </a>
                </div>

                 <?php } ?>

                 </div>
        </div>
    </div>

    <div class="items">
            <h2>Reserve a Table</h2>
            <div class="content">
                <?php
                include 'db.php';
                $sql = "SELECT * FROM tables";
                $res = mysqli_query($conn,$sql);
                $table;
                while($table = mysqli_fetch_assoc($res)){  ?>
                <div class="item">
                    <form method="post">
                        <h1 class="meal_name">Table <?=$table['name']?> </h1>
                        <label> Number of people: <input type="number" name="num"/> </label> 
                        <label> Date: <input type="date" name="date" min="<?=date("Y-m-d")?>"/> </label> 
                        <input type="hidden" name="id" value="<?=$table['ID']?>" />
                        <button type="submit"> reserve </button>
                    </form>
                </div>

                 <?php } ?>

                 </div>
    </div>

    <?php include 'footer.php' ; ?>

</body>
</html>
