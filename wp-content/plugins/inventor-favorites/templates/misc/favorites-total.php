<div class="inventor-favorites-total">
    <?php $favorite_users = Inventor_Favorites_Logic::get_post_total_users( get_the_ID() ); ?>
    <?php $icon = $favorite_users <= 0 ? 'fa-heart-o' : 'fa-heart'; ?>
    <i class="fa <?php echo $icon; ?>"></i>
    <?php echo sprintf( _n( '<strong>%d</strong> person loves it', '<strong>%d</strong> people love it', $favorite_users, 'inventor-favorites' ), $favorite_users ); ?>
</div>