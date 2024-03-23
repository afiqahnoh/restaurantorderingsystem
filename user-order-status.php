<?php
    include 'config.php';

    $status = $_GET['status'];

    runQuery("UPDATE `user_order` SET `status` = '$status' WHERE `user_order`.`id`=".$_GET['id']);

    echo "<script>window.location.href='user-order.php'</script>";
?>