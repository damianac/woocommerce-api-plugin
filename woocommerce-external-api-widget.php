<?php
// Creating the widget
class WC_External_API_Widget extends WP_Widget {

  function __construct() {
    parent::__construct(
        'wc_external_api_widget',
        __('WooCommerce External API Widget'),
        array( 'description' => __( 'Displays data from external API'))
    );
  }

  /**
   * Creates new widget and fetches external API results
   * @param $args
   * @param $instance
   */
  public function widget($args, $instance) {
    // This is where you run the code and display the output
    $elements = json_decode(get_user_option('external_api_elements'));

    echo __('WooCommerce External API');
    echo '<br>';

    if(!is_user_logged_in()) {
      echo 'Please log-in to use this widget.';
      return;
    }
    $response = json_decode(
        WC_External_API::fetch_api($elements)['body']
    );
    foreach($response->form as $input) {
      echo __($input . '<br>');
    }
  }

}

// Register and load the widget
function wpb_load_widget() {
  register_widget( 'WC_External_API_Widget' );
}
add_action( 'widgets_init', 'wpb_load_widget' );

?>