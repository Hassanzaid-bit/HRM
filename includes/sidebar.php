<?php 

$currentUrl = $_SERVER['REQUEST_URI'];


function isActive($currentUrl, $targetUrl)
{
    if (strpos($currentUrl, $targetUrl) !== false) {
        return 'active';
    } else {
        return '';
    }
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.html" class="brand-link">
        <img src="<?php echo $logo ?>" alt="Logo" class="brand-image "
            style="/* opacity: .8; */background: transaparent;">
        <span class="brand-text font-weight-light"><?php echo $siteName ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="#" class="d-block"><?php echo $userName ?></a>
                <p style="color:white;margin-bottom: 0;"> Role : <?php echo $rolename ?></p>
                <p style="color:white"> Department : <?php echo $_SESSION["departmentName"] ?></p>
            </div>
        </div>

        <?php if($role == 1 || $role == 2) {?>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="index.html" class="nav-link <?php echo isActive($currentUrl, 'index.html'); ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="leave-applications.html"
                        class="nav-link <?php echo isActive($currentUrl, 'leave-applications.html'); ?> ">
                        <i class="nav-icon fas fa-business-time"></i>
                        <p>
                            Leave applications
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>

                <li class="nav-item ">
                    <a href="tasks.html" class="nav-link  <?php echo isActive($currentUrl, 'tasks.html'); ?>">
                        <i class="nav-icon fas fas fa-tasks"></i>
                        <p>
                            Task Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                </li>
                <li class="nav-item d-none">
                    <a href="settings.html" class="nav-link <?php echo isActive($currentUrl, 'settings.html'); ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Account Settings
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->

        <?php } ?>


        <?php if($role == 3) { ?>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="index.html" class="nav-link <?php echo isActive($currentUrl, 'index.html'); ?>">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="staff.html" class="nav-link <?php echo isActive($currentUrl, 'staff.html'); ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Staff
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="roles.html" class="nav-link <?php echo isActive($currentUrl, 'roles.html'); ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Roles
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="departments.html"
                        class="nav-link <?php echo isActive($currentUrl, 'departments.html'); ?>">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            Departments
                        </p>
                    </a>
                </li>
                <li class="nav-item ">
                    <a href="#" class="nav-link <?php echo isActive($currentUrl, 'leave'); ?> ">
                        <i class="nav-icon fas fa-business-time"></i>
                        <p>
                            Leave Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="leave-types.html"
                                class="nav-link <?php echo isActive($currentUrl, 'leave-types.html'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Leave Types</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="leave-applications.html"
                                class="nav-link <?php echo isActive($currentUrl, 'leave-applications.html'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Leave applications</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item ">
                    <a href="#" class="nav-link <?php echo isActive($currentUrl, 'task'); ?> ">
                        <i class="nav-icon fas fas fa-tasks"></i>
                        <p>
                            Task Management
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="tasks.html" class="nav-link <?php echo isActive($currentUrl, 'tasks.html'); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tasks</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item d-none">
                    <a href="settings.html" class="nav-link <?php echo isActive($currentUrl, 'settings.html'); ?>">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            Account Settings
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->

        <?php } ?>
    </div>
    <!-- /.sidebar -->
</aside>