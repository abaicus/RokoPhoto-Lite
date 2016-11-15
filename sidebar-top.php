<?php
/**
 * Sidebar Top Template
 *
 * Displays any widgets for the top dynamic sidebar if they are available.
 *
 * @package WordPress
 * @subpackage RokoPhoto-Lite
 */

if ( is_active_sidebar( 'rokophoto-sidebar-top' )  ) : ?>
	<div id="secondary_top" class="secondary-top">
		<div class="container">

			<?php if ( is_active_sidebar( 'rokophoto-sidebar-top' ) ) : ?>
				<div id="widget-area" class="widget-area" role="complementary">
					<?php dynamic_sidebar( 'rokophoto-sidebar-top' ); ?>
				</div><!-- .widget-area -->
			<?php endif; ?>

		</div><!-- .container -->
	</div><!-- .secondary -->

<?php endif; ?>
