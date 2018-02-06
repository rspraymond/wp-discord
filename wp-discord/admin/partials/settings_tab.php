<?php

// If this file is called directly, abort.
if (!defined('WPINC')) {
    die;
}
?>

<h2>Discord Channel Settings</h2>
    <p class="description"></p>
    <?php
        foreach ($post_types as $type) {
            $slug = $type->name; ?>
                <div id="<?php echo WPD_PREFIX . $slug; ?>">
                    <h3><?php echo ucwords(str_replace(array('-', '_'), ' ', $slug)); ?></h3>

            <?php
                    $options = array(
                        0 => 'none'
                    );

            if (empty($channels)) {
                echo '<p>' . __('Channels not found. Please verify that your connection to Discord was setup properly.', 'wp-discord') . '</p>';
                continue;
            }

            foreach ($channels as $channel) {
                $options[$channel->id] = '#' . $channel->name;
            }

            $option_name = WPD_PREFIX . 'channel_' . $type->name;

            AdminFormFieldBuilder::label($option_name, __('Select a channel for ', 'wp-discord') . $type->label);
            AdminFormFieldBuilder::select($option_name, $options, get_option($option_name, 0)); ?>
                </div>

            <?php
        }
    ?>