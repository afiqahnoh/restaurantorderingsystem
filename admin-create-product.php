<?php
    include 'config.php';

    $collection = [];

    if(!isset($_SESSION['account_admin'])){
        header("Location: login.php");
        exit();
    }

    if(isset($_GET['id'])){
        $article = fetchRow("SELECT * FROM menu WHERE id =".$_GET['id']);
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
                            <h3><strong>Publish</strong> Pizza</h3>
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
                                            <input required type="text" name="menu_name" placeholder="Menu Name" class="form-control" value="<?php echo (!empty($article['name']) ? $article['name'] : ''); ?>" required />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Price</label>
                                            <input required type="number" name="menu_price" placeholder="Menu Price" class="form-control" value="<?php echo (!empty($article['price']) ? $article['price'] : ''); ?>" min="0" step="0.01" required  />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Category</label>
                                            <select required name="menu_category" placeholder="Menu Category" class="form-control" required >
                                                <option value="">Nothing Selected</option>
                                                <?php
                                                    $categories = fetchRows("SELECT * FROM category");

                                                    foreach($categories as $c){
                                                        echo '<option '.(!empty($article['category']) && $article['category'] == $c['id'] ? 'selected' : '').' value="'.$c['id'].'">'.$c['name'].'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="mb-3 image-container">
                                            <label class="form-label w-100">Picture</label>
                                            <input type="file" name="fileToUpload" placeholder="Choose Picture" accept=".jpg, .jpeg" required />
                                            <small class="form-text text-muted">Select picture of the product (JPG or JPEG)</small>
                                        </div>

                                       
                                        <div class="mb-3">
                                            <a href="admin-product.php">
                                                <button type="button" class="btn btn-secondary">Cancel</button>
                                            </a>
                                            <button type="submit" name="materialupload" class="btn btn-primary">Publish Pizza</button>
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
        if(isset($_POST['materialupload'])){
            $imagename = ($article['image'] ?? null);
            $menu_name = ($_POST['menu_name'] ?? '');
            $menu_stock = '99';
            $menu_price = ($_POST['menu_price'] ?? '');
            $menu_category = ($_POST['menu_category'] ?? '');

            if(isset($_FILES["fileToUpload"]) && !empty($_FILES["fileToUpload"]["size"])){
                $target_dir = "images/";
                $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);

                if(!$check) {
                    echo "File is not an image."; exit;
                }

                if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)){
                    // echo "The file ". htmlspecialchars( basename($_FILES["fileToUpload"]["name"])). " has been uploaded.";
                }else{
                    echo "Sorry, there was an error uploading your file.";
                }

                $imagename = $_FILES["fileToUpload"]["name"];
            }

            if(isset($_GET['id'])){
                runQuery("UPDATE `menu` SET `name` = '$menu_name', `image` = '$imagename', `category` = '$menu_category', `price` = '$menu_price', `in_stock` = '$menu_stock' WHERE `menu`.`id` = ".$_GET['id']);

                ToastMessage('Success', 'Product Saved', 'success', 'admin-product.php');
            }else{
                runQuery("INSERT INTO `menu` (`id`, `name`, `category`, `image`, `price`, `in_stock`, `is_active`) VALUES (NULL, '$menu_name', '$menu_category', '$imagename', '$menu_price', '$menu_stock', '1')");

                ToastMessage('Success', 'Product Added', 'success', 'admin-product.php');
            }
        }
    ?>
</body>
</html>