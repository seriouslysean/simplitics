<?php
/*
Plugin Name: Simplitics
Plugin URI: https://github.com/seriouslysean/simplitics
Description: Simplitics adds a textarea to the general settings page for you to add tracking snippets to your site.
Author: Sean Kennedy
Author URI: http://devjunkyard.com
Version: 1.0.2
License: MIT
*/
if (!defined('ABSPATH')) exit;
if (!class_exists('Simplitics')):
class Simplitics {

    /*************************************************
     * VARIABLES
     ************************************************/ 

    const NAME = 'Simplitics';
    const NAME_LOWER = 'simplitics';
    const VERSION = '1.0.2';
    const SLUG = 'simplitics';
    const DOWNLOAD_URL = 'http://wordpress.org/plugins/simplitics';
    const SETTINGS_CLASS = 'simplitics';

    static $instance;

    protected $_wpVersion;
    protected $_options;
    protected $_pluginPath;
    protected $_pluginUrl;



    /*************************************************
     * INITIALIZE / CONFIGURE
     ************************************************/ 

    static function load() {
        if (!self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct() {
        $this->_init();
    }

    protected function _init() {
        $this->_setWpVersion();
        $this->_setOptions();
        $this->_setPluginPath();
        $this->_setPluginUrl();
        //
        add_action('admin_init', array($this, 'settings'), 9000);
        add_action('admin_enqueue_scripts', array($this, 'styles'), 9000);
        add_action('admin_enqueue_scripts', array($this, 'scripts'), 9000);
        add_action('admin_footer', array($this, 'adminFooter'), 9000);
        //
        add_action('wp_head', array($this, 'wpHead'), 9000);
    }

    public static function activate() {
        self::defaults();
    }

    public static function deactivate() {
    }

    public static function uninstall() {
        delete_option(self::SLUG);
    }

    public static function defaults() {
        if (!get_option(self::SLUG)) {
            // Options
            update_option(
                self::SLUG,
                array(
                    'trackingcode' => '',
                    'version' => self::VERSION
                )
            );
        }
    }

    public function styles($hook) {
        if ($hook == 'options-general.php')
            wp_enqueue_style(self::SLUG.'-styles', $this->getPluginUrl().'css/styles.css', array(), self::VERSION);
    }

    public function scripts($hook) {
        if ($hook == 'options-general.php')
            wp_enqueue_script(self::SLUG.'-scripts', $this->getPluginUrl().'js/scripts.js', array(), self::VERSION);
    }

    public function wpHead() {
        if (!is_preview())
            require_once $this->getPluginPath.'templates/trackingcode.php';
    }

    public function adminFooter() {
        require_once $this->getPluginPath.'templates/donate.php';
    }




    /*************************************************
     * OPTIONS / SETTINGS
     ************************************************/

    public function settings() {
        register_setting(
            'general',
            self::SLUG,
            array($this, 'settings_validate')
        );
        add_settings_section(
            self::SLUG,
            self::NAME,
            '__return_false',
            'general'
        );
        add_settings_field(
            self::SLUG.'-trackingcode',
            __('Tracking Code', self::SLUG),
            array($this, 'settings_field_trackingcode'),
            'general',
            self::SLUG
        );
    }

    public function settings_validate($input) {
        if (is_array($input)) {
            foreach ($input as $field => $value) {
                switch ($field) {
                    case 'trackingcode':
                        $this->_options[$field] = $value;
                        break;
                }
            }
        }
        return $this->_options;
    }

    public function settings_field_trackingcode() 
    {
        ?>
        <div class="<?php echo self::SETTINGS_CLASS ?>">
            <textarea name="<?php echo self::SLUG ?>[trackingcode]" rows="10" cols="50" class="large-text code"><?php echo $this->getOption('trackingcode') ?></textarea>
            <p class="description">
                If a tracking snippet is entered, it will be added to the very end of the head of your site. Make sure to include the <code><?php echo htmlspecialchars('<script></script>') ?><script></script></code> tags! If you need help finding your Google analytics snippet, <a href="https://support.google.com/analytics/answer/1032385" title="Find your tracking code, tracking ID, and property number in your account - Analytics Help">here's a link to the help article</a>.
                <?php require_once $this->getPluginPath.'templates/share.php'; ?>
            </p>
        </div>
        <?php
    }



    /*************************************************
     * SETTERS
     ************************************************/

    private function _setWpVersion() {
        $this->_wpVersion = floatval(get_bloginfo('version'));
    }

    private function _setOptions() {
        $options = get_option(self::SLUG);
        if (!$options)
            $this->defaults();
        $this->_options = $options;
    }

    private function _setOption($key, $value) {
        $this->_options[$key] = $value;
        return update_option(self::SLUG, $this->_options);
    }

    private function _setPluginUrl() {
        $this->_pluginUrl = plugin_dir_url(__FILE__);
    }

    private function _setPluginPath() {
        $this->_pluginPath = plugin_dir_path(__FILE__);
    }


    
    /*************************************************
     * GETTERS
     ************************************************/ 

    public function getWpVersion() {
        return $this->_wpVersion;
    }

    public function getOptions() {
        return $this->_options;
    }

    public function getOption($key) {
        if (!isset($this->_options[$key]))
            return false;
        return $this->_options[$key];
    }

    public function getPluginUrl() {
        return $this->_pluginUrl;
    }

    public function getPluginPath() {
        return $this->_pluginPath;
    }

}
register_activation_hook( __FILE__, array('Simplitics', 'activate'));
register_deactivation_hook( __FILE__, array('Simplitics', 'deactivate'));
register_uninstall_hook(__FILE__, array('Simplitics', 'uninstall'));
add_action('plugins_loaded', array('Simplitics', 'load'), 9000);
endif;