<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="dropdown">
        <a href="./" class="brand-link">
            <?php if ($_SESSION['login_type'] == 1) : ?>
                <h3 class="text-center p-0 m-0"><b>ADMIN</b></h3>
            <?php else : ?>
                <h3 class="text-center p-0 m-0"><b>Employee</b></h3>
            <?php endif; ?>
        </a>
    </div>
    <div class="sidebar pb-4 mb-4">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item dropdown">
                    <a href="./" class="nav-link nav-home">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link nav-edit_project nav-view_project">
                        <i class="nav-icon fas fa-layer-group"></i>
                        <p>
                            Projects
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <?php if ($_SESSION['login_type'] != 3) : ?>
                            <li class="nav-item">
                                <a href="./index.php?page=new_project" class="nav-link nav-new_project tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if ($_SESSION['login_type'] == 1) : ?>
                            <li class="nav-item">
                                <a href="./index.php?page=project_list" class="nav-link nav-project_list tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </li>
                <?php if ($_SESSION['login_type'] == 1) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-edit_project nav-view_manager">
                            <i class="nav-icon fas fa-layer-group"></i>
                            <p>
                                Project manager
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <?php if ($_SESSION['login_type'] != 3) : ?>
                                <li class="nav-item">
                                    <a href="./index.php?page=monubhagat" class="nav-link nav-manager1 tree-item">
                                        <i class="fas fa-angle-right nav-icon"></i>
                                        <p>Monu Bhagat</p>
                                    </a>
                                </li>
                            <?php endif; ?>
                            <li class="nav-item">
                                <a href="./index.php?page=bhupendra" class="nav-link nav-manager2 tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Bhupendra</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <a href="./index.php?page=clients" class="nav-link nav-client">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Our Clients
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./index.php?page=task_list" class="nav-link nav-task_list">
                        <i class="fas fa-tasks nav-icon"></i>
                        <p>Task</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="./index.php?page=Calendar" class="nav-link nav-calendar">
                        <i class="fas fa-calendar nav-icon"></i>
                        <p>Calendar</p>
                    </a>
                </li>




                <li class="nav-item">
                    <a href="./index.php?page=clinet_base" class="nav-link nav-clinet_base">
                        <i class="fas fa-user nav-icon"></i>
                        <p>Clinet Content</p>
                    </a>
                </li>

 

                <?php if ($_SESSION['login_type'] == 1 || $_SESSION['login_type'] == 4) : ?>
                    <li class="nav-item">
                        <a href="./index.php?page=add_content" class="nav-link nav-add_content">
                            <i class="fas fa-th-list nav-icon"></i>
                            <p>Content calendar</p>
                        </a>
                    </li>
                <?php endif; ?>



                <?php if ($_SESSION['login_type'] != 3) : ?>
                    <li class="nav-item">
                        <a href="./index.php?page=reports" class="nav-link nav-reports">
                            <i class="fas fa-th-list nav-icon"></i>
                            <p>Report</p>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if ($_SESSION['login_type'] == 1) : ?>
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-edit_user">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Users
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="./index.php?page=new_user" class="nav-link nav-new_user tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="./index.php?page=user_list" class="nav-link nav-user_list tree-item">
                                    <i class="fas fa-angle-right nav-icon"></i>
                                    <p>List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</aside>