<?php
// App/animals/views/gest/stats.php
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">Animal Statistics</h1>
        <a href="/animals/gest/start" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Animals
        </a>
    </div>

    <?php if (isset($_GET['msg'])): ?>
        <div class="alert <?= ($_GET['msg'] === 'error') ? 'alert-danger' : 'alert-success' ?> alert-dismissible fade show" role="alert">
            <?php if ($_GET['msg'] === 'error' && isset($_GET['error'])): ?>
                <?= htmlspecialchars($_GET['error']) ?>
            <?php else: ?>
                Action completed successfully!
            <?php endif; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-2">Total Clicks (All Time)</h5>
                    <h2 class="mb-0"><?= number_format($totalClicks) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-2">Current Month (<?= htmlspecialchars($currentMonthName) ?>)</h5>
                    <h2 class="mb-0"><?= number_format($currentMonthTotal) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-2">Animals Tracked</h5>
                    <h2 class="mb-0"><?= count($currentMonthStats) ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-muted mb-2">Top Animal</h5>
                    <h6 class="mb-0">
                        <?php if (!empty($topAnimals)): ?>
                            <?= htmlspecialchars($topAnimals[0]->animal_name) ?>
                            <small class="text-muted">(<?= number_format($topAnimals[0]->total_clicks) ?> clicks)</small>
                        <?php else: ?>
                            N/A
                        <?php endif; ?>
                    </h6>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Animals -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-trophy"></i> Top 10 Animals (All Time)</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($topAnimals)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Animal</th>
                                        <th>Species</th>
                                        <th class="text-end">Total Clicks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topAnimals as $index => $animal): ?>
                                        <tr>
                                            <td>
                                                <?php if ($index === 0): ?>
                                                    <span class="badge" style="background-color: #FFD700;">🥇</span>
                                                <?php elseif ($index === 1): ?>
                                                    <span class="badge" style="background-color: #C0C0C0;">🥈</span>
                                                <?php elseif ($index === 2): ?>
                                                    <span class="badge" style="background-color: #CD7F32;">🥉</span>
                                                <?php else: ?>
                                                    <strong>#<?= $index + 1 ?></strong>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= htmlspecialchars($animal->animal_name) ?></td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($animal->specie_name ?? 'N/A') ?>
                                                    <?php if ($animal->category_name): ?>
                                                        <br><span class="badge bg-info"><?= htmlspecialchars($animal->category_name) ?></span>
                                                    <?php endif; ?>
                                                </small>
                                            </td>
                                            <td class="text-end">
                                                <strong><?= number_format($animal->total_clicks) ?></strong>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4">No statistics available yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-calendar-month"></i> Current Month (<?= htmlspecialchars($currentMonthName) ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($currentMonthStats)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Animal</th>
                                        <th>Species</th>
                                        <th class="text-end">Clicks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($currentMonthStats as $stat): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($stat->animal_name) ?></td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($stat->specie_name ?? 'N/A') ?>
                                                </small>
                                            </td>
                                            <td class="text-end">
                                                <strong><?= number_format($stat->click_count) ?></strong>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4">No clicks recorded for this month yet.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Historical Statistics -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="bi bi-graph-up"></i> Historical Statistics</h5>
                    <div class="d-flex align-items-center gap-2">
                        <label for="monthsSelector" class="mb-0 text-white small">Show last:</label>
                        <select id="monthsSelector" class="form-select form-select-sm" style="width: auto;" onchange="window.location.href='?months=' + this.value">
                            <?php for ($i = 1; $i <= 12; $i++): ?>
                                <option value="<?= $i ?>" <?= $monthsToShow == $i ? 'selected' : '' ?>>
                                    <?= $i ?> <?= $i == 1 ? 'month' : 'months' ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($lastMonthsStats)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Animal</th>
                                        <th>Species</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th class="text-end">Clicks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $monthNames = [
                                        1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
                                        5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
                                        9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December'
                                    ];
                                    foreach ($lastMonthsStats as $stat): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($stat->animal_name) ?></td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= htmlspecialchars($stat->specie_name ?? 'N/A') ?>
                                                </small>
                                            </td>
                                            <td><?= $monthNames[$stat->month] ?? $stat->month ?></td>
                                            <td><?= $stat->year ?></td>
                                            <td class="text-end">
                                                <strong><?= number_format($stat->click_count) ?></strong>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-4">No statistics available for the selected period.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

