<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
?>

<h2>Discord Message Templates</h2>
<div class="wpd-tabs">
    <ul>
    <?php
        $args = array(
            'public'   => true,
        );

        $post_types = get_post_types($args, 'objects');
        $banned_types = ['attachment', 'nav_menu_item', 'revision'];

        //cleanup
        foreach($post_types as $key => $type) {
            if (in_array($type->name, $banned_types)) {
                unset($post_types[$key]);
            }
        }

        //tab menu
        foreach($post_types as $type) {
            $slug = $type->name;
            echo '<li><a href="#wpd_' . $slug . '" role="tab" id="tab_wpd_' . $slug . '" aria-controls="wpd_' . $slug . '">' . ucwords(str_replace(['-', '_'], ' ', $slug)) . '</a></li>';
        }
    ?>
    </ul>

    <?php
        //tabs
        foreach($post_types as $type)
        {
            $slug = $type->name;
            ?>
                <div id="wpd_<?php echo $slug; ?>">
                    <?php echo ucwords(str_replace(['-', '_'], ' ', $slug)); ?>
                </div>

            <?php
        }
    ?>
</div>