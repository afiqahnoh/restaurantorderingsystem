<?php
    include 'config.php';

    $isEdit = (isset($_GET['id']));

    if(!isset($_SESSION['account_admin'])){
        header("Location: login.php");
        exit();
    }

    if($isEdit){
        $profile = fetchRow("SELECT * FROM login WHERE id =".$_GET['id']);
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
                            <h3> Staff</h3>
                        </div>
                    </div>
                    <!--#END HEADER -->

                    <!--#START Creation Form -->
                    <div class="row">
						<div class="col-xl-8 col-xxl-8">
							<div class="card flex-fill">

                                <!--#START Content -->
								<div class="card-body pt-4 pb-3">

                                    <form method="POST" enctype="multipart/form-data">

                                        <div class="mb-3">
                                            <label class="form-label">Name</label>
                                            <input required type="text" name="staff_name" placeholder="Please enter a valid name (only letters and spaces are allowed)" class="form-control" value="<?php echo (!empty($profile['name']) ? $profile['name'] : ''); ?>" pattern="^[A-Za-z\s]+$" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Email</label>
                                            <input required type="email" name="staff_email" placeholder="Please enter a valid email address (e.g., letter@letter.com)" class="form-control" value="<?php echo (!empty($profile['email']) ? $profile['email'] : ''); ?>" pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">MyKad / IC</label>
                                            <input required type="text" name="staff_mykad" placeholder="Please enter a valid MyKad / IC number in the format 123456-12-1234" class="form-control" value="<?php echo (!empty($profile['ic']) ? $profile['ic'] : ''); ?>" pattern="^\d{6}-\d{2}-\d{4}$" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Home Address</label>
                                            <textarea name="staff_address" class="form-control" placeholder="Home Address" rows="1"><?php echo (!empty($profile['address']) ? $profile['address'] : ''); ?></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Password</label>
                                            <input required type="password" name="staff_password" placeholder="Password must be at least 8 characters long and contain both letters and numbers." class="form-control" pattern="^(?=.*[a-zA-Z])(?=.*\d).{8,}$" title= />
                                        </div>
                                       
                                        <div class="mb-3">
                                            <a href="admin-users.php">
                                                <button type="button" class="btn btn-secondary">Cancel</button>
                                            </a>
                                            <button type="submit" name="create_account" class="btn btn-primary"><?php echo ($isEdit ? 'Save Change' : 'Add Staff'); ?></button>
                                        </div>
                                    </form>

								</div>
                                <!--#END Content -->

                                <!--#START Footer -->
								<div class="card-footer"></div>
                                <!--#END Footer -->

							</div>
						</div>
					</div>
                    <!--#END Creation Form -->

                </div>
            </main>

            <?php include 'footer.php'; ?>
        </div>
    </div>

    <?php
        if(isset($_POST['create_account'])){
            $name      = addslashes($_POST['staff_name']);
            $mykad     = addslashes($_POST['staff_mykad']);
            $address   = addslashes($_POST['staff_address']);
            $password  = addslashes($_POST['staff_password']);
            $staffcode = addslashes($_POST['staff_id']);
            $email     = addslashes($_POST['staff_email']);
    
            if($isEdit){
                runQuery("UPDATE `login` SET `name` = '$name', `email` = '$email', `password` = '$password', `ic` = '$mykad', `staff_id` = '$staffcode', `address` = '$address' WHERE `id` = ".$_GET['id']);

                ToastMessage('Success', 'Staff details updated!', 'success', 'admin-users.php');
            }else{
                runQuery("INSERT INTO `login` (`id`, `name`, `email`, `password`, `type`, `ic`, `address`, `staff_id`) VALUES (NULL, '$name', '$email', '$password', '2', '$mykad', '$address', '$staffcode')");

                ToastMessage('Success', 'Staff added!', 'success', 'admin-users.php');
            }
        }
    ?>
</body>
</html>