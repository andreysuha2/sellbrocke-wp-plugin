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
$SellbrokeApi = new Sellbroke_Api();
$hasToken = $SellbrokeApi->hasActiveToken();
if($hasToken) {
    $merchant = $SellbrokeApi->getAuthMerchant();
    $authMerchant = $merchant["success"] ? $merchant["merchant"] : null;
} else $authMerchant = null;
?>

<script>
    window.SELLBROKE_INIT = true;
    var test = <?php echo json_encode($authMerchant); ?>;
    console.log(test);
</script>

<div class="sellbroke">
    <form id="js-sellbroke-auth-form" class="sellbroke--auth sellbroke-auth">
        <h1 class="sellbroke-title">API Authorize</h1>
            <div
                id="js-sellbroke-auth-message"
                class="sellbroke-auth--auth-message sellbroke-auth--auth-message__auth <?php  if(!$authMerchant) echo  'hidden' ?>">
                <span>(Merchant is authorized)</span>
                <p>
                    Merchant id: <span id="js-sellbroke-auth-merchant-id"><?php echo $authMerchant ? $authMerchant["id"] : ""; ?></span>;
                </p>
                <p>
                    Merchant name: <span id="js-sellbroke-auth-merchant-name"><?php echo $authMerchant ? $authMerchant["name"] : ""; ?></span>;
                </p>
            </div>
            <div
                id="js-sellbroke-guest-message"
                class="sellbroke-auth--auth-message sellbroke-auth--auth-message__guest <?php  if($authMerchant) echo  'hidden' ?>">
                <span>(Merchant is not authorized!)</span>
            </div>
        <div class="sellbroke-auth--row">
            <div class="sellbroke-auth--cell sellbroke-auth--cell__label">
                <label for="js-sellbroke-auth-login">Login:</label>
            </div>
            <div class="sellbroke-auth--cell">
                <input id="js-sellbroke-auth-login"
                       type="text"
                       required
                       placeholder="Login">
            </div>
        </div>
        <div class="sellbroke-auth--row">
            <div class="sellbroke-auth--cell sellbroke-auth--cell__label">
                <label for="js-sellbroke-auth-password">Password:</label>
            </div>
            <div class="sellbroke-auth--cell">
                <input id="js-sellbroke-auth-password"
                       type="password"
                       required
                       placeholder="Password">
            </div>
        </div>
        <div class="sellbroke-auth--row">
            <div class="sellbroke-auth--cell justify-center">
                <button class="sellbroke-btn">Authorize</button>
            </div>
        </div>
    </form>
</div>