<?php
    include 'config.php';

    $collection = [];

    if(!isset($_SESSION['account_admin'])){
        header("Location: login.php");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<?php include 'header.php'; ?>
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
                            <h3><strong>Order</strong> List</h3>
                        </div>
                    </div>
                    <!--#END HEADER -->

                    <!--#START Chart -->
                    <div class="row">
						<div class="col-xl-12 col-xxl-12">
							<div class="card flex-fill w-100">

                                <!--#START Chart Canvas -->
								<div class="card-body pt-4 pb-3">

                                <div class="w-100 table-responsive">
                                    <table class="w-100 table table-bordered table-striped">
                                        <tr>
                                            <th class="py-2 surface-0 px-3 border-bottom-1 border-300 bg-yellow-400">No.</th>
                                            <th class="py-2 surface-0 px-3 border-bottom-1 border-300 bg-yellow-400">Products</th>
                                            <th class="py-2 surface-0 px-3 border-bottom-1 border-300 bg-yellow-400">Invoice Number</th>
                                            <th class="py-2 surface-0 px-3 border-bottom-1 border-300 bg-yellow-400">Time</th>
                                            <th class="py-2 surface-0 px-3 border-bottom-1 border-300 bg-yellow-400">Status</th>
                                            <th class="py-2 surface-0 px-3 border-bottom-1 border-300 bg-yellow-400">Invoice</th>
                                        </tr>

                                        <?php
                                            $counter = 0;
                                            $userrecord = fetchRows("SELECT * FROM `user_order` ORDER BY status DESC");

                                            foreach($userrecord as $key => $value){

                                                $menuList = '<ol class="p-3 m-0">';
                                                $menuorder = array_unique(json_decode($value['menu_id']));
                                                $menuquantity = array_count_values(json_decode($value['menu_id']));
                                                $menusize = json_decode($value['size']);

                                                foreach($menuorder as $key => $m){
                                                    $quantity = ($menuquantity[$m]);
                                                    $bobo = fetchRow("SELECT * FROM menu WHERE id=".$m);

                                                    $menuList .= "<li style='text-align: initial; padding: 0 .3rem;'>
                                                        ".$bobo['name']." <b>x".$quantity."</b>
                                                    </li>";
                                                }

                                                $menuList .= '</ol>';
                                                $counter++;
                                        ?>
                                        <tr>
                                            <td class="py-2 surface-0 px-3 text-center border-bottom-1 border-300"><?php echo ($counter); ?></td>
                                            <td class="py-2 surface-0 px-3 text-center border-bottom-1 border-300 flex align-items-center justify-content-center"><?php echo $menuList; ?></td>
                                            <td class="py-2 surface-0 px-3 text-center border-bottom-1 border-300"><?php echo $value['unique_number']; ?></td>
                                            <td class="py-2 surface-0 px-3 text-center border-bottom-1 border-300"><?php echo date_format(date_create($value['created_date']),"d F Y h:i A"); ?></td>
                                           
                                            <td class="py-2 surface-0 px-3 text-center border-bottom-1 border-300">
                                                <?php
                                                    if($value['status'] == 1){
                                                        echo '<span class="badge bg-secondary">Preparing</span>';
                                                    }

                                                    if($value['status'] == 2){
                                                        echo '<span class="badge bg-warning">Ready!</span>';
                                                    }

                                                    if($value['status'] == 3){
                                                        echo '<span class="badge me-1 my-1 bg-success">Completed</span>';
                                                    }
                                                ?>
                                            </td>

                                            <td class="py-2 surface-0 px-3 text-center border-bottom-1 border-300">
                                                <a href="./user-order-invoice.php?id=<?php echo $value['id']; ?>" class="btn btn-primary">Show Invoice</a>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        
                                        <?php
                                            if(empty($userrecord)){
                                                echo '
                                                <tr>
                                                    <td class="p-3" colspan="6">No Record Yet</td>
                                                </tr>';
                                            }
                                        ?>
                                    </table>
                                </div>

								</div>
                                <!--#END Chart Canvas -->

							</div>
						</div>
					</div>
                    <!--#END Sales Chart -->

                </div>
            </main>

            <?php include 'footer.php'; ?>
        </div>
    </div>
</body>
</html>