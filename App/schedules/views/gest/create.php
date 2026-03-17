<?php
// App/schedules/views/gest/create.php
?>

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">Create New Schedule</h4>
                </div>
                <div class="card-body">
                    <form action="/schedules/gest/create" method="POST">
                        
                        <!-- Time Slot Selection -->
                        <div class="mb-3">
                            <label for="time_slot" class="form-label fw-bold">Time Slot / Day</label>
                            <select class="form-select" id="time_slot" name="time_slot" required>
                                <option value="" disabled selected>Select a time slot...</option>
                                <option value="morning">Morning</option>
                                <option value="afternoon">Afternoon</option>
                                <option value="saturday">Saturday</option>
                                <option value="sunday">Sunday</option>
                            </select>
                            <div class="form-text">Choose the period this schedule applies to.</div>
                        </div>

                        <div class="row">
                            <!-- Opening Time -->
                            <div class="col-md-6 mb-3">
                                <label for="opening_time" class="form-label">Opening Time</label>
                                <input type="time" class="form-control" id="opening_time" name="opening_time" required>
                            </div>

                            <!-- Closing Time -->
                            <div class="col-md-6 mb-3">
                                <label for="closing_time" class="form-label">Closing Time</label>
                                <input type="time" class="form-control" id="closing_time" name="closing_time" required>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="open" selected>Open</option>
                                <option value="closed">Closed</option>
                            </select>
                        </div>

                        <!-- Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="/schedules/gest/start" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-success">Create Schedule</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

