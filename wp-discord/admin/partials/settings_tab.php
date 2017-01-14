<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
?>

<h2>Discord Channel Settings</h2>
    <ul>
    <?php
        //tab menu
        /*foreach ($post_types as $type) {
            $slug = $type->name;
            echo '<li><a href="#' . WPD_PREFIX . '' . $slug . '" role="tab" id="tab_wpd_' . $slug . '" aria-controls="' WPD_PREFIX . $slug . '">' . ucwords(str_replace(['-', '_'], ' ', $slug)) . '</a></li>';
        }*/
    ?>
    </ul>

    <?php
        //tabs
        foreach ($post_types as $type) {
            $slug = $type->name; ?>
                <div id="<?php echo WPD_PREFIX . $slug; ?>">
                    <h3><?php echo ucwords(str_replace(['-', '_'], ' ', $slug)); ?></h3>

                    <?php
                        $options = [
                                0 => 'None'
                        ];

            foreach ($channels as $channel) {
                $options[$channel->id] = $channel->name;
            }

            AdminFormFieldBuilder::select(WPD_PREFIX . 'post_channel_' . $type->name, $options); ?>
                </div>

            <?php

        }
    ?>