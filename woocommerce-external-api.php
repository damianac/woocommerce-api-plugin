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
     * Loads plugin on creation of this class object
     */
    public function __construct()
    {
      add_action( 'plugins_loaded', array( $this, 'init'));
    }

    /**
     * Initializes the plugin, if WooCommerce plugin is installed and enabled
     *
     * @return void
     */
    public function init()
    {
      // Checks whether WooCommerce is installed.
      if ( class_exists( 'WC_Integration' ) ) {

        // Include our integration class and widget
        include_once 'class-wc-integration-external-api.php';
        include_once 'woocommerce-external-api-widget.php';

        add_filter('woocommerce_integrations', array( $this, 'add_integration' ));
        add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), function($links) {
          $links[] = '<a href="'. menu_page_url( 'wc-settings', false ) .'&tab=integration">Settings</a>';
          return $links;
        } );
      }
    }

    /**
     * Adds a new integration to WooCommerce.
     *
     * @return array Returns array of string values
     */
    public function add_integration($integrations)
    {
      $integrations[] = 'WC_External_API_Integration';
      return $integrations;
    }

    /**
     * Fetches external API (defaults to httpbin) and returns its results.
     *
     * @param array $elements @see {WC_External_API_Integration}
     * @param string $url
     *
     * @return mixed
     */
    public static function fetch_api($elements = [], $url = 'https://httpbin.org/post')
    {
        $response = wp_remote_post($url, [
            'body' => $elements
        ]);

        // Sets cache in case API fetching didn't fail
        if(!is_wp_error($response)) {
            wp_cache_set('api_response', $response['body']);
        }

        return wp_cache_get('api_response');
    }

  }

  $WC_external_API = new WC_External_API(__FILE__);

endif;

?>