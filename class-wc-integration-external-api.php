<?php
/**
 * Integrates `Woocommerce External API` with WooCommerce
 *
 * @package   Woocommerce External Api Integration
 * @category Integration
 * @author   Luka Damjanac luka@exnihilo.dev
 */
if ( ! class_exists( 'WC_External_API_Integration' ) ) :
  class WC_External_API_Integration extends WC_Integration {
    /**
     * Init and hook in the integration.
     */
    public function __construct() {
      global $woocommerce;
      $this->id                 = 'external-api-integration';
      $this->method_title       = __( 'External API Integration');
      $this->method_description = __( 'External API Integration plugin fetches data from external API and displays it');
      // Load the settings.
      $this->init_form_fields();
      $this->init_settings();
      // Define user set variables.
      $this->external_api_key = $this->get_option( 'external_api_key' );
      // Actions.
      add_action( 'woocommerce_update_options_integration_' .  $this->id, array( $this, 'process_admin_options' ) );
    }
    /**
     * Initialize integration settings form fields.
     */
    public function init_form_fields() {
      $this->form_fields = array(
          'external_api_key' => array(
              'title'             => __( 'External API Key'),
              'type'              => 'text',
              'description'       => __( 'Enter your API key'),
              'desc_tip'          => true,
              'default'           => '',
              'css'      => 'width: 270px;',
          ),
      );
    }
  }
endif;