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
                            <h3><strong>Staff</strong> List</h3>
                        </div>

                        <div class="col-auto ms-auto text-end mt-n1">
							<a href="admin-invite-user.php" class="btn btn-primary">Register Staff</a>
						</div>
                    </div>
                    <!--#END HEADER -->

                    <!--#START Chart -->
                    <div class="row">
						<div class="col-xl-12 col-xxl-12">
							<div class="card flex-fill w-100">

                                <!--#START Table -->
								<div class="card-body pt-4 pb-3">

                                    <table class="table table-bordered table-striped">
                                        <tr class="shadow-1 border-1">
                                            <th align="center">No.</th>
                                            <th align="left">MyKad / IC</th>
                                            <th align="left">Name</th>
                                            <th align="left">Email</th>
                                            <th align="left">Password</th>
                                            <th align="center">Action</th>
                                        </tr>

                                        <?php
                                            $userrecord = fetchRows("SELECT * FROM login WHERE type=2");

                                            foreach($userrecord as $key => $value){
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo ($key + 1); ?></td>
                                            <td align="left"><?php echo $value['ic']; ?></td>
                                            <td align="left"><?php echo $value['name']; ?></td>
                                            <td align="left"><?php echo $value['email']; ?></td>
                                            <td align="left"><?php echo $value['password']; ?></td>
                                            <td align="center">
                                                <div class="d-flex gap-1">
                                                    <a href="./admin-invite-user.php?id=<?php echo $value['id']; ?>">
                                                        <button class="btn btn-primary btn-sm" type="button">Edit</button>
                                                    </a>
                                                    <form method="POST">
                                                        <button class="btn btn-danger btn-sm" type="submit" name="action_delete" value="<?php echo $value['id']; ?>">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        
                                        <?php
                                            if(empty($userrecord)){
                                                echo '<tr><td class="p-3" colspan="6">No Record Yet</td></tr>';
                                            }
                                        ?>
                                    </table>

								</div>
                                <!--#END Table -->

							</div>
						</div>
					</div>
                    <!--#END Sales Chart -->

                </div>
            </main>

            <?php include 'footer.php'; ?>
        </div>
    </div>

    <?php 
    if(isset($_POST['action_delete'])){
        $userId = $_POST['action_delete'];

        // Check if the user has any associated orders
        $query = "SELECT COUNT(*) AS order_count FROM `user-order` WHERE `user_id` = $userId";
        $result = runQuery($query);
        $orderCount = $result[0]['order_count'];

        if($orderCount > 0){
            // User has orders, show an error message or take appropriate action
            ToastMessage('Error', 'Cannot delete user with associated orders!', 'error', 'admin-users.php');
        } else {
            // User has no orders, proceed with deletion
            $deleteQuery = "DELETE FROM `login` WHERE `login`.`id` = $userId";
            $deleteResult = runQuery($deleteQuery);

            if($deleteResult){
                ToastMessage('Success', 'User deleted!', 'success', 'admin-users.php');
            } else {
                // Handle the case where the delete operation failed
                ToastMessage('Error', 'User deletion failed!', 'error', 'admin-users.php');
            }
        }
    }
?>


</body>
</html>