<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Includes\Templates
 * 📂 Physical File:   includes/templates/footer.php
 * 
 * 📝 Description:
 * Footer component.
 * Legal information, hours and closing of HTML structure.
 */

$datecopy = date('d-m-Y');

?>

<footer class="footer">
	<section class="footer__hours" id="opening-hours">
		<div class="footer__location">
			<div class="footer__location-details">
				<p class="footer__city">BRETAGNE (35380)</p>
				<p class="footer__forest">FORÊT DE BROCÉLIANDE</p>
			</div>

			<div>
				<p class="footer__hours-title">HEURES D'OUVERTURE</p>

				<table class="footer__hours-table">
					<tbody>
						<?php
						// here we get the zoo opening hours dynamically
						$footerSchedules = getOpeningHours();
						foreach ($footerSchedules as $schedule):
						?>
							<tr class="footer__hours-row">
								<th class="footer__hours-header"><?= ucfirst($schedule->time_slot) ?>:</th>
								<td class="footer__hours-data">
									<?php if ($schedule->status === 'closed'): ?>
										Closed
									<?php else: ?>
										<?= substr($schedule->opening_time, 0, 5) ?> - <?= substr($schedule->closing_time, 0, 5) ?>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>


		</div>

		<!-- the image click redirect to top for this moment just exemple -->
		<a class="footer__logo-link" href="#top">
			<img class="footer__logo" src="/src/assets/images/logo-site-mobile.svg"
				alt="Logo del sitio - Volver al inicio">
		</a>
	</section>

	<div class="footer__copyright">
		
		<small>&copy; <?= $datecopy; ?> Arcadia ZOO | Designed By D.S.F</small>
	</div>
</footer>

<script src="/build/js/jquery.min.js" defer></script>
<script src="/build/js/bootstrap.bundle.min.js" defer></script>
<script src="/build/js/dataTables.min.js" defer></script>
<script src="/build/js/dataTables.bootstrap5.min.js" defer></script>
<script src="/build/js/app.js" defer></script>

</body>
</html> 
