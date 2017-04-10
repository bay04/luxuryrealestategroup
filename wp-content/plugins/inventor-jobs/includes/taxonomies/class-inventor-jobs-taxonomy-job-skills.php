<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Inventor_Jobs_Taxonomy_Job_Skills
 *
 * @class Inventor_Jobs_Taxonomy_Job_Skills
 * @package Inventor_Jobs/Classes/Taxonomies
 * @author Pragmatic Mates
 */
class Inventor_Jobs_Taxonomy_Job_Skills {
    /**
     * Initialize taxonomy
     *
     * @access public
     * @return void
     */
    public static function init() {
        add_action( 'init', array( __CLASS__, 'definition' ) );
        add_action( 'parent_file', array( __CLASS__, 'menu' ) );
    }

    /**
     * Widget definition
     *
     * @access public
     * @return void
     */
    public static function definition() {
        $labels = array(
            'name'              => __( 'Job Skills', 'inventor-jobs' ),
            'singular_name'     => __( 'Job Skill', 'inventor-jobs' ),
            'search_items'      => __( 'Search Job Skill', 'inventor-jobs' ),
            'all_items'         => __( 'All Job Skills', 'inventor-jobs' ),
            'parent_item'       => __( 'Parent Job Skill', 'inventor-jobs' ),
            'parent_item_colon' => __( 'Parent Job Skill:', 'inventor-jobs' ),
            'edit_item'         => __( 'Edit Job Skill', 'inventor-jobs' ),
            'update_item'       => __( 'Update Job Skill', 'inventor-jobs' ),
            'add_new_item'      => __( 'Add New Job Skill', 'inventor-jobs' ),
            'new_item_name'     => __( 'New Job Skill', 'inventor-jobs' ),
            'menu_name'         => __( 'Job Skills', 'inventor-jobs' ),
            'not_found'         => __( 'No job skills found.', 'inventor-jobs' ),
        );

        register_taxonomy( 'job_skills', array( 'job' ), array(
            'labels'            => $labels,
            'hierarchical'      => true,
            'query_var'         => 'job-skill',
            'rewrite'           => array( 'slug' => _x( 'job-skill', 'URL slug', 'inventor-jobs' ), 'hierarchical' => true ),
            'public'            => true,
            'show_ui'           => true,
            'show_in_menu'      => 'lexicon',
            'show_in_nav_menus' => true,
            'show_in_rest'      => true,
            'meta_box_cb'       => false,
            'show_admin_column' => true,
        ) );
    }

    /**
     * Set active menu for taxonomy job skill
     *
     * @access public
     * @return string
     */
    public static function menu( $parent_file ) {
        global $current_screen;
        $taxonomy = $current_screen->taxonomy;

        if ( 'job_skills' == $taxonomy ) {
            return 'lexicon';
        }

        return $parent_file;
    }
}

Inventor_Jobs_Taxonomy_Job_Skills::init();
