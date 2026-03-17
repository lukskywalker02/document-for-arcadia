<?php 
// Session is already started by App/router.php
?>

<div class="jumbotron">
    <h1 class="display-4">Welcome <?php echo htmlspecialchars($_SESSION["user"]["username"]); ?> to your dashboard !</h1>
    <p class="display-6">As <?php echo htmlspecialchars($_SESSION["user"]["role_name"]); ?> you can access the following sections:</p>
    <hr class="my-4">
</div>

<?php if (!empty($lastItems)): ?>
<div class="container-fluid">
    <h2 class="mb-4">Latest Activity</h2>
    <div class="row">
        <?php if (isset($lastItems['testimonial']) && $lastItems['testimonial']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Latest Testimonial</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['testimonial']->pseudo ?? 'Anonymous'); ?></strong></p>
                    <p class="card-text"><?php echo htmlspecialchars(substr($lastItems['testimonial']->message ?? '', 0, 100)); ?>...</p>
                    <p class="text-muted small">Rating: <?php echo $lastItems['testimonial']->rating ?? 'N/A'; ?>/5</p>
                    <a href="/testimonials/gest/start" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['user']) && $lastItems['user']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Latest User</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['user']->username ?? 'N/A'); ?></strong></p>
                    <p class="card-text">Role: <?php echo htmlspecialchars($lastItems['user']->role_name ?? 'N/A'); ?></p>
                    <p class="text-muted small">Created: <?php echo date('Y-m-d', strtotime($lastItems['user']->created_at ?? 'now')); ?></p>
                    <a href="/users/gest/start" class="btn btn-sm btn-info">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['employee']) && $lastItems['employee']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Latest Employee</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars(trim(($lastItems['employee']->first_name ?? '') . ' ' . ($lastItems['employee']->last_name ?? ''))); ?></strong></p>
                    <p class="card-text">Email: <?php echo htmlspecialchars($lastItems['employee']->email ?? 'N/A'); ?></p>
                    <p class="text-muted small">Created: <?php echo date('Y-m-d', strtotime($lastItems['employee']->created_at ?? 'now')); ?></p>
                    <a href="/employees/gest/start" class="btn btn-sm btn-success">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['schedule']) && $lastItems['schedule']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Latest Schedule</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['schedule']->time_slot ?? 'N/A'); ?></strong></p>
                    <p class="card-text"><?php echo htmlspecialchars($lastItems['schedule']->opening_time ?? 'N/A'); ?> - <?php echo htmlspecialchars($lastItems['schedule']->closing_time ?? 'N/A'); ?></p>
                    <a href="/schedules/gest/start" class="btn btn-sm btn-warning">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['service']) && $lastItems['service']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Latest Service</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['service']->service_title ?? 'N/A'); ?></strong></p>
                    <p class="card-text"><?php echo htmlspecialchars(substr($lastItems['service']->service_description ?? '', 0, 100)); ?>...</p>
                    <a href="/cms/gest/start" class="btn btn-sm btn-secondary">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['serviceLog']) && $lastItems['serviceLog']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Latest Service Log</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['serviceLog']->service_title ?? 'N/A'); ?></strong></p>
                    <p class="card-text">Action: <?php echo htmlspecialchars($lastItems['serviceLog']->action ?? 'N/A'); ?></p>
                    <p class="text-muted small">By: <?php echo htmlspecialchars($lastItems['serviceLog']->username ?? 'System'); ?></p>
                    <a href="/cms/gest/logs" class="btn btn-sm btn-dark">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['brick']) && $lastItems['brick']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Latest Content Block</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['brick']->title ?? 'N/A'); ?></strong></p>
                    <p class="card-text">Page: <?php echo htmlspecialchars($lastItems['brick']->page_name ?? 'N/A'); ?></p>
                    <a href="/cms/bricks/start" class="btn btn-sm btn-secondary">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['animal']) && $lastItems['animal']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Latest Animal</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['animal']->animal_name ?? 'N/A'); ?></strong></p>
                    <p class="card-text">Species: <?php echo htmlspecialchars($lastItems['animal']->specie_name ?? 'N/A'); ?></p>
                    <p class="card-text">Habitat: <?php echo htmlspecialchars($lastItems['animal']->habitat_name ?? 'None'); ?></p>
                    <a href="/animals/gest/start" class="btn btn-sm btn-danger">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['feeding']) && $lastItems['feeding']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Latest Feeding Log</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['feeding']->animal_name ?? 'N/A'); ?></strong></p>
                    <p class="card-text">Food: <?php echo htmlspecialchars($lastItems['feeding']->food_type ?? 'N/A'); ?> (<?php echo $lastItems['feeding']->food_qtty ?? 0; ?>g)</p>
                    <p class="text-muted small">Date: <?php echo date('Y-m-d H:i', strtotime($lastItems['feeding']->food_date ?? 'now')); ?></p>
                    <a href="/animals/feeding/start" class="btn btn-sm btn-info">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['habitat']) && $lastItems['habitat']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Latest Habitat</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['habitat']->habitat_name ?? 'N/A'); ?></strong></p>
                    <p class="card-text"><?php echo htmlspecialchars(substr($lastItems['habitat']->habitat_description ?? '', 0, 100)); ?>...</p>
                    <a href="/habitats/gest/start" class="btn btn-sm btn-success">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['habitatSuggestion']) && $lastItems['habitatSuggestion']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">Latest Habitat Suggestion</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['habitatSuggestion']->habitat_name ?? 'N/A'); ?></strong></p>
                    <p class="card-text"><?php echo htmlspecialchars(substr($lastItems['habitatSuggestion']->suggestion_text ?? '', 0, 100)); ?>...</p>
                    <p class="text-muted small">By: <?php echo htmlspecialchars($lastItems['habitatSuggestion']->suggested_by_username ?? 'N/A'); ?></p>
                    <a href="/habitats/suggestion/start" class="btn btn-sm btn-warning">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['healthReport']) && $lastItems['healthReport']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">Latest Health Report</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['healthReport']->animal_name ?? 'N/A'); ?></strong></p>
                    <p class="card-text">State: <?php echo htmlspecialchars($lastItems['healthReport']->hsr_state ?? 'N/A'); ?></p>
                    <p class="text-muted small">Date: <?php echo date('Y-m-d', strtotime($lastItems['healthReport']->review_date ?? 'now')); ?></p>
                    <a href="/vreports/gest/start" class="btn btn-sm btn-danger">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['contact']) && $lastItems['contact']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Latest Contact Form</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars(($lastItems['contact']->ff_name ?? '') . ' ' . ($lastItems['contact']->fl_name ?? '')); ?></strong></p>
                    <p class="card-text">Subject: <?php echo htmlspecialchars($lastItems['contact']->f_subject ?? 'N/A'); ?></p>
                    <p class="text-muted small">Date: <?php echo date('Y-m-d H:i', strtotime($lastItems['contact']->f_sent_date ?? 'now')); ?></p>
                    <a href="/contact/gest/start" class="btn btn-sm btn-primary">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if (isset($lastItems['hero']) && $lastItems['hero']): ?>
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Latest Page Header</h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><strong><?php echo htmlspecialchars($lastItems['hero']->hero_title ?? 'N/A'); ?></strong></p>
                    <p class="card-text">Page: <?php echo htmlspecialchars($lastItems['hero']->page_name ?? 'N/A'); ?></p>
                    <a href="/hero/gest/start" class="btn btn-sm btn-dark">View All</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php else: ?>
<div class="alert alert-info">
    <p>No recent activity to display. Start managing your zoo!</p>
</div>
<?php endif; ?>
