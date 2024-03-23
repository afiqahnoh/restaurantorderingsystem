<?php
    include 'config.php';
    
    $todeleteID = explode(',',$_GET['id']);

    foreach($todeleteID as $c){
        runQuery("DELETE FROM `user_cart` WHERE `user_cart`.`id`=".$c);
    }

    echo "<script>window.location.href='user-cart.php'</script>";
?>