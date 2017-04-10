<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Google_Places_Commands_Google_Places
 *
 * @access public
 * @package Inventor_Google_Places/Classes/Commands
 */
class Inventor_Google_Places_Commands_Google_Places extends WP_CLI_Command {
    /**
     * Google Places radar search URL.
     */
    public $api_radarsearch_url = 'https://maps.googleapis.com/maps/api/place/radarsearch/json?';

    /**
     * Status codes.
     */
    public $status_codes = array(
        'OK'                => 'No errors occurred.',
        'ZERO_RESULTS'      => 'Search was successful but returned no results.',
        'OVER_QUERY_LIMIT'  => 'You are over quota.', 'inventor-google-places',
        'REQUEST_DENIED'    => 'Request was denied. Check if all required parameters are available and API key is correct.',
        'INVALID_REQUEST'   => 'Required query parameter is missing.',
    );

    /**
     * Field names in CSV
     */
    public $columns = array(
        'name', 'latitude', 'longitude', 'rating', 'price_level', 'icon', 'types', 'formatted_address', 'vicinity',
        'url', 'website', 'formatted_phone_number', 'international_phone_number', 'id', 'html_attributions'                         
    );

    /**
     * Fetches all places and save them into CSV file.
     * 
     * ## OPTIONS
     * 
     * <location>
     * : Location of the desired target.
     * 
     * <radius>
     * : Radius in meters.
     *
     * <api-key>
     * : Google Maps API key.
     *     
     * <output>
     * : Filename containing the results. The directory is wp-content/inventor-google-places
     *
     * ## EXAMPLES
     * 
     *     wp inventor-google-places radarsearch --location=40.738095,-73.991360 --radius=500 --api-key=YourApiKey --output=results.csv
     *
     * @synopsis --location=<latitude,longitude> --radius=<radius> --api-key=<api-key> --output=<output> --types=<array> [--max-pages=<number>]
     */
    public function radarsearch( $args, $assoc_args ) {
        if ( ! empty( $args ) ) {
            list( $name ) = $args;
        } 

        $this->parse( $args, $assoc_args );
    }

    /**
     * Fetch and parse the data from google
     *
     * @param array $args
     * @param array $assoc_args
     * @param int $index
     * @param array $content
     * @param null|string $next_page
     * @param int $sleep
     * @return void
     */
    private function parse( $args, $assoc_args, $index = 1, $content = array(), $next_page = null, $sleep = 3 ) {
        WP_CLI::line( 'Processing page ' . $index );

        // Some delay required by Google
        sleep( $sleep );

        $params = array(
            'location'  => $assoc_args['location'],
            'radius'    => $assoc_args['radius'],
            'key'       => $assoc_args['api-key'],
        );

        if ( ! empty( $assoc_args['types'] ) ) {
            $params['types'] = $assoc_args['types'];
        }

        // If this token is set all other params are ignored
        if ( ! empty( $next_page ) ) {
            $params['pagetoken'] = $next_page;
        }        
        $query = http_build_query( $params );
        $url = $this->api_radarsearch_url . $query;            
        $response = wp_remote_get( $url );        
        $json = json_decode( $response['body'] );

        if ( 'OK' != $json->status ) {                        
            WP_CLI::error( $this->status_codes[ $json->status ] );
            exit();
        }
        
        foreach ( $json->results as $result ) {
            $detail = wp_remote_get( 'https://maps.googleapis.com/maps/api/place/details/json?reference=' . $result->reference . '&key=' . $assoc_args['api-key'] );
            $detail = json_decode( $detail['body'] );

            $content[] = array(                
                'name'                          => ! empty( $detail->result->name ) ? $detail->result->name : null,
                'latitude'                      => ! empty( $detail->result->geometry ) ? $detail->result->geometry->location->lat : null,
                'longitude'                     => ! empty( $detail->result->geometry ) ? $detail->result->geometry->location->lng : null,
                'rating'                        => ! empty( $detail->result->rating ) ? $detail->result->rating : null,
                'price_level'                   => ! empty( $detail->result->price_level ) ? $detail->result->price_level : null,
                'icon'                          => ! empty( $detail->result->icon ) ? $detail->result->icon : null,
                'types'                         => ! empty( $detail->result->types ) ? implode( $detail->result->types, ',' ) : null,
                'formatted_address'             => ! empty( $detail->result->formatted_address ) ? $detail->result->formatted_address : null,
                'vicinity'                      => ! empty( $detail->result->vicinity ) ? $detail->result->vicinity : null,
                'url'                           => ! empty( $detail->result->url ) ? $detail->result->url : null,
                'website'                       => ! empty( $detail->result->website ) ? $detail->result->website : null,
                'formatted_phone_number'        => ! empty( $detail->result->formatted_phone_number ) ? $detail->result->formatted_phone_number : null,                
                'international_phone_number'    => ! empty( $detail->result->international_phone_number ) ? $detail->result->international_phone_number : null,
                'id'                            => $detail->result->id,
                'attribution'                   => ! empty( $detail->result->html_attributions ) ? implode( ',', $detail->result->html_attributions ) : null
            );                   
        }

        $next_page = ! empty( $json->next_page_token ) ? $json->next_page_token : null;
        
        if ( ! empty( $assoc_args['max-pages' ] ) ) {
            if ( $index >= $assoc_args['max-pages'] ) {
                $next_page = null;
            }
        }

        if ( ! empty( $next_page ) ) {
            $this->parse( $args, $assoc_args, ++$index, $content, $next_page );
        } else {            
            // Create directory if it does not exist
            if ( ! is_dir( get_home_path() . 'wp-content/inventor/' ) ) {
                mkdir( get_home_path() . 'wp-content/inventor/', 0755 );
            }

            $output = fopen( get_home_path() . 'wp-content/inventor/' . $assoc_args['output'], 'w+');
            // First line are column names
            fputcsv( $output, $this->columns, ';' );

            foreach ( $content as $line ) {
                fputcsv( $output, $line, ';' );
            }            

            fclose( $output );
            WP_CLI::success( 'Add data has been saved. Check your exports file.' );
        }
    }
}

WP_CLI::add_command( 'inventor-google-places', 'Inventor_Google_Places_Commands_Google_Places' );
