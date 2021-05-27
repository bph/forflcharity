<?php
namespace wp4good\forflcharity;

define( 'FLCHARITY_REST_NAMESPACE', 'forflcharity/v1' );
define( 'FLCHARITY_NUMBER', 'forflcharity_number' );
define( 'FLCHARITY_TEXT', 'forflcharity_text' );

add_action( 'rest_api_init', __NAMESPACE__ . '\\custom_endpoints' );

/**
 * Create custom endpoints for FLCharity options
 */

function custom_endpoints(){

    register_rest_route(
        FLCHARITY_REST_NAMESPACE,
        'charity-number',
        [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => __NAMESPACE__ . '\\get_charity_number',
            'permission_callback' => '__return_true'
        ]
    );

    register_rest_route(
        FLCHARITY_REST_NAMESPACE,
        'charity-number',
        [
            'methods' => \WP_REST_Server::EDITABLE,
            'callback' => __NAMESPACE__ . '\\update_charity_number',
            'permission_callback' => __NAMESPACE__ . '\\check_permissions'
        ]
    );

    register_rest_route(
        FLCHARITY_REST_NAMESPACE,
        'charity-text',
        [
            'methods' => \WP_REST_Server::READABLE,
            'callback' => __NAMESPACE__ . '\\get_charity_text',
            'permission_callback' => '__return_true'
        ]
    );
}

function get_charity_number(){
/** - we read the options and send it as response with a 200 status
 * Test making a POST request to [SiteURL]/wp-json/flcharity/v1/charity-number/ 
 */
    $charity_number = get_option( FLCHARITY_NUMBER );

    $response = new \WP_REST_Response( $charity_number );
    $response ->set_status(200);

    return $response;
}

function update_charity_number( $request ) {
/**
 * we are getting data via REST route as a request and update the database
 */

    $new_charity_number = $request -> get_body(); 
    // we read the body of the request for the new data
    update_option( FLCHARITY_NUMBER, $new_charity_number );

    // just making sure our data comes from the database. 
    $charity_number = get_option( FLCHARITY_NUMBER );
    
    // our Response is the saved new data + status code 201 as - we saved data correctly. 
    $response = new \WP_REST_Response( $charity_number );
    $response -> set_status(201);

    return $response;
}

function check_permissions() {
    // we are doing this in the editor so we make sure the person as the right permissions 
    return current_user_can("edit_posts");

}

function get_charity_text(){
    /** - we read the options and send it as response with a 200 status
     * Test making a POST request to [SiteURL]/wp-json/forflcharity/v1/charity-number/
     */
        $charity_text = get_option( FLCHARITY_TEXT );
    
        $response = new \WP_REST_Response( $charity_text );
        $response ->set_status(200);
    
        return $response;
}