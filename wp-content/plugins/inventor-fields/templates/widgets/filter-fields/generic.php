<?php $field = Inventor_Fields_Logic::get_field( $field_id ); ?>

<?php $field_type = get_post_meta( $field->ID, INVENTOR_FIELDS_FIELD_PREFIX . 'type', true ); ?>
<?php $field_settings = Inventor_Fields_Logic::get_field_settings( $field ); ?>

<?php if ( class_exists( 'Inventor_Template_Loader' ) ) : ?>
    <?php if ( strpos( $field_type, 'taxonomy_multicheck' ) !== false ): ?>
        <?php include Inventor_Template_Loader::locate( 'widgets/filter-fields/taxonomy-multicheck', INVENTOR_FIELDS_DIR ); ?>
    <?php elseif ( strpos( $field_type, 'taxonomy' ) !== false ): ?>
        <?php include Inventor_Template_Loader::locate( 'widgets/filter-fields/taxonomy', INVENTOR_FIELDS_DIR ); ?>
    <?php endif; ?>

    <?php if ( strpos( $field_type, 'radio' ) === 0 || $field_type == 'select' ): ?>
        <?php include Inventor_Template_Loader::locate( 'widgets/filter-fields/select', INVENTOR_FIELDS_DIR ); ?>
    <?php endif; ?>

    <?php if ( strpos( $field_type, 'multicheck' ) === 0 ): ?>
        <?php include Inventor_Template_Loader::locate( 'widgets/filter-fields/multicheck', INVENTOR_FIELDS_DIR ); ?>
    <?php endif; ?>

    <?php if ( strpos( $field_type, 'checkbox' ) === 0 ): ?>
        <?php include Inventor_Template_Loader::locate( 'widgets/filter-fields/checkbox', INVENTOR_FIELDS_DIR ); ?>
    <?php endif; ?>

    <?php if ( strpos( $field_type, 'money' ) !== false ): ?>
        <?php include Inventor_Template_Loader::locate( 'widgets/filter-fields/money', INVENTOR_FIELDS_DIR ); ?>
    <?php endif; ?>

    <?php if ( in_array( $field_type, array( 'text', 'text_small', 'text_medium', 'text_email', 'text_url', 'textarea', 'textarea_small', 'textarea_code', 'wysiwyg' ) ) ): ?>
        <?php include Inventor_Template_Loader::locate( 'widgets/filter-fields/text', INVENTOR_FIELDS_DIR ); ?>
    <?php endif; ?>
<?php endif; ?>