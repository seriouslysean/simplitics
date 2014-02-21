<?php if (!defined('ABSPATH')) exit; ?>
<span class="share" data-form="<?php echo self::SLUG ?>-donate">
    <a href="#donate" title="PayPal - The safer, easier way to pay online!" class="button button-donate">donate</a></li>
    <a href="http://wordpress.org/support/view/plugin-reviews/<?php echo urlencode(self::NAME_LOWER) ?>" class="button button-rate" target="_blank">rate</a>
    <a href="http://www.facebook.com/sharer.php?u=<?php echo urlencode(self::DOWNLOAD_URL) ?>" class="button button-share" target="_blank">share</a>
    <a href="http://twitter.com/share?url=<?php echo urlencode(self::DOWNLOAD_URL) ?>&text=<?php echo urlencode(self::NAME.' is a simple WordPress plugin to add a tracking code to your site. Try it! #'.self::NAME_LOWER) ?>" class="button button-tweet" target="_blank">tweet</a>
</span>