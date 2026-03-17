<?php include_once __DIR__ . '/../../../../includes/templates/hero.php'; ?>

<main>
	<div class="intro intro--services">

        <?php if (!empty($services)): ?>
            <?php foreach($services as $service): ?>
                <section class="intro__section">
                    <h2 class="intro__title"><?= htmlspecialchars($service->service_title) ?></h2>

                    <div class="intro__content">
                        <?php if (!empty($service->media_path)): ?>
                            <picture>
                                <source
                                    srcset="<?= getCloudinaryUrl($service->media_path, 'w_1280,c_scale,q_auto,f_auto') ?>"
                                    media="(min-width: 1280px)" />
                                <source
                                    srcset="<?= getCloudinaryUrl($service->media_path, 'w_744,c_scale,q_auto,f_auto') ?>"
                                    media="(min-width: 744px)" />
                                <img src="<?= getCloudinaryUrl($service->media_path, 'w_400,c_scale,q_auto,f_auto') ?>"
                                    class="intro__image d-block" alt="Image for <?= htmlspecialchars($service->service_title) ?>" loading="lazy" />
                            </picture>
                        <?php endif; ?>

                        <div class="intro__details">
                            <p class="intro__description"><?= nl2br(htmlspecialchars($service->service_description)) ?></p>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="container text-center py-5">
                <p class="h3 text-muted">No services are available at the moment.</p>
            </div>
        <?php endif; ?>

	</div>
</main>
