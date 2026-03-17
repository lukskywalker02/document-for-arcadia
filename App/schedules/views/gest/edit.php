<?php
// App/schedules/views/gest/edit.php
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Edit Schedule</h4>
                </div>
                <div class="card-body">
                    <!-- Success/Error Messages -->
                    <?php 
                    require_once __DIR__ . '/../../../../includes/helpers/messages.php';
                    display_alert_message();
                    display_error_variable($error ?? null);
                    ?>
                    
                    <!-- The form sends data to the same URL but via POST -->
                    <form action="/schedules/gest/edit" method="POST">
                        
                        <!-- Hidden ID to know what we are editing -->
                        <input type="hidden" name="id_opening" value="<?= $schedule->id_opening ?>">
                        
                        <!-- Day of Week (Read-only, we don't want them to change the day name) -->
                        <div class="mb-3">
                            <label class="form-label fw-bold">Day of Week</label>
                            <input type="text" class="form-control" name="time_slot" value="<?= ucfirst($schedule->time_slot) ?>" readonly>
                            <div class="form-text">This value corresponds to the day being edited.</div>
                        </div>

                        <div class="row">
                            <!-- Opening Time -->
                            <div class="col-md-6 mb-3">
                                <label for="opening_time" class="form-label">Opening Time</label>
                                <input type="time" class="form-control" id="opening_time" name="opening_time" 
                                       value="<?= $schedule->opening_time ?>" required>
                            </div>

                            <!-- Closing Time -->
                            <div class="col-md-6 mb-3">
                                <label for="closing_time" class="form-label">Closing Time</label>
                                <input type="time" class="form-control" id="closing_time" name="closing_time" 
                                       value="<?= $schedule->closing_time ?>" required>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="open" <?= $schedule->status === 'open' ? 'selected' : '' ?>>Open</option>
                                <option value="closed" <?= $schedule->status === 'closed' ? 'selected' : '' ?>>Closed</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="/schedules/gest/start" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Save Changes</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>