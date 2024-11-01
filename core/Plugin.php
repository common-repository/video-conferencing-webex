<?php

namespace Codemanas\Webex\Core;

/**
 * Class Plugin
 *
 * @package Codemanas\Webex\Core
 * @since 1.0.0
 * @author Codemanas (Deepen)
 */
class Plugin
{

    public $minified;

    /**
     * Plugin constructor.
     */
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'admin_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'frontend_scripts']);
        add_action('init', [$this, 'load_text_domain']);
        $this->minified = SCRIPT_DEBUG ? '' : '.min';
    }

    public function load_text_domain()
    {
        load_plugin_textdomain('video-conferencing-webex', false, trailingslashit(basename(dirname(__DIR__))) . 'lang/');
    }

    /**
     * Invoke datatable scripts from here from any other function
     *
     * This is for frontend usage.
     *
     * @since 1.0.0
     * @author Codemanas (Deepen)
     */
    public function invoke_dt_scripts()
    {
        wp_register_style('vcw-dt', VCW_DIR_DIST_VENDORS_URI . 'datatables.net-dt/css/jquery.dataTables' . $this->minified . '.css', false, VCW_VERSION);
        wp_register_script('vcw-dt', VCW_DIR_DIST_VENDORS_URI . 'datatables.net/js/jquery.dataTables' . $this->minified . '.js', [], VCW_VERSION, true);
    }

    /**
     * Invoke flatpickr scripts from here from any other function
     *
     * This is for frontend usage.
     *
     * @since 1.0.0
     * @author Codemanas (Deepen)
     */
    public function invoke_flatpickr_scripts()
    {
        wp_register_style('vcw-flatpickr', VCW_DIR_DIST_VENDORS_URI . 'flatpickr/dist/flatpickr' . $this->minified . '.css', false, VCW_VERSION);
        wp_register_script('vcw-flatpickr', VCW_DIR_DIST_VENDORS_URI . 'flatpickr/dist/flatpickr' . $this->minified . '.js', [], VCW_VERSION, true);
    }

    /**
     * Invoke flatpickr scripts from here from any other function
     *
     * This is for frontend usage.
     *
     * @since 1.0.0
     * @author Codemanas (Deepen)
     */
    public function invokeSelect2Scripts()
    {
        wp_register_style('vcw-select2', VCW_DIR_DIST_VENDORS_URI . 'select2/dist/css/select2' . $this->minified . '.css', false, VCW_VERSION);
        wp_register_script('vcw-select2', VCW_DIR_DIST_VENDORS_URI . 'select2/dist/js/select2' . $this->minified . '.js', [], VCW_VERSION, true);
    }

    /**
     * Enqueue Admin Scripts
     *
     * @param $hook
     *
     * @since 1.0.0
     * @author Codemanas (Deepen)
     */
    public function admin_scripts($hook)
    {
        $this->invoke_flatpickr_scripts();
        $this->invoke_dt_scripts();
        $this->invokeSelect2Scripts();

        //register admin scripts
        wp_register_script('vcw-events', VCW_DIR_DIST_URI . 'backend/events.js', [], VCW_VERSION, true);
        wp_register_script('vcw-settings', VCW_DIR_DIST_URI . 'backend/main.js', [], VCW_VERSION, true);
        wp_register_script('vcw-recordings', VCW_DIR_DIST_URI . 'backend/recordings.js', [], VCW_VERSION, true);
        wp_register_script('vcw-users', plugin_dir_url(__FILE__) . '/Users/ui/users.js', [], VCW_VERSION, true);



        //register styles
        wp_register_style('vcw-admin', VCW_DIR_DIST_URI . 'backend/app.css', false, VCW_VERSION);
        

        global $post_type;
        if ($post_type == "webex-events" || (isset($_GET['post_type']) && $_GET['post_type'] == "webex-events")) {
            wp_enqueue_script('vcw-flatpickr');
            wp_enqueue_style('vcw-flatpickr');
            wp_enqueue_script('vcw-select2');
            wp_enqueue_style('vcw-select2');
            wp_enqueue_script('vcw-events');
        }

        //Add Style to all post types
        if ($post_type == "webex-events" || (isset($_GET['post_type']) && $_GET['post_type'] == "webex-events") || (isset($_GET['page']) && $_GET['page'] == "webex-events-settings")) {
            wp_enqueue_style('vcw-admin');
            wp_enqueue_script('vcw-settings');
        }

        if ($hook == "webex-events_page_webex-events-users" || $hook == "webex-events_page_webex-events-recordings" || $hook == "webex-events_page_webex-events-importer") {
            wp_enqueue_style('vcw-dt');
            wp_enqueue_script('vcw-dt');
        }

        if ($hook == "webex-events_page_webex-events-users") {
            wp_enqueue_script('vcw-users');
        }

        if ($hook == "webex-events_page_webex-events-recordings") {
            wp_enqueue_script('vcw-flatpickr');
            wp_enqueue_style('vcw-flatpickr');
            wp_enqueue_script('vcw-recordings');
        }

        if ($hook == "webex-events_page_webex-events-importer") {
            wp_enqueue_script('vcw-flatpickr');
            wp_enqueue_style('vcw-flatpickr');
            wp_enqueue_script('vcw-importer', VCW_DIR_DIST_URI . 'backend/importer.js', [], VCW_VERSION, true);
            wp_localize_script('vcw-importer', 'vcw_importer', [
                'importInProgress' => __("Please wait while your Webex event is being imported: ", "video-conferencing-webex"),
            ]);
        }
    }

    /**
     * Frontend scripts
     *
     * @since 1.0.0
     * @author Codemanas (Deepen)
     */
    public function frontend_scripts()
    {
        $post_id = get_the_id();
        wp_enqueue_style('vcw', VCW_DIR_DIST_URI . 'frontend/app.css', false, VCW_VERSION);
        wp_register_script('vcw', VCW_DIR_DIST_URI . 'frontend/app.js', [], VCW_VERSION, true);

        wp_localize_script('vcw', 'vcw', [
            'ajaxurl' => admin_url('admin-ajax.php'),
            'eventInProgress' => __("Event has started and is in progress. You can join the event by clicking the button below.", "video-conferencing-webex"),
            'post_id' => !empty($post_id) ? $post_id : '',
        ]);
    }

    /**
     * Instance property
     *
     * @var null
     */
    private static ?Plugin $_instance = null;

    /**
     * Create only one instance so that it may not Repeat
     *
     * @since 1.0.0
     */
    public static function get_instance(): ?Plugin
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }
}
