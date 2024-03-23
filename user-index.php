<?php
    include 'config.php';

    if(!isset($_SESSION['account_session'])){
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

        <div class="main">
            <?php include 'top-navbar.php'; ?>

            <main class="content">
                <div class="container-fluid p-0">

                    <!--#START HEADER -->
                    <div class="row mb-2 mb-xl-3">
                        <div class="col-auto d-none d-sm-block">
                            <h3>Welcome back, <?php echo (!empty($accountData) ? $accountData['name'] : '') ?></h3>
                        </div>
                    </div>
                    <!--#END HEADER -->

                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <!--#START CONTENT -->
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <div class="card py-2 py-md-3 border">
                                        <div class="card-body">
                                            <a href="./user-profile.php" class="d-flex align-items-center justify-content-center gap-2 flex-column">
                                                <h4 class="w-100 text-center fw-bold text-mute">My Profile</h4>
                                                <img src="./img/account-setting.png" class="w-100">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <div class="card py-2 py-md-3 border">
                                        <div class="card-body">
                                            <a href="./user-menu.php" class="d-flex align-items-center justify-content-center gap-2 flex-column">
                                                <h4 class="w-100 text-center fw-bold text-mute">Menu List</h4>
                                                <img src="./img/online-menu.png" class="w-100">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <div class="card py-2 py-md-3 border">
                                        <div class="card-body">
                                            <a href="./user-cart.php" class="d-flex align-items-center justify-content-center gap-2 flex-column">
                                                <h4 class="w-100 text-center fw-bold text-mute">Pizza Cart</h4>
                                                <img src="./img/pizza-cart.png" class="w-100">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <div class="card py-2 py-md-3 border">
                                        <div class="card-body">
                                            <a href="./user-order.php" class="d-flex align-items-center justify-content-center gap-2 flex-column">
                                                <h4 class="w-100 text-center fw-bold text-mute">Customer Order</h4>
                                                <img src="./img/pizza-order.png" class="w-100">
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-3 text-center">
                                    <div class="card py-2 py-md-3 border">
                                        <div class="card-body">
                                            <a href="./logout.php" class="d-flex align-items-center justify-content-center gap-2 flex-column">
                                                <h4 class="w-100 text-center fw-bold text-mute">Logout</h4>
                                                <img src="./img/log-out.png" class="w-100">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--#END CONTENT -->
                        </div>
                        <div class="col-md-1"></div>
                    </div>

                </div>
            </main>

            <?php include 'footer.php'; ?>
        </div>
    </div>
</body>
</html>