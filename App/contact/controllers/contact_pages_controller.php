<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Contact\Controllers
 * 📂 Physical File:   App/contact/controllers/contact_pages_controller.php
 * 
 * 📝 Description:
 * Controller for the public Contact page.
 * Handles displaying the contact page (with Hero/Slides) and processing contact form submissions.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Hero\Models\Hero (via App/hero/models/Hero.php) - used in contact()
 * - Arcadia\Hero\Models\Slide (via App/hero/models/Slide.php) - used in contact()
 * - Arcadia\Contact\Models\FormContact (via App/contact/models/formContact.php) - used in submit()
 * - Arcadia\Includes\Helpers\EmailHelper (via includes/helpers/EmailHelper.php) - used in submit()
 */

require_once __DIR__ . '/../../hero/models/Hero.php';
require_once __DIR__ . '/../../hero/models/Slide.php';
require_once __DIR__ . '/../models/formContact.php';
require_once __DIR__ . '/../../../includes/helpers/EmailHelper.php';
require_once __DIR__ . '/../../../includes/helpers/csrf.php';

class ContactPagesController {
    
    public function contact() {
        // Process form submission if POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->submit();
            return;
        }

        // 1. Get Hero for Contact Page
        $heroModel = new Hero();
        $hero = $heroModel->getByPage('contact');
        $slides = [];

        if ($hero && $hero->has_sliders) {
            $slideModel = new Slide();
            $slides = $slideModel->getByHeroId($hero->id_hero);
        }

        if (file_exists(__DIR__ . '/../views/pages/contact.php')) {
            include_once __DIR__ . '/../views/pages/contact.php';
        } else {
            echo "Error: View contact.php not found.";
        }
    }

    /**
     * Process contact form submission
     * Saves the form to database and sends email to zoo
     */
    public function submit()
    {
        // Verify CSRF token before processing
        if (!csrf_verify('contact_form')) {
            header('Location: /contact/pages/contact?msg=error&error=Invalid request. Please try again.');
            exit;
        }

        // Get form data
        $firstName = trim($_POST['first-name'] ?? '');
        $lastName = trim($_POST['last-name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        // Validate inputs
        if (empty($firstName)) {
            header('Location: /contact/pages/contact?msg=error&error=First name is required');
            exit;
        }

        if (empty($lastName)) {
            header('Location: /contact/pages/contact?msg=error&error=Last name is required');
            exit;
        }

        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header('Location: /contact/pages/contact?msg=error&error=Valid email is required');
            exit;
        }

        if (empty($subject)) {
            header('Location: /contact/pages/contact?msg=error&error=Subject is required');
            exit;
        }

        if (empty($message)) {
            header('Location: /contact/pages/contact?msg=error&error=Message is required');
            exit;
        }

        // Save to database
        $formContactModel = new FormContact();
        $contactId = $formContactModel->create($firstName, $lastName, $email, $subject, $message);

        if (!$contactId) {
            header('Location: /contact/pages/contact?msg=error&error=Failed to submit contact form. Please try again.');
            exit;
        }

        // Send notification email to zoo (optional - just for notification)
        // Get zoo email from .env or use a default
        $zooEmail = $_ENV['ZOO_EMAIL'] ?? $_ENV['SMTP_FROM_EMAIL'] ?? 'contact@arcadia-zoo.com';
        
        $emailResult = EmailHelper::sendContactFormEmail(
            $zooEmail,
            $firstName,
            $lastName,
            $email,
            $subject,
            $message
        );

        // NOTE: We do NOT mark as "sent" here because email_sent means "employee replied to client"
        // The notification email to zoo is separate from replying to the client
        // Employees will manually mark as "sent" after they reply to the client
        
        if ($emailResult['success']) {
            header('Location: /contact/pages/contact?msg=success&message=Thank you for your message! We will get back to you soon.');
        } else {
            // Form was saved but email failed - still show success to user
            // The email can be sent later by an employee
            error_log("Contact form saved (ID: $contactId) but notification email failed: " . $emailResult['message']);
            header('Location: /contact/pages/contact?msg=success&message=Thank you for your message! We have received it and will get back to you soon.');
        }
        exit;
    }
}
