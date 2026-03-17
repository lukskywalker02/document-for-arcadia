<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Testimonials\Controllers
 * 📂 Physical File:   App/testimonials/controllers/testimonials_pages_controller.php
 * 
 * 📝 Description:
 * Public controller for testimonials.
 * Handles testimonial creation by visitors (non-employees).
 * 
 * 🔗 Dependencies:
 * - Arcadia\Testimonials\Models\Testimonial (via App/testimonials/models/testimonial.php)
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . '/../models/testimonial.php';
require_once __DIR__ . '/../../../includes/functions.php';

class TestimonialsPagesController
{
    /**
     * Create a new testimonial (only for non-employee visitors)
     * Validates that the user is NOT an employee before allowing creation
     */
    public function create()
    {
        // Ensure session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Check if user is logged in and is an employee
        if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
            // If user has an employee_id, they are an employee and cannot create testimonials
            if (isset($_SESSION["user"]["employee_id"]) && $_SESSION["user"]["employee_id"] !== null) {
                // Employee trying to create testimonial - redirect with error
                header('Location: /about/pages/about?msg=error&error=Employees cannot submit testimonials');
                exit();
            }
        }

        // Only process POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /about/pages/about?msg=error&error=Invalid request method');
            exit();
        }

        // Debug: Log POST data
        // error_log("Testimonial POST data: " . print_r($_POST, true));

        // Get and validate form data
        $pseudo = trim($_POST['pseudo'] ?? '');
        $message = trim($_POST['message'] ?? '');
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;

        // Debug: Log extracted values
        // error_log("Testimonial values - Pseudo: '$pseudo', Message length: " . strlen($message) . ", Rating: $rating");

        // Validate inputs
        if (empty($pseudo)) {
            header('Location: /about/pages/about?msg=error&error=Pseudonym is required');
            exit();
        }

        if (empty($message)) {
            header('Location: /about/pages/about?msg=error&error=Message is required');
            exit();
        }

        if ($rating < 1 || $rating > 5) {
            error_log("Testimonial validation failed: Rating is $rating (must be 1-5)");
            header('Location: /about/pages/about?msg=error&error=Please select a rating from 1 to 5 stars');
            exit();
        }

        // Create testimonial
        try {
            $testimonialModel = new Testimonial();
            $result = $testimonialModel->create($pseudo, $message, $rating);

            if ($result) {
                // Success - redirect with success message
                header('Location: /about/pages/about?msg=success&message=Thank you for your feedback! Your testimonial is pending approval.');
                exit();
            } else {
                // Error creating testimonial - log for debugging
                error_log("Testimonial creation failed: Model returned false");
                header('Location: /about/pages/about?msg=error&error=Failed to submit testimonial. Please try again.');
                exit();
            }
        } catch (Exception $e) {
            // Log the exception
            error_log("Testimonial creation exception: " . $e->getMessage());
            header('Location: /about/pages/about?msg=error&error=An error occurred. Please try again later.');
            exit();
        }
    }
}

