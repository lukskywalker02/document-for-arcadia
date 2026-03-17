<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Record New Feeding</h1>
        <a href="/animals/feeding/start" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Back to List
        </a>
    </div>

    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message();
    ?>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card shadow-sm">
                <div class="card-body">
                    <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
                    
                    <form method="POST" action="/animals/feeding/save">
                        <?= csrf_field('feeding_save') ?>
                        
                        <!-- Animal Selection -->
                        <div class="mb-3">
                            <label for="animal_f_id" class="form-label fw-bold">Animal <span class="text-danger">*</span></label>
                            <select class="form-select" id="animal_f_id" name="animal_f_id" required>
                                <option value="">-- Select an animal --</option>
                                <?php if (!empty($animals)): ?>
                                    <?php foreach ($animals as $animal): ?>
                                        <option value="<?= $animal->id_full_animal ?>" 
                                                data-nutrition-type="<?= htmlspecialchars($animal->nutrition_type ?? '') ?>"
                                                data-plan-food-type="<?= htmlspecialchars($animal->nutrition_food_type ?? '') ?>"
                                                data-plan-food-qtty="<?= $animal->nutrition_food_qtty ?? 0 ?>">
                                            <?= htmlspecialchars($animal->animal_name ?? 'N/A') ?> 
                                            (<?= htmlspecialchars($animal->specie_name ?? 'N/A') ?>)
                                            <?php if ($animal->nutrition_id): ?>
                                                - Plan: <?= htmlspecialchars(ucfirst($animal->nutrition_type ?? '')) ?> 
                                                (<?= htmlspecialchars(ucfirst($animal->nutrition_food_type ?? '')) ?>: <?= number_format($animal->nutrition_food_qtty ?? 0) ?>g)
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <small class="form-text text-muted">Select the animal that was fed.</small>
                        </div>

                        <!-- Nutrition Plan Info (Dynamic) -->
                        <div id="nutrition-plan-info" class="alert alert-info" style="display: none;">
                            <strong>Nutrition Plan:</strong>
                            <span id="plan-details"></span>
                        </div>

                        <!-- Food Type -->
                        <div class="mb-3">
                            <label for="food_type" class="form-label fw-bold">Food Type <span class="text-danger">*</span></label>
                            <select class="form-select" id="food_type" name="food_type" required>
                                <option value="">-- Select food type --</option>
                                <option value="meat">Meat</option>
                                <option value="fruit">Fruit</option>
                                <option value="legumes">Legumes</option>
                                <option value="insect">Insect</option>
                            </select>
                            <small class="form-text text-muted">Type of food that was given to the animal.</small>
                        </div>

                        <!-- Food Quantity -->
                        <div class="mb-3">
                            <label for="food_qtty" class="form-label fw-bold">Quantity (grams) <span class="text-danger">*</span></label>
                            <input type="number" 
                                   class="form-control" 
                                   id="food_qtty" 
                                   name="food_qtty" 
                                   min="1" 
                                   step="1" 
                                   required
                                   placeholder="Enter quantity in grams">
                            <small class="form-text text-muted">Amount of food given in grams.</small>
                            <div id="quantity-comparison" class="mt-2" style="display: none;">
                                <small class="text-muted">
                                    Plan: <span id="plan-quantity" class="fw-bold"></span>g | 
                                    Difference: <span id="quantity-diff" class="fw-bold"></span>
                                </small>
                            </div>
                        </div>

                        <!-- Food Date (Optional) -->
                        <div class="mb-3">
                            <label for="food_date" class="form-label fw-bold">Date & Time</label>
                            <input type="datetime-local" 
                                   class="form-control" 
                                   id="food_date" 
                                   name="food_date"
                                   value="<?= date('Y-m-d\TH:i') ?>">
                            <small class="form-text text-muted">Leave empty to use current date and time.</small>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="/animals/feeding/start" class="btn btn-outline-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Save Feeding Log
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Show nutrition plan info when animal is selected
document.getElementById('animal_f_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const nutritionType = selectedOption.getAttribute('data-nutrition-type');
    const planFoodType = selectedOption.getAttribute('data-plan-food-type');
    const planFoodQty = selectedOption.getAttribute('data-plan-food-qtty');
    
    const infoDiv = document.getElementById('nutrition-plan-info');
    const planDetails = document.getElementById('plan-details');
    
    if (nutritionType && planFoodType && planFoodQty) {
        planDetails.textContent = `${nutritionType.charAt(0).toUpperCase() + nutritionType.slice(1)} - ${planFoodType.charAt(0).toUpperCase() + planFoodType.slice(1)} (${parseInt(planFoodQty).toLocaleString()}g)`;
        infoDiv.style.display = 'block';
        
        // Pre-fill food type if available
        if (planFoodType) {
            document.getElementById('food_type').value = planFoodType;
        }
        
        // Show quantity comparison
        document.getElementById('plan-quantity').textContent = parseInt(planFoodQty).toLocaleString();
        document.getElementById('quantity-comparison').style.display = 'block';
    } else {
        infoDiv.style.display = 'none';
        document.getElementById('quantity-comparison').style.display = 'none';
    }
});

// Update quantity comparison in real-time
document.getElementById('food_qtty').addEventListener('input', function() {
    const selectedOption = document.getElementById('animal_f_id').options[document.getElementById('animal_f_id').selectedIndex];
    const planFoodQty = selectedOption.getAttribute('data-plan-food-qtty');
    const diffSpan = document.getElementById('quantity-diff');
    
    if (planFoodQty && this.value) {
        const diff = parseInt(this.value) - parseInt(planFoodQty);
        const diffPercent = planFoodQty > 0 ? Math.round((diff / planFoodQty) * 100) : 0;
        
        if (diff > 0) {
            diffSpan.textContent = `+${diff.toLocaleString()}g (+${Math.abs(diffPercent)}%)`;
            diffSpan.className = 'fw-bold text-warning';
        } else if (diff < 0) {
            diffSpan.textContent = `${diff.toLocaleString()}g (${Math.abs(diffPercent)}%)`;
            diffSpan.className = 'fw-bold text-danger';
        } else {
            diffSpan.textContent = '0g (0%)';
            diffSpan.className = 'fw-bold text-success';
        }
    }
});
</script>

