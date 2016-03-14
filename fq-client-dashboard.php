<?php
/**
 * Plugin Name: FQ Client Dashboard
 * Plugin URI: http://figoliquinn.com
 * Description: A custom dashboard for FQ clients
 * Version: 1.0.0
 * Author: Figoli Quinn & Associate | Steven Quinn
 * Author URI: http://figoliquinn.com
 * License: GPL2
*/



if (!class_exists('BFIGitHubPluginUpdater'))
{
	require_once( 'BFIGitHubPluginUploader.php' );
}

if ( is_admin() ) {
    new BFIGitHubPluginUpdater( __FILE__, 'figoliquinn', "fq-client-dashboard" );
}


/**
 * Initilize the plugin and setup our settings page 
 */
function fq_client_dashboard_init() {
	
	// Make sure our helper class is enabled
	if( is_admin() && class_exists('FQ_Settings') ) {

		$settings = new FQ_Settings();
		$settings->parent_slug	= false;
		$settings->menu_slug	= 'client-dashboard-settings';
		$settings->menu_title	= 'Client Dashboard Settings';
		$settings->page_title	= 'Client Dashboard Settings';
		$settings->page_intro	= '';
		$settings->settings	= array(
			array(
				'label' => 'Disable Default Dashboards',
				'name' => 'disabled-dashboards',
				'type' => 'checkbox', // select, radio, checkbox, textarea, upload, OR text
				'class' => 'regular-text', // large-text, regular-text
				'value' => '', // default value
				'description' => '',
				'options' => array(
					'dashboard_activity' => 'Activity',
					'dashboard_recent_comments' => 'Recent Comments',
					'dashboard_incoming_links' => 'Incoming Links',
					'dashboard_plugins' => 'Plugins',
					'dashboard_primary' => 'Primary',
					'dashboard_secondary' => 'Secondary',
					'dashboard_quick_press' => 'Quickpress',
					'dashboard_recent_drafts' => 'Recent Drafts',
					'dashboard_right_now' => 'Right Now',
					'bbp-dashboard-right-now' => 'BBPress',
					'yoast_db_widget' => 'Yoast',
					'rg_forms_dashboard' => 'Gravity Forms'	
				)
			),
			array(
				'label' => 'Enable FQ Dashboards',
				'name' => 'fq-dashboards',
				'type' => 'checkbox',
				'class' => 'regular-text',
				'value' => '',
				'description' => '',
				'options' => array(
					'contact' => 'Contact',
					'news' => 'News'
				)	
			),
			array(
				'label' => 'Main Contact',
				'name' => 'fq-main-contact',
				'type' => 'select',
				'class' => 'regular-text',
				'value' => '',
				'description' => '',
				'options' => array(
					'tony' => 'Tony Figoli',
					'bob' => 'Bob Passaro',
					'steven' => 'Steven Quinn'
				)
			)
		);

	}

}
add_action( 'init', 'fq_client_dashboard_init' );


/**
 * Add in our custom styling
 */
add_action( 'admin_enqueue_scripts', 'fq_client_dashboard_enqueues' );
function fq_client_dashboard_enqueues( $hook ) {
	if( 'index.php' != $hook ) {
		return;
	}
	wp_enqueue_style( 'fq-client-dashboard-widget-styles', plugins_url( '', __FILE__ ) . '/css/style.css' );
}








// Disable the default dashboard widgets we don't want
function fq_client_dashboard_disable_default_dashboard_widgets() {
	global $wp_meta_boxes;
	$disabledDashboards = get_option('disabled-dashboards');
	
	foreach ($disabledDashboards as $dashboard)
	{
		unset($wp_meta_boxes['dashboard']['normal']['core'][$dashboard]);
		unset($wp_meta_boxes['dashboard']['side']['core'][$dashboard]);
	}
	
}
add_action('wp_dashboard_setup', 'fq_client_dashboard_disable_default_dashboard_widgets', 999);


// Include the dashboard widget class
require_once('DashboardWidget.php');

$fqDashboards = get_option('fq-dashboards');

if (!empty($fqDashboards))
{

	// Add our main branding widget
	if (in_array('contact', $fqDashboards))
	{
		$brandingWidget = new DashboardWidget('Figoli Quinn & Associates');
		
		// Get the default contact person
		$contact = get_option('fq-main-contact');
		
		// Render the output from the view file
		ob_start();
		include('templates/branding.php');
		$template = ob_get_contents();
		ob_end_clean();
		$brandingWidget->setStaticContent($template);
		$brandingWidget->create();
	}
	
	
	if (in_array('news', $fqDashboards))
	{
		// Add our news feed widget
		$brandingWidget = new DashboardWidget('Figoli Quinn & Associates News');
		// Render the output from the view file
		$brandingWidget->setRSSContent('https://www.figoliquinn.com/?feed=rss');
		$brandingWidget->create();
	}

}





