<?php
// Define the structure of our categories and the prefixes that belong to them.
$permissionStructure = [
    '🔑 Account Management' => ['users', 'roles'],
    '🎪 Zoo Management' => ['services', 'schedules', 'habitats', 'hero', 'bricks'],
    '🐼 Animal Management' => ['animals', 'animal_stats', 'animal_feeding'],
    '⚕️ Veterinary' => ['vet_reports', 'habitat_suggestions'],
    '💬 Public Interaction' => ['testimonials']
];

// Initialize the array to hold the grouped permissions, with keys for each category.
$groupedPermissions = array_fill_keys(array_keys($permissionStructure), []);

// Group permissions based on the defined structure.
foreach ($permissions as $permission) {
    $permissionPrefix = explode('-', $permission['permission_name'])[0];
    $found = false;
    foreach ($permissionStructure as $categoryName => $prefixes) {
        if (in_array($permissionPrefix, $prefixes)) {
            $groupedPermissions[$categoryName][] = $permission;
            $found = true;
            break; // Move to the next permission once categorized.
        }
    }
    // Optional: Handle permissions that don't match any category.
    if (!$found) {
        if (!isset($groupedPermissions['Others'])) {
            $groupedPermissions['Others'] = [];
        }
        $groupedPermissions['Others'][] = $permission;
    }
}
?>

<div class="container-fluid overflow-auto py-4 pt-4 px-4">
    <div class="row py-4 card">
        <div class="col-12">
            <div class="rounded h-100 p-4" style="background-color: #c3c1c8;">
                <h1 class="h3">System Permissions Catalog</h1>
                <p class="mb-4">
                    This is a list of all possible actions within the system.
                    It cannot be edited here; it serves as a reference dictionary.
                </p>
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <table class="table mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">ID</th>
                                    <th scope="col" style="width: 40%;" class="ps-4">Permission</th>
                                    <th scope="col">Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $rowNumber = 0; ?>
                                <?php foreach ($groupedPermissions as $categoryName => $permissionsInCategory): ?>
                                    <?php if (empty($permissionsInCategory)) continue; ?>
                                    <tr>

                                        <td colspan="3" class="table-dark fw-bold ps-4">
                                            <?= htmlspecialchars($categoryName) ?>
                                        </td>
                                    </tr>
                                    <?php foreach ($permissionsInCategory as $permission): ?>
                                        <?php
                                        $rowNumber++;
                                        $prettyName = ucwords(str_replace(['-', '_'], ' ', $permission['permission_name']));
                                        ?>
                                        <tr class="<?php echo get_row_class($rowNumber); ?>">


                                            <td class="text-nowrap <?php echo get_cell_border_class($rowNumber); ?>">#<?php echo $permission['id_permission']; ?></td>
                                            <td class="ps-4">
                                                <strong>
                                                    <?= htmlspecialchars($prettyName) ?>
                                                </strong>
                                                <!-- (<code>
                                                    <?= htmlspecialchars($permission['permission_name']) ?>
                                                </code>) -->
                                            </td>
                                            <td>
                                                <?= htmlspecialchars($permission['permission_desc']) ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>