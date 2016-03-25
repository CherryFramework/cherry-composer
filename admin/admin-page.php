<?php
/**
 * Admin page.
 *
 * @package Cherry Team
 */

/** WordPress Administration Bootstrap */
	require_once( dirname( __FILE__ ) . '/admin.php' );

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to manage options for this site.' ) );
	}
?>
<div class="wrap">
	<h1><?php _e( 'Cherry Composer Settings', 'cherry-composer' ) ?></h1>
	<form method="post" action="options.php">
		<?php
			settings_fields('cherry-composer');

			$filds =  array(
				'url'	=> array(
					'type'				=> 'text',
					'value'				=> '',
					'placeholder'		=> esc_html__( 'Repository URL', 'cherry-compose' ),
					'class'				=> 'regular-text',
					'label'				=> esc_html__( 'Repository URL', 'cherry-compose' ),
				),
				'type'	=> array(
					'type'				=> 'radio',
					'value'				=> 'public',
					'options'			=> array(
						'private' => array(
							'label'		=> esc_html__( 'Private', 'cherry-compose' ),
							'slave'		=> 'repos_private',
						),
						'public' => array(
							'label'		=> esc_html__( 'Public', 'cherry-compose' ),
							'slave'		=> 'repos_public',
						),
					),
					'label'				=> esc_html__( 'Repository type', '__tm' ),
				),
				'user'	=> array(
					'type'				=> 'text',
					'value'				=> '',
					'placeholder'		=> esc_html__( 'User', 'cherry-compose' ),
					'class'				=> 'regular-text',
					'label'				=> esc_html__( 'User', 'cherry-compose' ),
					'master'			=> 'repos_private',
				),
				'key'	=> array(
					'type'				=> 'text',
					'value'				=> '',
					'placeholder'		=> esc_html__( 'Secret Key', 'cherry-compose' ),
					'class'				=> 'regular-text',
					'label'				=> esc_html__( 'Secret Key', 'cherry-compose' ),
					'master'			=> 'repos_private',
				),
			);

			echo $this->render_ui_elements( $filds );

			do_settings_sections('cherry-composer');

			submit_button();


		 ?>
	</form>
</div>