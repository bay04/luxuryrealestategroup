<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Superlist_Widget_Recent_Posts
 *
 * Extends default WordPress Recent Posts widgets with display option
 *
 * @class Superlist_Widget_Recent_Posts
 * @package Superlist/Widgets
 * @author Pragmatic Mates
 */
Class Superlist_Widget_Recent_Posts extends WP_Widget_Recent_Posts {

    /**
     * Outputs the content for the current Recent Posts widget instance.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $args     Display arguments including 'before_title', 'after_title',
     *                        'before_widget', and 'after_widget'.
     * @param array $instance Settings for the current Recent Posts widget instance.
     */
    function widget( $args, $instance ) {

        $number = ( ! empty( $instance['number'] ) ) ? absint( $instance['number'] ) : 5;
        if ( ! $number )
            $number = 5;
        $show_date = isset( $instance['show_date'] ) ? $instance['show_date'] : false;

        $r = new WP_Query( apply_filters( 'widget_posts_args', array(
            'posts_per_page'      => $number,
            'no_found_rows'       => true,
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true
        ) ) );

        if ( $r->have_posts() ) {

            $display = empty( $instance['display'] ) ? 'default' : $instance['display'];

            if ( $display == 'default' ) {
                parent::widget($args, $instance);
            } elseif ( $display == 'masonry' ) {
    //            if ( ! isset( $args['widget_id'] ) ) {
    //                $args['widget_id'] = $this->id;
    //            }

                echo wp_kses( $args['before_widget'], wp_kses_allowed_html( 'post' ) );
                ?>

                <div class="widget-inner
                    <?php if ( ! empty( $instance['classes'] ) ) : ?><?php echo esc_attr( $instance['classes'] ); ?><?php endif; ?>
                    <?php echo ( empty( $instance['padding_top'] ) ) ? '' : 'widget-pt' ; ?>
                    <?php echo ( empty( $instance['padding_bottom'] ) ) ? '' : 'widget-pb' ; ?>"
                    <?php if ( ! empty( $instance['background_color'] ) || ! empty( $instance['background_image'] ) ) : ?>
                        style="
                        <?php if ( ! empty( $instance['background_color'] ) ) : ?>
                            background-color: <?php echo esc_attr( $instance['background_color'] ); ?>;
                    <?php endif; ?>
                        <?php if ( ! empty( $instance['background_image'] ) ) : ?>
                            background-image: url('<?php echo esc_attr( $instance['background_image'] ); ?>');
                        <?php endif; ?>"
                    <?php endif; ?>>

                    <?php if ( ! empty( $instance['title'] ) ) : ?>
                        <?php echo wp_kses( $args['before_title'], wp_kses_allowed_html( 'post' ) ); ?>
                        <?php echo wp_kses( $instance['title'], wp_kses_allowed_html( 'post' ) ); ?>
                        <?php echo wp_kses( $args['after_title'], wp_kses_allowed_html( 'post' ) ); ?>
                    <?php endif; ?>

                    <?php if ( ! empty( $instance['description'] ) ) : ?>
                        <div class="description">
                            <?php echo wp_kses( $instance['description'], wp_kses_allowed_html( 'post' ) ); ?>
                        </div><!-- /.description -->
                    <?php endif; ?>

                    <div class="content clearfix">
                        <?php while ( $r->have_posts() ) : $r->the_post(); ?>
                            <div id="post-<?php the_ID(); ?>" <?php post_class( 'post post-masonry' ); ?>>
                            <?php include get_template_directory() . '/templates/content-post-masonry.php'; ?>
                            </div><!-- /.post -->
                        <?php endwhile; ?>
                    </div><!-- /.content -->

                    <?php
                        // Reset the global $the_post as this query will have stomped on it
                        wp_reset_postdata();
                    ?>
                </div><!-- /.widget-inner -->

                <?php
                echo wp_kses( $args['after_widget'], wp_kses_allowed_html( 'post' ) );
            }
        }
    }

    /**
     * Update
     *
     * @access public
     * @param array $new_instance New widget instance.
     * @param array $old_instance Old widget instance.
     * @return array
     */
    function update( $new_instance, $old_instance ) {
        $instance = parent::update( $new_instance, $old_instance );
        $new_instance['title'] = $instance['title'];
        $new_instance['number'] = $instance['number'];
        $new_instance['show_date'] = $instance['show_date'];
        $new_instance['description'] = sanitize_text_field( $new_instance['description'] );
        $new_instance['display'] = sanitize_text_field( $new_instance['display'] );
        return $new_instance;
    }

    /**
     * Outputs the settings form for the Recent Posts widget.
     *
     * @since 2.8.0
     * @access public
     *
     * @param array $instance Current settings.
     * @return void
     */
    public function form( $instance ) {
        $title          = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
        $description    = isset( $instance['description'] ) ? esc_attr( $instance['description'] ) : '';
        $number         = isset( $instance['number'] ) ? absint( $instance['number'] ) : 5;
        $show_date      = isset( $instance['show_date'] ) ? (bool) $instance['show_date'] : false;
        $display        = isset( $instance['display'] ) ? esc_attr( $instance['display'] ) : 'default';
        ?>
        <p><label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" /></p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>">
                <?php echo __( 'Description', 'inventor' ); ?>
            </label>

            <textarea class="widefat"
                      rows="4"
                      id="<?php echo esc_attr( $this->get_field_id( 'description' ) ); ?>"
                      name="<?php echo esc_attr( $this->get_field_name( 'description' ) ); ?>"><?php echo esc_attr( $description ); ?></textarea>
        </p>

        <p><label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to show:' ); ?></label>
            <input class="tiny-text" id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="number" step="1" min="1" value="<?php echo $number; ?>" size="3" /></p>

        <p><input class="checkbox" type="checkbox"<?php checked( $show_date ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" />
            <label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?' ); ?></label></p>

        <p>
            <label for="<?php echo esc_attr( $this->get_field_id( 'display' ) ); ?>">
                <?php echo __( 'Display as', 'superlist' ); ?>
            </label>

            <select id="<?php echo esc_attr( $this->get_field_id( 'display' ) ); ?>"
                    name="<?php echo esc_attr( $this->get_field_name( 'display' ) ); ?>">
                <option value="default" <?php echo ( 'default' == $display ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Default (title)', 'superlist' ); ?></option>
                <option value="masonry" <?php echo ( 'masonry' == $display ) ? 'selected="selected"' : ''; ?>><?php echo __( 'Masonry', 'inventor' ); ?></option>
            </select>
        </p>
        <?php

        if ( class_exists( 'Inventor_Template_Loader' ) ) {
            include Inventor_Template_Loader::locate( 'widgets/appearance-admin' );
            include Inventor_Template_Loader::locate( 'widgets/visibility-admin' );
        }
    }
}

function superlist_widget_recent_posts_registration() {
    unregister_widget('WP_Widget_Recent_Posts');
    register_widget('Superlist_Widget_Recent_Posts');
}
add_action('widgets_init', 'superlist_widget_recent_posts_registration');