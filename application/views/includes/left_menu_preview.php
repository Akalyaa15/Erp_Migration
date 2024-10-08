<div id="sidebar" class="box-content ani-width">
    <div id="sidebar-scroll">
        <ul id="sidebar-menu">
            <?php
            if (!$is_preview) {
                $sidebar_menu = get_active_menu($sidebar_menu);
            }
            foreach ($sidebar_menu as $main_menu) {
                if (isset($main_menu["name"])) {
                    $submenu = get_array_value($main_menu, "submenu");
                    $expend_class = $submenu ? " expand " : "";
                    $active_class = isset($main_menu["is_active_menu"]) ? "active" : "";
                    $submenu_open_class = "";
                    if ($expend_class && $active_class) {
                        $submenu_open_class = " open ";
                    }
                    $devider_class = ($show_devider && get_array_value($main_menu, "devider")) ? "devider" : "";
                    $badge = get_array_value($main_menu, "badge");
                    $badge_class = get_array_value($main_menu, "badge_class");
                    $target = (isset($main_menu['is_custom_menu_item']) && isset($main_menu['open_in_new_tab']) && $main_menu['open_in_new_tab']) ? "target='_blank'" : "";
                    $url = isset($main_menu['url']) ? $main_menu['url'] : '#';
                    ?>
                    <li class="<?php echo $active_class . " " . $expend_class . " " . $submenu_open_class . " $devider_class"; ?> main">
                        <a <?php echo $target; ?> href="<?php echo isset($main_menu['is_custom_menu_item']) ? $main_menu['url'] : get_uri($url); ?>">
                            <i class="fa <?php echo isset($main_menu['class']) ? $main_menu['class'] : ''; ?>"></i>
                            <span><?php echo isset($main_menu['is_custom_menu_item']) ? $main_menu['name'] : lang($main_menu['name']); ?></span>
                            <?php
                            if ($badge) {
                                echo "<span class='badge $badge_class'>$badge</span>";
                            }
                            ?>
                        </a>
                        <?php
                        if ($submenu) {
                            echo "<ul>";
                            foreach ($submenu as $s_menu) {
                                if (isset($s_menu['name'])) {
                                    $sub_menu_target = (isset($s_menu['is_custom_menu_item']) && isset($s_menu['open_in_new_tab']) && $s_menu['open_in_new_tab']) ? "target='_blank'" : "";
                                    $sub_menu_url = isset($s_menu['url']) ? $s_menu['url'] : '#';
                                    ?>
                                <li>
                                    <a <?php echo $sub_menu_target; ?> href="<?php echo isset($s_menu['is_custom_menu_item']) ? $s_menu['url'] : get_uri($sub_menu_url); ?>">
                                        <i class="fa <?php echo isset($s_menu['class']) ? $s_menu['class'] : ''; ?>"></i>
                                        <span><?php echo isset($s_menu['is_custom_menu_item']) ? $s_menu['name'] : lang($s_menu['name']); ?></span>
                                    </a>
                                </li>
                                <?php
                                }
                            }
                            echo "</ul>";
                        }
                        ?>
                    </li>
                    <?php
                }       }
            ?>
        </ul>
    </div>
</div><!-- sidebar menu end -->
