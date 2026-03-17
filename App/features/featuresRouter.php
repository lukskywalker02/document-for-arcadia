<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Features
 * 📂 Physical File:   App/features/featuresRouter.php
 * 
 * 📝 Description:
 * Router for the Features domain.
 * Handles incoming requests and delegates to the appropriate controller.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Includes\Functions (via includes/functions.php)
 */

require_once __DIR__ . '/../../includes/functions.php';
handleDomainRouting('features', __DIR__);
