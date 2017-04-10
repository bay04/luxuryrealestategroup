<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>

<?php if ( have_posts() ) : ?>
    <table class="invoices-table">
        <thead>
            <tr>
                <th><?php echo __( 'Number', 'inventor-invoices' ); ?></th>
                <th><?php echo __( 'Type', 'inventor-invoices' ); ?></th>
                <th><?php echo __( 'Items', 'inventor-invoices' ); ?></th>
                <th><?php echo __( 'Total', 'inventor-invoices' ); ?></th>
                <th><?php echo __( 'Currency', 'inventor-invoices' ); ?></th>
                <th><?php echo __( 'Issue date', 'inventor-invoices' ); ?></th>
            </tr>
        </thead>

        <tbody>
        <?php while ( have_posts() ) : the_post(); ?>
            <tr>
                <td>
                    <strong><a href="<?php echo get_the_permalink( get_the_ID() ); ?>">#<?php the_title(); ?></a></strong>
                </td>
                <td>
                    <?php
                    $type = get_post_meta( get_the_ID(), INVENTOR_INVOICE_PREFIX . 'type', true );
                    $types = apply_filters( 'inventor_invoices_types', array() );
                    echo ( empty ( $types[$type] ) ) ? $type : $types[$type];
                    ?>
                </td>
                <td>
                    <?php foreach ( Inventor_Invoices_Logic::get_invoice_item_list( get_the_ID() ) as $item ): ?>
                        <?php echo esc_attr( $item ); ?>
                    <?php endforeach; ?>
                </td>
                <td>
                    <?php echo Inventor_Invoices_Logic::get_invoice_total( get_the_ID() ); ?>
                </td>
                <td>
                    <?php echo get_post_meta( get_the_ID(), INVENTOR_INVOICE_PREFIX . 'currency_code', true ); ?>
                </td>
                <td>
                    <?php echo get_the_date( 'Y-m-d' ); ?>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <?php the_posts_pagination( array(
        'prev_text'          => __( 'Previous page', 'inventor-invoices' ),
        'next_text'          => __( 'Next page', 'inventor-invoices' ),
        'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'inventor-invoices' ) . ' </span>',
    ) ); ?>
<?php else : ?>
    <div class="alert alert-warning"><?php echo __( 'No Invoices found.', 'inventor-invoices' ); ?></div>
<?php endif; ?>

<?php wp_reset_query(); ?>