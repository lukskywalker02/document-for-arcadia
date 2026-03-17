<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Medias
 * 📂 Physical File:   App/medias/mediasRouter.php
 * 
 * 📝 Description:
 * Router for the medias module.
 * Handles the routing for the medias module.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Medias\Controllers\MediasGestController
 * - Arcadia\Medias\Models\Cloudinary
 * - Arcadia\Medias\Models\Media
 */

require_once __DIR__ . '/../../includes/functions.php';
handleDomainRouting('medias', __DIR__);

