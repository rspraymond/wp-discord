<h2>Connect to Discord</h2>

<h3>1. Copy and Paste Your Server ID</h3>
Your Server ID found in your discord server at Server Settings -> Widget.
<p>
    <?php AdminFormFieldBuilder::label(WPD_PREFIX . 'guild_id', 'Server ID:'); ?>&nbsp;
    <?php AdminFormFieldBuilder::text(WPD_PREFIX . 'guild_id', $guild_id, ['size' => 75, 'placeholder' => 'Enter Server ID']);  ?>
</p>

<h3>2. Register your Discord App. <a href="https://discordapp.com/developers/applications/me" target="_blank">Click Here</a></h3>

<ul>
    <li>Make sure you are logged into Discord</li>
    <li>Click "New App"</li>
    <li>Enter an app name and click "Create App"</li>
</ul>

<h3>3. Create Your Bot User</h3>
<ul>
    <li>Click "Create a Bot User" and confirm the creation of your bot user</li>
</ul>

<h3>4. Copy and Paste Client ID and Bot Token:</h3>
<p>
    <?php AdminFormFieldBuilder::label(WPD_PREFIX . 'client_id', 'Client ID:'); ?>&nbsp;&nbsp;
    <?php AdminFormFieldBuilder::text(WPD_PREFIX . 'client_id', $client_id, ['size' => 75, 'placeholder' => 'Enter Client ID']);  ?>
</p>

<p>
    <?php AdminFormFieldBuilder::label(WPD_PREFIX . 'auth_token', 'Bot Token:');  ?>
    <?php AdminFormFieldBuilder::text(WPD_PREFIX . 'auth_token', $auth_token, ['size' => 75, 'placeholder' => 'Enter Bot Token']);  ?>
</p>

<p class="description">Make sure to copy the Token for your bot. DO NOT COPY AND PASTE CLIENT SECRET</p>

<h3>5. Click Save Changes Below</h3>

<h3>6. Authorize your bot</h3>

<ul>
    <li>Once you have completed the steps above. Click below to Authorize your bot</li>
    <li>Select the server you want to authorize. Should match the server for the id you entered in Step 1.</li>
    <li>You should not have to change any settings.</li>
</ul>

<h4><a class="<?php echo WPD_PREFIX ; ?>disabled" href="<?php echo $auth_link; ?>" target="_blank">Click Here to Authorize Bot</a></h4>

<h3>All Done!</h3>
<ul>
    <li>Once you have completed the steps above you should now be able to click on settings configure your channels.</li>
</ul>