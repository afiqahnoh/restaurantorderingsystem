<?php
    include 'config.php';

    $collection = [];

    if(!isset($_SESSION['account_admin'])){
        header("Location: login.php");
        exit();
    }

    $totalorder = numRows("SELECT * FROM `user_order` WHERE status = 1");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'header.php'; ?>

    <style>
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 5px 7px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  margin: 4px 2px;
  cursor: pointer;
}

.buttonAvailable {
  background-color: #ffbf00;
  border: none;
  color: white;
  padding: 5px 7px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 12px;
  margin: 4px 2px;
  cursor: pointer;
}
</style>
</head>
<body>
    <div class="wrapper">
        <?php include 'sidebar.php'; ?>

        <div class="main">
            <?php include 'top-navbar.php'; ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <!--#START HEADER -->
                    <div class="row mb-2 mb-xl-3">
                        <div class="col-auto d-none d-sm-block">
                            <h3><strong>Manage</strong> Pizza</h3>
                        </div>

                        <div class="col-auto ms-auto text-end mt-n1">
							<a href="admin-create-product.php" class="btn btn-primary">Publish Pizza</a>
						</div>
                    </div>
                    <!--#END HEADER -->

                    <!--#START BODY -->
                    <div class="row">
						<div class="col-xl-12 col-xxl-12">
							<div class="card flex-fill w-100">

                                <!--#START Content -->
								<div class="card-body pt-4 pb-3">
                                
                                    <table class="table table-bordered table-md w-100">
                                        <tr class="shadow-1 border-1">
                                            <th>No.</th>
                                            <th>Picture</th>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>Category</th>
                                            <th>Visibility</th>
                                            <th>Action</th>
                                        </tr>

                                        <?php
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

                                            //# Menu Record
                                            $menurecord = fetchRows("SELECT * FROM menu");

                                            foreach($menurecord as $key => $value){

                                                $categoryname = [];
                                                $totalOrdered = 0;
                                                $isOutofstock = false;

                                                if(!empty($value['category'])){
                                                    $categoryfetch = fetchRow("SELECT * from category WHERE id = ".$value['category']);

                                                    if(!empty($categoryfetch)){
                                                        $categoryname = $categoryfetch;
                                                    }
                                                }

                                                if(isset($productOrder[$value['id']])){
                                                    $totalOrdered = explode(',',$productOrder[$value['id']]);
                                                    $totalOrdered = count($totalOrdered);
                                                }

                                                $isOutofstock = (($value['in_stock'] - $totalOrdered) <= 0);
                                        ?>
                                        <tr>
                                            <td align="center">
                                                <?php echo ($key + 1); ?>
                                            </td>
                                            <td align="left">
                                                <img src="images/<?php echo $value['image']; ?>" class="img-fluid pe-2" style="height: 100px;"/>
                                            </td>
                                            <td align="left">
                                                <?php echo $value['name']; ?>
                                            </td>
                                            <td>
                                                RM <?php echo $value['price']; ?>
                                            </td>
                                            <td align="left">
                                                <?php echo ($categoryname['name'] ?? '-'); ?>
                                            </td>
                                            <td align="left">
                                                <?php
                                                    if($value['is_active'] == 1){
                                                        echo '<a class="badge bg-warning">Available</a>';
                                                    }else{
                                                        echo '<a class="badge bg-danger">Sold Out</a>';
                                                    }
                                                ?>
                                            </td>
                                            <td align="left">
                                    <div class="w-full flex flex-row gap-2">
                                        <?php if ($value['is_active'] == 1) { ?>
                                            <a href="admin-product-deactive.php?id=<?php echo $value['id']; ?>">
                                            <button class="button" type="button" >Sold out</button>

                                            </a>
                                        <?php } else { ?>
                                            <a href="admin-product-deactive.php?id=<?php echo $value['id']; ?>">
                                                <button class="buttonAvailable" type="button">Available</button>
                                            </a>
                                        <?php } ?>

                                        <a href="admin-create-product.php?id=<?php echo $value['id']; ?>">
                                            <button class="btn btn-primary btn-sm" type="button">Edit</button>
                                        </a>

                                        <form method="POST">
                                            <button class="btn btn-danger btn-sm" type="submit" name="action_delete" value="<?php echo $value['id']; ?>">Delete</button>
                                        </form>
                                    </div>
                                </td>

                                        </tr>
                                        <?php } ?>
                                        
                                        <?php if(empty($menurecord)){ ?>
                                            <tr><td class="p-3" colspan="10">No Record Yet</td></tr>
                                        <?php } ?>
                                    </table>

								</div>
                                <!--#END Content -->

							</div>
						</div>
					</div>
                    <!--#END BODY -->

                </div>
            </main>

            <?php include 'footer.php'; ?>
        </div>
    </div>

    <?php 
if (isset($_POST['action_delete'])) {
    $menuId = $_POST['action_delete'];

    // Check if the menu is associated with any orders
    $menuOrders = fetchRows("SELECT * FROM `user_order` WHERE JSON_CONTAINS(menu_id, '[" . $menuId . "]')");

    if (empty($menuOrders)) {
        // If no orders are associated, then proceed with deletion
        runQuery("DELETE FROM `menu` WHERE `menu`.`id` = " . $menuId);
        ToastMessage('Success', 'Menu deleted!', 'success', 'admin-product.php');
    } else {
        // If orders are associated, display an error message
        ToastMessage('Error', 'Cannot delete the menu. It has already been purchased by customers.', 'error', 'admin-product.php');
    }
}
?>


</body>
</html>