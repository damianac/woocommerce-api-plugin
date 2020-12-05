<?php

/**
 * Plugin Name: WooCommerce - External API
 * Plugin URI: https://saucal.com
 * Description: A plugin that fetches external API and displays it inside of WP Widget
 * and in Woocommerce `My Account` tab
 * Author: Luka Damjanac
 * Author URI:  https://saucal.com
 * Version: 1.0
*/
if ( ! class_exists( 'WC_External_API' ) ) :
  class WC_External_API {
    /**
     * Construct the plugin.
     */
    public function __construct() {
      add_action( 'plugins_loaded', array( $this, 'init' ) );
    }
    /**
     * Initialize the plugin.
     */
    public function init() {
      // Checks whether WooCommerce is installed.
      if ( class_exists( 'WC_Integration' ) ) {
        // Include our integration class.
        include_once 'class-wc-integration-external-api.php';
        // Register the integration.
        add_filter('woocommerce_integrations', array( $this, 'add_integration' ));

        // Set the plugin slug
        define( 'MY_PLUGIN_SLUG', 'wc-settings' );

        // Setting action for plugin
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'WC_my_custom_plugin_action_links' );
      }
    }
    /**
     * Add a new integration to WooCommerce.
     */
    public function add_integration($integrations) {
      $integrations[] = 'WC_External_API_Integration';
      return $integrations;
    }

    public function fetch_api(
        $elements = [],
        $url = 'https://httpbin.org/post',
        $request_method = 'POST'
        )
    {
    
    }

  }

  $WC_external_API = new WC_External_API(__FILE__);

  function WC_my_custom_plugin_action_links( $links ) {

    $links[] = '<a href="'. menu_page_url( MY_PLUGIN_SLUG, false ) .'&tab=integration">Settings</a>';
    return $links;
  }

endif;

?>