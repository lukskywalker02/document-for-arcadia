<!-- <nav class="nav navbar"> -->

<!-- HERO SECTION for animal picked page -->
<?php if (isset($animal) && $animal): ?>
<header class="hero">


	<!-- HERO TEXT for animal picked page animal name and its specie name -->
	<div class="hero__container">
		<div class="hero__text">
			<h1 class="hero__title"><?= htmlspecialchars(strtoupper($animal->animal_name ?? 'Unknown')) ?></h1>
			<p class="hero__subtitle"><?= htmlspecialchars($animal->specie_name ?? 'Unknown species') ?></p>
		</div>

		<a type="button" class="btn intro__button intro__button--hours" href="#opening-hours">opening hours</a>
	</div>

	
	<?php if (!empty($animal->media_path)): ?>
		<!-- ANIMAL IMAGE for animal picked page -->
		<picture>
			<source
				srcset="<?= !empty($animal->media_path_large) ? htmlspecialchars($animal->media_path_large) : getCloudinaryUrl($animal->media_path, 'w_1280,c_scale,q_auto,f_auto') ?>"
				media="(min-width: 1280px)" />
			<source
				srcset="<?= !empty($animal->media_path_medium) ? htmlspecialchars($animal->media_path_medium) : getCloudinaryUrl($animal->media_path, 'w_744,c_scale,q_auto,f_auto') ?>"
				media="(min-width: 744px)" />
			<img src="<?= getCloudinaryUrl($animal->media_path, 'w_400,c_scale,q_auto,f_auto') ?>"
				class="hero__image d-block" alt="<?= htmlspecialchars($animal->animal_name ?? 'Animal image') ?>" />
		</picture>
	<?php else: ?>
		<!-- ANIMAL IMAGE NOT FOUND for animal picked page -->
		<div class="hero__image bg-light d-flex align-items-center justify-content-center" style="min-height: 400px;">
			<i class="bi bi-image" style="font-size: 4rem; color: #ccc;"></i>
		</div>
	<?php endif; ?>
</header>
<?php endif; ?>












<?php if (isset($animal) && $animal): ?>
<main class="animal">

	<!-- Sección de Información del Animal -->
	<section class="animal__info animal__card">
		<h2 class="animal__title">Animal</h2>
		<table class="animal__table">
			<tbody>
				<tr class="animal__row">
					<th class="animal__header">Name:</th>
					<td class="animal__data"><?= htmlspecialchars($animal->animal_name ?? 'Unknown') ?></td>
				</tr>
				<tr class="animal__row">
					<th class="animal__header">gender:</th>
					<td class="animal__data"><?= htmlspecialchars($animal->gender ?? 'Unknown') ?></td>
				</tr>
				<tr class="animal__row">
					<th class="animal__header">Animal specie:</th>
					<td class="animal__data"><?= htmlspecialchars($animal->specie_name ?? 'Unknown species') ?></td>
				</tr>
				<tr class="animal__row">
					<th class="animal__header">Habitat:</th>
					<td class="animal__data"><?= htmlspecialchars($animal->habitat_name ?? 'Unknown habitat') ?></td>
				</tr>
			</tbody>
		</table>
	</section>
	<?php endif; ?>



	<!-- Sección de Información Adicional -->
	<?php if (isset($animal) && $animal): ?>
	<section class="animal__about animal__card">
		<h2 class="animal__title">About It</h2>
		<table class="animal__table">
			<tbody>
				<tr class="animal__row">
					<th class="animal__header">Nutrition:</th>
					<td class="animal__data">
						<?= !empty($animal->nutrition_type) ? htmlspecialchars(ucfirst($animal->nutrition_type)) : 'Not assigned' ?>
					</td>
				</tr>
				<tr class="animal__row">
					<th class="animal__header">Food Offered:</th>
					<td class="animal__data">
						<?php if (!empty($animal->nutrition_food_type)): ?>
							<?= htmlspecialchars(ucfirst($animal->nutrition_food_type)) ?>
						<?php else: ?>
							Not assigned
						<?php endif; ?>
					</td>
				</tr>
				<tr class="animal__row">
					<th class="animal__header">Food Qty:</th>
					<td class="animal__data">
						<?php if (!empty($animal->nutrition_food_qtty)): ?>
							<?= number_format($animal->nutrition_food_qtty / 1000, 1) ?>KG
						<?php else: ?>
							Not assigned
						<?php endif; ?>
					</td>
				</tr>
				<tr class="animal__row">
					<th class="animal__header">Date Of Check-Up:</th>
					<td class="animal__data">
						<?php if (isset($latestReport) && $latestReport && !empty($latestReport->review_date)): ?>
							<?= date('F j, Y', strtotime($latestReport->review_date)) ?>
						<?php else: ?>
							No Check-Up Recorded
						<?php endif; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</section>
	<?php endif; ?>



	<!-- Sección de Observación Veterinaria -->
	<?php if (isset($animal) && $animal): ?>
	<section class="animal__observation animal__card">
		<h2 class="animal__title">Veterinary Observation</h2>
		<?php if (isset($latestReport) && $latestReport && !empty($latestReport->vet_obs)): ?>
			<p class="animal__description"><?= htmlspecialchars($latestReport->vet_obs) ?></p>
		<?php else: ?>
			<p class="animal__description">No veterinary observations recorded yet.</p>
		<?php endif; ?>
		<table class="animal__table">
			<tbody>
				<tr class="animal__row">
					<th class="animal__header">Mood Animal:</th>
					<td class="animal__data">
						<?php if (isset($latestReport) && $latestReport && !empty($latestReport->hsr_state)): ?>
							<?= htmlspecialchars(ucfirst(str_replace('_', ' ', $latestReport->hsr_state))) ?>
						<?php else: ?>
							Not recorded
						<?php endif; ?>
					</td>
				</tr>
			</tbody>
		</table>
	</section>



	<!-- Sección de Detalles Opcionales -->
	<section class="animal__optional animal__card">
		<h2 class="animal__title">Optional Animal Details</h2>
		<?php if (isset($latestReport) && $latestReport && !empty($latestReport->opt_details)): ?>
			<p class="animal__description"><?= htmlspecialchars($latestReport->opt_details) ?></p>
		<?php else: ?>
			<p class="animal__description">No additional details available.</p>
		<?php endif; ?>
	</section>

</main>
<?php endif; ?>
