<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Jobs_Post_Type_Resume
 *
 * @class Inventor_Jobs_Post_Type_Resume
 * @package Inventor_Jobs/Classes/Post_Types
 * @author Pragmatic Mates
 */
class Inventor_Jobs_Post_Type_Resume {
    /**
     * Initialize custom post type
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'cmb2_init', array( __CLASS__, 'fields' ) );

        add_filter( 'inventor_jobs_experience_levels', array( __CLASS__, 'default_experience_levels' ) );
        add_filter( 'inventor_listing_detail_sections', array( __CLASS__, 'resume_sections' ), 10, 2 );
        add_filter( 'inventor_listing_detail_section_root_dir', array( __CLASS__, 'section_root_dir' ), 10, 2 );
        add_filter( 'inventor_metabox_field_enabled', array( __CLASS__, 'disable_some_metabox_fields' ), 10, 4 );
    }

    /**
     * Custom post type definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'                  => __( 'Resumes', 'inventor-jobs' ),
            'singular_name'         => __( 'Resume', 'inventor-jobs' ),
            'add_new'               => __( 'Add New Resume', 'inventor-jobs' ),
            'add_new_item'          => __( 'Add New Resume', 'inventor-jobs' ),
            'edit_item'             => __( 'Edit Resume', 'inventor-jobs' ),
            'new_item'              => __( 'New Resume', 'inventor-jobs' ),
            'all_items'             => __( 'Resumes', 'inventor-jobs' ),
            'view_item'             => __( 'View Resume', 'inventor-jobs' ),
            'search_items'          => __( 'Search Resume', 'inventor-jobs' ),
            'not_found'             => __( 'No Resumes found', 'inventor-jobs' ),
            'not_found_in_trash'    => __( 'No Resumes Found in Trash', 'inventor-jobs' ),
            'parent_item_colon'     => '',
            'menu_name'             => __( 'Resumes', 'inventor-jobs' ),
            'icon'                  => apply_filters( 'inventor_listing_type_icon', 'inventor-poi-male', 'resume' )
        );

        register_post_type( 'resume',
            array(
                'labels'            => $labels,
                'show_in_menu'	    => 'listings',
                'supports'          => array( 'title', 'editor', 'thumbnail', 'comments', 'author' ),
                'has_archive'       => true,
                'rewrite'           => array( 'slug' => _x( 'resumes', 'URL slug', 'inventor-jobs' ) ),
                'public'            => true,
                'show_ui'           => true,
                'show_in_rest'      => true,
                'categories'        => array(),
            )
        );
    }

    /**
     * Defines custom fields
     *
     * @access public
     * @return array
     */
    public static function fields() {
        $post_type = 'resume';
        Inventor_Post_Types::add_metabox( $post_type, array( 'general' ) );

        // Working history
        $working_history_box = new_cmb2_box( array(
            'id'            => INVENTOR_LISTING_PREFIX . 'resume_working_history',
            'title'         => __( 'Working history', 'inventor-jobs' ),
            'object_types'  => array( 'resume' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $working_history = $working_history_box->add_field( array(
            'id'          => INVENTOR_LISTING_PREFIX . 'resume_working_history_group',
            'type'        => 'group',
            'options'     => array(
                'group_title'   => __( 'Item', 'inventor-jobs' ),
                'add_button'    => __( 'Add Another', 'inventor-jobs' ),
                'remove_button' => __( 'Remove', 'inventor-jobs' ),
            ),
            'default'     => apply_filters( 'inventor_metabox_field_default', null, INVENTOR_LISTING_PREFIX . 'resume_working_history', INVENTOR_LISTING_PREFIX  . 'resume_working_history_group', $post_type ),
        ) );

        $working_history_box->add_group_field( $working_history, array(
            'id'                => INVENTOR_LISTING_PREFIX . 'resume_working_history_title',
            'name'              => __( 'Title', 'inventor-jobs' ),
            'type'              => 'text',
            'attributes'        => array(
                'required'          => 'required'
            )
        ) );

        $working_history_box->add_group_field( $working_history, array(
            'id'                => INVENTOR_LISTING_PREFIX . 'resume_working_history_description',
            'name'              => __( 'Description', 'inventor-jobs' ),
            'type'              => 'textarea',
        ) );

        $working_history_box->add_group_field( $working_history, array(
            'id'                => INVENTOR_LISTING_PREFIX . 'resume_working_history_date_from',
            'name'              => __( 'Date from', 'inventor-jobs' ),
            'type'              => 'text_date_timestamp',
        ) );

        $working_history_box->add_group_field( $working_history, array(
            'id'                => INVENTOR_LISTING_PREFIX . 'resume_working_history_date_to',
            'name'              => __( 'Date to', 'inventor-jobs' ),
            'type'              => 'text_date_timestamp',
        ) );

        // Experience
        $experience_box = new_cmb2_box( array(
            'id'            => INVENTOR_LISTING_PREFIX . 'resume_experience',
            'title'         => __( 'Experience', 'inventor-jobs' ),
            'object_types'  => array( 'resume' ),
            'context'       => 'normal',
            'priority'      => 'high',
        ) );

        $experience = $experience_box->add_field( array(
            'id'          => INVENTOR_LISTING_PREFIX . 'resume_experience_group',
            'type'        => 'group',
            'options'     => array(
                'group_title'   => __( 'Item', 'inventor-jobs' ),
                'add_button'    => __( 'Add Another', 'inventor-jobs' ),
                'remove_button' => __( 'Remove', 'inventor-jobs' ),
            ),
            'default'     => apply_filters( 'inventor_metabox_field_default', null, INVENTOR_LISTING_PREFIX . 'resume_experience', INVENTOR_LISTING_PREFIX  . 'resume_experience_group', $post_type ),
        ) );

        $experience_box->add_group_field( $experience, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'resume_experience_title',
            'name'              => __( 'Title', 'inventor-jobs' ),
            'type'              => 'text',
            'attributes'        => array(
                'required'          => 'required'
            )
        ) );

        $experience_box->add_group_field( $experience, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'resume_experience_since',
            'name'              => __( 'Since', 'inventor-jobs' ),
            'type'              => 'text_date_timestamp',
        ) );

        $experience_box->add_group_field( $experience, array(
            'id'                => INVENTOR_LISTING_PREFIX  . 'resume_experience_level',
            'name'              => __( 'Level', 'inventor-jobs' ),
            'type'              => 'radio',
            'options'           => apply_filters( 'inventor_jobs_experience_levels', array() )
        ) );

        Inventor_Post_Types::add_metabox( 'resume', array( 'contact', 'location', 'social' ) );
    }

    /**
     * Sets defaul experience levels
     *
     * @access public
     * @param array $levels
     * @return array
     */
    public static function default_experience_levels( $levels ) {
        $levels['beginner'] = __( 'Beginner', 'inventor-jobs' );
        $levels['intermediate'] = __( 'Intermediate', 'inventor-jobs' );
        $levels['professional'] = __( 'Professional', 'inventor-jobs' );
        return $levels;
    }

    /**
     * Disable some location fields for resume post type
     *
     * @access public
     * @param bool $enabled
     * @param string $metabox_id
     * @param string $field_id
     * @param string $post_type
     * @return bool
     */
    public static function disable_some_metabox_fields( $enabled, $metabox_id, $field_id, $post_type ) {
        return $post_type == 'resume' && in_array( $field_id, array(
            'listing_street_view',
            'listing_inside_view',
            'listing_map_location_polygon',
            'listing_person') ) ? false : $enabled;
    }

    /**
     * Renders special sections
     *
     * @access public
     * @return void
     */
    public static function special_sections() {
        echo Inventor_Template_Loader::load( 'listings/detail/section-working-history', array(), INVENTOR_JOBS_DIR );
        echo Inventor_Template_Loader::load( 'listings/detail/section-experience', array(), INVENTOR_JOBS_DIR );
    }

    /**
     * Returns path for plugin templates
     *
     * @access public
     * @param string $path
     * @param string $section
     * @return string
     */
    public static function section_root_dir( $path, $section ) {
        return in_array( $section, array( 'resume_working_history', 'resume_experience' ) ) ? INVENTOR_JOBS_DIR : $path;
    }

    /**
     * Defines working history section
     *
     * @access public
     * @param array $sections
     * @param string $post_type
     * @return array
     */
    public static function resume_sections( $sections, $post_type ) {
        if ( $post_type == 'resume' ) {
            $experience_section = array( 'resume_experience' => esc_attr__( 'Experience', 'inventor-jobs' ) );
            $sections = array_merge( array_slice( $sections, 0, 3 ), $experience_section, array_slice( $sections, 3 ) );

            $working_history_section = array( 'resume_working_history' => esc_attr__( 'Working history', 'inventor-jobs' ) );
            $sections = array_merge( array_slice( $sections, 0, 3 ), $working_history_section, array_slice( $sections, 3 ) );
        }

        return $sections;
    }

    /**
     * Gets experience groups
     *
     * @access public
     * @param null $post_id
     * @return array
     */
    public static function get_experience_groups( $post_id = null ) {
        if ( empty( $post_id ) ) {
            $post_id = get_the_ID();
        }

        $experience_levels = apply_filters( 'inventor_jobs_experience_levels', array() );

        $groups = array();

        foreach( array_keys( $experience_levels ) as $level ) {
            $groups[ $level ] = array();
        }

        $experiences = get_post_meta( $post_id, INVENTOR_LISTING_PREFIX . 'resume_experience_group', true );

        if ( is_array( $experiences ) && count( $experiences ) > 0 ) {
            foreach ( $experiences as $experience ) {
                if ( ! empty( $experience[ INVENTOR_LISTING_PREFIX. 'resume_experience_level' ] ) ) {
                    $level = $experience[ INVENTOR_LISTING_PREFIX. 'resume_experience_level' ];
                    $title = empty( $experience[ INVENTOR_LISTING_PREFIX. 'resume_experience_title' ] ) ? null : $experience[ INVENTOR_LISTING_PREFIX. 'resume_experience_title' ];
                    $since = empty( $experience[ INVENTOR_LISTING_PREFIX. 'resume_experience_since' ] ) ? null : $experience[ INVENTOR_LISTING_PREFIX. 'resume_experience_since' ];

                    if ( ! empty( $since ) ) {
                        $current_year = date('Y');
                        $experience_year = date( 'Y', $since );
                        $years = (int) $current_year - (int) $experience_year;

                        if ( $years <= 0) $years = null;
                    } else {
                        $years = null;
                    }

                    $groups[ $level ][] = array(
                        'title' => $title,
                        'since' => $since,
                        'years' => $years
                    );
                }
            }
        }

        return $groups;
    }
}

Inventor_Jobs_Post_Type_Resume::init();