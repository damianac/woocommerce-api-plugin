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
    public function __construct()
    {
      $this->id                 = 'external-api-integration';
      $this->method_title       = __( 'External API Integration');
      $this->method_description = __( 'External API Integration plugin fetches data from external API and displays it');
      // Load the settings.
      $this->init_form_fields();
      $this->init_settings();

      $this->external_api_key = $this->get_option( 'external_api_key' );

      add_action( 'woocommerce_update_options_integration_' .  $this->id, array( $this, 'process_admin_options' ) );
      add_action( 'init', function() {
        add_rewrite_endpoint( 'external-api-settings', EP_ROOT | EP_PAGES );
      });
      add_filter(
        'query_vars',
        function($vars) {
          $vars[] = 'external-api-settings';
          return $vars;
        },
        0
      );
      add_filter( 'woocommerce_account_menu_items', array($this, 'my_custom_my_account_menu_items'));
      add_action( 'woocommerce_account_external-api-settings_endpoint', array($this, 'external_api_settings_content' ));
    }

    /**
     * Insert the new endpoint into the My Account menu.
     *
     * @param array $items List of items that are already in the menu
     * @return array List of items with new item added
     */
    public function my_custom_my_account_menu_items( $items )
    {
      // Remove the logout menu item.
      $logout = $items['customer-logout'];
      unset( $items['customer-logout'] );

      // Insert your custom endpoint.
      $items['external-api-settings'] = __( 'External API Settings');

      // Insert back the logout item.
      $items['customer-logout'] = $logout;

      return $items;
    }

    /**
     * Initialize integration settings form fields.
     *
     * @return void
     */
    public function init_form_fields()
    {
      $this->form_fields = array(
          'external_api_key' => array(
              'title'        => __( 'External API Key'),
              'type'         => 'text',
              'description'  => __( 'Enter your API key'),
              'desc_tip'     => true,
              'default'      => '',
              'css'          => 'width: 270px;',
          ),
      );
    }

    /**
     * Displays HTML content on external api settings section in `My Account`
     *
     * @return void
     */
    public function external_api_settings_content()
    {
      if(isset($_POST['submit'])) {
        update_user_option(
            get_current_user_id(),
            'external_api_elements',
            $_POST['external-api-elements']
        );
      } ?>
      <p>Enter elements to use to fetch API (JSON object):</p>
      <form action="" method="POST">
      <textarea name="external-api-elements" rows="4" cols="50">
        <?php echo get_user_option('external_api_elements', get_current_user_id()) ?: '[]';?>
      </textarea>
        <br>
        <br>
        <button type="submit" class="btn" name="submit">Submit</button>
      </form>
      <?php
    }
  }
endif;