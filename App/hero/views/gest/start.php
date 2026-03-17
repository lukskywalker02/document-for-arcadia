<?php
// App/hero/views/gest/start.php
?>

<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Manage Page Heroes</h1>
        <a href="/hero/gest/create" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Hero
        </a>
    </div>

    <?php 
    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
    display_alert_message();
    ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 50px;">ID</th>
                            <th>Img</th>
                            <th>Page</th>
                            <th>Title</th>
                            <th>Carousel?</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($heroes)): ?>
                            <?php foreach ($heroes as $hero): ?>
                                <tr>
                                    <td class="text-muted">#<?= $hero->id_hero ?></td>
                                    
                                    <!-- Image Column -->
                                    <td style="width: 80px;">
                                        <?php if (!empty($hero->media_path)): ?>
                                            <img src="<?= $hero->media_path ?>" class="rounded" style="width: 60px; height: 40px; object-fit: cover;" loading="lazy">
                                        <?php else: ?>
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 40px; font-size: 0.8rem;">
                                                <?= $hero->has_sliders ? 'Slides' : 'No Img' ?>
                                            </div>
                                        <?php endif; ?>
                                    </td>

                                    <td><span class="badge bg-info text-dark"><?= ucfirst($hero->page_name) ?></span></td>
                                    <td class="fw-bold"><?= htmlspecialchars($hero->hero_title) ?></td>
                                    <td>
                                        <?php if ($hero->has_sliders): ?>
                                            <span class="badge bg-success">Yes</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <a href="/hero/gest/edit?id=<?= $hero->id_hero ?>" class="btn btn-sm btn-warning me-1">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <a href="/hero/gest/delete?id=<?= $hero->id_hero ?>" 
                                           class="btn btn-sm btn-danger"
                                           onclick="return confirm('Are you sure? This will delete associated slides too.');">
                                            <i class="bi bi-trash">delete</i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    No heroes found. Create one for your pages (Home, About, etc.).
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
