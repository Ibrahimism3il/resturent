<?php 
session_start();
if(empty($_SESSION['user_id'])){
    header('location: login.php');
}else {
    if($_SESSION['is_admin']) {
        header('location: admin/index.php');
    }else{
        header('location: home.php');
    }
}

?>