<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://kunal-saha
 * @since      1.0.0
 *
 * @package    Content_calender_plugin
 * @subpackage Content_calender_plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Content_calender_plugin
 * @subpackage Content_calender_plugin/admin
 * @author     Kunal Saha <kunal.saha@wisdmlabs.com>
 */
class Content_calender_plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		require_once(dirname(__FILE__). '/partials/content_calender_plugin-admin-display.php');
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Content_calender_plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Content_calender_plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/content_calender_plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Content_calender_plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Content_calender_plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/content_calender_plugin-admin.js', array( 'jquery' ), $this->version, false );

	}

	function register_event_page() {

		add_menu_page( 
			__('Customize Content Calender', 'content-calendar'),
			'CONTENT CALENDER',
			'manage_options',
			'content-calendar',
			array($this, 'content_calendar_callback'),
			'dashicons-calendar-alt',
			40
		 );
	
	
		add_submenu_page(
			'content-calendar',
			__('SCHEDULE EVENT', 'content-calendar'),
			__('SCHEDULE EVENT', 'content-calendar'),
			'manage_options',
			'schedule-event',
			array($this, 'wpac_settings_page_html')
		);
	
		add_submenu_page(
			'content-calendar',
			__('VIEW SCHEDULE', 'content-calendar'),
			__('VIEW SCHEDULE', 'content-calendar'),
			'manage_options',
			'view-schedule',
			array($this, 'print_schedule')
		);
	}

	function content_calendar_callback()
{
?>
	<h1 class="plugin-title"><?php esc_html_e(get_admin_page_title()); ?></h1>
<?php
	wpac_settings_page_html();
	print_schedule();
}



function form_submit() {
    global $wpdb;

    if( isset( $_POST['myDate'] ) && isset( $_POST['myOccasion'] ) && isset( $_POST['myTitle'] ) && isset( $_POST['A_name'] ) && isset( $_POST['reviewer'] ) ) {
        $table_name = $wpdb->prefix . "events";
        $date = sanitize_text_field( $_POST['myDate'] );
        $occassion = sanitize_text_field( $_POST['myOccasion'] );
        $post_title = sanitize_text_field( $_POST['myTitle'] );
        $author = sanitize_text_field( $_POST['A_name'] );
        $reviewer = sanitize_text_field( $_POST['reviewer'] );


        echo "form Submit";
        $wpdb->insert(
            $table_name,
            array(
                'date'       => $date,
                'occassion'  => $occassion,
                'post_title' => $post_title,
                'author'     => $author,
                'reviewer'   => $reviewer
            )
        );
    }
}




function submitBtn() {
    
    if( isset( $_POST['submit'] ) ) {
        $this->form_submit();
    }
}




}


