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

  public function widget( $args, $instance ) {
    // This is where you run the code and display the output
    $response = json_decode(WC_External_API::fetch_api(['test' => 1, 'test12' => 12])['body']);
    echo __('WooCommerce External API');
    echo '<br>';
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