<?php
    include 'config.php';

    $id = ($_GET['id']);
    $size = ($_GET['size']);
    $userid = ($_SESSION['account_session']);
    $totalCart = fetchRows("SELECT * FROM user_cart where user=".$userid." AND menu=".$id);

    //# Get Product Stock
    $totalOrdered = 0;
    $totalCurrentcart = 0;
    $productInfo = fetchRow("SELECT * FROM menu WHERE id =".$id);
    $productStock = $productInfo['in_stock'];

    //# Collect Cart Count
    $totalCurrentcart = numRows("SELECT * FROM user_cart where user=".$userid." AND menu=".$id);

    //# Collect Order Count
    $productOrder = [];
    $orderFetch = fetchRows("SELECT * FROM `user_order`");

    foreach($orderFetch as $order){
        $itemorder = json_decode($order['menu_id']);

        foreach($itemorder as $o){
            if(isset($productOrder[$o])){
                $productOrder[$o] = $productOrder[$o].",".$o;
            }else{
                $productOrder[$o] = $o;
            }
        } 
    }

    //# Current Order For Single Product
    if(isset($productOrder[$id])){
        $totalOrdered = explode(',',$productOrder[$id]);
        $totalOrdered = count($totalOrdered);
    }

    //# Conclusion
    if(!empty($totalCart)){
        switch($_GET['action']){

            case 'add':
                if(($productStock - $totalOrdered - $totalCurrentcart) <= 0){
                    echo '<script>alert("Sorry, this product is out of stock"); window.location.href="user-cart.php"</script>';
                }else{
                    header("Location: user-cart-amount-increase.php?tocartpage&id=".$id."&size=".$size);
                }
            break;

            case 'minus':
                header("Location: user-cart-amount-reduce.php?id=".$totalCart[0]['id']."&size=".$size);
            break;

        }
    } 
?>