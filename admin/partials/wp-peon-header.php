<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin/partials
 */
?>

        <div class="wrap">
            <h2>Welcome to WP Peon - <?php echo $this->menu_array[$_GET['page']][0]; ?></h2>

            <h2 class="nav-tab-wrapper">
                <?php foreach ($this->menu_array as $key => $value):  ?>           
                <a class="nav-tab<?php if ($_GET['page'] == $key) echo ' nav-tab-active'; ?>" href="<?php echo admin_url("admin.php?page=" . $key); ?>"><?php echo $value[0]; ?></a>
                <?php endforeach; ?>
            </h2>
        </div>