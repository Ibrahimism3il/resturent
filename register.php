<?php
include 'db.php';
session_start();
if(!empty($_SESSION['user_id'])){
    header('location: home.php');
}
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $pass = sha1($_POST['password']);
    $cpass = sha1($_POST['cpassword']);

    $user_type = 'user';
    $select = "SELECT * FROM users WHERE email = '$email' ";
    $result = mysqli_query($conn, $select);
    if (mysqli_num_rows($result) > 0) {
        $error[] = 'user already exist!';
    } else {

        if ($pass != $cpass) {
            $error[] = 'password not matched';
        } else {
            $insert = "INSERT INTO users (name , email , password , type) VALUES ('$name' , '$email' , '$pass' , '$user_type' )";
            mysqli_query($conn, $insert);
            header('location: login.php');
        }
    }
}
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
    <style>
        .register .content .info .error-msg {
            margin: 10px 0;
            display: block;
            background: #ff000078;
            color: white;
            border-radius: 5px;
            font-size: 20px;
            padding: 10px;
        }
    </style>
</head>

<body>
    <?php
    //session_start();
    ?>

    <body>
        <div class="header" id="header">
            <div class="container">
                <a href="home.php" class="logo"> Restaurant </a>
                <ul class="main-nav">
                    <li><a href="home.php">Home</a></li>
                    <?php if (isset($_SESSION['user_id'])) { ?>
                        <li><a href="cart.php">Cart</a></li>
                        <li><a href="logout.php">Logout</a></li>
                    <?php } else { ?>
                        <li><a href="login.php">login</a></li>
                        <li><a href="register.php">register</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="register" id="register">
            <div class="content">
                <div class="info">
                    <h2>Create new account</h2>
                    <?php if (isset($error)) {
                        foreach ($error as $error) {
                            echo '<span class="error-msg">' . $error . '</span>';
                        };
                    }; ?>
                    <form action="" method="post">
                        <input class="input" type="text" placeholder="Name" name="name" required />
                        <input class="input" type="email" placeholder="Email" name="email" required />
                        <input class="input" type="password" placeholder="Password" name="password" required />
                        <input class="input" type="password" placeholder="Confirm Password" name="cpassword" required />

                        <input type="submit" value="Register" name="submit" />
                    </form>
                </div>
            </div>
        </div>
        <?php
        include 'footer.php' ?> ;
    </body>

</html>