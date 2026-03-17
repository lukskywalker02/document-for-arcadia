<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Permissions
 * 📂 Physical File:   App/permissions/permissionList.php
 * 
 * 📝 Description:
 * Utility class with constant permissions.
 * Define the unique identifiers for each permission in the system.
 */
// App/permissions/PermissionList.php

final class PermissionList {

    // We don't want anyone to create an object of this class
    private function __construct() {}

    // --- ACCOUNT MANAGEMENT PERMISSIONS ---
    const USERS_VIEW = 'users-view';
    const USERS_CREATE = 'users-create';
    const USERS_EDIT = 'users-edit';
    const USERS_DELETE = 'users-delete';
    const ROLES_VIEW = 'roles-view';
    const ROLES_CREATE = 'roles-create';
    const ROLES_EDIT = 'roles-edit';
    const ROLES_DELETE = 'roles-delete';

    // --- ZOO MANAGEMENT PERMISSIONS ---
    const SERVICES_CREATE = 'services-create';
    const SERVICES_VIEW = 'services-view';
    const SERVICES_EDIT = 'services-edit';
    const SERVICES_DELETE = 'services-delete';
    const SCHEDULES_VIEW = 'schedules-view';
    const SCHEDULES_EDIT = 'schedules-edit';
    const HABITATS_VIEW = 'habitats-view';
    const HABITATS_EDIT = 'habitats-edit';

    // --- ANIMAL MANAGEMENT PERMISSIONS ---
    const ANIMALS_CREATE = 'animals-create';
    const ANIMALS_VIEW = 'animals-view';
    const ANIMALS_EDIT = 'animals-edit';
    const ANIMALS_DELETE = 'animals-delete';
    const ANIMAL_STATS_VIEW = 'animal_stats-view';
    const ANIMAL_FEEDING_VIEW = 'animal_feeding-view';
    const ANIMAL_FEEDING_ASSIGN = 'animal_feeding-assign';

    // --- VETERINARY PERMISSIONS ---
    const VET_REPORTS_CREATE = 'vet_reports-create';
    const VET_REPORTS_VIEW = 'vet_reports-view';
    const VET_REPORTS_EDIT = 'vet_reports-edit';
    const HABITAT_SUGGESTIONS_CREATE = 'habitat_suggestions-create';
    const HABITAT_SUGGESTIONS_VIEW = 'habitat_suggestions-view';
    const HABITAT_SUGGESTIONS_MANAGE = 'habitat_suggestions-manage'; // Accept/Reject
    const HABITAT_SUGGESTIONS_DELETE = 'habitat_suggestions-delete';
    
    // --- PUBLIC INTERACTION PERMISSIONS ---
    const TESTIMONIALS_VIEW = 'testimonials-view';
    const TESTIMONIALS_VALIDATE = 'testimonials-validate'; // Validate/Invalidate
    const TESTIMONIALS_DELETE = 'testimonials-delete';
}
