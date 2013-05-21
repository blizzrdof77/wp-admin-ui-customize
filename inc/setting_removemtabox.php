<?php

if( !empty( $_POST["update"] ) ) {
	$this->update_removemetabox();
} elseif( !empty( $_POST["reset"] ) ) {
	$this->update_reset( 'removemetabox' );
}

$Data = $this->get_data( 'removemetabox' );
$Metaboxes = $this->get_data( "regist_metabox" );

// include js css
$ReadedJs = array( 'jquery' , 'jquery-ui-sortable' );
wp_enqueue_script( $this->PageSlug ,  $this->Dir . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '.js', $ReadedJs , $this->Ver );
wp_enqueue_style( $this->PageSlug , $this->Dir . dirname( dirname( plugin_basename( __FILE__ ) ) ) . '.css', array() , $this->Ver );

?>

<div class="wrap">
	<div class="icon32" id="icon-tools"></div>
	<?php echo $this->Msg; ?>
	<h2><?php _e( 'Remove meta box' , $this->ltd ); ?></h2>
	<p><?php _e( 'Please once access the "post" or "page" edit screen to load the meta box for the new plugin.' , $this->ltd ); ?></p>

	<form id="waum_setting_removemtabox" class="waum_form" method="post" action="">
		<input type="hidden" name="<?php echo $this->UPFN; ?>" value="Y" />
		<?php wp_nonce_field(); ?>

		<div class="metabox-holder columns-1">

			<div class="postbox">
				<div class="handlediv" title="Click to toggle"><br></div>
				<h3 class="hndle"><span><?php _e( 'Post' ); ?></span></h3>
				<div class="inside">

					<?php if( empty( $Metaboxes["metaboxes"]["post"] ) ) : ?>

						<p><?php _e( 'Could not read the meta box.' , $this->ltd ); ?></p>
						<p><?php _e( 'Meta boxes will be loaded automatically when you view once the post editing screen.' , $this->ltd ); ?></p>
					
					<?php else: ?>
					
						<table class="form-table">
							<tbody>
								<?php foreach( $Metaboxes["metaboxes"]["post"] as $context => $meta_box ) : ?>
									<?php foreach( $meta_box as $priority => $box ) : ?>
										<?php foreach( $box as $metabox_id => $metabox_title ) : ?>
											<?php if( $metabox_id != 'submitdiv' ) : ?>
												<tr>
													<th><?php echo $metabox_title; ?></th>
													<td>
														<?php $Checked = ''; ?>
														<?php if( !empty( $Data["post"][$metabox_id] ) ) : $Checked = 'checked="checked"'; endif; ?>
														<label><input type="checkbox" name="data[post][<?php echo $metabox_id; ?>]" value="1" <?php echo $Checked; ?> /> <?php _e ( 'Hide' ); ?></label>
													</td>
												</tr>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endforeach; ?>
								<?php endforeach; ?>

								<?php global $wp_version; ?>
								<?php if ( version_compare( $wp_version , '3.5.1' , '>' ) ) : ?>
									<tr>
										<th><?php _e( 'Post Formats' ); ?></th>
										<td>
											<?php $Checked = ''; ?>
											<?php if( !empty( $Data["post"]["postformat"] ) ) : $Checked = 'checked="checked"'; endif; ?>
											<label><input type="checkbox" name="data[post][postformat]" value="1" <?php echo $Checked; ?> /> <?php _e ( 'Hide' ); ?></label>
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>


					<?php endif; ?>
				</div>
			</div>

			<div class="postbox">
				<div class="handlediv" title="Click to toggle"><br></div>
				<h3 class="hndle"><span><?php _e( 'Page' ); ?></span></h3>
				<div class="inside">

					<?php if( empty( $Metaboxes["metaboxes"]["page"] ) ) : ?>

						<p><?php _e( 'Could not read the meta box.' , $this->ltd ); ?></p>
						<p><?php _e( 'Meta boxes will be loaded automatically when you view once the page editing screen.' , $this->ltd ); ?></p>
					
					<?php else: ?>

						<table class="form-table">
							<tbody>
								<?php foreach( $Metaboxes["metaboxes"]["page"] as $context => $meta_box ) : ?>
									<?php foreach( $meta_box as $priority => $box ) : ?>
										<?php foreach( $box as $metabox_id => $metabox_title ) : ?>
											<?php if( $metabox_id != 'submitdiv' ) : ?>
												<tr>
													<th><?php echo $metabox_title; ?></th>
													<td>
														<?php $Checked = ''; ?>
														<?php if( !empty( $Data["page"][$metabox_id] ) ) : $Checked = 'checked="checked"'; endif; ?>
														<label><input type="checkbox" name="data[page][<?php echo $metabox_id; ?>]" value="1" <?php echo $Checked; ?> /> <?php _e ( 'Hide' ); ?></label>
													</td>
												</tr>
											<?php endif; ?>
										<?php endforeach; ?>
									<?php endforeach; ?>
								<?php endforeach; ?>
							</tbody>
						</table>

					<?php endif; ?>

				</div>
			</div>

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
