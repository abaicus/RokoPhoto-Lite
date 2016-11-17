<?php
/**
 * Class to display upsells.
 *
 * @package WordPress
 * @subpackage RokoPhoto-Lite
 */

if ( ! class_exists( 'WP_Customize_Control' ) ) {
	return;
}

/**
 * Class RokoPhoto_Info
 */
class RokoPhoto_Info extends WP_Customize_Control {

	/**
	 * Enqueue required scripts and styles.
	 */
	public function enqueue() {
		wp_enqueue_style( 'rokophoto-theme-info-control', get_template_directory_uri() . '/css/admin-style.css','1.0.0' );
	}

	/**
	 * The render function for the controler
	 */
	public function render_content() {
		$links = array(
			array(
				'name' => __( ' View PRO version','rokophotolite' ),
				'link' => esc_url( 'https://themeisle.com/themes/rokophoto/' ),
			),
			array(
				'name' => __( 'Documentation ','rokophotolite' ),
				'link' => esc_url( 'http://docs.themeisle.com/article/137-rokophoto-documentation' ),
			),
			array(
				'name' => __( 'Leave us a review(it will help us)','rokophotolite' ),
				'link' => esc_url( 'https://wordpress.org/support/theme/rokophoto-lite/reviews/' ),
			),
		); ?>


		<div class="rokophoto-theme-info">
			<?php
			foreach ( $links as $item ) {  ?>
				<a href="<?php echo esc_url( $item['link'] ); ?>" target="_blank"><?php echo esc_html( $item['name'] ); ?></a>
				<hr/>
				<?php
			} ?>
		</div>
		<?php
	}
}
