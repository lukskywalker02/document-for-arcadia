<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Includes
 * 📂 Physical File:   includes/pageTitle.php
 * 
 * 📝 Description:
 * Presentation logic for Page Titles.
 * Determines the <title> dynamic based on the current domain.
 */

// Get the name of the current file
$domain = $currentDomain ?? "home";

// Define the dynamic title

switch ($domain) {
    // PUBLIC PAGES
    case "home":
        if (isset($_GET['action']) && $_GET['action'] === 'start') {
            $pageTitle = "ARC Dashboard"; // For the admin/employee
        } else {
            $pageTitle = "ARC Home";      // For the public
        }
        break;
    case "cms": // Services are inside the CMS domain
        $pageTitle = "ARC Services";
        break;
    case "habitats":
        $pageTitle = "ARC Habitats";
        break;
    case "animals":
        $pageTitle = "ARC Animals";
        break;
    case "contact":
        $pageTitle = "ARC Contact";
        break;
    case "auth":
        $pageTitle = "ARC Login";
        break;

    // MANAGEMENT PAGES (DASHBOARD)
    case "employees":
        $pageTitle = "ARC Employees";
        break;
    case "users":
        $pageTitle = "ARC Users";
        break;
    case "roles":
        $pageTitle = "ARC Roles";
        break;
    case "permissions":
        $pageTitle = "ARC Permissions";
        break;
    case "reports":
        $pageTitle = "ARC Reports";
        break;

    // SPECIFIC OR ANTIQUES CASES (Just in case)
    case "animal-picked":
        $pageTitle = "ARC Animal Details";
        break;
    case "error-404":
        $pageTitle = "ARC Error 404";
        break;

    default:
        $pageTitle = "Arcadia Zoo";
        break;
}
