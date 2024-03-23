<?php
    $categories = fetchRows("SELECT * FROM category");

    $hasSession = (isset($_SESSION) && !empty($_SESSION));
    $accountData = [];
    $hiddenForAdmin = '';

    if($hasSession){
        $profileid = (isset($_SESSION['account_admin']) ? $_SESSION['account_admin'] : $_SESSION['account_session']);
        $profiledata = fetchRow("SELECT * FROM `login` WHERE id = '$profileid'");
        $accountData = $profiledata;

        if($profiledata['type'] == 1){
            $hiddenForAdmin = 'd-none';
        }
    }
?>
<nav class="navbar navbar-expand navbar-light navbar-bg">

    <a class="nav-icon pe-md-0 dropdown-toggle p-0 <?php echo $hiddenForAdmin; ?>" >
        <img src="<?php echo $logoicon; ?>" class="avatar img-fluid rounded" alt="logo">
    </a>
    
    <a class="sidebar-toggle js-sidebar-toggle m-0 ms-3 d-none">
        <i class="hamburger align-self-center"></i>
    </a>
    
    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">

            <li class="nav-item dropdown <?php echo ($hasSession ? '' : 'd-none'); ?>">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>

                <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                    <span class="text-dark"><?php echo (!empty($accountData) ? $accountData['name'] : '') ?></span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="./logout.php"><i class="align-middle me-1" data-feather="log-out"></i> Log Out</a>
                </div>
            </li>

        </ul>
    </div>
</nav>