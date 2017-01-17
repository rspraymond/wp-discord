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
                    <h3><?php echo ucwords(str_replace(['-', '_'], ' ', $slug)); ?></h3>

            <?php
                    $options = [
                        0 => 'none'
                    ];

            if (empty($channels)) {
                echo '<p>Channels not found. Please verify that your connection to Discord was setup properly.</p>';
                continue;
            }

            foreach ($channels as $channel) {
                $options[$channel->id] = '#' . $channel->name;
            }

            $option_name = WPD_PREFIX . 'channel_' . $type->name;

            AdminFormFieldBuilder::label($option_name, 'Select a channel for ' . $type->label);
            AdminFormFieldBuilder::select($option_name, $options, get_option($option_name, 0)); ?>
                </div>

            <?php

        }
    ?>