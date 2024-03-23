<?php
    include 'config.php';

    if(!isset($_SESSION['account_session'])){
        header("Location: login.php");
        exit();
    }

    $profiledata = fetchRow("SELECT * FROM login WHERE id = ".$_SESSION['account_session']);
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

                    <!--#START CONTENT -->
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">
                            <!--#START Profile -->
                            <div class="row">
                                <div class="col-xl-12 col-xxl-12">
                                    <div class="card flex-fill w-100">

                                        <div class="card-header">
                                            <h1 class="h3">My Profile</h1>
                                        </div>

                                        <div class="card-body pt-2 pb-3">
                                            <form method="POST">

                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-sm-2 text-sm-end">MyKad / IC</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" placeholder="MyKad / IC" disabled value="<?php echo $profiledata['ic']; ?>">
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-sm-2 text-sm-end">Name</label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" placeholder="Name" disabled value="<?php echo $profiledata['name']; ?>">
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-sm-2 text-sm-end">Email</label>
                                                    <div class="col-sm-10">
                                                        <input type="email" class="form-control" placeholder="Email" disabled value="<?php echo $profiledata['email']; ?>">
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-sm-2 text-sm-end">Address</label>
                                                    <div class="col-sm-10">
                                                        <textarea class="form-control" placeholder="Address" rows="3" ><?php echo $profiledata['address']; ?></textarea>
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <label class="col-form-label col-sm-2 text-sm-end">Password</label>
                                                    <div class="col-sm-10">
                                                        <input type="password" class="form-control" placeholder="Password" name="staff_password" value="<?php echo $profiledata['password']; ?>">
                                                    </div>
                                                </div>

                                                <div class="mb-3 row">
                                                    <div class="col-sm-10 ms-sm-auto">
                                        
                                                        <button type="submit" name="update_account" class="btn btn-success">Confirm Update Profile</button>
                                                    </div>
                                                </div>

                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!--#END Profile -->
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <!--#END CONTENT -->

                </div>
            </main>

            <?php include 'footer.php'; ?>
        </div>
    </div>

    <?php
        if(isset($_POST['update_account'])){
            $password  = addslashes($_POST['staff_password']);
    
            runQuery("UPDATE `login` SET `password` = '$password' WHERE `id` = ".$_SESSION['account_session']);

            ToastMessage('Success', 'Staff details updated!', 'success', 'user-index.php');
        }
    ?>
</body>
</html>