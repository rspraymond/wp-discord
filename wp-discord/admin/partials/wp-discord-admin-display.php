<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://wpdiscord.com
 * @since      0.1.0
 *
 * @package    WP_Discord
 * @subpackage WP_Discord/admin/partials
 */
?>

<div class="wrap">
    <div id="icon-themes" class="icon32"></div>
    <h1><?php echo $title; ?></h1>
    <?php settings_errors(); ?>

    <h2 class="nav-tab-wrapper">
        <?php

        foreach($tabs as $tab) {
            ?>
                <a href="?page=wp-discord&tab=<?php echo $tab->name; ?>" class="nav-tab <?php echo $active_tab == $tab->name ? 'nav-tab-active' : ''; ?>"><?php echo $tab->get_display_name() ?></a>
            <?php
        }

        ?>
    </h2>


    <form method="post" action="options.php">

        <?php

        if (isset($tabs[$active_tab])) {
            $tabs[$active_tab]->display();
        }

        ?>

        <?php submit_button(); ?>
    </form>

</div>