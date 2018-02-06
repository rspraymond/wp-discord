<h2><?php _e('Connect to Discord', 'wp-discord'); ?></h2>

<h3><?php _e('1. Copy and Paste Your Server ID', 'wp-discord'); ?></h3>
<?php _e('Your Server ID found in your discord server at Server Settings -> Widget.', 'wp-discord'); ?>
<p>
    <?php AdminFormFieldBuilder::label(WPD_PREFIX . 'guild_id', __('Server ID:', 'wp-discord')); ?>&nbsp;
    <?php AdminFormFieldBuilder::text(WPD_PREFIX . 'guild_id', $guild_id, array('size' => 75, 'placeholder' => __('Enter Server ID', 'wp-discord'))); ?>
</p>

<h3><?php _e('2. Register your Discord App.', 'wp-discord'); ?> <a href="https://discordapp.com/developers/applications/me" target="_blank"><?php _e('Click Here', 'wp-discord'); ?></a></h3>

<ul>
    <li><?php _e('Make sure you are logged into Discord', 'wp-discord'); ?></li>
    <li><?php _e('Click "New App"', 'wp-discord'); ?></li>
    <li><?php _e('Enter an app name and click "Create App"', 'wp-discord'); ?></li>
</ul>

<h3><?php _e('3. Create Your Bot User', 'wp-discord'); ?></h3>
<ul>
    <li><?php _e('Click "Create a Bot User" and confirm the creation of your bot user', 'wp-discord'); ?></li>
</ul>

<h3><?php _e('4. Copy and Paste Client ID and Bot Token:', 'wp-discord'); ?></h3>
<p>
    <?php AdminFormFieldBuilder::label(WPD_PREFIX . 'client_id', 'Client ID:'); ?>&nbsp;&nbsp;
    <?php AdminFormFieldBuilder::text(WPD_PREFIX . 'client_id', $client_id, array('size' => 75, 'placeholder' => __('Enter Client ID', 'wp-discord'))); ?>
</p>

<p>
    <?php AdminFormFieldBuilder::label(WPD_PREFIX . 'auth_token', 'Bot Token:'); ?>
    <?php AdminFormFieldBuilder::text(WPD_PREFIX . 'auth_token', $auth_token, array('size' => 75, 'placeholder' => __('Enter Bot Token', 'wp-discord'))); ?>
</p>

<p class="description"><?php _e('Make sure to copy the Token for your bot. DO NOT COPY AND PASTE CLIENT SECRET', 'wp-discord'); ?></p>

<h3><?php _e('5. Click Save Changes Below', 'wp-discord'); ?></h3>

<h3><?php _e('6. Authorize your bot', 'wp-discord'); ?></h3>

<ul>
    <li><?php _e('Once you have completed the steps above. Click below to Authorize your bot', 'wp-discord');?></li>
    <li><?php _e('Select the server you want to authorize. Should match the server for the id you entered in Step 1.', 'wp-discord'); ?></li>
    <li><?php _e('You should not have to change any settings.', 'wp-discord'); ?></li>
</ul>

<h4><?php echo '<a class="' . WPD_PREFIX . ' disabled" href="' . $auth_link . '" target="_blank">' . __('Click Here to Authorize Bot', 'wp-discord') . '</a>'; ?></h4>

<h3><?php _e('All Done!', 'wp-discord'); ?></h3>
<ul>
    <li><?php _e('Once you have completed the steps above you should now be able to click on settings configure your channels.', 'wp-discord'); ?></li>
</ul>