<?php
// App/habitats/views/pages/habitats.php
?>

<?php include_once __DIR__ . '/../../../../includes/templates/hero.php'; ?>

<main>
	<div class="intro intro--services">

        <?php if (!empty($habitats)): ?>
            <?php foreach($habitats as $habitat): ?>
                <section class="intro__section">
                    <h2 class="intro__title"><?= htmlspecialchars(strtoupper($habitat->habitat_name)) ?></h2>

                    <div class="intro__content">
                        <?php if (!empty($habitat->media_path)): ?>
                            <picture>
                                <source
                                    srcset="<?= !empty($habitat->media_path_large) ? $habitat->media_path_large : getCloudinaryUrl($habitat->media_path, 'w_1280,c_scale,q_auto,f_auto') ?>"
                                    media="(min-width: 1280px)" />
                                <source
                                    srcset="<?= !empty($habitat->media_path_medium) ? $habitat->media_path_medium : getCloudinaryUrl($habitat->media_path, 'w_744,c_scale,q_auto,f_auto') ?>"
                                    media="(min-width: 744px)" />
                                <img src="<?= getCloudinaryUrl($habitat->media_path, 'w_400,c_scale,q_auto,f_auto') ?>"
                                    class="intro__image d-block" alt="Image for <?= htmlspecialchars($habitat->habitat_name) ?>" loading="lazy" />
                            </picture>
                        <?php endif; ?>

                        <div class="intro__details">
                            <a class="btn intro__button intro__button--more" href="/habitats/pages/habitat1?id=<?= $habitat->id_habitat ?>">more</a>
                            <p class="intro__description"><?= htmlspecialchars($habitat->description_habitat ?? '') ?></p>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="container text-center py-5">
                <p class="h3 text-muted">No habitats are available at the moment.</p>
            </div>
        <?php endif; ?>

	</div>
</main>
