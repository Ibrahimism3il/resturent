<?php 
session_start();
if(!empty($_SESSION['user_id'])){
    header('location: home.php');
}
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="css/all.min.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/normaliza.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&family=Open+Sans:ital,wght@0,300;0,400;0,700;0,800;1,300&family=Work+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

</head>
<body>
    <div class="header" id="header">
        <div class="container">
            <a href="home.php" class="logo"> Restaurant </a>
            <ul class="main-nav">
                <li><a href="home.php">Home</a></li>
                <?php if(isset($_SESSION['user_id'])) { ?>
                <li><a href="cart.php">Cart</a></li>
                <li><a href="logout.php">Logout</a></li>
                <?php }else{?>                
                <li><a href="login.php">login</a></li>
                <li><a href="register.php">register</a></li>
                <?php }?>
            </ul>
        </div>
    </div>

    <?php 
    include 'db.php' ;

if(isset($_POST['login'])) {
    $email = $_POST['email'];
    $pass = sha1($_POST['pass']);
    
    $sql = "SELECT * FROM users WHERE email = '$email' and password = '$pass'" ;
    $result = mysqli_query($conn , $sql);
    $user = mysqli_fetch_assoc($result);
    if($user) {
        $_SESSION['user_id'] = $user['id'] ;
        if($user['type'] == 'admin') {
            header("location: admin/index.php") ; 
            $_SESSION['is_admin'] = true ;
        }else {
            header("location: home.php") ; 

        }

    }else {
        $error = "Invalid Credenttial" ;
    }
}
?>
    <div class="login" id="login">
        <div class="content">
            <div class="info">
              <?php 
                if(isset($error)) { 
                     echo $error;
                }
              ?>
                <h2> Login to your account </h2>
                <form action="" method="post">
                    <input class="input" type="email" placeholder="Email" name="email">
                    <input class="input"type="password" placeholder="Password" name="pass">
                    <input type="submit" value="Login" name="login">
                </form>
            </div>
        </div>
    </div>
    <?php include 'footer.php' ; ?>
</body>
</html>
