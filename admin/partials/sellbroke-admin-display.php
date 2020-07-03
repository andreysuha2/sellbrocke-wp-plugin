<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Sellbroke
 * @subpackage Sellbroke/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" class="sellbroke">
    <input type="hidden" name="action" value="sellbroke_authorize">
    <div>
        <label for="sellbroke-login">Login:</label>
        <input id="sellbroke-login"
               type="text"
               name="username"
               placeholder="Login">
    </div>
    <div>
        <label for="sellbroke-password">Password:</label>
        <input id="sellbroke-password"
               type="password"
               name="password"
               placeholder="password">
    </div>
    <div>
        <button>Authorize</button>
    </div>
</form>