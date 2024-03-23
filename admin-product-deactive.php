<?php
    include 'config.php';

    $getmenu = fetchRow("SELECT * FROM menu where id =".$_GET['id']);
    $flag = ($getmenu['is_active'] == '0' ? '1' : '0');

    runQuery("UPDATE `menu` SET `is_active` = $flag WHERE `menu`.`id` =".$_GET['id']);

    echo "<script>window.location.href='admin-product.php'</script>";
?>