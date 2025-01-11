<?php

namespace engard;

?>          <footer class="footer">

				<div class="footer-inner">

					<section class="footer-copyright">
						&copy;&nbsp;<?=date('Y')?>
					</section>

					<section class="footer-wordpress">
						<?php if ( isset($_COOKIE['engard_admin']) && $_COOKIE['engard_admin'] === 'true' ) { ?>
						<a href="<?=admin_url()?>"><span class="dashicons dashicons-wordpress"></span></a>
						<?php } ?>
					</section>

				</div>
				
			</footer>

		</div><!-- .main-container -->

		<?php wp_footer(); ?>

	</div><!-- .site-container -->

</body>
</html>
