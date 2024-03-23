<?php
    include 'config.php';

    if(!isset($_SESSION['account_session'])){
        header("Location: login.php");
        exit();
    }

    $searchKey = ($_GET['searchkey'] ?? '');
    $searchcategory = ($_GET['searchcategory'] ?? '');
    $categories = fetchRows("SELECT * FROM category");

    $sizeChart = array(
        array( 'size'=> 'Small' ),
        array( 'size'=> 'Medium' ),
        array( 'size'=> 'Large' )
    );
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'header.php'; ?>
</head>
<body>
    <div class="wrapper">

        <div class="main">
            <?php include 'top-navbar.php'; ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <!--#START HEADER -->
                    <div class="row mb-2 mb-xl-3">
                        <div class="col-auto d-none d-sm-block">
                            <h3>Welcome back, <?php echo (!empty($accountData) ? $accountData['name'] : '') ?></h3>
                            <div class="card-footer pt-0">
                            <a href="./user-index.php" type="button" class="btn btn-secondary">Back</a>
                        </div>
                        </div>
                    </div>
                    <!--#END HEADER -->

                    <!--#START Tools -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="card">
                                <div class="card-body">

                                    <h4 class="mb-3">Search Tools</h4>

                                    <!--#Category Tab -->
                                    <ul class="pagination pagination-lg">
                                        <?php
                                            foreach($categories as $c){
                                                echo '
                                                <li class="page-item '.($searchcategory == $c['id'] ? 'active' : '').'">
                                                    <a class="page-link" href="user-menu.php?searchkey=&searchcategory='.$c['id'].'">'.$c['name'].'</a>
                                                </li>';
                                            }
                                        ?>
                                    </ul>

                                    <!--#Search Key -->
                                    <form method="GET" class="d-flex gap-3">
										<select name="searchcategory" class="form-control bg-light">
											<option value="">-- Select Category --</option>
											<?php
												foreach($categories as $c){
													echo '<option '.($searchcategory == $c['id'] ? 'selected' : '').' value="'.$c['id'].'">'.$c['name'].'</option>';
												}
											?>
										</select>

										<input type="text" name="searchkey" class="form-control bg-light" placeholder="Search" value="<?php echo $searchKey; ?>"/>

										<input type="submit" value="Search" class="btn btn-success"/>

										<a href="user-menu.php">
											<input class="btn btn-warning" type="button" value="Reset"/>
										</a>
									</form>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!--#END Tools -->

                    <!--#START CONTENT -->
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">

                            <!--#START Menu -->
                            <div class="row">
                                <?php
                                    $alreadypush = [];
                                    $searchquery = '';

                                    if(!empty($searchKey)){
                                        $searchquery .= "name LIKE '%$searchKey%'";
                                    }

                                    if(!empty($searchcategory)){
                                        if(!empty($searchKey)){
                                            $searchquery .= " AND ";
                                        }
                                        $searchquery .= "category = ".$searchcategory;
                                    }

                                    if(empty($searchKey) && empty($searchcategory)){
                                        $searchquery = '(1=1)';
                                    }

                                    $productPreview = fetchRows("SELECT * FROM menu WHERE $searchquery");
                                    
                                    if(!empty($productPreview)){
                                        //# Collect Order Product
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

                                        //# Loop Product
                                        foreach($productPreview as $c){
                                            $isOutstock = FALSE;
                                            $totalOrdered = 0;
                                            $totalCart = 0;
                                            $categoryname = [];
                                            $stockbalance = $c['in_stock'];

                                            if(isset($_SESSION['account_session'])){
                                                $totalCart = numRows("SELECT * FROM user_cart where user=".$_SESSION['account_session']." AND menu=".$c['id']);
                                            }

                                            if(!empty($c['category'])){
                                                $categoryfetch = fetchRow("SELECT * from category WHERE id = ".$c['category']);

                                                if(!empty($categoryfetch)){
                                                    $categoryname = $categoryfetch;
                                                }
                                            }

                                            if(isset($productOrder[$c['id']])){
                                                $totalOrdered = explode(',',$productOrder[$c['id']]);
                                                $totalOrdered = count($totalOrdered);
                                            }

                                            if(($stockbalance - $totalOrdered - $totalCart) <= 0){
                                                $isOutstock = TRUE;
                                            }

                                            if($c['is_active'] == 0){
                                                $isOutstock = TRUE;
                                            }

                                            if($isOutstock == FALSE){
                                                $sizeOptions = '';

                                                foreach($sizeChart as $size){
                                                    $sizeOptions .= '<option class="'.$size['size'].'">'.$size['size'].'</option>';
                                                }

                                                $addCartButton = '
                                                    <form method="GET" action="./user-menu-addcart.php" class="input-group" style="position: relative;">
                                                        <select name="size" class="form-select flex-grow-1" style="position: absolute;top: 0;z-index: -99;opacity: 0;left: 0;">'.$sizeOptions.'</select>

                                                        <input type="hidden" name="id" value="'.$c['id'].'"/>

                                                        <button class="btn btn-info" type="submit">Add Cart</button>
                                                    </form>
                                                ';
                                            }

                                            if($isOutstock == TRUE){
                                                $addCartButton = '<span class="text-danger fw-bold">Out of stock</span>';
                                            }

                                            //# Product Card
                                            if(!in_array($c['id'], $alreadypush)){
                                                echo '
                                                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                                    <div class="card">
                                                        <img class="card-img-top" src="./images/'.$c['image'].'" alt="Unsplash">
                                                        <div class="card-header">
                                                            <h5 class="card-title mb-0">'.$c['name'].'</h5>
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="card-text">'.($categoryname['name'] ?? '-').'</p>
                                                            <p class="card-text">RM '.$c['price'].'</p>
                                                            '.$addCartButton.'
                                                        </div>
                                                    </div>
                                                </div>';

                                                $alreadypush[] = $c['id'];
                                            }
                                        }
                                    }else{
                                        echo 'No record found';
                                    }
                                ?>
                            </div>
                            <!--#END Menu -->
                           
                        </div>
                        <div class="col-md-1"></div>
                    </div>
                    <!--#END CONTENT -->

                </div>
            </main>

            <?php include 'footer.php'; ?>
        </div>
    </div>
</body>
</html>