<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Contact\Views\Gest
 * 📂 Physical File:   App/contact/views/gest/start.php
 * 
 * 📝 Description:
 * Back office view for managing contact form submissions.
 * Displays all contact forms with filtering and action buttons.
 */

?>

<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Contact Form Submissions</h1>
            </div>

            <!-- Success/Error Messages -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-<?= $_GET['msg'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                    <?= htmlspecialchars($_GET['message'] ?? $_GET['error'] ?? '') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card text-white bg-primary">
                        <div class="card-body">
                            <h5 class="card-title">Total</h5>
                            <h2 class="mb-0"><?= $stats->total ?? 0 ?></h2>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-success">
                        <div class="card-body">
                            <h5 class="card-title">Email Sent</h5>
                            <h2 class="mb-0"><?= $stats->sent ?? 0 ?></h2>
                        </div>
                    </div>
                </div>
                <?php if (($stats->pending ?? 0) > 0): ?>
                <div class="col-md-4">
                    <div class="card text-white bg-warning">
                        <div class="card-body">
                            <h5 class="card-title">Pending</h5>
                            <h2 class="mb-0"><?= $stats->pending ?? 0 ?></h2>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>

            <!-- Filter Buttons -->
            <div class="mb-3">
                <a href="/contact/gest/start" class="btn btn-sm btn-outline-secondary <?= !isset($_GET['status']) ? 'active' : '' ?>">
                    All
                </a>
                <a href="/contact/gest/start?status=sent" class="btn btn-sm btn-outline-success <?= (isset($_GET['status']) && $_GET['status'] === 'sent') ? 'active' : '' ?>">
                    Email Sent
                </a>
                <a href="/contact/gest/start?status=pending" class="btn btn-sm btn-outline-warning <?= (isset($_GET['status']) && $_GET['status'] === 'pending') ? 'active' : '' ?>">
                    Pending
                </a>
            </div>

            <!-- Contact Forms Table -->
            <div class="card">
                <div class="card-body">
                    <?php if (!empty($contactForms)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="contactFormsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50px;">ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($contactForms as $contact): ?>
                                        <tr>
                                            <!-- ID -->
                                            <td class="fw-bold text-muted">#<?= $contact->id_form ?? 'N/A' ?></td>

                                            <!-- Name -->
                                            <td class="fw-bold">
                                                <?= htmlspecialchars($contact->ff_name ?? '') ?> 
                                                <?= htmlspecialchars($contact->fl_name ?? '') ?>
                                            </td>

                                            <!-- Email -->
                                            <td>
                                                <?php 
                                                $contactEmail = htmlspecialchars($contact->f_email ?? '');
                                                if (!empty($contact->f_email)): 
                                                    $gmailComposeUrl = "https://mail.google.com/mail/?view=cm&to=" . rawurlencode($contact->f_email);
                                                ?>
                                                    <a href="<?= $gmailComposeUrl ?>" 
                                                       class="text-decoration-none" 
                                                       target="_blank"
                                                       rel="noopener noreferrer"
                                                       title="Open Gmail to send email to <?= $contactEmail ?>">
                                                        <?= $contactEmail ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">N/A</span>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Subject -->
                                            <td><?= htmlspecialchars($contact->f_subject ?? 'N/A') ?></td>

                                            <!-- Message (truncated) -->
                                            <td>
                                                <?php
                                                $message = htmlspecialchars($contact->f_message ?? '');
                                                $truncated = strlen($message) > 100 ? substr($message, 0, 100) . '...' : $message;
                                                ?>
                                                <span title="<?= htmlspecialchars($contact->f_message ?? '') ?>">
                                                    <?= $truncated ?>
                                                </span>
                                            </td>

                                            <!-- Date -->
                                            <td>
                                                <small class="text-muted">
                                                    <?php
                                                    if (isset($contact->f_sent_date)) {
                                                        $date = new DateTime($contact->f_sent_date);
                                                        echo $date->format('Y-m-d H:i');
                                                    } else {
                                                        echo 'N/A';
                                                    }
                                                    ?>
                                                </small>
                                            </td>

                                            <!-- Status Badge -->
                                            <td>
                                                <?php 
                                                // Convert to boolean explicitly to handle MySQL BOOLEAN (TINYINT) values (0/1 or "0"/"1")
                                                $isEmailSent = (bool) $contact->email_sent;
                                                ?>
                                                <?php if ($isEmailSent): ?>
                                                    <span class="badge bg-success">Email Sent</span>
                                                <?php else: ?>
                                                    <span class="badge bg-warning">Pending</span>
                                                <?php endif; ?>
                                            </td>

                                            <!-- Actions -->
                                            <td class="text-end">
                                                <div class="btn-group" role="group">
                                                    <?php 
                                                    // Both Admin and Employee can mark as sent and delete
                                                    $roleName = $_SESSION["user"]["role_name"] ?? '';
                                                    if ($roleName === 'Admin' || $roleName === 'Employee'): 
                                                    ?>
                                                        <?php 
                                                        // Convert to boolean explicitly to handle MySQL BOOLEAN (TINYINT) values (0/1 or "0"/"1")
                                                        $isEmailSent = (bool) $contact->email_sent;
                                                        ?>
                                                        <?php if (!$isEmailSent): ?>
                                                            <a href="/contact/gest/markAsSent?id=<?= $contact->id_form ?>" 
                                                               class="btn btn-sm btn-success" 
                                                               title="Mark as Sent"
                                                               onclick="return confirm('Mark this contact form as email sent?');">
                                                                Mark Sent
                                                            </a>
                                                        <?php else: ?>
                                                            <a href="/contact/gest/markAsPending?id=<?= $contact->id_form ?>" 
                                                               class="btn btn-sm btn-warning" 
                                                               title="Mark as Pending (Revert)"
                                                               onclick="return confirm('Mark this contact form as pending again? This will revert the sent status.');">
                                                                Mark Pending
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php
                                                        // Build Gmail compose URL
                                                        // 1. Email cleaning and validation
                                                        $replyEmail = trim($contact->f_email ?? '');
                                                        
                                                        if (!empty($replyEmail)) {
                                                            // 2. Preparar el Asunto
                                                            $replySubject = 'Re: ' . ($contact->f_subject ?? 'Contact Inquiry');
                                                            
                                                            // 3. Preparar el Cuerpo
                                                            $replyBody = "--- Original Message ---\n";
                                                            $replyBody .= "From: " . ($contact->ff_name ?? '') . " " . ($contact->fl_name ?? '') . "\n";
                                                            
                                                            if (!empty($contact->f_sent_date)) {
                                                                $replyBody .= "Date: " . date('Y-m-d H:i', strtotime($contact->f_sent_date)) . "\n";
                                                            }
                                                            
                                                            $replyBody .= "\n" . ($contact->f_message ?? '');
                                                            
                                                            // Limitar longitud del cuerpo para evitar URLs demasiado largas
                                                            if (strlen($replyBody) > 1500) {
                                                                $replyBody = substr($replyBody, 0, 1500) . "\n\n[... message truncated ...]";
                                                            }
                                                            
                                                            // 4. Construir URL de Gmail compose
                                                            // Gmail URL format: https://mail.google.com/mail/?view=cm&to=EMAIL&su=SUBJECT&body=BODY
                                                            $gmailUrl = "https://mail.google.com/mail/?view=cm" .
                                                                        "&to=" . rawurlencode($replyEmail) .
                                                                        "&su=" . rawurlencode($replySubject) .
                                                                         "&body=" . rawurlencode($replyBody);
                                                        } else {
                                                            $gmailUrl = "#";
                                                        }
                                                        ?>
                                                        <?php if (empty($replyEmail)): ?>
                                                            <button type="button" 
                                                                    class="btn btn-sm btn-primary" 
                                                                    title="No email available"
                                                                    disabled>
                                                                Reply
                                                            </button>
                                                        <?php else: ?>
                                                            <a href="<?= $gmailUrl ?>" 
                                                               class="btn btn-sm btn-primary reply-mailto-link" 
                                                               title="Reply to <?= htmlspecialchars($replyEmail) ?>"
                                                               target="_blank"
                                                               rel="noopener noreferrer">
                                                                Reply
                                                            </a>
                                                        <?php endif; ?>

                                                        <a href="/contact/gest/delete?id=<?= $contact->id_form ?>" 
                                                           class="btn btn-sm btn-danger" 
                                                           title="Delete"
                                                           onclick="return confirm('Are you sure you want to delete this contact form? This action cannot be undone.');">
                                                            Delete
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-4">
                            <i class="bi bi-inbox"></i> No contact forms found.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Initialize DataTables if available
    // Wait for all scripts to load (including DataTables)
    window.addEventListener('load', function() {
        // Double check jQuery and DataTables are available
        if (typeof jQuery === 'undefined' || typeof jQuery.fn.DataTable === 'undefined') {
            console.error('jQuery or DataTables not loaded!');
            return;
        }
        
        const $ = jQuery;
        const table = $('#contactFormsTable');
        
        if (table.length) {
            // Check if DataTables is already initialized
            if ($.fn.DataTable.isDataTable('#contactFormsTable')) {
                // Get existing instance
                const dataTable = table.DataTable();
                console.log('Using existing DataTable instance');
            } else {
                // Initialize new instance
                table.DataTable({
                    order: [[5, 'desc']], // Sort by date descending
                    pageLength: 25,
                    language: {
                        search: "Search:",
                        lengthMenu: "Show _MENU_ entries",
                        info: "Showing _START_ to _END_ of _TOTAL_ contact forms",
                        infoEmpty: "No contact forms available",
                        infoFiltered: "(filtered from _TOTAL_ total contact forms)"
                    }
                });
                console.log('DataTables initialized');
            }
            
            // Ensure mailto links work - prevent DataTables from interfering
            // Use event delegation but allow the default behavior for mailto links
            $(document).on('click', 'a.reply-mailto-link', function(e) {
                // Don't prevent default - let the browser handle mailto natively
                // Just stop propagation to prevent DataTables row click handlers
                e.stopPropagation();
                // The href will be followed naturally by the browser
            });
        }
    });
</script>


