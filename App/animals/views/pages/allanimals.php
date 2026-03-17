<!-- <nav class="nav navbar"> -->

<?php include_once __DIR__ . '/../../../../includes/templates/hero.php'; ?>

<main>

    <nav class="filter">
        <div class="container-fluid">
            <a href="#">Open Filter</a>
            <button class="navbar-toggler bar-button" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                <i class="bi bi-filter-right"></i>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar"
                aria-labelledby="offcanvasNavbarLabel">
                <div class="offcanvas-header">
                    <h2 class="offcanvas-title" id="offcanvasNavbarLabel">Close Filter</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <form class="filter__container d-flex mt-3" role="search" id="filterForm">
                        <fieldset class="filter__fieldset">
                            <legend class="filter__legend">Filter by:</legend>
                            <div class="filter__legend-election">
                                <!-- Animal specie filter -->
                                <label for="filter-specie" class="filter__label">Animal specie:</label>
                                <select id="filter-specie" name="filter-specie" class="filter__select">
                                    <option value="">specie...</option>
                                    <?php if (!empty($species)): ?>
                                        <?php 
                                        // Extract unique values from parentheses
                                        $specieTypes = [];
                                        foreach ($species as $specie) {
                                            if (preg_match('/\(([^)]+)\)/', $specie->specie_name, $matches)) {
                                                $type = trim($matches[1]);
                                                if (!in_array($type, $specieTypes)) {
                                                    $specieTypes[] = $type;
                                                }
                                            }
                                        }
                                        sort($specieTypes);
                                        foreach ($specieTypes as $type): ?>
                                            <option value="<?= htmlspecialchars($type) ?>">
                                                <?= htmlspecialchars(ucfirst($type)) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                                <!-- Habitat filter -->
                                <label for="filter-habitat" class="filter__label">Habitat:</label>
                                <select id="filter-habitat" name="filter-habitat" class="filter__select">
                                    <option value="">habitat...</option>
                                    <?php if (!empty($habitats)): ?>
                                        <?php foreach ($habitats as $hab): ?>
                                            <option value="<?= htmlspecialchars($hab->habitat_name) ?>">
                                                <?= htmlspecialchars($hab->habitat_name) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                                <!-- Nutrition filter -->
                                <label for="filter-nutrition" class="filter__label">Nutrition:</label>
                                <select id="filter-nutrition" name="filter-nutrition" class="filter__select">
                                    <option value="">nutrition...</option>
                                    <?php if (!empty($nutritions)): ?>
                                        <?php 
                                        $uniqueNutritionTypes = [];
                                        foreach ($nutritions as $nutrition) {
                                            if (!in_array($nutrition->nutrition_type, $uniqueNutritionTypes)) {
                                                $uniqueNutritionTypes[] = $nutrition->nutrition_type;
                                            }
                                        }
                                        foreach ($uniqueNutritionTypes as $nutType): ?>
                                            <option value="<?= htmlspecialchars($nutType) ?>">
                                                <?= htmlspecialchars(ucfirst($nutType)) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                                <!-- State filter -->
                                <label for="filter-state" class="filter__label">state:</label>
                                <select id="filter-state" name="filter-state" class="filter__select">
                                    <option value="">state...</option>
                                    <?php if (isset($allowedStates) && !empty($allowedStates)): ?>
                                        <?php foreach ($allowedStates as $stateValue => $stateLabel): ?>
                                            <option value="<?= htmlspecialchars($stateValue) ?>">
                                                <?= htmlspecialchars($stateLabel) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>

                                <!-- Name filter -->
                                <label for="filter-name" class="filter__label">name:</label>
                                <input type="text" id="filter-name" name="filter-name" class="filter__select" placeholder="name">

                                <!-- Items per page filter -->
                                <label for="filter-per-page" class="filter__label">Show:</label>
                                <select id="filter-per-page" name="filter-per-page" class="filter__select">
                                    <option value="5">5</option>
                                    <option value="7">7</option>
                                    <option value="10" selected>10</option>
                                    <option value="15">15</option>
                                    <option value="20">20</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                            </div>

                            <!-- Restart button -->
                            <button type="reset" class="filter__button filter__button--reset" id="resetFilters">Restart</button>
                        </fieldset>
                    </form>
                </div>
                <div class="offcanvas-header">
                    <h2 class="offcanvas-title">Close Filter</h2>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
            </div>
        </div>
    </nav>

    <div class="intro">
        <?php if (!empty($animals)): ?>
            <?php foreach ($animals as $animal): ?>
                <article class="intro__article intro__animal" 
                         data-specie="<?= htmlspecialchars($animal->specie_name ?? '') ?>"
                         data-habitat="<?= htmlspecialchars($animal->habitat_name ?? '') ?>"
                         data-nutrition="<?= htmlspecialchars(strtolower($animal->nutrition_type ?? '')) ?>"
                         data-state="<?= htmlspecialchars(strtolower($animal->latest_health_state ?? '')) ?>"
                         data-name="<?= htmlspecialchars(strtolower($animal->animal_name ?? '')) ?>">
                    <a class="intro__link" href="/animals/pages/animalpicked?id=<?= $animal->id_full_animal ?>" target="_blank" rel="noopener noreferrer">
                        <?php if (!empty($animal->media_path)): ?>
                            <picture>
                                <source
                                    srcset="<?= !empty($animal->media_path_large) ? $animal->media_path_large : getCloudinaryUrl($animal->media_path, 'w_1280,c_scale,q_auto,f_auto') ?>"
                                    media="(min-width: 1280px)" />
                                <source
                                    srcset="<?= !empty($animal->media_path_medium) ? $animal->media_path_medium : getCloudinaryUrl($animal->media_path, 'w_744,c_scale,q_auto,f_auto') ?>"
                                    media="(min-width: 744px)" />
                                <img src="<?= getCloudinaryUrl($animal->media_path, 'w_400,c_scale,q_auto,f_auto') ?>"
                                    class="intro__image d-block img-fluid" alt="<?= htmlspecialchars($animal->animal_name) ?>" loading="lazy" />
                            </picture>
                        <?php else: ?>
                            <div class="intro__image bg-light d-flex align-items-center justify-content-center" style="min-height: 200px;">
                                <i class="bi bi-image" style="font-size: 3rem; color: #ccc;"></i>
                            </div>
                        <?php endif; ?>

                        <div class="intro__details">
                            <h3 class="intro__name"><?= htmlspecialchars($animal->animal_name ?? 'Unknown') ?></h3>
                            <p class="intro__classes"><?= htmlspecialchars($animal->specie_name ?? 'Unknown species') ?></p>
                            <p class="intro__habitat"><?= htmlspecialchars($animal->habitat_name ?? 'Unknown habitat') ?></p>
                        </div>
                    </a>
                </article>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="container text-center py-5">
                <p class="h3 text-muted">No animals found at the moment.</p>
            </div>
        <?php endif; ?>
    </div>

    <nav class="nav-pagination" id="paginationNav" style="display: none;">
        <ul class="nav-pagination__ul">
            <li class="nav-pagination__li">
                <a href="#" id="paginationPrev" aria-label="Previous">
                    <i class="bi bi-caret-left-fill"></i>
                </a>
            </li>
            <!-- Numbers will be generated dynamically here -->
            <li class="nav-pagination__li">
                <a href="#" id="paginationNext" aria-label="Next">
                    <i class="bi bi-caret-right-fill"></i>
                </a>
            </li>
        </ul>
    </nav>
</main>

<script src="/build/js/animals-filter.js" defer></script>