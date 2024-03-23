<?php
    include 'config.php';

    if (!isset($_GET['id'])) {
        echo 'Invalid invoice id'; exit();
    }

    $totalPrice = 0;
    $dataset = fetchRow("SELECT * FROM `user_order` WHERE id=".$_GET['id']);
    $profile = fetchRow("SELECT * FROM `login` WHERE id=".$dataset['user_id']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header.php'; ?>
</head>

<body>
    <div class="wrapper">

        <div class="main">

            <main class="content">
                <div class="container-fluid p-0">

                    <!--#START content -->
                    <div class="row">
                        <div class="col-xl-8 offset-xl-2">
                            <div class="card flex-fill">

                                <!--#START Body -->
                                <div class="card-body pt-6 pb-6">
                                    <div class="w-full d-flex align-items-center justify-content-center flex-column py-8 gap-3">
                                        <h3 class="capitalize text-green-600">We have received your order, Thank You!</h3>
                                        <h4 class="m-0 capitalize">Here is your invoice number</h4>
                                        
                                        <h1><?php echo $dataset['unique_number']; ?></h1>

                                        <div class="border d-flex gap-2 flex-column p-3 round">
                                            <h5 class="p-0 m-0 fw-bold">Menu List</h5>
                                            <?php
                                                $menuList = '<table class="table table-striped table-sm p-0 m-0">';
                                                $menuorder = array_unique(json_decode($dataset['menu_id']));
                                                $menuquantity = array_count_values(json_decode($dataset['menu_id']));
                                            
                                                $menuList .= "<tr>";
                                                $menuList .= "<th>#</th>";
                                                $menuList .= "<th>Menu</th>";
                                                $menuList .= "<th>Quantity</th>";
                                                $menuList .= "<th>Unit Price</th>";
                                                $menuList .= "</th>";

                                                foreach($menuorder as $key => $m){
                                                    $p = fetchRow("SELECT * FROM menu WHERE id=".$m);
                                                    $q = ($menuquantity[$p['id']]);
                                            
                                                    $totalPrice += ($totalPrice + $p['price']);
                                                    $menuList .= "<tr>";
                                                    $menuList .= "<td>".($key + 1).".</td>";
                                                    $menuList .= "<td class='text-left'>".$p['name']."</td>";
                                                    $menuList .= "<td class='text-center'>".$q."</td>";
                                                    $menuList .= "<td class='text-center'>RM ".$p['price']."</td>";
                                                    $menuList .= "</tr>";
                                                }

                                                $menuList .= "<tr>";
                                                $menuList .= "<th colspan='3'>Total Price</th>";
                                                $menuList .= "<th colspan='1' class='text-center'>RM ".$totalPrice."</th>";
                                                $menuList .= "</th>";
                                            
                                                $menuList .= '</table>';

                                                echo $menuList;
                                            ?>
                                        </div>

                                        <table class="w-30rem">
                                            <tbody>
                                                <tr class="py-3">
                                                    <td class="px-3 font-bold uppercase">Customer name</td>
                                                    <td class=""><?php echo $profile['name']; ?></td>
                                                </tr>

                                                <tr class="py-3">
                                                    <td class="px-3 font-bold uppercase">Customer phone number</td>
                                                    <td class=""><?php echo $dataset['payer_phone']; ?></td>
                                                </tr>

                                                <tr class="py-3">
                                                    <td class="px-3 font-bold uppercase">Order Date</td>
                                                    <td class=""><?php echo date_format(date_create($dataset['created_date']),"d F Y h:i A"); ?></td>
                                                </tr>
                                                
                                            </tbody>
                                        </table>

                                        <h4 class="w-20rem line-height-3 text-center">Please keep your invoice number, we will verify it later</h4>

                                        <div class="d-flex gap-3">
                                            <a href="javascript:void(0);" onclick="(history.back())">
                                                <button class="btn btn-secondary">Back</button>
                                            </a>

                                            <a href="javascript:void(0);" onclick="(window.print())">
                                                <button class="btn btn-primary">Print</button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!--#END Body -->

                            </div>
                        </div>
                    </div>
                    <!--#END content -->

                </div>
            </main>

        </div>

    </div>
</body>

</html>
