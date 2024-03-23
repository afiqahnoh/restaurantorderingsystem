<?php
    include 'config.php';

    $isEdit = (isset($_GET['id']));

    if(!isset($_SESSION['account_admin'])){
        header("Location: login.php");
        exit();
    }

    if($isEdit){
        $profile = fetchRow("SELECT * FROM `category` WHERE id =".$_GET['id']);
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
                            <h3><strong>Add</strong> Category</h3>
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
                                            <label class="form-label">Category</label>
                                            <input required type="text" name="category_name" placeholder="Name" class="form-control" value="<?php echo (!empty($profile['name']) ? $profile['name'] : ''); ?>"/>
                                        </div>
                                       
                                        <div class="mb-3">
                                            <a href="admin-categories.php">
                                                <button type="button" class="btn btn-secondary">Cancel</button>
                                            </a>
                                            <button type="submit" name="create_account" class="btn btn-primary"><?php echo ($isEdit ? 'Save Change' : 'Add Category'); ?></button>
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
            $name = addslashes($_POST['category_name']);
    
            if($isEdit){
                runQuery("UPDATE `category` SET `name` = '$name' WHERE `id` = ".$_GET['id']);

                ToastMessage('Success', 'Category updated!', 'success', 'admin-categories.php');
            }else{
                runQuery("INSERT INTO `category` (`id`, `name`) VALUES (NULL, '$name')");

                ToastMessage('Success', 'Category added!', 'success', 'admin-categories.php');
            }
        }
    ?>
</body>
</html>