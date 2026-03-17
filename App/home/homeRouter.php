<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Home
 * 📂 Physical File:   App/home/homeRouter.php
 * 
 * 📝 Description:
 * Router for the Home domain.
 * Handles incoming requests and delegates to the appropriate controller.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . '/../../includes/functions.php';
handleDomainRouting('home', __DIR__);
