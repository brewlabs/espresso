<div id='footer-content' <?php espresso_footer_classes('default');?>>
<?php	if( current_theme_supports('espresso-show-support') ){ ?>
<small class="alignright">Powered by <a href="<?php echo esc_url( __( 'http://wordpress.org/', 'espresso' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'espresso' ); ?>" rel="generator"><?php printf( __( '%s', 'espresso' ), 'WordPress' ); ?></a> &amp <a href="<?php echo esc_url( __( 'http://themebrewers.com/', 'espresso' ) ); ?>" title="<?php esc_attr_e( 'HTML5 WordPress Theme Framework', 'espresso' ); ?>" rel="generator framework"><?php printf( __( '%s', 'espresso' ), 'Espresso' ); ?></a></small>
			<?php } ?>
<small >&copy;<?php echo date("Y"); echo " "; bloginfo('name'); ?></small>
</div>
