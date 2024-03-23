<?php
    $sidebarLabel = '';
    $isCollapsed = 'collapsed';
    $sidebarMenu = [];
    $currentFile = constant("currentFile");
    $hasSession = (isset($_SESSION) && !empty($_SESSION));

    if($hasSession){
        $profileid    = (isset($_SESSION['account_admin']) ? $_SESSION['account_admin'] : $_SESSION['account_session']);
        $profiledata  = fetchRow("SELECT * FROM `login` WHERE id = '$profileid'");
        $accountType  = ($profiledata['type']);
        $accountData  = $profiledata;
        $isCollapsed  = '';
        $sidebarLabel = ($accountType == 1 ? 'Admin Dashboard' : 'User Dashboard');

        //# Admin
        if($accountType == 1){
            $sidebarMenu[] = (object) ['label' => 'Manage Pizza', 'icon' => 'box', 'path' => 'admin-product.php'];
            $sidebarMenu[] = (object) ['label' => 'Publish Pizza', 'icon' => 'plus-circle', 'path' => 'admin-create-product.php'];
            $sidebarMenu[] = (object) ['label' => 'Order', 'icon' => 'shopping-cart', 'path' => 'admin-order.php'];
            $sidebarMenu[] = (object) ['label' => 'Register Staff', 'icon' => 'user-plus', 'path' => 'admin-invite-user.php'];
            $sidebarMenu[] = (object) ['label' => 'Staff List', 'icon' => 'users', 'path' => 'admin-users.php'];
            $sidebarMenu[] = (object) ['label' => 'Category', 'icon' => 'grid', 'path' => 'admin-categories.php'];
            $sidebarMenu[] = (object) ['label' => 'Log Out', 'icon' => 'log-out', 'path' => 'logout.php'];
        }

        //# User
        if($accountType == 2){
            $sidebarMenu[] = (object) ['label' => 'My Profile', 'icon' => 'user', 'path' => 'user-index.php'];
            $sidebarMenu[] = (object) ['label' => 'My Cart', 'icon' => 'shopping-cart', 'path' => 'user-cart.php'];
            $sidebarMenu[] = (object) ['label' => 'Log Out', 'icon' => 'log-out', 'path' => 'logout.php'];
        }
    }
?>

<nav id="sidebar" class="sidebar js-sidebar <?php echo $isCollapsed; ?>">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" >
            <span class="align-middle"><?php echo $sidebarLabel; ?></span>
        </a>

        <ul class="sidebar-nav">
        <?php
            $hasActiveTab = false;

            foreach($sidebarMenu as $menu){
                $isActive = ($currentFile == $menu->path ? 'active' : '');

                if($currentFile == $menu->path){
                    $hasActiveTab = true;
                }

                echo '<li class="sidebar-item '.$isActive.'">
                    <a class="sidebar-link" href="'.$menu->path.'">
                        <i class="align-middle" data-feather="'.$menu->icon.'"></i>
                        <span class="align-middle">'.$menu->label.'</span>
                    </a>
                </li>';
            }
        ?>
        </ul>
    </div>
</nav>