<main class="contact">

    <!-- Logo site web -->
    <header class="contact__header">
        <a href="/home/pages/index" class="contact__logo-link">
            <img src="/src/assets/images/logo-site-mobile.svg" alt="Logo del sitio" class="contact__logo">
        </a>
        <a href="/auth/pages/login">
            <span>Log in?</span>
        </a>
    </header>



    <div class="contact__container">
        <!-- Form contact -->
        <section class="contact__form-section">
            <h2 class="contact__title">Contact About:</h2>

            <!-- Success/Error Messages -->
            <?php if (isset($_GET['msg'])): ?>
                <div class="alert alert-<?= $_GET['msg'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert" style="margin-bottom: 1rem; padding: 1rem; border-radius: 0.358rem;">
                    <?= htmlspecialchars($_GET['message'] ?? $_GET['error'] ?? '') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <script>
                    // Clean URL parameters after 3 seconds or on click
                    (function() {
                        const cleanUrl = function() {
                            if (window.location.search.includes('msg=')) {
                                const url = new URL(window.location);
                                url.searchParams.delete('msg');
                                url.searchParams.delete('message');
                                url.searchParams.delete('error');
                                window.history.replaceState({}, '', url.pathname + (url.search ? url.search : ''));
                            }
                        };
                        
                        // Clean after 3 seconds
                        setTimeout(cleanUrl, 3000);
                        
                        // Clean on click anywhere
                        document.addEventListener('click', cleanUrl, { once: true });
                    })();
                </script>
            <?php endif; ?>

            <?php require_once __DIR__ . '/../../../../includes/helpers/csrf.php'; ?>
            
            <form action="/contact/pages/contact" method="POST" class="contact__form">
                <?= csrf_field('contact_form') ?>

                <div class="contact__form-info">

                    <div>

                        <!-- Field of first name -->


                        <label for="first-name" class="contact__label">First Name</label>
                        <input type="text" id="first-name" name="first-name" placeholder="Emilio" required
                            class="contact__input">





                        <!-- Field of last name -->


                        <label for="last-name" class="contact__label">Last Name</label>
                        <input type="text" id="last-name" name="last-name" placeholder="Emiliano" required
                            class="contact__input">

                    </div>

                    <div>
                        <!-- Field of email -->

                        <label for="email" class="contact__label">Email</label>
                        <input type="email" id="email" name="email" placeholder="Maximiliano@outlook.com" required
                            class="contact__input">





                        <label for="subject" class="contact__label">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="snakes" required
                            class="contact__input">





                    </div>
                </div>
                <!-- Field of message -->
                <div>

                    <label for="message" class="contact__label">Message</label>

                    <textarea id="message" name="message" rows="4" placeholder="are there snakes?" required
                        class="contact__textarea"></textarea>
                </div>




                <!-- Submit -->
                <button type="submit" class="contact__button">Send</button>
            </form>
        </section>
    </div>

</main>

