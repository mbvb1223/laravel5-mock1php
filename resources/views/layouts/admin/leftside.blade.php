<?php $class_name = isset($class_name) ? $class_name : '' ?>
<?php $action_name = isset($action_name) ? $action_name : '' ?>
<div class="page-sidebar-wrapper">
    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
    <div class="page-sidebar navbar-collapse collapse">
        <!-- BEGIN SIDEBAR MENU -->
        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
        <ul class="page-sidebar-menu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
            <li class="sidebar-toggler-wrapper">
                <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                <div class="sidebar-toggler">
                </div>
                <!-- END SIDEBAR TOGGLER BUTTON -->
            </li>
            <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
            <li class="sidebar-search-wrapper">
                <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
                <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
                <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
                <form class="sidebar-search " action="extra_search.html" method="POST">
                    <a href="javascript:;" class="remove">
                        <i class="icon-close"></i>
                    </a>

                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search...">
							<span class="input-group-btn">
							<a href="javascript:;" class="btn submit"><i class="icon-magnifier"></i></a>
							</span>
                    </div>
                </form>
                <!-- END RESPONSIVE QUICK SEARCH FORM -->
            <!--Product-->
            <li <?php if ($class_name == "ProductController") echo 'class="start active open"'; ?>>
                <a href="javascript:;">
                    <i class="icon-diamond"></i>
                    <span class="title">Product - Shoes</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('ProductController@index') }}">
                            List/Create Product</a>
                    </li>
                </ul>
            </li>
            <!--End Product-->

            <!--Product-->
            <li <?php if ($class_name == "StyleController" ||$class_name == "ColorController" || $class_name == "SizeController" || $class_name == "HeightController" || $class_name == "MadeinController" ||$class_name == "MaterialController") echo 'class="start active open"'; ?>>
                <a href="javascript:;">
                    <i class="icon-list"></i>
                    <span class="title">Attribute - Product</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('StyleController@index') }}">
                            List/Create Style</a>
                    </li>
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('MadeinController@index') }}">
                            List/Create Countries</a>
                    </li>
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('MaterialController@index') }}">
                            List/Create Material</a>
                    </li>
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('HeightController@index') }}">
                            List/Create Height</a>
                    </li>
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('SizeController@index') }}">
                            List/Create Size</a>
                    </li>
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('ColorController@index') }}">
                            List/Create Color</a>
                    </li>


                </ul>
            </li>
            <!--End Product-->


            <!--Invoice Import-->
            <li <?php if ($class_name == "InvoiceImportController") echo 'class="start active open"'; ?>>
                <a href="javascript:;">
                    <i class="icon-basket"></i>
                    <span class="title">Invoice Import</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('InvoiceImportController@index') }}">
                            List Invoice</a>
                    </li>
                    <li <?php if ($action_name == "create") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('InvoiceImportController@import') }}">
                            Create Invoice</a>
                    </li>

                </ul>
            </li>
            <!--End Invoice Import-->

            <!--Order-->
            <li <?php if ($class_name == "OrderController") echo 'class="start active open"'; ?>>
                <a href="javascript:;">
                    <i class="icon-basket"></i>
                    <span class="title">Order</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('OrderController@index') }}">
                            List Order</a>
                    </li>
                </ul>
            </li>
            <!--End Invoice Import-->

            <!--User-->
            <li <?php if ($class_name == "UsersController") echo 'class="start active open"'; ?>>
                <a href="javascript:;">
                    <i class="icon-user"></i>
                    <span class="title">Users</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('UsersController@index') }}">
                            List Users</a>
                    </li>
                    <li <?php if ($action_name == "create") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('UsersController@create') }}">
                            Create Users</a>
                    </li>

                </ul>
            </li>
            <!--End User-->
            <!--Roles-->
            <li <?php if ($class_name == "RolesController") echo 'class="start active open"'; ?>>
                <a href="javascript:;">
                    <i class="icon-fire"></i>
                    <span class="title">Roles</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('RolesController@index') }}">
                            List Roles</a>
                    </li>
                    <li <?php if ($action_name == "create") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('RolesController@create') }}">
                            Create Roles</a>
                    </li>

                </ul>
            </li>
            <!--End Roles-->
            <!--Permission-->
            <li <?php if ($class_name == "PermissionController") echo 'class="start active open"'; ?>>
                <a href="javascript:;">
                    <i class="icon-shield"></i>
                    <span class="title">Permission</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('PermissionController@index') }}">
                            List Roles</a>
                    </li>


                </ul>
            </li>
            <!--End Permission-->
            <!--Category-->
            <li <?php if ($class_name == "CategoryController") echo 'class="start active open"'; ?>>
                <a href="javascript:;">
                    <i class="icon-layers"></i>
                    <span class="title">Category</span>
                    <span class="arrow "></span>
                </a>
                <ul class="sub-menu">
                    <li <?php if ($action_name == "index") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('CategoryController@index') }}">
                            List Category</a>
                    </li>
                    <li <?php if ($action_name == "create") echo 'class="active"'; ?>>
                        <a href="{{ URL::action('CategoryController@create') }}">
                            Create Category</a>
                    </li>

                </ul>
            </li>
            <!--End Category-->



        </ul>
        <!-- END SIDEBAR MENU -->
    </div>
</div>