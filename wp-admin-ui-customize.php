<?php
/*
Plugin Name: WP Admin UI Customize
Description: Customize the management screen UI.
Plugin URI: http://gqevu6bsiz.chicappa.jp
Version: 1.0.1
Author: gqevu6bsiz
Author URI: http://gqevu6bsiz.chicappa.jp/author/admin/
Text Domain: wauc
Domain Path: /languages
*/

/*  Copyright 2012 gqevu6bsiz (email : gqevu6bsiz@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
	published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/



class WP_Admin_UI_Customize
{

	var $Ver,
		$Name,
		$Dir,
		$ltd,
		$Record,
		$PageSlug,
		$UPFN,
		$Menu,
		$SubMenu,
		$Msg;


	function __construct() {
		$this->Ver = '1.0.1';
		$this->Name = 'WP Admin UI Customize';
		$this->Dir = WP_PLUGIN_URL . '/' . dirname( plugin_basename( __FILE__ ) ) . '/';
		$this->ltd = 'wauc';
		$this->Record = array(
			"user_role" => $this->ltd . '_user_role_setting',
			"site" => $this->ltd . '_site_setting',
			"admin_general" => $this->ltd . '_admin_general_setting',
			"dashboard" => $this->ltd . '_dashboard_setting',
			"sidemenu" => $this->ltd . '_sidemenu_setting',
			"removemetabox" => $this->ltd . '_removemetabox_setting',
			"loginscreen" => $this->ltd . '_loginscreen_setting',
		);
		$this->PageSlug = 'wp_admin_ui_customize';
		$this->UPFN = 'Y';
		
		$this->PluginSetup();
		$this->FilterStart();
	}





	// PluginSetup
	function PluginSetup() {
		// load text domain
		load_plugin_textdomain( $this->ltd , false , basename( dirname( __FILE__ ) ) . '/languages' );

		// plugin links
		add_filter( 'plugin_action_links' , array( $this , 'plugin_action_links' ) , 10 , 2 );

		// add menu
		add_action( 'admin_menu' , array( $this , 'admin_menu' ) , 2 );
	}

	// PluginSetup
	function plugin_action_links( $links , $file ) {
		if( plugin_basename(__FILE__) == $file ) {
			$link = '<a href="' . 'admin.php?page=' . $this->PageSlug . '">' . __('Settings') . '</a>';
			array_unshift( $links, $link );
		}
		return $links;
	}

	// PluginSetup
	function admin_menu() {
		add_menu_page( $this->Name , $this->Name , 'administrator', $this->PageSlug , array( $this , 'setting_default') );
		add_submenu_page( $this->PageSlug , __( 'Site Settings' , $this->ltd ) , __( 'Site Settings' , $this->ltd ) , 'administrator' , $this->PageSlug . '_setting_site' , array( $this , 'setting_site' ) );
		add_submenu_page( $this->PageSlug , __( 'Admin screen setting' , $this->ltd ) , __( 'Admin screen setting' , $this->ltd ) , 'administrator' , $this->PageSlug . '_admin_general_setting' , array( $this , 'setting_admin_general' ) );
		add_submenu_page( $this->PageSlug , __( 'Dashboard' ) , __( 'Dashboard' ) , 'administrator' , $this->PageSlug . '_dashboard' , array( $this , 'setting_dashboard' ) );
		add_submenu_page( $this->PageSlug , __( 'Side Menu' , $this->ltd ) , __( 'Side Menu' , $this->ltd ) , 'administrator' , $this->PageSlug . '_sidemenu' , array( $this , 'setting_sidemenu' ) );
		add_submenu_page( $this->PageSlug , __( 'Remove meta box' , $this->ltd ) , __( 'Remove meta box' , $this->ltd ) , 'administrator' , $this->PageSlug . '_removemtabox' , array( $this , 'setting_removemtabox' ) );
		add_submenu_page( $this->PageSlug , __( 'Login Screen' , $this->ltd ) , __( 'Login Screen' , $this->ltd ) , 'administrator' , $this->PageSlug . '_loginscreen' , array( $this , 'setting_loginscreen' ) );
	}





	// SettingPage
	function setting_default() {
		include_once 'inc/setting_default.php';
	}

	// SettingPage
	function setting_site() {
		include_once 'inc/setting_site.php';
	}

	// SettingPage
	function setting_admin_general() {
		include_once 'inc/setting_admin_general.php';
	}

	// SettingPage
	function setting_dashboard() {
		include_once 'inc/setting_dashboard.php';
	}

	// SettingPage
	function setting_sidemenu() {
		include_once 'inc/setting_sidemenu.php';
	}

	// SettingPage
	function setting_removemtabox() {
		include_once 'inc/setting_removemtabox.php';
	}

	// SettingPage
	function setting_loginscreen() {
		include_once 'inc/setting_loginscreen.php';
	}





	// GetData
	function get_data( $record ) {
		$GetData = get_option( $this->Record[$record] );

		$Data = array();
		if( !empty( $GetData ) && !empty( $GetData["UPFN"] ) && $GetData["UPFN"] == $this->UPFN ) {
			$Data = $GetData;
		}

		return $Data;
	}





	// SetList
	function get_user_role() {
		$editable_roles = get_editable_roles();
		foreach ( $editable_roles as $role => $details ) {
			$UserRole[$role] = translate_user_role( $details['name'] );
		}

		return $UserRole;
	}

	// SetList
	function sidemenu_default_load() {
		global $menu , $submenu;

		$this->Menu = $menu;
		$this->SubMenu = $submenu;
	}

	// SetList
	function menu_widget( $menu_widget ) {
		 $sepalator_widget = '';
		 if( $menu_widget["slug"] == 'separator' ) {
			  $sepalator_widget = $menu_widget["slug"];
		 }
		 $new_widget = '';
		 if( !empty( $menu_widget["new"] ) ) {
			  $new_widget = 'new';
		 }
?>
		<div class="widget <?php echo $sepalator_widget; ?> <?php echo $new_widget; ?>">

			<div class="widget-top">
				<div class="widget-title-action">
					<a class="widget-action" href="#available"></a>
				</div>
				<div class="widget-title">
					<h4>
						<?php echo $menu_widget["title"]; ?>
						: <span class="in-widget-title"><?php echo $menu_widget["slug"]; ?></span>
					</h4>
				</div>
			</div>

			<div class="widget-inside">
				<div class="settings">
					<p class="description">
						<?php _e( 'Slug' ); ?>: <?php echo $menu_widget["slug"]; ?>
						<input type="hidden" class="slugtext" value="<?php echo $menu_widget["slug"]; ?>" name="data[][slug]">
					</p>
					<label>
						<?php _e( 'Title' ); ?> : <input type="text" class="regular-text titletext" value="<?php echo $menu_widget["title"]; ?>" name="data[][title]">
					</label>
					<input type="hidden" class="parent_slugtext" value="<?php echo $menu_widget["parent_slug"]; ?>" name="data[][parent_slug]">
				</div>

				<?php if( $menu_widget["slug"] != 'separator' ) : ?>
					<div class="submenu">
						<p class="description"><?php _e( 'Sub Menus' , $this->ltd ); ?></p>
						<?php if( empty( $menu_widget["new"] ) && !empty( $menu_widget["submenu"] ) ) : ?>
							<?php foreach($menu_widget["submenu"] as $sm) : ?>
								<?php $sepalator_widget = ''; ?>
								<?php if( $sm["slug"] == 'separator' ) : $sepalator_widget = $sm["slug"]; endif; ?>

								<div class="widget <?php echo $sepalator_widget; ?>">

									<div class="widget-top">
										<div class="widget-title-action">
											<a class="widget-action" href="#available"></a>
										</div>
										<div class="widget-title">
											<h4>
												<?php echo $sm["title"]; ?>
												: <span class="in-widget-title"><?php echo $sm["slug"]; ?></span>
											</h4>
										</div>
									</div>

									<div class="widget-inside">
										<div class="settings">
											<p class="description">
												<?php _e( 'Slug' ); ?>: <?php echo $sm["slug"]; ?>
												<input type="hidden" class="slugtext" value="<?php echo $sm["slug"]; ?>" name="data[][slug]">
											</p>
											<label>
												<?php _e( 'Title' ); ?> : <input type="text" class="regular-text titletext" value="<?php echo $sm["title"]; ?>" name="data[][title]">
											</label>
											<input type="hidden" class="parent_slugtext" value="<?php echo $sm["parent_slug"]; ?>" name="data[][parent_slug]">
										</div>
										<div class="widget-control-actions">
											<div class="alignleft">
												<a href="#remove"><?php _e( 'Remove' ); ?></a>
											</div>
											<div class="clear"></div>
										</div>
									</div>
								</div>

							<?php endforeach; ?>
						<?php endif; ?>
					</div>
					<div class="widget-control-actions">
						<div class="alignleft">
							<a href="#remove"><?php _e( 'Remove' ); ?></a>
						</div>
						<div class="clear"></div>
					</div>

				<?php endif; ?>
			</div>

		</div>
<?php
	}




	// DataUpdate
	function update_validate() {
		$Update = array();

		if( !empty( $_POST[$this->UPFN] ) ) {
			$UPFN = strip_tags( $_POST[$this->UPFN] );
			if( $UPFN == $this->UPFN ) {
				$Update["UPFN"] = strip_tags( $_POST[$this->UPFN] );
			}
		}

		return $Update;
	}

	// DataUpdate
	function update_reset( $record ) {
		$Update = $this->update_validate();
		if( !empty( $Update ) ) {
			delete_option( $this->Record[$record] );
			$this->Msg = '<div class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
		}
	}

	// DataUpdate
	function update_userrole() {
		$Update = $this->update_validate();
		if( !empty( $Update ) ) {

			if( !empty( $_POST["data"]["user_role"] ) ) {
				foreach($_POST["data"]["user_role"] as $key => $val) {
					$tmpK = strip_tags( $key );
					$tmpV = strip_tags ( $val );
					$Update[$tmpK] = $tmpV;
				}
			}

			update_option( $this->Record["user_role"] , $Update );
			$this->Msg = '<div class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
		}
	}

	// DataUpdate
	function update_site() {
		$Update = $this->update_validate();
		if( !empty( $Update ) ) {

			if( !empty( $_POST["data"] ) ) {
				foreach($_POST["data"] as $key => $val) {
					$tmpK = strip_tags( $key );
					$tmpV = strip_tags ( $val );
					$Update[$tmpK] = $tmpV;
				}
			}

			update_option( $this->Record["site"] , $Update );
			$this->Msg = '<div class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
		}
	}

	// DataUpdate
	function update_admin_general() {
		$Update = $this->update_validate();
		if( !empty( $Update ) ) {

			if( !empty( $_POST["data"] ) ) {
				foreach($_POST["data"] as $key => $val) {
					$tmpK = strip_tags( $key );
					$tmpV = $val;
					$Update[$tmpK] = $tmpV;
				}
			}

			update_option( $this->Record["admin_general"] , $Update );
			$this->Msg = '<div class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
		}
	}

	// DataUpdate
	function update_dashboard() {
		$Update = $this->update_validate();
		if( !empty( $Update ) ) {

			if( !empty( $_POST["data"] ) ) {
				foreach($_POST["data"] as $key => $val) {
					$tmpK = strip_tags( $key );
					$tmpV = $val;
					$Update[$tmpK] = $tmpV;
				}
			}

			update_option( $this->Record["dashboard"] , $Update );
			$this->Msg = '<div class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
		}
	}

	// DataUpdate
	function update_sidemenu() {
		$Update = $this->update_validate();
		if( !empty( $Update ) ) {

			if( !empty( $_POST["data"] ) ) {
				foreach($_POST["data"] as $menu) {
					if( !empty( $menu["title"] ) && !empty( $menu["slug"] ) ) {
						$slug = strip_tags( $menu["slug"] );
						$title = strip_tags( $menu["title"] );
						$parent_slug = '';
						$depth = 'main';

						if( !empty( $menu["parent_slug"] ) ) {
							$parent_slug = strip_tags( $menu["parent_slug"] );
							$depth = 'sub';
						}
						
						$Update[$depth][] = array( "slug" => $slug , "title" => $title , "parent_slug" => $parent_slug );
					}
				}
			}

			update_option( $this->Record["sidemenu"] , $Update );
			$this->Msg = '<div class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
		}
	}

	// DataUpdate
	function update_removemetabox() {
		$Update = $this->update_validate();
		if( !empty( $Update ) ) {

			if( !empty( $_POST["data"] ) ) {
				foreach($_POST["data"] as $post_type => $val) {
					$post_type = strip_tags( $post_type );
					if( is_array( $val ) ) {
						foreach($val as $id => $v) {
							$tmpK = strip_tags( $id );
							$tmpV = strip_tags ( $v );
							$Update[$post_type][$tmpK] = $tmpV;
						}
					}
					
				}
			}

			update_option( $this->Record["removemetabox"] , $Update );
			$this->Msg = '<div class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';
		}
	}

	// DataUpdate
	function update_loginscreen() {
		$Update = $this->update_validate();
		if( !empty( $Update ) ) {

			if( !empty( $_POST["data"] ) ) {
				foreach($_POST["data"] as $key => $val) {
					$tmpK = strip_tags( $key );
					$tmpV = $val;
					$Update[$tmpK] = $tmpV;
				}
			}

			update_option( $this->Record["loginscreen"] , $Update );
			$this->Msg = '<div class="updated"><p><strong>' . __('Settings saved.') . '</strong></p></div>';

		}
	}






	// FilterStart
	function FilterStart() {
		// site
		if( !is_admin() ) {
			$this->remove_action_front();
			add_filter( 'login_headerurl' , array( $this , 'login_headerurl' ) );
			add_filter( 'login_headertitle' , array( $this , 'login_headertitle' ) );
			add_action( 'login_head' , array( $this , 'login_head' ) );
			add_action( 'login_footer' , array( $this , 'login_footer' ) );
		}
		// admin UI
		if ( is_admin() ) {
			// default side menu load.
			add_action( 'admin_menu' , array( $this , 'sidemenu_default_load' ) );

			$SettingRole = $this->get_data( 'user_role' );
			if( !empty( $SettingRole ) ) {
				unset($SettingRole["UPFN"]);
				if( !empty( $SettingRole ) ) {
					add_action( 'init' , array( $this , 'admin_init' ) );
				}
			}
		}
	}

	// FilterStart
	function admin_init() {
		$SettingRole = $this->get_data( 'user_role' );
		unset($SettingRole["UPFN"]);

		$User = wp_get_current_user();
		$UserRole = $User->roles[0];

		if( array_key_exists( $UserRole , $SettingRole ) ){
			add_filter( 'admin_bar_menu' , array( $this , 'admin_bar_menu') , 25 );
			add_action( 'init' , array( $this , 'notice_dismiss' ) , 2 );
			add_action( 'admin_head' , array( $this , 'remove_tab' ) );
			add_filter( 'admin_footer_text' , array( $this , 'admin_footer_text' ) );
			add_action( 'admin_print_styles' , array( $this , 'load_css' ) );
			add_action( 'wp_dashboard_setup' , array( $this , 'wp_dashboard_setup' ) );
			add_action( 'admin_menu' , array( $this , 'removemetabox' ) );
			add_filter( 'admin_menu', array( $this , 'sidemenu' ) );
		}
	}

	// FilterStart
	function remove_action_front() {
		$GetData = $this->get_data( 'site' );
		
		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );
			foreach($GetData as $key => $val) {
				if( $key == 'feed_links' ) {
					remove_action( 'wp_head', $key , 2 );
				} elseif( $key == 'feed_links_extra' ) {
					remove_action( 'wp_head', $key , 3 );
				} elseif( $key == 'admin_bar' ) {
					add_filter( 'show_admin_bar' , '__return_false' );  
				} else {
					remove_action( 'wp_head', $key );
				}
			}
		}

	}

	// FilterStart
	function login_headerurl() {
		$GetData = get_option( $this->Record["loginscreen"] );

		$url = __( 'http://wordpress.org/' );
		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );

			if( !empty( $GetData["login_headerurl"] ) ) {
				$url = strip_tags( $GetData["login_headerurl"] );
				$url = str_replace( '[blog_url]' , get_bloginfo( 'url' ) , $url );
				
			}
		}

		return $url;
	}

	// FilterStart
	function login_headertitle() {
		$GetData = get_option( $this->Record["loginscreen"] );

		$title = __( 'Powered by WordPress' );
		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );

			if( !empty( $GetData["login_headertitle"] ) ) {
				$title = strip_tags( $GetData["login_headertitle"] );
				$title = str_replace( '[blog_name]' , get_bloginfo( 'name' ) , $title );
				
			}
		}

		return $title;
	}

	// FilterStart
	function login_head() {
		$GetData = get_option( $this->Record["loginscreen"] );

		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );

			if( !empty( $GetData["login_headerlogo"] ) ) {
				$logo = strip_tags( $GetData["login_headerlogo"] );
				$logo = str_replace( '[blog_url]' , get_bloginfo( 'url' ) , $logo );
				$logo = str_replace( '[template_directory_uri]' , get_bloginfo( 'template_directory' ) , $logo );

				echo '<style type="text/css">.login h1 a { background-image: url(' . $logo . '); }</style>';
			}

			if( !empty( $GetData["login_css"] ) ) {
				$css = strip_tags( $GetData["login_css"] );
				$css = str_replace( '[blog_url]' , get_bloginfo( 'url' ) , $css );
				$css = str_replace( '[template_directory_uri]' , get_bloginfo( 'template_directory' ) , $css );

				wp_enqueue_style( $this->PageSlug , $css , array() , $this->Ver );
			}

		}

	}

	// FilterStart
	function login_footer() {
		$GetData = get_option( $this->Record["loginscreen"] );

		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );

			if( !empty( $GetData["login_footer"] ) ) {
				$text = stripslashes( $GetData["login_footer"] );

				echo $text;
			}

		}
	}

	// FilterStart
	function admin_bar_menu( $wp_admin_bar ) {
		$GetData = $this->get_data( 'admin_general' );
		
		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );

			$remove_menu = array( 'wp-logo');
			foreach($GetData as $id => $val) {
				if( in_array( $id , $remove_menu ) ) {
					$wp_admin_bar->remove_menu( $id );
				} else {
					if( $id == 'comment' ) {
						remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
					} elseif( $id == 'new_content' ) {
						remove_action( 'admin_bar_menu', 'wp_admin_bar_new_content_menu', 70 );
					} elseif( $id == 'update_menu' ) {
						remove_action( 'admin_bar_menu', 'wp_admin_bar_updates_menu', 40 );
					} elseif( $id == 'edit-profile' ) {
						$wp_admin_bar->remove_menu( $id );
						$wp_admin_bar->remove_menu( 'user-info' );
						$wp_admin_bar->add_node( array( 'id' => 'my-account' , 'href' => '' , 'meta' => array() ) );
					}
				}
			}

			$User = wp_get_current_user();
			$title = strip_tags( $GetData["my-account-title"] );
			$title = str_replace( '[AcountName]' , $User->data->display_name , $title );
			$wp_admin_bar->add_node( array( 'id' => 'my-account' , 'title' => $title , 'meta' => array() ) );
		}
	}

	// FilterStart
	function notice_dismiss() {
		$GetData = $this->get_data( 'admin_general' );

		if( !empty( $GetData["UPFN"] ) ) {

			if( !empty( $GetData["notice_update_core"] ) ) {
				add_filter( 'update_footer' , '__return_false' , 20) ;
				add_filter( 'site_transient_update_core' , array( $this , 'notice_update_core' ) );
				//add_filter( 'site_transient_update_core' , '__return_zero' );
			}

			if( !empty( $GetData["notice_update_plugin"] ) ) {
				add_filter( 'site_transient_update_plugins' , array( $this , 'notice_update_plugin' ) );
			}
			if( !empty( $GetData["notice_update_theme"] ) ) {
				add_filter( 'site_transient_update_themes' , array( $this , 'notice_update_theme' ) );
			}

		}

	}

	// FilterStart
	function notice_update_core( $site_transient_update_core ) {
		$site_transient_update_core->updates = '';
		
		return $site_transient_update_core;
	}

	// FilterStart
	function notice_update_plugin( $site_transient_update_plugins ) {
		$site_transient_update_plugins->response = '';
		
		return $site_transient_update_plugins;
	}

	// FilterStart
	function notice_update_theme( $site_transient_update_themes ) {
		$site_transient_update_themes->response = '';
		
		return $site_transient_update_themes;
	}

	// FilterStart
	function remove_tab() {
		$GetData = get_option( $this->Record["admin_general"] );

		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );

			if( !empty( $GetData["help_tab"] ) ) {
				$screen = get_current_screen();
				$screen->remove_help_tabs();
			}
	
			if( !empty( $GetData["screen_option_tab"] ) ) {
				add_filter( 'screen_options_show_screen' , '__return_false' );
			}
		}

	}

	// FilterStart
	function admin_footer_text( $text ) {
		$GetData = $this->get_data( 'admin_general' );

		$footer_text = $text;
		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );

			$footer_text = stripslashes( $GetData["footer_text"] );
		}

		return $footer_text;
	}

	// FilterStart
	function load_css() {
		$GetData = get_option( $this->Record["admin_general"] );

		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );

			if( !empty( $GetData["css"] ) ) {

				$css = strip_tags( $GetData["css"] );
				$css = str_replace( '[blog_url]' , get_bloginfo( 'url' ) , $css );
				$css = str_replace( '[template_directory_uri]' , get_bloginfo( 'template_directory' ) , $css );

				wp_enqueue_style( $this->PageSlug , strip_tags( $css ) , array() , $this->Ver );
			}
	
		}

	}

	// FilterStart
	function wp_dashboard_setup() {
		global $wp_meta_boxes;

		$GetData = get_option( $this->Record["dashboard"] );
		unset($GetData["f"]);

		if( !empty( $GetData ) && is_array( $GetData ) ) {
			$dashboard_widgets = array();
			foreach($wp_meta_boxes["dashboard"] as $ns => $core) {
				foreach($core["core"] as $id => $val) {
					$dashboard_widgets[$id] = $ns;
				}
			}

			foreach($GetData as $id => $val) {
				if( $id == 'show_welcome_panel' ) {
					$user_id = get_current_user_id();
					if( get_user_meta( $user_id , 'show_welcome_panel' , true ) == true ) {
						update_user_meta( $user_id , 'show_welcome_panel' , 0 );
					}
				} elseif( array_key_exists( $id , $dashboard_widgets ) ){
					remove_meta_box( $id , 'dashboard' , $dashboard_widgets[$id] );
				}
			}
		}

	}

	// FilterStart
	function removemetabox() {
		$GetData = get_option( $this->Record["removemetabox"] );

		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );

			if( !empty( $GetData ) && is_array( $GetData ) ) {
				foreach($GetData as $post_type => $val) {
					foreach($val as $id => $v) {
						if( $id == 'postimagediv' ) {
							if( current_theme_supports( 'post-thumbnails' ) ) {
								remove_post_type_support( $post_type , 'thumbnail' );
							}
						} else {
							remove_meta_box( $id , $post_type , 'normal' );
						}
					}
				}
			}
		}

	}

	// FilterStart
	function sidemenu() {
		global $menu;
		global $submenu;

		$GetData = get_option( $this->Record["sidemenu"] );
		$General = get_option( $this->Record["admin_general"] );

		if( !empty( $GetData["UPFN"] ) ) {
			unset( $GetData["UPFN"] );

			if( !empty( $GetData ) && is_array( $GetData ) && !empty( $GetData["main"] ) ) {
				$SetMain_menu = array();
				$SetMain_submenu = array();
				$separator_menu = $menu[99];
				
				foreach($GetData["main"] as $mm_pos => $mm) {
					if($mm["slug"] == 'separator') {
						$SetMain_menu[] = $separator_menu;
					} else {
						$gm_search = false;
						foreach($menu as $gm_pos => $gm) {
							if($mm["slug"] == $gm[2]) {
								$menu[$gm_pos][0] = $mm["title"];
								$SetMain_menu[] = $menu[$gm_pos];
								$gm_search = true;
								break;
							}
						}
						if( empty( $gm_search ) ) {
							foreach($submenu as $gsm_parent_slug => $v) {
								foreach($v as $gsm_pos => $gsm) {
									if($mm["slug"] == $gsm[2]) {
										
										foreach($menu as $tmp_m) {
											if( $tmp_m[2] == $gsm_parent_slug) {
												$submenu[$gsm_parent_slug][$gsm_pos][4] = $tmp_m[4];
												break;
											}
										}
										
										$submenu[$gsm_parent_slug][$gsm_pos][0] = $mm["title"];
										$SetMain_menu[] = $submenu[$gsm_parent_slug][$gsm_pos];
									}
								}
							}
						}
					}
				}

				foreach($GetData["sub"] as $sm_pos => $sm) {
					if($sm["slug"] == 'separator') {
						$SetMain_submenu[$sm["parent_slug"]][] = $separator_menu;
					} else {
						$gm_search = false;
						foreach($menu as $gm_pos => $gm) {
							if($sm["slug"] == $gm[2]) {
								$menu[$gm_pos][0] = $sm["title"];
								$SetMain_submenu[$sm["parent_slug"]][] = $menu[$gm_pos];
								$gm_search = true;
								break;
							}
						}
						if( empty( $gm_search ) ) {
							foreach($submenu as $gsm_parent_slug => $v) {
								foreach($v as $gsm_pos => $gsm) {
									if($sm["slug"] == $gsm[2]) {
										$submenu[$gsm_parent_slug][$gsm_pos][0] = $sm["title"];
										$SetMain_submenu[$sm["parent_slug"]][] = $submenu[$gsm_parent_slug][$gsm_pos];
									}
								}
							}
						}
					}
				}

				$menu = $SetMain_menu;
				$submenu = $SetMain_submenu;
				
			}
		}
	}

}
$wauc = new WP_Admin_UI_Customize();


