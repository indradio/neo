<div class="sidebar" data-color="azure" data-image="<?= base_url(); ?>/assets/img/sidebar-1.jpg">
    <!--
Tip 1: You can change the color of the sidebar using: data-color="purple | blue | green | orange | red"

Tip 2: you can also add an image using data-image tag
-->
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="<?= base_url('dashboard'); ?>" class="simple-text logo-mini">
                NEO
            </a>
            <a href="<?= base_url('dashboard'); ?>" class="advance-text logo-normal">
                Winteq Parts Center
            </a>
        </div>
        <div class="user">
            <div class="photo">
                <img src="<?= base_url(); ?>/assets/img/faces/face-0.jpg" />
            </div>
            <div class="info ">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span><?= session()->get('name'); ?>
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a class="profile-dropdown" href="#pablo">
                                <span class="sidebar-mini">MP</span>
                                <span class="sidebar-normal">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="profile-dropdown" href="#pablo">
                                <span class="sidebar-mini">EP</span>
                                <span class="sidebar-normal">Edit Profile</span>
                            </a>
                        </li>
                        <li>
                            <a class="profile-dropdown" href="#pablo">
                                <span class="sidebar-mini">S</span>
                                <span class="sidebar-normal">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <!-- QUERY ROLE MENU -->
            <?php
            $db = \Config\Database::connect();
            $roleId = session()->get('roleId');
            $query = "SELECT `user_menu`.`id`,`menu`,`icon`
                                FROM `user_menu` JOIN `user_access_menu`
                                ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                                WHERE `user_access_menu`.`role_id` = $roleId
                                AND `user_menu`.`is_active` = 1
                                ORDER BY `user_access_menu`.`menu_id` ASC ";
            $listmenu = $db->query($query)->getResult();
            foreach ($listmenu as $m) : ?>
            <li class="nav-item <?= ($menu==$m->menu) ? 'active' : '';?>">
                <?php if ($m->menu=='Dashboard') : ?>
                    <a class="nav-link" href="<?= base_url('dashboard'); ?>">
                <?php else : ?>
                    <a class="nav-link" data-toggle="collapse" href="#<?= $m->id; ?>">
                <?php endif; ?>
                    <i class="nc-icon <?= $m->icon; ?>"></i>
                    <p>
                        <?= $m->menu; ?>
                        <b class="<?= ($m->menu!='Dashboard') ? 'caret' : '';?>"></b>
                    </p>
                </a>
                <div class="collapse <?= ($menu==$m->menu) ? 'show' : '';?>" id="<?= $m->id; ?>">
                    <?php
                    $query = "SELECT * FROM `user_sub_menu`
                                WHERE `menu_id` = {$m->id}
                                AND `user_sub_menu`.`is_active` = 1 
                                ORDER BY `user_sub_menu`.`id` ASC
                                ";

                    $listsubmenu = $db->query($query)->getResult();
                    foreach ($listsubmenu as $sm) : ?>
                    <ul class="nav">
                        <li class="nav-item <?= ($submenu==$sm->title) ? 'active' : '';?>">
                            <a class="nav-link" href="<?= base_url($sm->url); ?>">
                                <span class="sidebar-mini"><?= substr($sm->title, 0, 1); ?></span>
                                <span class="sidebar-normal"><?= $sm->title; ?></span>
                            </a>
                        </li>
                    </ul>
                    <?php endforeach; ?>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
 