<?php
    include 'config.php';

    if(!isset($_SESSION['account_session'])){
        echo "<script>alert('Please login first');</script>";
        echo "<script>window.location.href='menu_list'</script>";
        exit;
    }

    $getmenu = fetchRow("SELECT * FROM menu where id =".$_GET['id']);
    
    runQuery("INSERT INTO `user_cart` (`id`, `menu`, `user`, `size`) VALUES (NULL, '".$_GET['id']."', '".$_SESSION['account_session']."', '".$_GET['size']."')");

    $totalitem = numRows("SELECT * FROM user_cart where menu=".$_GET['id']." AND user=".$_SESSION['account_session']);

    echo "<script>window.location.href='user-cart.php'</script>";
?>