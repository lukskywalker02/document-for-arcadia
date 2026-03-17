

<main class="login">

    <!-- Logo site web -->
    <header class="login__header">
        <a href="/public/index.php" target="_blank" rel="noopener" class="login__logo-link">
            <img src="/src/assets/images/logo-site-mobile.svg" alt="Logo del sitio" class="login__logo">
        </a>
    </header>



    <div class="login__container">
        <!-- Form login -->
        <section class="login__form-section">
            <h2 class="login__title">Owner?</h2>

            <!-- Show error message if it exists -->
            <?php 
            require_once __DIR__ . '/../../../../includes/helpers/messages.php';
            display_session_alert('login_error', 'danger', 2800);
            ?>

            <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
            
            <form action="" method="POST" class="login__form">
                <?= csrf_field('login_form') ?>

                <div class="login__form-info">

                    <div>

                        <div>
                            <!-- Field of user (Email or Username) -->
                            <label for="login_input" class="login__label">Email or UserName</label>
                            <!-- if email is set, show it, if not, show empty -->
                            <input
                                type="text"
                                id="login_input"
                                name="email"
                                placeholder="(dumitru@arcadia.com or dumitrusf123 example)"
                                required
                                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                class="login__input">

                            <!-- Field of password -->
                            <label for="password" class="login__label">Password</label>
                            <input type="password" id="password" name="password" placeholder="********" required
                                class="login__input">
                        </div>

                    </div>
                </div>
                <!-- Submit button -->
                <button type="submit" class="login__button">Login</button>

            </form>
        </section>
    </div>

</main>