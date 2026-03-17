<?php
/**
 * 🏛️ ARCHITECTURE ARCADIA (Simulated Namespace)
 * ----------------------------------------------------
 * 📍 Logical Path: Arcadia\Includes\Templates
 * 📂 Physical File:   includes/templates/nav.php
 * 
 * 📝 Description:
 * Main navigation component.
 * Shared responsive menu in public views.
 * 
 * 🔗 Dependencies:
 * - Arcadia\Includes\PageTitle (via includes/pageTitle.php)
 */

// Basic data of the public router
$currentDomain = $_GET['domain'] ?? 'home';
$currentAction = $_GET['action'] ?? 'index';

if (!function_exists('public_nav_is_active')) {
    function public_nav_is_active(string $expectedDomain, array $actions = []): string
    {
        $domain = $_GET['domain'] ?? 'home';
        $action = $_GET['action'] ?? 'index';

        if ($domain !== $expectedDomain) {
            return '';
        }

        if (!empty($actions) && !in_array($action, $actions, true)) {
            return '';
        }

        return 'nav__link--active';
    }
}

include(__DIR__ . '/../pageTitle.php');
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

    <link rel="stylesheet" href="/build/css/normalize.css" />
    <link rel="stylesheet" href="/build/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/build/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="/build/css/app.css" />



</head>

<?php
// Función para generar los items del menú (una sola vez)
if (!function_exists('generate_nav_items')) {
    function generate_nav_items(): string {
        $items = [
            ['domain' => 'home', 'actions' => ['index'], 'href' => '/home/pages/index', 'text' => 'home'],
            ['domain' => 'cms', 'actions' => ['cms'], 'href' => '/cms/pages/cms', 'text' => 'services'],
            ['domain' => 'habitats', 'actions' => ['habitats'], 'href' => '/habitats/pages/habitats', 'text' => 'habitats'],
            ['domain' => 'animals', 'actions' => [], 'href' => '/animals/pages/allanimals', 'text' => 'animals'],
            ['domain' => 'contact', 'actions' => ['contact'], 'href' => '/contact/pages/contact', 'text' => 'contact'],
        ];

        $html = '';
        foreach ($items as $item) {
            $activeClass = public_nav_is_active($item['domain'], $item['actions']);
            $html .= '<li class="nav__item">';
            $html .= '<a class="nav__link ' . $activeClass . '" href="' . $item['href'] . '">' . $item['text'] . '</a>';
            $html .= '</li>';
        }
        return $html;
    }
}
?>

<body class="<?= $currentDomain == 'contact' ? 'body-contact' : ($currentDomain == 'auth' ? 'body-login' : '') ?>" id="top">

    <!-- navbar for mobile with his fonts and sizes -->
    <nav class="d-md-none nav navbar position-fixed">
        <div class="nav__menu collapse" id="navbarTogglerMobile">
            <div class="nav__m-flex">
                <ul class="nav__items">
                    <?= generate_nav_items(); ?>
                </ul>
                <img class="panda__logo" src="/src/assets/images/panda-menu-mobile.svg" alt="Logo site">
            </div>
        </div>

        <div class="bar container-fluid d-flex">
            <button class="bar-button navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerMobile" aria-controls="navbarTogglerMobile" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="main-logo-link" href="/home/pages/index">
                <img class="main__logo" src="/src/assets/images/logo-bar.svg" alt="logo site">
            </a>
        </div>
    </nav>

    <!-- navbar for desk with his fonts and sizes -->
    <nav class="d-none d-md-block nav navbar position-fixed">
        <div class="bar container-fluid d-flex">
            <button class="bar-button navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerTablet" aria-controls="navbarTogglerTablet" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="main-logo-link" href="/home/pages/index">
                <img class="main__logo" src="/src/assets/images/logo-bar.svg" alt="logo site">
            </a>
        </div>

        <div class="nav__menu nav__menu--tablet collapse" id="navbarTogglerTablet">
            <div class="nav__m-flex">
                <ul class="nav__items">
                    <?= generate_nav_items(); ?>
                </ul>
                <img class="panda__logo" src="/src/assets/images/panda-menu-mobile.svg" alt="Logo site">
            </div>
            <div class="nav__menu nav__menu--desk collapse" id="navbarTogglerDesk">
                <ul class="nav__items">
                    <?= generate_nav_items(); ?>
                </ul>
                <div class="logo-desk">
                    <img class="logo-desk" src="/src/assets/images/logo-desk.svg" alt="Logo site">
                </div>
            </div>
        </div>
    </nav>