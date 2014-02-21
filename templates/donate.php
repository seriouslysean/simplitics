<?php if (!defined('ABSPATH')) exit; ?>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top" id="<?php echo self::SLUG ?>-donate">
    <input type="hidden" name="cmd" value="_donations">
    <input type="hidden" name="business" value="98V8HW5QKDK8W">
    <input type="hidden" name="lc" value="US">
    <input type="hidden" name="no_note" value="0">
    <input type="hidden" name="cn" value="Want to say hello?">
    <input type="hidden" name="no_shipping" value="1">
    <input type="hidden" name="rm" value="1">
    <input type="hidden" name="return" value="<?php echo get_admin_url('', 'options-general.php') ?>">
    <input type="hidden" name="currency_code" value="USD">
    <input type="hidden" name="bn" value="Splitleaf_Donate_<?php echo self::NAME ?>_US">
    <input type="hidden" name="item_name" value="Support <?php echo self::NAME ?>! (WordPress Plugin)">
    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1" class="pixel" />
</form>