<?php
/*
Plugin Name:  WPMU Database Reset
Description:  Delete all posts, comments, terms and media files on a site in a WP network.
Author:       Hassan Derakhshandeh
Author URI: 
Version:      0.2
Text Domain:  wpmu-database-reset
Domain Path:  /languages
*/

if( ! defined( 'ABSPATH' ) || ! is_admin() )
	return;

class WPMU_Database_Reset {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'init', array( $this, 'i18n' ) );
	}

	function admin_menu() {
		$hook = add_submenu_page(
			'tools.php',
			__( 'Database Reset', 'wpmu-database-reset' ),
			__( 'Database Reset', 'wpmu-database-reset' ),
			'manage_options',
			'wpmu-database-reset',
			array( $this, 'page_callback' )
		);
		add_action( "load-{$hook}", array( $this, 'actions' ) );
	}

	function i18n() {
		load_plugin_textdomain( 'wpmu-database-reset', false, '/languages' );
	}

	/**
	 * Do the magic. Clears database tables and remove media files.
	 *
	 * @since 0.1
	 */
	function actions() {
		if( ! current_user_can( 'manage_options' ) )
			return;

		if( ! isset( $_GET['wpdr-do-it-daddy'] ) )
			return;

		check_admin_referer( 'wpmu-reset-database-do-it-daddy' );

		global $wpdb;
		global $current_user;

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

		/* drop custom database tables */
		$prefix = $wpdb->get_blog_prefix();
		$core_tables = $wpdb->tables( 'blog' ); /* tables specific to the current website */
		$all_tables = $wpdb->get_results( "SHOW TABLES LIKE '{$prefix}%'", ARRAY_N );
		if( is_array( $all_tables ) && ! empty( $all_tables ) ) {
			foreach( $all_tables as $custom_table ) {
				$name = $custom_table[0];
				if( ! in_array( $name, $core_tables ) ) { // do not remove WP core tables
					$wpdb->query( "DROP TABLE {$name}" );
				}
			}
		}

		/* clean up database tables */
		$wpdb->query( "TRUNCATE {$wpdb->posts}" );
		$wpdb->query( "TRUNCATE {$wpdb->postmeta}" );
		$wpdb->query( "TRUNCATE {$wpdb->links}" );
		$wpdb->query( "TRUNCATE {$wpdb->comments}" );
		$wpdb->query( "TRUNCATE {$wpdb->commentmeta}" );
		$wpdb->query( "TRUNCATE {$wpdb->terms}" );
		$wpdb->query( "TRUNCATE {$wpdb->term_taxonomy}" );
		$wpdb->query( "TRUNCATE {$wpdb->term_relationships}" );
		$wpdb->query( "TRUNCATE {$wpdb->termmeta}" );

		/* clean up options table, and put it back to normal */
		$home = get_option( 'home' );
		$siteurl = get_option( 'siteurl' );
		$blog_public = get_option( 'blog_public' );
		$blogname = get_option( 'blogname' );
		$WPLANG = get_option( 'WPLANG' );
		$user = ( 0 !== $current_user->ID ) ? wp_get_current_user() : get_userdata( 1 );
		$username = $user->user_login;

		$wpdb->query( "TRUNCATE {$wpdb->options}" );
		wp_check_mysql_version();
		wp_cache_flush();
		make_db_current_silent();
		populate_options();
		populate_roles();
		update_option( 'siteurl', $siteurl );
		update_option( 'home', $home );
		update_option( 'blog_public', $blog_public );
		update_option( 'blogname', $blogname );
		update_option( 'WPLANG', $WPLANG );
		if ( ! $blog_public )
			update_option( 'default_pingback_flag', 0 );
		$user = new WP_User( $username );
		$user->set_role( 'administrator' );

		wp_install_maybe_enable_pretty_permalinks();

		flush_rewrite_rules();

		wp_cache_flush();

		/* remove all media files */
		$upload_dir = wp_upload_dir();
		$this->deleteDir( $upload_dir['basedir'] );

		wp_redirect( admin_url( 'index.php' ) );
		die;
	}

	/**
	 * Display the admin page
	 *
	 * @since 0.1
	 */
	function page_callback() {
		?>
		<div class="wrap">
			<h2><?php _e( 'Reset Database', 'wpmu-database-reset' ); ?></h2>
			<form method="GET" action="<?php echo admin_url( 'tools.php?page=wpmu-database-reset' ); ?>">
				<?php wp_nonce_field( 'wpmu-reset-database-do-it-daddy' ); ?>
				<input type="hidden" name="page" value="wpmu-database-reset" />

				<div class="" style="text-align: center;">
					<p>
						<?php _e( 'This action will remove all posts, comments, terms, and media files on this site.', 'wpmu-database-reset' ); ?>
					</p>
					<p>
						<a class="button button-secondary wpdr-confirm" href="#"> <?php _e( 'I understand, do it.', 'wpmu-database-reset' ); ?> </a>
					</p>
					<p>
						<input type="submit" name="wpdr-do-it-daddy" value=" <?php _e( 'Confirm, do it daddy!', 'wpmu-database-reset' ); ?> " class="button button-primary wpdr-submit" style="display: none;">
					</p>
				</div>

			</form>
		</div>
		<script>
		jQuery( '.wpdr-confirm' ).click(function(){
			jQuery( '.wpdr-submit' ).fadeIn();
		});
		</script>
	<?php
	}

	/**
	 * Delete a whole directory with all it's files
	 * @source http://stackoverflow.com/a/3349792/382738
	 */
	public function deleteDir( $dirPath ) {
		if (! is_dir( $dirPath ) ) {
			throw new InvalidArgumentException("$dirPath must be a directory");
		}
		if ( substr( $dirPath, strlen( $dirPath ) - 1, 1 ) != '/' ) {
			$dirPath .= '/';
		}
		$files = glob( $dirPath . '*', GLOB_MARK );
		foreach ( $files as $file ) {
			if ( is_dir( $file ) ) {
				$this->deleteDir( $file );
			} else {
				@ unlink( $file );
			}
		}
		@ rmdir( $dirPath );
	}
}
new WPMU_Database_Reset;