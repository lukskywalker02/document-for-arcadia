<?php
// App/animals/views/gest/start.php
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Animals</h1>
        <?php 
            // Include functions to use hasPermission()
            require_once __DIR__ . '/../../../../includes/functions.php';
            
            // Only users with animals-create permission can create animals
            if (hasPermission('animals-create')): 
        ?>
            <a href="/animals/gest/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Animal
            </a>
        <?php endif; ?>
    </div>

    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message();
    ?>

    <!-- TABS NAVIGATION -->
    <ul class="nav nav-tabs mb-4" id="animalsTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="animals-tab" data-bs-toggle="tab" data-bs-target="#animals" type="button" role="tab">
                Animals
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="species-tab" data-bs-toggle="tab" data-bs-target="#species" type="button" role="tab">
                Species
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="categories-tab" data-bs-toggle="tab" data-bs-target="#categories" type="button" role="tab">
                Categories
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="nutrition-tab" data-bs-toggle="tab" data-bs-target="#nutrition" type="button" role="tab">
                Nutrition
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="feeding-tab" data-bs-toggle="tab" data-bs-target="#feeding" type="button" role="tab">
                Feeding Logs
            </button>
        </li>
    </ul>

    <!-- TABS CONTENT -->
    <div class="tab-content" id="animalsTabsContent">
        
        <!-- ANIMALS TAB -->
        <div class="tab-pane fade show active" id="animals" role="tabpanel">

    <!-- FILTERS -->
    <?php
    // Extract unique values for filters
    $uniqueSpeciesTypes = [];
    $uniqueHabitats = [];
    $uniqueGenders = [];
    $uniqueFullSpecies = [];
    
    if (!empty($animals)) {
        foreach ($animals as $animal) {
            // Extract species type from parentheses (e.g., "roller", "lizard")
            if (!empty($animal->specie_name) && preg_match('/\(([^)]+)\)/', $animal->specie_name, $matches)) {
                $type = trim($matches[1]);
                if (!in_array($type, $uniqueSpeciesTypes)) {
                    $uniqueSpeciesTypes[] = $type;
                }
            }
            
            // Extract full species name
            if (!empty($animal->specie_name) && !in_array($animal->specie_name, $uniqueFullSpecies)) {
                $uniqueFullSpecies[] = $animal->specie_name;
            }
            
            // Extract unique habitats
            if (!empty($animal->habitat_name) && $animal->habitat_name !== 'No habitat assigned' && !in_array($animal->habitat_name, $uniqueHabitats)) {
                $uniqueHabitats[] = $animal->habitat_name;
            }
            
            // Extract unique genders
            if (!empty($animal->gender) && !in_array($animal->gender, $uniqueGenders)) {
                $uniqueGenders[] = $animal->gender;
            }
        }
        sort($uniqueSpeciesTypes);
        sort($uniqueHabitats);
        sort($uniqueGenders);
        sort($uniqueFullSpecies);
    }
    ?>
    
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row g-3 mb-3">
                <div class="col-md-3">
                    <label for="filterSpeciesType" class="form-label fw-bold">Filter by Species Type:</label>
                    <select class="form-select" id="filterSpeciesType">
                        <option value="">All types...</option>
                        <?php foreach ($uniqueSpeciesTypes as $type): ?>
                            <option value="<?= htmlspecialchars($type) ?>"><?= htmlspecialchars(ucfirst($type)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterGender" class="form-label fw-bold">Filter by Gender:</label>
                    <select class="form-select" id="filterGender">
                        <option value="">All genders...</option>
                        <?php foreach ($uniqueGenders as $gender): ?>
                            <option value="<?= htmlspecialchars($gender) ?>"><?= htmlspecialchars(ucfirst($gender)) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterHabitat" class="form-label fw-bold">Filter by Habitat:</label>
                    <select class="form-select" id="filterHabitat">
                        <option value="">All habitats...</option>
                        <?php foreach ($uniqueHabitats as $habitat): ?>
                            <option value="<?= htmlspecialchars($habitat) ?>"><?= htmlspecialchars($habitat) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="animalsTable" class="table table-hover align-middle dataTable">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Species</th>
                            <th>Category</th>
                            <th>Habitat</th>
                            <th>Gender</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($animals)): ?>
                            <?php foreach ($animals as $animal): ?>
                                <tr>
                                    <!-- ID Column -->
                                    <td class="fw-bold text-muted" data-order="<?= $animal->id_full_animal ?? 0 ?>">#<?= $animal->id_full_animal ?? 'N/A' ?></td>

                                    <!-- Image Column -->
                                    <td style="width: 80px;">
                                        <?php if (!empty($animal->media_path)): ?>
                                            <img src="<?= htmlspecialchars($animal->media_path) ?>" alt="Animal Photo" 
                                                 class="rounded" style="width: 60px; height: 60px; object-fit: cover;" loading="lazy">
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                                <i class="bi bi-image"></i>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                    
                                    <!-- Name -->
                                    <td class="fw-bold"><?= htmlspecialchars($animal->animal_name ?? 'N/A') ?></td>
                                    
                                    <!-- Species -->
                                    <td data-species-type="<?= !empty($animal->specie_name) && preg_match('/\(([^)]+)\)/', $animal->specie_name, $matches) ? htmlspecialchars(trim($matches[1])) : '' ?>" 
                                        data-full-species="<?= htmlspecialchars($animal->specie_name ?? 'N/A') ?>">
                                        <?= htmlspecialchars($animal->specie_name ?? 'N/A') ?>
                                    </td>
                                    
                                    <!-- Category -->
                                    <td><?= htmlspecialchars($animal->category_name ?? 'N/A') ?></td>
                                    
                                    <!-- Habitat -->
                                    <td data-habitat="<?= htmlspecialchars($animal->habitat_name ?? 'No habitat assigned') ?>">
                                        <?= htmlspecialchars($animal->habitat_name ?? 'No habitat assigned') ?>
                                    </td>
                                    
                                    <!-- Gender -->
                                    <td data-gender="<?= htmlspecialchars($animal->gender ?? 'N/A') ?>">
                                        <?= htmlspecialchars($animal->gender ?? 'N/A') ?>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="text-end">
                                        <?php 
                                            // Only users with animals-edit permission can edit animals
                                            if (hasPermission('animals-edit')): 
                                        ?>
                                            <a href="/animals/gest/edit?id=<?= $animal->id_full_animal ?>" class="btn btn-sm btn-warning me-1">
                                                <i>edit</i>
                                            </a>
                                        <?php endif; ?>
                                        
                                        <?php 
                                            // Only users with animals-delete permission can delete animals
                                            if (hasPermission('animals-delete')): 
                                        ?>
                                            <a href="/animals/gest/delete?id=<?= $animal->id_full_animal ?>" 
                                               class="btn btn-sm btn-danger"
                                               onclick="return confirm('Are you sure you want to delete this animal?');">
                                                <i>delete</i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    No animals found. Click "Create New Animal" to add one.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        </div>

        <!-- SPECIES TAB -->
        <div class="tab-pane fade" id="species" role="tabpanel">
            <?php if (hasPermission('animals-create')): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Create New Species</h5>
                </div>
                <div class="card-body">
                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form action="/animals/gest/saveSpecies" method="POST" class="row g-3">
                        <?= csrf_field('animal_save_species') ?>
                        <div class="col-md-5">
                            <label for="specie_name" class="form-label fw-bold">Species Name (Scientific)</label>
                            <input type="text" class="form-control" id="specie_name" name="specie_name" 
                                   placeholder="E.g., Panthera leo, Giraffa camelopardalis" required>
                            <div class="form-text">Enter the scientific name of the species.</div>
                        </div>
                        <div class="col-md-5">
                            <label for="category_id" class="form-label fw-bold">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="" disabled selected>Select a category...</option>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $cat): ?>
                                        <option value="<?= $cat->id_category ?>">
                                            <?= htmlspecialchars($cat->category_name) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option disabled>No categories available. Create one first!</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-plus-circle"></i> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Existing Species</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Species Name</th>
                                    <th>Category</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($species)): ?>
                                    <?php foreach ($species as $specie): ?>
                                        <tr>
                                            <td class="fw-bold text-muted">#<?= $specie->id_specie ?></td>
                                            <td class="fw-bold"><?= htmlspecialchars($specie->specie_name) ?></td>
                                            <td><?= htmlspecialchars($specie->category_name ?? 'N/A') ?></td>
                                            <td class="text-end">
                                                <?php if (hasPermission('animals-edit')): ?>
                                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                                        onclick="editSpecies(<?= $specie->id_specie ?>, '<?= htmlspecialchars($specie->specie_name, ENT_QUOTES) ?>', <?= $specie->category_id ?>)">
                                                    <i>edit</i>
                                                </button>
                                                <?php endif; ?>
                                                <?php if (hasPermission('animals-delete')): ?>
                                                <a href="/animals/gest/deleteSpecies?id=<?= $specie->id_specie ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Are you sure? This will delete all animals of this species!');">
                                                    <i>delete</i>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            No species found. Create one above.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- CATEGORIES TAB -->
        <div class="tab-pane fade" id="categories" role="tabpanel">
            <?php if (hasPermission('animals-create')): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Create New Category</h5>
                </div>
                <div class="card-body">
                    <form action="/animals/gest/saveCategory" method="POST" class="row g-3">
                        <?= csrf_field('animal_save_category') ?>
                        <div class="col-md-10">
                            <label for="category_name" class="form-label fw-bold">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="category_name" 
                                   placeholder="E.g., Mammal, Bird, Reptile, Fish" required>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-success w-100">
                                <i class="bi bi-plus-circle"></i> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Existing Categories</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Category Name</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($categories)): ?>
                                    <?php foreach ($categories as $category): ?>
                                        <tr>
                                            <td class="fw-bold text-muted">#<?= $category->id_category ?></td>
                                            <td class="fw-bold"><?= htmlspecialchars($category->category_name) ?></td>
                                            <td class="text-end">
                                                <?php if (hasPermission('animals-edit')): ?>
                                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                                        onclick="editCategory(<?= $category->id_category ?>, '<?= htmlspecialchars($category->category_name, ENT_QUOTES) ?>')">
                                                    <i>edit</i>
                                                </button>
                                                <?php endif; ?>
                                                <?php if (hasPermission('animals-delete')): ?>
                                                <a href="/animals/gest/deleteCategory?id=<?= $category->id_category ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Are you sure? This will delete all species and animals in this category!');">
                                                    <i>delete</i>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">
                                            No categories found. Create one above.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- NUTRITION TAB -->
        <div class="tab-pane fade" id="nutrition" role="tabpanel">
            <?php if (hasPermission('animals-create')): ?>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Create New Nutrition Plan</h5>
                </div>
                <div class="card-body">
                    <form action="/animals/gest/saveNutrition" method="POST" class="row g-3">
                        <?= csrf_field('animal_save_nutrition') ?>
                        <div class="col-md-4">
                            <label for="nutrition_type" class="form-label fw-bold">Nutrition Type</label>
                            <select class="form-select" id="nutrition_type" name="nutrition_type" required>
                                <option value="" disabled selected>Select type...</option>
                                <option value="carnivorous">Carnivorous</option>
                                <option value="herbivorous">Herbivorous</option>
                                <option value="omnivorous">Omnivorous</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="food_type" class="form-label fw-bold">Food Type</label>
                            <select class="form-select" id="food_type" name="food_type" required>
                                <option value="" disabled selected>Select food...</option>
                                <option value="meat">Meat</option>
                                <option value="fruit">Fruit</option>
                                <option value="legumes">Legumes</option>
                                <option value="insect">Insect</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="food_qtty" class="form-label fw-bold">Quantity (grams)</label>
                            <input type="number" class="form-control" id="food_qtty" name="food_qtty" 
                                   min="1" step="1" placeholder="e.g., 5000" required>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            <button type="submit" class="btn btn-info text-white w-100">
                                <i class="bi bi-plus-circle"></i> Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <?php endif; ?>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="mb-3">Existing Nutrition Plans</h5>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Nutrition Type</th>
                                    <th>Food Type</th>
                                    <th>Quantity (g)</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($nutritions)): ?>
                                    <?php foreach ($nutritions as $nutrition): ?>
                                        <tr>
                                            <td class="fw-bold text-muted">#<?= $nutrition->id_nutrition ?></td>
                                            <td class="fw-bold"><?= htmlspecialchars(ucfirst($nutrition->nutrition_type)) ?></td>
                                            <td><?= htmlspecialchars(ucfirst($nutrition->food_type)) ?></td>
                                            <td><?= number_format($nutrition->food_qtty) ?>g</td>
                                            <td class="text-end">
                                                <?php if (hasPermission('animals-edit')): ?>
                                                <button type="button" class="btn btn-sm btn-warning me-1" 
                                                        onclick="editNutrition(<?= $nutrition->id_nutrition ?>, '<?= htmlspecialchars($nutrition->nutrition_type, ENT_QUOTES) ?>', '<?= htmlspecialchars($nutrition->food_type, ENT_QUOTES) ?>', <?= $nutrition->food_qtty ?>)">
                                                    <i>edit</i>
                                                </button>
                                                <?php endif; ?>
                                                <?php if (hasPermission('animals-delete')): ?>
                                                <a href="/animals/gest/deleteNutrition?id=<?= $nutrition->id_nutrition ?>" 
                                                   class="btn btn-sm btn-danger"
                                                   onclick="return confirm('Are you sure? This will remove this nutrition plan from all animals using it!');">
                                                    <i>delete</i>
                                                </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            No nutrition plans found. Create one above.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- FEEDING LOGS TAB -->
        <div class="tab-pane fade" id="feeding" role="tabpanel">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Feeding Logs Management</h5>
                <?php if (hasPermission('animal_feeding-assign')): ?>
                    <a href="/animals/feeding/create" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Record New Feeding
                    </a>
                <?php endif; ?>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 50px;">ID</th>
                                    <th>Animal</th>
                                    <th>Food Type</th>
                                    <th>Quantity (g)</th>
                                    <th>Plan Base</th>
                                    <th>Difference</th>
                                    <th>Fed By</th>
                                    <th>Date & Time</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($feedings)): ?>
                                    <?php foreach ($feedings as $feeding): ?>
                                        <tr>
                                            <!-- ID Column -->
                                            <td class="fw-bold text-muted">#<?= $feeding->id_feeding_log ?? 'N/A' ?></td>

                                            <!-- Animal Name -->
                                            <td class="fw-bold">
                                                <a href="/animals/feeding/view?animal_id=<?= $feeding->animal_f_id ?>" class="text-decoration-none">
                                                    <?= htmlspecialchars($feeding->animal_name ?? 'N/A') ?>
                                                </a>
                                            </td>

                                            <!-- Food Type -->
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= htmlspecialchars(ucfirst($feeding->food_type ?? 'N/A')) ?>
                                                </span>
                                            </td>

                                            <!-- Quantity Given -->
                                            <td class="fw-bold"><?= number_format($feeding->food_qtty ?? 0) ?>g</td>

                                            <!-- Plan Base (from nutrition) -->
                                            <td>
                                                <?php if ($feeding->plan_food_qtty): ?>
                                                    <span class="text-muted">
                                                        <?= number_format($feeding->plan_food_qtty) ?>g
                                                        <small class="d-block text-muted">(<?= htmlspecialchars(ucfirst($feeding->plan_food_type ?? 'N/A')) ?>)</small>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">No plan assigned</span>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Difference (Real vs Plan) -->
                                            <td>
                                                <?php if ($feeding->plan_food_qtty): ?>
                                                    <?php 
                                                        $diff = $feeding->food_qtty - $feeding->plan_food_qtty;
                                                        $diffPercent = $feeding->plan_food_qtty > 0 ? round(($diff / $feeding->plan_food_qtty) * 100, 1) : 0;
                                                    ?>
                                                    <?php if ($diff > 0): ?>
                                                        <span class="badge bg-warning text-dark">
                                                            +<?= number_format($diff) ?>g (+<?= abs($diffPercent) ?>%)
                                                        </span>
                                                    <?php elseif ($diff < 0): ?>
                                                        <span class="badge bg-danger">
                                                            <?= number_format($diff) ?>g (<?= abs($diffPercent) ?>%)
                                                        </span>
                                                    <?php else: ?>
                                                        <span class="badge bg-success">
                                                            Exact (0%)
                                                        </span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Fed By (User) -->
                                            <td>
                                                <?= htmlspecialchars($feeding->fed_by_username ?? 'Unknown') ?>
                                            </td>

                                            <!-- Date & Time -->
                                            <td>
                                                <?php 
                                                    $date = new DateTime($feeding->food_date);
                                                    echo $date->format('Y-m-d H:i');
                                                ?>
                                            </td>

                                            <!-- Actions -->
                                            <td class="text-end">
                                                <a href="/animals/feeding/view?animal_id=<?= $feeding->animal_f_id ?>" 
                                                   class="btn btn-sm btn-outline-primary me-1" 
                                                   title="View all feedings for this animal">
                                                    <i class="bi bi-eye">view</i>
                                                </a>
                                                <?php if (hasPermission('animal_feeding-delete') || hasPermission('animal_feeding-assign')): ?>
                                                    <a href="/animals/feeding/delete?id=<?= $feeding->id_feeding_log ?>" 
                                                       class="btn btn-sm btn-outline-danger" 
                                                       onclick="return confirm('Are you sure you want to delete this feeding log?')"
                                                       title="Delete">
                                                        <i class="bi bi-trash">delete</i>
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox"></i> No feeding logs found.
                                            <?php if (hasPermission('animal_feeding-assign')): ?>
                                                <a href="/animals/feeding/create">Create the first one!</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Modals (Hidden Forms) -->
<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/animals/gest/saveCategory" method="POST">
                <?= csrf_field('animal_save_category') ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_category_id" name="id_category">
                    <div class="mb-3">
                        <label for="edit_category_name" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="edit_category_name" name="category_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Species Modal -->
<div class="modal fade" id="editSpeciesModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/animals/gest/saveSpecies" method="POST">
                <?= csrf_field('animal_save_species') ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Species</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_specie_id" name="id_specie">
                    <div class="mb-3">
                        <label for="edit_specie_name" class="form-label">Species Name</label>
                        <input type="text" class="form-control" id="edit_specie_name" name="specie_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_specie_category_id" class="form-label">Category</label>
                        <select class="form-select" id="edit_specie_category_id" name="category_id" required>
                            <option value="" disabled>Select a category...</option>
                            <?php if (!empty($categories)): ?>
                                <?php foreach ($categories as $cat): ?>
                                    <option value="<?= $cat->id_category ?>">
                                        <?= htmlspecialchars($cat->category_name) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Nutrition Modal -->
<div class="modal fade" id="editNutritionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="/animals/gest/saveNutrition" method="POST">
                <?= csrf_field('animal_save_nutrition') ?>
                <div class="modal-header">
                    <h5 class="modal-title">Edit Nutrition Plan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edit_nutrition_id" name="id_nutrition">
                    <div class="mb-3">
                        <label for="edit_nutrition_type" class="form-label">Nutrition Type</label>
                        <select class="form-select" id="edit_nutrition_type" name="nutrition_type" required>
                            <option value="carnivorous">Carnivorous</option>
                            <option value="herbivorous">Herbivorous</option>
                            <option value="omnivorous">Omnivorous</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_food_type" class="form-label">Food Type</label>
                        <select class="form-select" id="edit_food_type" name="food_type" required>
                            <option value="meat">Meat</option>
                            <option value="fruit">Fruit</option>
                            <option value="legumes">Legumes</option>
                            <option value="insect">Insect</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_food_qtty" class="form-label">Quantity (grams)</label>
                        <input type="number" class="form-control" id="edit_food_qtty" name="food_qtty" 
                               min="1" step="1" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info text-white">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function editCategory(id, name) {
    document.getElementById('edit_category_id').value = id;
    document.getElementById('edit_category_name').value = name;
    new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
}

function editSpecies(id, name, categoryId) {
    document.getElementById('edit_specie_id').value = id;
    document.getElementById('edit_specie_name').value = name;
    document.getElementById('edit_specie_category_id').value = categoryId;
    new bootstrap.Modal(document.getElementById('editSpeciesModal')).show();
}

function editNutrition(id, nutritionType, foodType, foodQty) {
    document.getElementById('edit_nutrition_id').value = id;
    document.getElementById('edit_nutrition_type').value = nutritionType;
    document.getElementById('edit_food_type').value = foodType;
    document.getElementById('edit_food_qtty').value = foodQty;
    new bootstrap.Modal(document.getElementById('editNutritionModal')).show();
}

// DataTables Configuration with Custom Filters - LITERAL copy from animals-filter.js
// Wait for all scripts to load (including DataTables)
window.addEventListener('load', function() {
    // Double check jQuery and DataTables are available
    if (typeof jQuery === 'undefined' || typeof jQuery.fn.DataTable === 'undefined') {
        console.error('jQuery or DataTables not loaded!');
        return;
    }
    
    const $ = jQuery;
    const table = $('#animalsTable');
    
    if (table.length) {
        // Get existing DataTable instance or initialize
        let dataTable;
        if ($.fn.DataTable.isDataTable('#animalsTable')) {
            // Get existing instance
            dataTable = table.DataTable();
            // Reorder by ID if not already ordered
            dataTable.order([0, 'asc']).draw();
            console.log('Using existing DataTable instance');
        } else {
            // Initialize new instance
            dataTable = table.DataTable({
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, 100], [5, 10, 25, 50, 100]],
                responsive: true,
                order: [[0, "asc"]], // Order by ID column (first column) ascending
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "Showing 0 to 0 of 0 entries",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    zeroRecords: "No matching records found",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: [1, 7] }, // Photo and Actions columns not sortable
                    { type: 'num', targets: [0] } // ID column should be sorted as numbers (uses data-order attribute)
                ]
            });
            console.log('DataTables initialized');
        }

        // Custom filter function - LITERAL copy from animals-filter.js lines 5-45
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                // Only apply to animalsTable
                const tableId = $(settings.nTable).attr('id');
                if (tableId !== 'animalsTable') {
                    return true;
                }
                
                // Get filter values - LITERAL from animals-filter.js line 6-10
                const specie = $('#filterSpeciesType').val().toLowerCase();
                const habitat = $('#filterHabitat').val().toLowerCase();
                const gender = $('#filterGender').val().toLowerCase();
                
                // Get the row node
                const api = new $.fn.dataTable.Api(settings);
                const row = api.row(dataIndex).node();
                
                if (!row) {
                    return true;
                }
                
                const $row = $(row);
                
                // Get data from cells - LITERAL from animals-filter.js line 16-19
                const speciesCell = $row.find('td').eq(3);
                const habitatCell = $row.find('td').eq(5);
                const genderCell = $row.find('td').eq(6);
                
                const articleSpecie = speciesCell.data('full-species') || '';
                const articleHabitat = habitatCell.data('habitat') || '';
                const articleGender = genderCell.data('gender') || '';
                
                let show = true;

                // Filter by specie (extract value from parentheses and compare) - LITERAL from animals-filter.js line 24-29
                if (specie) {
                    const specieMatch = articleSpecie.match(/\(([^)]+)\)/);
                    const articleSpecieType = specieMatch ? specieMatch[1].toLowerCase().trim() : '';
                    if (articleSpecieType !== specie.toLowerCase()) {
                        show = false;
                    }
                }

                // Filter by habitat - LITERAL from animals-filter.js line 33-35
                if (show && habitat && articleHabitat.toLowerCase().indexOf(habitat) === -1) {
                    show = false;
                }

                // Filter by gender - exact match (not partial like habitat)
                if (show && gender) {
                    if (articleGender.toLowerCase().trim() !== gender.trim()) {
                        show = false;
                    }
                }

                return show;
            }
        );
        
        console.log('Filter function added');

        // Add event listeners to filters - LITERAL from animals-filter.js line 202
        $('#filterSpeciesType, #filterGender, #filterHabitat').off('change').on('change', function() {
            console.log('Filter changed:', $(this).attr('id'), $(this).val());
            dataTable.draw();
        });
        
        console.log('Event listeners added');
    }
});
</script>