<?php

if( !empty( $_POST["update"] ) ) {
	$this->update_removemetabox();
} elseif( !empty( $_POST["reset"] ) ) {
	$this->update_reset( 'removemetabox' );
}

$Data = $this->get_data( 'removemetabox' );

// include js css
$ReadedJs = array( 'jquery' , 'jquery-ui-sortable' );
wp_enqueue_script( $this->PageSlug ,  $this->Dir . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '.js', $ReadedJs , $this->Ver );
wp_enqueue_style( $this->PageSlug , $this->Dir . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '.css', array() , $this->Ver );

?>

<div class="wrap">
	<div class="icon32" id="icon-tools"></div>
	<?php echo $this->Msg; ?>
	<h2><?php _e( 'Remove meta box' , $this->ltd ); ?></h2>
	<p><?php _e( 'Please update or add a "post" and a "page" to load the available meta boxes.' , $this->ltd ); ?></p>

	<h3 id="wauc-apply-user-roles"><?php echo $this->get_apply_roles(); ?></h3>

	<form id="wauc_setting_removemtabox" class="wauc_form" method="post" action="">
		<input type="hidden" name="<?php echo $this->UPFN; ?>" value="Y" />
		<?php wp_nonce_field( $this->Nonces["value"] , $this->Nonces["field"] ); ?>

		<div id="poststuff">
			<div id="post-body" class="metabox-holder columns-1">

				<div id="postbox-container-1" class="postbox-container">
					<div id="metabox_post">
						<?php echo $this->set_setting_removemetabox( 'post' , $Data ); ?>
					</div>
				</div>
				
				<div id="postbox-container-2" class="postbox-container">
					<div id="metabox_page">
						<?php echo $this->set_setting_removemetabox( 'page' , $Data ); ?>
					</div>
				</div>
				
				<br class="clear">
			</div>
		</div>

		<p class="submit">
			<input type="submit" class="button-primary" name="update" value="<?php _e( 'Save' ); ?>" />
		</p>

		<p class="submit reset">
			<span class="description"><?php _e( 'Reset all settings?' , $this->ltd ); ?></span>
			<input type="submit" class="button-secondary" name="reset" value="<?php _e('Reset'); ?>" />
		</p>

	</form>

</div>
