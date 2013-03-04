<?php

if( !empty( $_POST["update"] ) ) {
	$this->update_userrole();
} elseif( !empty( $_POST["reset"] ) ) {
	$this->update_reset( 'user_role' );
}

$Data = $this->get_data( 'user_role' );
$UserRoles = $this->get_user_role();

// include js css
$ReadedJs = array( 'jquery' , 'jquery-ui-sortable' );
wp_enqueue_script( $this->PageSlug ,  $this->Dir . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '.js', $ReadedJs , $this->Ver );
wp_enqueue_style( $this->PageSlug , $this->Dir . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '.css', array() , $this->Ver );

?>
<div class="wrap">
	<div class="icon32" id="icon-tools"></div>
	<?php echo $this->Msg; ?>
	<h2><?php echo $this->Name; ?></h2>
	<p><?php _e( 'Customize the UI of the management screen for all users.' , $this->ltd ); ?>
	<p><?php _e ('Please select the user role you want to apply the settings.' , $this->ltd ); ?></p>

	<form id="waum_setting_site" class="waum_form" method="post" action="">
		<input type="hidden" name="<?php echo $this->UPFN; ?>" value="Y" />
		<?php wp_nonce_field(); ?>

		<div class="metabox-holder columns-2">

			<div id="postbox-container-1" class="postbox-container">
				<div class="postbox">
					<h3 class="hndle"><span><?php _e( 'Role' ); ?></span></h3>
					<div class="inside">
						<?php $field = 'user_role'; ?>
						<?php foreach($UserRoles as $key => $val) : ?>
							<?php $Checked = ''; ?>
							<?php if( !empty( $Data[$key] ) ) : $Checked = 'checked="checked"'; endif; ?>
							<p>
								<label>
									<input type="checkbox" name="data[<?php echo $field; ?>][<?php echo $key; ?>]" value="1" <?php echo $Checked; ?> />
									<?php echo $val; ?>
								</label>
							</p>
						<?php endforeach; ?>
					</div>
				</div>
			</div>

			<div id="postbox-container-2" class="postbox-container">
				<div class="postbox">
					<h3 class="hndle"><span><?php _e( 'Plugin About' , $this->ltd ); ?></span></h3>
					<div class="inside">
						<?php $moFile = WP_PLUGIN_DIR . '/' . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/' . $this->ltd . '-' . get_locale() . '.mo'; ?>
						<?php if( !file_exists($moFile ) ) : ?>
							<p><strong>Please translate to your language.</strong><br />Looking for someone who will translate.</p>
							<p><a href="http://gqevu6bsiz.chicappa.jp/please-translation/" target="_blank">To translate</a></p>
						<?php endif; ?>
						<p><strong><?php _e( 'Please donation.' , $this->ltd ); ?></strong></p>
						<p><?php _e( 'When you are satisfied with my plugin,<br />I\'m want a gift card.<br />Thanks!' , $this->ltd ); ?></p>
						<p><img src="http://gqevu6bsiz.chicappa.jp/wp-content/uploads/2013/01/email.gif"  /></p>
						<p><a href="<?php _e( 'http://www.amazon.com/gp/gc' , $this->ltd ); ?>" target="_blank">Amazon Gift Card</a></p>
						<p><strong><?php _e( 'Other' , $this->ltd ); ?></strong></p>
						<p>
							<span><a href="http://gqevu6bsiz.chicappa.jp/" target="_blank">blog</a></span> &nbsp; 
							<span><a href="https://twitter.com/gqevu6bsiz" target="_blank">twitter</a></span> &nbsp; 
							<span><a href="http://www.facebook.com/pages/Gqevu6bsiz/499584376749601" target="_blank">facebook</a></span> &nbsp; 
							<span><a href="http://wordpress.org/support/plugin/wp-admin-ui-customize" target="_blank">support forum</a></span> &nbsp; 
							<span><a href="http://wordpress.org/support/view/plugin-reviews/wp-admin-ui-customize" target="_blank">review</a></span>
						</p>
					</div>
				</div>
			</div>

			<div class="clear"></div>

		</div>

		<p class="submit">
			<input type="submit" class="button-primary" name="update" value="<?php _e( 'Save' ); ?>" />
		</p>

		<p class="submit reset">
			<span class="description"><?php _e( 'Would initialize?' , $this->ltd ); ?></span>
			<input type="submit" class="button-secondary" name="reset" value="<?php _e('Reset'); ?>" />
		</p>

	</form>

</div>
