<?php echo theme_view('parts/header'); ?>
    <!-- Top line begins -->
    <div id="top">
        <div class="wrapper">
            <?php echo anchor(SITE_AREA.'/content',settings_item('site.title'),'class="logo"'); ?>
            <!-- Right top nav -->
            <div class="topNav">
                <ul class="userNav">
                    <li><a href="#" title="" class="notification"></a></li>
                    <li><a href="#" title="" class="settings"></a></li>
                    <li><a href="#" title="" class="logout"></a></li>
                    <li class="showTabletP"><a href="#" title="" class="sidebar"></a></li>
                </ul>
                <a title="" class="iButton"></a>
                <a title="" class="iTop"></a>

                <div class="topNotification">
                    <div class="topDropArrow"></div>
                    <div id="notification">
                        <div class="fluid headerNotification">
                            <div><?php echo lang('Recent Activities'); ?></div>
                        </div>
                        <div class="contentNotification">
                            <ul class="fluid"></ul>
                        </div>
                        <div class="fluid seeMore">
                            <div><?php echo anchor(SITE_AREA.'settings/activity',lang('See All')); ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Responsive nav -->
            <?php echo Contexts::render_menu('altMenu','exp'); ?>
            <div class="clear"></div>
        </div>
    </div>
    <!-- Top line ends -->


    <!-- Sidebar begins -->
    <div id="sidebar">
        <div class="mainNav">
            <div class="user">
                <a title="" class="leftUserDrop"><img src="<?php echo $userProfile->avatar; ?>" alt="<?php echo $userProfile->full_name; ?>" /></a><span><?php echo $userProfile->full_name; ?></span>
                <ul class="leftUser">
                    <li><?php echo anchor(SITE_AREA."/settings/users/edit",lang("My Profile"),"class='sProfile'"); ?></li>
                    <li><?php echo anchor("logout",lang("Logout"),"class='sLogout'"); ?></li>
                </ul>
            </div>

            <!-- Responsive nav -->
            <div class="altNav">
                <div class="userSearch">
                </div>

                <!-- User nav -->
                <ul class="userNav">
                    <li><?php echo anchor(SITE_AREA."/settings/users/edit","&nbsp;","class='profile'"); ?></li>
                    <li><?php echo anchor("logout","&nbsp;","class='logout'"); ?></li>
                </ul>
            </div>

            <!-- Main nav -->
            <?php echo Contexts::render_menu(); ?>
        </div>

        <!-- Secondary nav -->
        <?php Template::block('secNav',''); ?>
    </div>
    <!-- Sidebar ends -->


    <!-- Content begins -->
    <div id="content">
        <div class="contentTop">
            <span class="pageTitle"><span class="icon-screen"></span><?php echo isset($toolbar_title) ? $toolbar_title : ''; ?></span>
            <div class="clear"></div>
        </div>

        <!-- Breadcrumbs line -->
        <div class="breadLine">
            <div class="bc">
                <ul id="breadcrumbs" class="breadcrumbs">
                    <li><a href="<?php echo site_url(SITE_AREA); ?>  "><?php echo lang("Dashboard"); ?></a></li>
                    <li class="current"><a href="#" title=""><?php echo isset($toolbar_title) ? $toolbar_title : ''; ?></a></li>
                </ul>
            </div>

            <div class="breadLinks">
                <?php Template::block('sub_nav', ''); ?>
                <div class="clear"></div>
            </div>
        </div>

        <!-- Main content -->
        <div class="wrapper">
            <?php echo Template::message(); ?>
            <?php echo Template::content(); ?>
        </div>
        <!-- Main content ends -->
    </div>
    <!-- Content ends -->
    <div class="copyright"><?php echo lang('Developed by'); ?> <?php echo anchor(lang('author_url'),lang('author_name'),"target='_blank'"); ?></div>
<?php echo theme_view('parts/footer'); ?>