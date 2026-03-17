<?php

/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Includes\Layouts
 * 📂 Physical File:   includes/layouts/BO_main_layout.php
 * 
 * 📝 Description:
 * Main layout for BACKOFFICE (Management).
 * HTML base structure for the administration panel.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Includes\PageTitle (via includes/pageTitle.php)
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Get the name of the current file
$currentDomain = $_GET['domain'] ?? 'home';
$domain = $_GET['domain'] ?? 'home';
$controller = $_GET['controller'] ?? 'pages';
$action = $_GET['action'] ?? 'index';
include(__DIR__ . "/../pageTitle.php");

// Include functions to use hasPermission()
require_once __DIR__ . "/../functions.php";

// If user is logged in but permissions are not loaded in session, load them now
// This handles cases where user was already logged in before we implemented permission loading
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    $userId = $_SESSION["user"]["id_user"] ?? null;
    if ($userId && (!isset($_SESSION["user"]["permissions"]) || empty($_SESSION["user"]["permissions"]))) {
        require_once __DIR__ . "/../../App/users/models/user.php";
        $_SESSION["user"]["permissions"] = User::getAllUserPermissions($userId);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="description" content="" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="keywords"
        content="zoo, animals, habitats, Brocéliande, veterinarians, ecology, wildlife park, conservation, zoo services, guided tours, France zoo, sustainable energy, wild animals, animal feeding, zoo management, Arcadia Zoo" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover" />
    <title><?= $pageTitle; ?></title>

    <link rel="icon" type="image/svg+xml" href="/src/assets/images/favicon.svg" />

    <link rel="icon" type="image/png" href="/src/assets/images/favicon.png" />

    <!-- Compiled and copied stylesheets by Gulp -->
    <!-- <link rel="stylesheet" href="/build/css/normalize.css"> -->
    <link rel="stylesheet" href="/build/css/bootstrap.min.css">
    <link rel="stylesheet" href="/build/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="/node_modules/bootstrap-icons/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/build/css/bo-sidebar-only.css">
    <script>
        // Aplicar estado del sidebar ANTES de que se renderice el body
        (function() {
            const isCollapsed = localStorage.getItem('boSidebarCollapsed') === 'true';
            if (isCollapsed && window.innerWidth >= 743.9) {
                document.documentElement.style.setProperty('--sidebar-collapsed', '1');
                document.documentElement.classList.add('sidebar-will-be-collapsed');
            }
        })();
    </script>
    <style>
        /* Aplicar estado colapsado antes de que se cargue el CSS */
        html.sidebar-will-be-collapsed .bo-sidebar {
            width: 2rem !important;
            overflow: visible !important;
        }
        html.sidebar-will-be-collapsed .bo-main-content {
            margin-left: 0 !important;
        }
        html.sidebar-will-be-collapsed .bo-sidebar .bo-sidebar__menu,
        html.sidebar-will-be-collapsed .bo-sidebar .bo-sidebar__header .bo-sidebar__logo,
        html.sidebar-will-be-collapsed .bo-sidebar .bo-sidebar__footer {
            opacity: 0 !important;
            overflow: hidden !important;
        }
    </style>

</head>

<body class="<?= $currentDomain == 'contact' ? 'body-contact' : ($currentDomain == 'auth' ? 'body-login' : '') ?>" id="top">

    <?php if ($currentDomain !== 'auth'): ?>
        <!-- Sidebar Overlay (Mobile) -->
        <div class="bo-sidebar-overlay" id="boSidebarOverlay"></div>

        <!-- Back Office Sidebar -->
        <aside class="bo-sidebar" id="boSidebar">
            <!-- Flecha para expandir/colapsar -->
            <button class="bo-sidebar__toggle-arrow" id="boSidebarToggle" aria-label="Toggle sidebar">
                <i class="bi bi-chevron-left" id="boSidebarToggleIcon"></i>
            </button>

            <div class="bo-sidebar__header">
                <a href="/home/pages/start" class="bo-sidebar__logo">Zoo Arcadia</a>
            </div>

            <nav class="bo-sidebar__menu">
                <ul class="bo-sidebar__items">
                    <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                        <li class="bo-sidebar__item">
                            <a href="/home/pages/start" class="bo-sidebar__link <?= ($domain === 'home' && $controller === 'pages' && $action === 'start') ? 'bo-sidebar__link--active' : '' ?>">
                                Dashboard
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php 
                    $isAdmin = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin';
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): 
                    ?>
                        <li class="bo-sidebar__item">
                            <a href="/users/gest/start" class="bo-sidebar__link <?= ($domain === 'users' && $controller === 'gest') ? 'bo-sidebar__link--active' : '' ?>">
                                Users
                            </a>
                        </li>
                        <li class="bo-sidebar__item">
                            <a href="/employees/gest/start" class="bo-sidebar__link <?= ($domain === 'employees' && $controller === 'gest') ? 'bo-sidebar__link--active' : '' ?>">
                                Employees
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php 
                    if ($isAdmin || hasPermission('roles-view') || hasPermission('roles-create') || hasPermission('roles-edit') || hasPermission('roles-delete')): 
                    ?>
                        <li class="bo-sidebar__item">
                            <a href="/roles/gest/start" class="bo-sidebar__link <?= ($domain === 'roles' && $controller === 'gest') ? 'bo-sidebar__link--active' : '' ?>">
                                Roles
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php 
                    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): 
                    ?>
                        <li class="bo-sidebar__item">
                            <a href="/permissions/gest/start" class="bo-sidebar__link <?= ($domain === 'permissions' && $controller === 'gest') ? 'bo-sidebar__link--active' : '' ?>">
                                Permissions
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if (hasPermission('schedules-view') || hasPermission('schedules-edit')): ?>
                        <li class="bo-sidebar__item">
                            <a href="/schedules/gest/start" class="bo-sidebar__link <?= ($domain === 'schedules' && $controller === 'gest') ? 'bo-sidebar__link--active' : '' ?>">
                                Schedules
                            </a>
                        </li>
                    <?php endif; ?>
                    
                    <?php if (hasPermission('services-view') || hasPermission('services-edit') || hasPermission('services-create') || hasPermission('services-delete')): ?>
                        <li class="bo-sidebar__item">
                            <a href="/cms/gest/start" class="bo-sidebar__link <?= ($domain === 'cms' && $controller === 'gest' && ($action === 'start' || $action === 'edit' || $action === 'create')) ? 'bo-sidebar__link--active' : '' ?>">
                                Services
                            </a>
                        </li>
                        <li class="bo-sidebar__item">
                            <a href="/cms/gest/logs" class="bo-sidebar__link <?= ($domain === 'cms' && $controller === 'gest' && $action === 'logs') ? 'bo-sidebar__link--active' : '' ?>">
                                Service Logs
                            </a>
                        </li>
                        <li class="bo-sidebar__item">
                            <a href="/cms/bricks/start" class="bo-sidebar__link <?= ($domain === 'cms' && $controller === 'bricks') ? 'bo-sidebar__link--active' : '' ?>">
                                Content Blocks
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('animals-view') || hasPermission('animals-create') || hasPermission('animals-edit') || hasPermission('animals-delete')): ?>
                        <li class="bo-sidebar__item">
                            <a href="/animals/gest/start" class="bo-sidebar__link <?= ($domain === 'animals' && $controller === 'gest' && ($action === 'start' || $action === 'edit' || $action === 'create')) ? 'bo-sidebar__link--active' : '' ?>">
                                All Animals
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('animal_stats-view')): ?>
                        <li class="bo-sidebar__item">
                            <a href="/animals/stats/start" class="bo-sidebar__link <?= ($domain === 'animals' && $controller === 'stats') ? 'bo-sidebar__link--active' : '' ?>">
                                Animal Statistics
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('animal_feeding-view') || hasPermission('animal_feeding-assign')): ?>
                        <li class="bo-sidebar__item">
                            <a href="/animals/feeding/start" class="bo-sidebar__link <?= ($domain === 'animals' && $controller === 'feeding') ? 'bo-sidebar__link--active' : '' ?>">
                                Feeding Logs
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('habitats-view') || hasPermission('habitats-create') || hasPermission('habitats-edit') || hasPermission('habitats-delete')): ?>
                        <li class="bo-sidebar__item">
                            <a href="/habitats/gest/start" class="bo-sidebar__link <?= ($domain === 'habitats' && $controller === 'gest' && ($action === 'start' || $action === 'edit' || $action === 'create')) ? 'bo-sidebar__link--active' : '' ?>">
                                All Habitats
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('habitat_suggestions-view') || hasPermission('habitat_suggestions-manage')): ?>
                        <li class="bo-sidebar__item">
                            <a href="/habitats/suggestion/start" class="bo-sidebar__link <?= ($domain === 'habitats' && $controller === 'suggestion') ? 'bo-sidebar__link--active' : '' ?>">
                                Habitat Suggestions
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (hasPermission('vet_reports-view') || hasPermission('vet_reports-create') || hasPermission('vet_reports-edit')): ?>
                        <li class="bo-sidebar__item">
                            <a href="/vreports/gest/start" class="bo-sidebar__link <?= ($domain === 'vreports' && $controller === 'gest') ? 'bo-sidebar__link--active' : '' ?>">
                                Health Reports
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php 
                    $isEmployee = isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Employee';
                    if ($isAdmin || $isEmployee): 
                    ?>
                        <li class="bo-sidebar__item">
                            <a href="/testimonials/gest/start" class="bo-sidebar__link <?= ($domain === 'testimonials' && $controller === 'gest') ? 'bo-sidebar__link--active' : '' ?>">
                                Testimonials
                            </a>
                        </li>
                        <li class="bo-sidebar__item">
                            <a href="/contact/gest/start" class="bo-sidebar__link <?= ($domain === 'contact' && $controller === 'gest') ? 'bo-sidebar__link--active' : '' ?>">
                                Contact Forms
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (isset($_SESSION['user']['role_name']) && $_SESSION['user']['role_name'] === 'Admin'): ?>
                        <li class="bo-sidebar__item">
                            <a href="/hero/gest/start" class="bo-sidebar__link <?= ($domain === 'hero') ? 'bo-sidebar__link--active' : '' ?>">
                                Page Headers
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>

            <div class="bo-sidebar__footer">
                <?php if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
                    <div class="bo-sidebar__user">
                        <i class="bi bi-person-circle"></i> <?php echo htmlspecialchars($_SESSION["user"]["username"] ?? 'User'); ?>
                    </div>
                <?php endif; ?>
                <a href="/home/pages/index" class="bo-sidebar__home-link">
                    <i class="bi bi-house-door"></i> Arcadia Zoo
                </a>
                <a href="/auth/pages/logout" class="bo-sidebar__logout">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </aside>
    <?php endif; ?>

    <div class="bo-main-content">
        <div class="container-fluid p-5">
            <div class="row">
                <div class="col-12">
                    <?php

                    // Show the captured content from the controller, otherwise show a message that there is no content to show
                    echo $viewContent ?? '<p>There is no content to show</p>';

                    ?>
                </div>
            </div>
        </div>
    </div>


    <!-- 
      Order of loading Scripts is important:
      1. jQuery (required for Bootstrap and DataTables)
      2. Bootstrap JS (for the functionality of the template)
      3. DataTables Core
      4. DataTables Bootstrap 5 Integration
      5. Nuestro código de activación (app.js)
    -->
    <script src="/build/js/jquery.min.js" defer></script>
    <script src="/build/js/bootstrap.bundle.min.js" defer></script>
    <script src="/build/js/dataTables.min.js" defer></script>
    <script src="/build/js/dataTables.bootstrap5.min.js" defer></script>
    <script src="/build/js/app.js" defer></script>
    <script>
        // Back Office Sidebar Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('boSidebar');
            const toggleBtn = document.getElementById('boSidebarToggle');
            const toggleIcon = document.getElementById('boSidebarToggleIcon');
            const overlay = document.getElementById('boSidebarOverlay');
            const mainContent = document.querySelector('.bo-main-content');

            // Aplicar estado guardado y activar transiciones
            const isCollapsed = localStorage.getItem('boSidebarCollapsed') === 'true';
            if (sidebar && window.innerWidth >= 743.9) {
                if (isCollapsed) {
                    sidebar.classList.add('collapsed');
                    if (mainContent) mainContent.classList.add('sidebar-collapsed');
                }
                // Activar transiciones después de aplicar el estado y quitar clase temporal
                requestAnimationFrame(function() {
                    sidebar.classList.add('loaded');
                    document.documentElement.classList.remove('sidebar-will-be-collapsed');
                });
            }

            function toggleSidebar() {
                if (!sidebar) return;
                
                const isCurrentlyCollapsed = sidebar.classList.contains('collapsed');
                
                if (isCurrentlyCollapsed) {
                    // Expandir
                    sidebar.classList.remove('collapsed');
                    if (mainContent) mainContent.classList.remove('sidebar-collapsed');
                    localStorage.setItem('boSidebarCollapsed', 'false');
                } else {
                    // Colapsar
                    sidebar.classList.add('collapsed');
                    if (mainContent) mainContent.classList.add('sidebar-collapsed');
                    localStorage.setItem('boSidebarCollapsed', 'true');
                }
            }

            function openSidebarMobile() {
                if (sidebar) sidebar.classList.add('show');
                if (overlay) overlay.classList.add('show');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebarMobile() {
                if (sidebar) sidebar.classList.remove('show');
                if (overlay) overlay.classList.remove('show');
                document.body.style.overflow = '';
            }

            // Manejar clicks en la flecha del sidebar
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    const isMobile = window.innerWidth < 743.9;
                    if (isMobile) {
                        if (sidebar && sidebar.classList.contains('show')) {
                            closeSidebarMobile();
                        } else {
                            openSidebarMobile();
                        }
                    } else {
                        toggleSidebar();
                    }
                });
            }

            if (overlay) {
                overlay.addEventListener('click', closeSidebarMobile);
            }

            // Cerrar con ESC (solo en móvil)
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar && sidebar.classList.contains('show')) {
                    closeSidebarMobile();
                }
            });
        });
    </script>

</body>
