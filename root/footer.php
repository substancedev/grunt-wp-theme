<?php
/**
 * The template for displaying the footer.
 *
 * @package {%= title %}
 * @since 0.1.0
 */
 ?>
 
   </div><!-- #main -->
 
   <footer id="colophon" class="site-footer" role="contentinfo">
     <nav id="footer-navigation" class="navigation-footer container" role="navigation">
       <?php if ( ! dynamic_sidebar( 'Footer Menu' ) ) : ?>
         <?php wp_nav_menu( array( 'theme_location' => 'footer' ) ); ?>
       <?php endif; // end sidebar widget area ?>
       <p class="copyright">&copy;<?php echo date('Y'); ?> <?php _e('{%= title %}', '{%= js_safe_name %}') ?> <?php _e('All rights reserved', '{%= js_safe_name %}') ?>.</p>
     </nav><!-- #site-navigation -->
   </footer><!-- #colophon -->
 </div><!-- #page -->
 
 <?php wp_footer(); ?>
 
 </body>
 </html>