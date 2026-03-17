<?php
/**
 * PARTIAL: HERO SECTION (Dynamic)
 * ------------------------------
 * Requires variables: $hero (Object) and $slides (Array) to be defined before inclusion.
 */
?>

<?php if (isset($hero) && $hero): ?>
    
    <?php if ($hero->has_sliders && !empty($slides)): ?>
        <!-- CAROUSEL MODE -->
        <header class="hero hero-carousel hero--<?= htmlspecialchars($hero->page_name) ?>">
            
            <div class="hero__container">
                <!-- In Carousel mode, we might NOT want the main hero title/subtitle, as slides have their own captions.
                     But we KEEP the Opening Hours button container for layout consistency. -->
                
                <?php if ($hero->page_name === 'home'): // Special case: Home might want the title even with carousel? Or remove this IF to apply globally ?>
                    <div class="hero__text">
                        <h1 class="hero__title"><?= htmlspecialchars($hero->hero_title) ?></h1>
                        <?php if (!empty($hero->hero_subtitle)): ?>
                            <p class="hero__subtitle"><?= htmlspecialchars($hero->hero_subtitle) ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <a type="button" class="btn intro__button intro__button--hours" href="#opening-hours">opening hours</a>
            </div>

            <div id="heroCarousel" class="carousel carousel-fade slide" data-bs-ride="true">
                <div class="carousel-indicators">
                    <?php foreach ($slides as $index => $slide): ?>
                        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?= $index ?>" 
                                class="<?= $index === 0 ? 'active' : '' ?>" aria-current="<?= $index === 0 ? 'true' : 'false' ?>" 
                                aria-label="Slide <?= $index + 1 ?>"></button>
                    <?php endforeach; ?>
                </div>

                <div class="carousel-inner">
                    <?php foreach ($slides as $index => $slide): ?>
                        <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <picture>
                                <!-- Desktop Source -->
                                <source 
                                    srcset="<?= !empty($slide->media_path_large) ? htmlspecialchars($slide->media_path_large) : getCloudinaryUrl($slide->media_path, 'w_1280,c_scale,q_auto,f_auto') ?>" 
                                    media="(min-width: 1280px)" />
                                
                                <!-- Tablet Source -->
                                <source 
                                    srcset="<?= !empty($slide->media_path_medium) ? htmlspecialchars($slide->media_path_medium) : getCloudinaryUrl($slide->media_path, 'w_744,c_scale,q_auto,f_auto') ?>" 
                                    media="(min-width: 744px)" />
                                
                                <!-- Mobile Image (Base) -->
                                <img 
                                    src="<?= !empty($slide->media_path) ? htmlspecialchars($slide->media_path) : '' ?>"
                                    class="hero__image d-block img-fluid" 
                                    alt="<?= htmlspecialchars($slide->title_caption) ?>"
                                    <?= $index === 0 ? '' : 'loading="lazy"' ?> />
                            </picture>
                            
                            <div class="carousel-caption d-none d-md-block">
                                <h4 class="carousel-caption__title"><?= htmlspecialchars($slide->title_caption) ?></h4>
                                <p><?= htmlspecialchars($slide->description_caption) ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="controls-carousel">
                    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </header>

    <?php else: ?>
        <!-- SINGLE IMAGE MODE -->
        <header class="hero hero--<?= htmlspecialchars($hero->page_name) ?>">
            <div class="hero__container">
                <div class="hero__text">
                    <h1 class="hero__title"><?= htmlspecialchars($hero->hero_title) ?></h1>
                    <?php if (!empty($hero->hero_subtitle)): ?>
                        <p class="hero__subtitle"><?= htmlspecialchars($hero->hero_subtitle) ?></p>
                    <?php endif; ?>
                </div>
                <a type="button" class="btn intro__button intro__button--hours" href="#opening-hours">opening hours</a>
            </div>

            <?php if (!empty($hero->media_path)): ?>
                <picture>
                    <!-- Desktop Source -->
                    <source 
                        srcset="<?= !empty($hero->media_path_large) ? htmlspecialchars($hero->media_path_large) : getCloudinaryUrl($hero->media_path, 'w_1280,c_scale,q_auto,f_auto') ?>" 
                        media="(min-width: 1280px)" />
                    
                    <!-- Tablet Source -->
                    <source 
                        srcset="<?= !empty($hero->media_path_medium) ? htmlspecialchars($hero->media_path_medium) : getCloudinaryUrl($hero->media_path, 'w_744,c_scale,q_auto,f_auto') ?>" 
                        media="(min-width: 744px)" />
                    
                    <!-- Mobile Image (Base) -->
                    <img 
                        src="<?= htmlspecialchars($hero->media_path) ?>"
                        class="hero__image d-block" 
                        alt="hero image" />
                </picture>
            <?php endif; ?>
        </header>
    <?php endif; ?>

<?php else: ?>
    <!-- FALLBACK -->
    <header class="hero">
        <div class="hero__container">
            <div class="hero__text">
                <h1 class="hero__title">zoo arcadia</h1>
                <p class="hero__subtitle">Where all animals love to live</p>
            </div>
            <a type="button" class="btn intro__button intro__button--hours" href="#opening-hours">opening hours</a>
        </div>
    </header>
<?php endif; ?>
