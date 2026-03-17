<?php
// App/about/views/pages/about.php
?>

<!-- HERO SECTION (Dynamic) -->
<?php include_once __DIR__ . '/../../../../includes/templates/hero.php'; ?>

<main class="intro">

	<section class="intro__section--presentation">
        <!-- Dynamic Brick Title -->
		<h2 class="intro__title"><?= isset($aboutBrick) ? htmlspecialchars($aboutBrick->title) : 'who we are ?' ?></h2>

		<div class="intro__content">
			<div class="intro__presentation">
                <!-- Dynamic Brick Description -->
                <?php if (isset($aboutBrick)): ?>
				    <p><?= nl2br(htmlspecialchars($aboutBrick->description)) ?></p>
                <?php else: ?>
                    <!-- Fallback static content -->
                    <p>Arcadia Zoo, located near the Brocéliande Forest in Brittany, France, has been a sanctuary for
					animals since 1960. Organized into diverse habitats such as the savannah, jungle, and wetlands,
					the zoo is committed to the well-being of its residents. Daily veterinary checks ensure the
					health of all animals before the zoo opens its doors to the public, and their meals are
					carefully portioned according to veterinarian reports.
					<br><br>
					With its thriving operation and happy animals, Arcadia Zoo is a source of pride for its
					director, José, who envisions even greater achievements for the zoo's future. Through innovation
					and care, the zoo continues to be a place where visitors can connect with animals and nature.
				    </p>
                <?php endif; ?>
			</div>
		</div>
	</section>

</main>

<section class="testimony" id="testimonys">
	<div class="testimony__approuved testimony__container">
		<h2 class="testimony__title testimony__title--shown">All testimonys</h2>

		<?php if (!empty($validatedTestimonials)): ?>
			<div id="carouselExampleRide" data-bs-theme="dark" class="carousel slide" data-bs-ride="true">
				<div class="carousel-inner">
					<?php foreach ($validatedTestimonials as $index => $testimonial): ?>
						<div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
							<div class="testimony__item">
								<div class="testimony__header">
									<span class="testimony__user"><?= htmlspecialchars($testimonial->pseudo) ?></span>
									<span class="testimony__rating">
										<?php
										$rating = (int)$testimonial->rating;
										for ($i = 1; $i <= 5; $i++):
											if ($i <= $rating):
												echo '★';
											else:
												echo '☆';
											endif;
										endfor;
										?>
									</span>
								</div>
								<p class="testimony__text">
									<?= nl2br(htmlspecialchars($testimonial->message)) ?>
								</p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
				<?php if (count($validatedTestimonials) > 1): ?>
					<div>
						<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleRide"
							data-bs-slide="prev">
							<span class="carousel-control-prev-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Previous</span>
						</button>
						<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleRide"
							data-bs-slide="next">
							<span class="carousel-control-next-icon" aria-hidden="true"></span>
							<span class="visually-hidden">Next</span>
						</button>
					</div>
				<?php endif; ?>
			</div>
		<?php else: ?>
			<div class="testimony__item">
				<p class="testimony__text text-center text-muted">
					No testimonials available yet. Be the first to share your experience!
				</p>
			</div>
		<?php endif; ?>
	</div>

	<div class="testimony__feedback testimony__container">
		<h2 class="testimony__title testimony__title--feedback">Write your feedback</h2>
		
		<!-- Success/Error Messages -->
		<?php if (isset($_GET['msg'])): ?>
			<div class="alert alert-<?= $_GET['msg'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert" style="margin-bottom: 1rem;">
				<?= htmlspecialchars($_GET['message'] ?? $_GET['error'] ?? '') ?>
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
			<script>
				// Clean URL parameters after 3 seconds or on click
				(function() {
					const cleanUrl = function() {
						if (window.location.search.includes('msg=')) {
							const url = new URL(window.location);
							url.searchParams.delete('msg');
							url.searchParams.delete('message');
							url.searchParams.delete('error');
							window.history.replaceState({}, '', url.pathname + (url.search ? url.search : ''));
						}
					};
					
					// Clean after 3 seconds
					setTimeout(cleanUrl, 3000);
					
					// Clean on click anywhere
					document.addEventListener('click', cleanUrl, { once: true });
				})();
			</script>
		<?php endif; ?>

		<form class="testimony__form" method="POST" action="/testimonials/pages/create" id="testimonyForm">
			<fieldset class="testimony__fieldset">
				<div class="testimony__field">
					<div class="testimony__rating-group">
						<label class="testimony__label" for="rating">Rating </span></label>
						<div id="rating" class="testimony__stars" style="margin-bottom: 10px;">
							<span class="testimony__star" data-value="1" style="cursor: pointer; color: #ccc; opacity: 0.5; font-size: 1.5rem; margin-right: 5px;" title="1 star">★</span>
							<span class="testimony__star" data-value="2" style="cursor: pointer; color: #ccc; opacity: 0.5; font-size: 1.5rem; margin-right: 5px;" title="2 stars">★</span>
							<span class="testimony__star" data-value="3" style="cursor: pointer; color: #ccc; opacity: 0.5; font-size: 1.5rem; margin-right: 5px;" title="3 stars">★</span>
							<span class="testimony__star" data-value="4" style="cursor: pointer; color: #ccc; opacity: 0.5; font-size: 1.5rem; margin-right: 5px;" title="4 stars">★</span>
							<span class="testimony__star" data-value="5" style="cursor: pointer; color: #ccc; opacity: 0.5; font-size: 1.5rem; margin-right: 5px;" title="5 stars">★</span>
						</div>
						<input type="hidden" name="rating" id="ratingInput">
						<label class="testimony__label" for="pseudo">Pseudo</label>
					</div>
					<input class="testimony__input" type="text" id="pseudo" name="pseudo" placeholder="Pseudo" maxlength="100" />
				</div>

				<div class="testimony__field testimony__field--message">
					<div class="testimony__message-group">
						<label class="testimony__label" for="message">Message</label>
						<br />
						<textarea class="testimony__textarea" id="message" name="message" rows="4"
							placeholder="Your message"></textarea>
						<br />
					</div>
					<button type="submit" class="btn intro__button intro__button--send">SEND</button>
				</div>
			</fieldset>
		</form>
	</div>
</section>

<script src="/build/js/rating-testimony.js" defer></script>
