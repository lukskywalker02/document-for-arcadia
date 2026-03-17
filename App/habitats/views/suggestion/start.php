<?php
// App/habitats/views/suggestion/start.php
require_once __DIR__ . '/../../../../includes/helpers/csrf.php';

$userRoleName = $_SESSION['user']['role_name'] ?? null;
$isAdmin = ($userRoleName === 'Admin');
$isVeterinarian = ($userRoleName === 'Veterinary');
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><?= $isAdmin ? 'All Habitat Suggestions' : 'My Habitat Suggestions' ?></h1>
        <?php if ($isVeterinarian): ?>
            <a href="/habitats/suggestion/create" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Create New Suggestion
            </a>
        <?php endif; ?>
    </div>

    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message('Action completed successfully!', [
        'saved' => 'Suggestion created successfully!',
        'updated' => 'Suggestion updated successfully!',
        'reviewed' => 'Suggestion reviewed successfully!',
        'deleted' => 'Suggestion deleted successfully!'
    ]);
    ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Habitat</th>
                            <th>Details</th>
                            <th>Status</th>
                            <th>Suggested By</th>
                            <th>Proposed On</th>
                            <?php if ($isAdmin): ?>
                                <th>Reviewed By</th>
                                <th>Reviewed On</th>
                            <?php endif; ?>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($suggestions)): ?>
                            <?php foreach ($suggestions as $suggestion): ?>
                                <tr>
                                    <!-- ID Column -->
                                    <td class="fw-bold text-muted">#<?= $suggestion->id_hab_suggestion ?? 'N/A' ?></td>

                                    <!-- Habitat -->
                                    <td class="fw-bold"><?= htmlspecialchars($suggestion->habitat_name ?? 'N/A') ?></td>

                                    <!-- Details -->
                                    <td>
                                        <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                            <?= htmlspecialchars($suggestion->details ?? 'N/A') ?>
                                        </div>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-info mt-1" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#detailsModal<?= $suggestion->id_hab_suggestion ?>"
                                                title="View full details">
                                            <i class="bi bi-eye"></i> View
                                        </button>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <?php
                                            $status = $suggestion->status ?? 'pending';
                                            $badgeClass = '';
                                            if ($status === 'accepted') {
                                                $badgeClass = 'bg-success';
                                            } elseif ($status === 'rejected') {
                                                $badgeClass = 'bg-danger';
                                            } else {
                                                $badgeClass = 'bg-warning text-dark';
                                            }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>">
                                            <?= htmlspecialchars(ucfirst($status)) ?>
                                        </span>
                                    </td>

                                    <!-- Suggested By -->
                                    <td><?= htmlspecialchars($suggestion->suggested_by_username ?? 'Unknown') ?></td>

                                    <!-- Proposed On -->
                                    <td>
                                        <?php 
                                            $date = new DateTime($suggestion->proposed_on);
                                            echo $date->format('Y-m-d H:i');
                                        ?>
                                    </td>

                                    <?php if ($isAdmin): ?>
                                        <!-- Reviewed By -->
                                        <td>
                                            <?= htmlspecialchars($suggestion->reviewed_by_username ?? '-') ?>
                                        </td>

                                        <!-- Reviewed On -->
                                        <td>
                                            <?php 
                                                if ($suggestion->reviewed_on) {
                                                    $date = new DateTime($suggestion->reviewed_on);
                                                    echo $date->format('Y-m-d H:i');
                                                } else {
                                                    echo '-';
                                                }
                                            ?>
                                        </td>
                                    <?php endif; ?>

                                    <!-- Actions -->
                                    <td class="text-end">
                                        <?php if ($isVeterinarian && $suggestion->status === 'pending'): ?>
                                            <!-- Veterinarian can edit pending suggestions -->
                                            <a href="/habitats/suggestion/edit?id=<?= $suggestion->id_hab_suggestion ?>" 
                                               class="btn btn-sm btn-outline-warning me-1" 
                                               title="Edit">
                                                <i class="bi bi-pencil">edit</i>
                                            </a>
                                        <?php endif; ?>

                                        <?php if ($isAdmin && $suggestion->status === 'pending'): ?>
                                            <!-- Admin can accept/reject pending suggestions -->
                                            <form method="POST" action="/habitats/suggestion/review" class="d-inline me-1">
                                                <?= csrf_field('habitat_suggestion_review') ?>
                                                <input type="hidden" name="id_hab_suggestion" value="<?= $suggestion->id_hab_suggestion ?>">
                                                <input type="hidden" name="status" value="accepted">
                                                <button type="submit" class="btn btn-sm btn-success" title="Accept">
                                                    <i class="bi bi-check-circle">accept</i>
                                                </button>
                                            </form>
                                            <form method="POST" action="/habitats/suggestion/review" class="d-inline me-1">
                                                <?= csrf_field('habitat_suggestion_review') ?>
                                                <input type="hidden" name="id_hab_suggestion" value="<?= $suggestion->id_hab_suggestion ?>">
                                                <input type="hidden" name="status" value="rejected">
                                                <button type="submit" class="btn btn-sm btn-danger" title="Reject">
                                                    <i class="bi bi-x-circle">reject</i>
                                                </button>
                                            </form>
                                        <?php endif; ?>

                                        <?php 
                                            // Veterinarians can delete accepted/rejected (not pending)
                                            // Admins can delete only accepted/rejected (not pending - they must review first)
                                            $canDelete = false;
                                            if ($isAdmin && $suggestion->status !== 'pending') {
                                                $canDelete = true;
                                            } elseif ($isVeterinarian && $suggestion->status !== 'pending') {
                                                $canDelete = true;
                                            }
                                        ?>
                                        <?php if ($canDelete): ?>
                                            <a href="/habitats/suggestion/delete?id=<?= $suggestion->id_hab_suggestion ?>" 
                                               class="btn btn-sm btn-outline-danger" 
                                               onclick="return confirm('Are you sure you want to delete this suggestion?')"
                                               title="Delete">
                                                <i class="bi bi-trash">delete</i>
                                            </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="<?= $isAdmin ? '9' : '7' ?>" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox"></i> No suggestions found.
                                    <?php if ($isVeterinarian): ?>
                                        <a href="/habitats/suggestion/create">Create the first one!</a>
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

<!-- Details Modals -->
<?php if (!empty($suggestions)): ?>
    <?php foreach ($suggestions as $suggestion): ?>
        <div class="modal fade" id="detailsModal<?= $suggestion->id_hab_suggestion ?>" tabindex="-1" aria-labelledby="detailsModalLabel<?= $suggestion->id_hab_suggestion ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detailsModalLabel<?= $suggestion->id_hab_suggestion ?>">
                            Suggestion Details - <?= htmlspecialchars($suggestion->habitat_name ?? 'N/A') ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <strong>Status:</strong>
                            <?php
                                $status = $suggestion->status ?? 'pending';
                                $badgeClass = '';
                                if ($status === 'accepted') {
                                    $badgeClass = 'bg-success';
                                } elseif ($status === 'rejected') {
                                    $badgeClass = 'bg-danger';
                                } else {
                                    $badgeClass = 'bg-warning text-dark';
                                }
                            ?>
                            <span class="badge <?= $badgeClass ?> ms-2">
                                <?= htmlspecialchars(ucfirst($status)) ?>
                            </span>
                        </div>
                        <div class="mb-3">
                            <strong>Proposed On:</strong>
                            <?php 
                                $date = new DateTime($suggestion->proposed_on);
                                echo $date->format('Y-m-d H:i');
                            ?>
                        </div>
                        <?php if ($suggestion->reviewed_on): ?>
                            <div class="mb-3">
                                <strong>Reviewed On:</strong>
                                <?php 
                                    $date = new DateTime($suggestion->reviewed_on);
                                    echo $date->format('Y-m-d H:i');
                                ?>
                                <?php if ($suggestion->reviewed_by_username): ?>
                                    by <?= htmlspecialchars($suggestion->reviewed_by_username) ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <strong>Suggested By:</strong> <?= htmlspecialchars($suggestion->suggested_by_username ?? 'Unknown') ?>
                        </div>
                        <hr>
                        <div>
                            <strong>Details:</strong>
                            <div class="mt-2 p-3 bg-light rounded" style="white-space: pre-wrap; word-wrap: break-word;">
                                <?= htmlspecialchars($suggestion->details ?? 'N/A') ?>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

