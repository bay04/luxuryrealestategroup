<div class="invoice">
    <?php
    $invoice_id = get_the_ID();
    $issue_date = get_the_date( 'Y-m-d' );
    $type = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'type', true );
    $currency_code = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'currency_code', true );
    $reference = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'reference', true );
    $payment_term = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'payment_term', true );
    $details = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'details', true );
    $supplier_name = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'supplier_name', true );
    $supplier_registration_number = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'supplier_registration_number', true );
    $supplier_vat_number = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'supplier_vat_number', true );
    $supplier_details = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'supplier_details', true );
    $customer_name = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'customer_name', true );
    $customer_registration_number = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'customer_registration_number', true );
    $customer_vat_number = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'customer_vat_number', true );
    $customer_details = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'customer_details', true );
    $items = get_post_meta( $invoice_id, INVENTOR_INVOICE_PREFIX . 'item', true );
    $total = Inventor_Invoices_Logic::get_invoice_total( $invoice_id );
    ?>

    <h1><?php echo Inventor_Invoices_Logic::get_type_display( $type ); ?> #<?php the_title(); ?></h1>

    <section id="general">
        <dl>
            <dt><?php echo __( 'Issue date', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo $issue_date; ?></dd>
            <dt><?php echo __( 'Payment term', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo _n( sprintf( '%d day', $payment_term ), sprintf( '%d days', $payment_term), $payment_term, 'inventor-invoices' ); ?></dd>
            <dt><?php echo __( 'Reference', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo $reference; ?></dd>
        </dl>
    </section>

    <?php if ( ! empty( $details ) ): ?>
        <section id="details">
            <dl>
                <dt><?php echo __( 'Details / Instructions', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo nl2br( apply_filters ( 'inventor_invoices_payment_details', $details ) ); ?></dd>
            </dl>
        </section>
    <?php endif; ?>

    <section id="supplier">
        <h2><?php echo __( 'Supplier', 'inventor-invoices' ) ?></h2>
        <dl>
            <dt><?php echo __( 'Name', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo $supplier_name; ?></dd>
            <dt><?php echo __( 'Reg. No.', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo $supplier_registration_number; ?></dd>
            <dt><?php echo __( 'VAT No.', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo $supplier_vat_number; ?></dd>
            <dt><?php echo __( 'Details', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo nl2br( apply_filters ( 'inventor_invoices_supplier_details', $supplier_details ) ); ?></dd>
        </dl>
    </section>

    <section id="customer">
        <h2><?php echo __( 'Customer', 'inventor-invoices' ) ?></h2>
        <dl>
            <dt><?php echo __( 'Name', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo $customer_name; ?></dd>
            <dt><?php echo __( 'Reg. No.', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo $customer_registration_number; ?></dd>
            <dt><?php echo __( 'VAT No.', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo $customer_vat_number; ?></dd>
            <dt><?php echo __( 'Details', 'inventor-invoices' ) . ':' ?></dt> <dd><?php echo nl2br( apply_filters ( 'inventor_invoices_customer_details', $customer_details ) ); ?></dd>
        </dl>
    </section>

    <section id="items">
        <?php if ( count( $items ) > 0 ) : ?>
            <table class="invoice-items-table">
                <thead>
                    <th><?php echo __( 'Item', 'inventor-invoices' ); ?></th>
                    <th><?php echo __( 'Quantity', 'inventor-invoices' ); ?></th>
                    <th><?php echo __( 'Unit price', 'inventor-invoices' ); ?></th>
                    <th><?php echo __( 'Tax rate', 'inventor-invoices' ); ?></th>
                    <th><?php echo __( 'Tax', 'inventor-invoices' ); ?></th>
                    <th><?php echo __( 'Subtotal', 'inventor-invoices' ); ?></th>
                    <th><?php echo __( 'Currency', 'inventor-invoices' ); ?></th>
                </thead>

                <tbody>
                <?php foreach( $items as $item ): ?>
                    <?php
                        $title = $item[ INVENTOR_INVOICE_PREFIX  . 'item_title' ];
                        $quantity = $item[ INVENTOR_INVOICE_PREFIX  . 'item_quantity' ];
                        $unit_price = $item[ INVENTOR_INVOICE_PREFIX  . 'item_unit_price' ];
                        $tax_rate = $item[ INVENTOR_INVOICE_PREFIX  . 'item_tax_rate' ];
                        $tax = Inventor_Invoices_Logic::get_invoice_item_tax( $item );
                        $subtotal = Inventor_Invoices_Logic::get_invoice_item_subtotal( $item );
                    ?>

                    <tr>
                        <td><?php echo $title; ?></td>
                        <td><?php echo $quantity; ?></td>
                        <td><?php echo $unit_price; ?></td>
                        <td><?php echo $tax_rate; ?>%</td>
                        <td><?php echo $tax; ?></td>
                        <td><?php echo $subtotal; ?></td>
                        <td><?php echo $currency_code; ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <div class="alert alert-warning"><?php echo __( 'No invoice items found.', 'inventor-invoices' ); ?></div>
        <?php endif; ?>
    </section>

    <section id="total">
        <label><?php echo __( 'Total', 'inventor-invoices' ) . ':' ?></label> <span><?php printf( '%s %s', $total, $currency_code); ?><span>
    </section>
</div>