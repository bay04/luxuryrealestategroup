<?php if ( ! empty( $currencies ) && is_array( $currencies ) ) : ?>
    <ul class="currency-switch">
        <?php foreach ( $currencies as $currency ) : ?>
            <?php if ( ! empty( $currency['code'] ) ) : ?>
                <li class="<?php if ( $currency_code == $currency['code'] ) : ?>active<?php endif; ?>">
                    <a href="?currency_code=<?php echo esc_attr( $currency['code'] ); ?>">
                        <span class="currency-symbol"><?php echo esc_attr( $currency['symbol'] ); ?></span>
                        <span class="currency-code"><?php echo esc_attr( $currency['code'] ); ?></span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>