<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Widget_Users
 *
 * @class Inventor_Widget_Users
 * @package Inventor/Classes/Widgets
 * @author Pragmatic Mates
 */
class Inventor_Widget_Users extends WP_Widget {
    /**
     * Initialize widget
     *
     * @access public
     */
    function __construct() {
        parent::__construct(
            'users',
            __( 'Users', 'inventor' ),
            array(
                'description' => __( 'Displays users.', 'inventor' ),
            )
        );
    }

    /**
     * Frontend
     *
     * @access public
     * @param array $args
     * @param array $instance
     * @return void
     */
    function widget( $args, $instance ) {
        $count = ! empty( $instance['count'] ) ? $instance['count'] : 3;
        $order = ! empty( $instance['order'] ) ? $instance['order'] : 'registered';
        $type = ! empty( $instance['type'] ) ? $instance['type'] : 'author';

        $users = Inventor_Post_Type_User::get_users( $type, $count, $order );

        include Inventor_Template_Loader::locate( 'widgets/users' );
    }

    /**
     * Update
     *
     * @access public
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    function update( $new_instance, $old_instance ) {
        return $new_instance;
    }

    /**
     * Backend
     *
     * @access public
     * @param array $instance
     * @return void
     */
    function form( $instance ) {
        include Inventor_Template_Loader::locate( 'widgets/users-admin' );
        include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
        include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
    }
}