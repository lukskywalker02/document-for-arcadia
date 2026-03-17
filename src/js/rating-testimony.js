// Interactive star rating for testimonial form
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('#rating .testimony__star');
    const ratingInput = document.getElementById('ratingInput');
    let selectedRating = 0;

    stars.forEach((star, index) => {
        star.addEventListener('click', function() {
            selectedRating = index + 1;
            ratingInput.value = selectedRating;

            // Hide hint when rating is selected
            const ratingHint = document.getElementById('ratingHint');
            if (ratingHint) {
                ratingHint.style.display = 'none';
            }

            // Update star colors
            stars.forEach((s, i) => {
                if (i < selectedRating) {
                    s.style.color = '#ffc107'; // Gold/yellow for selected
                    s.style.opacity = '1';
                } else {
                    s.style.color = '#ccc'; // Gray for unselected
                    s.style.opacity = '0.5';
                }
            });
        });

        star.addEventListener('mouseenter', function() {
            const hoverRating = index + 1;
            stars.forEach((s, i) => {
                if (i < hoverRating) {
                    s.style.color = '#ffc107';
                    s.style.opacity = '1';
                } else {
                    s.style.color = '#ccc';
                    s.style.opacity = '0.5';
                }
            });
        });
    });

    // Reset on mouse leave (if no rating selected)
    const ratingGroup = document.getElementById('rating');
    ratingGroup.addEventListener('mouseleave', function() {
        if (selectedRating === 0) {
            stars.forEach(s => {
                s.style.color = '#ccc';
                s.style.opacity = '0.5';
            });
        } else {
            stars.forEach((s, i) => {
                if (i < selectedRating) {
                    s.style.color = '#ffc107';
                    s.style.opacity = '1';
                } else {
                    s.style.color = '#ccc';
                    s.style.opacity = '0.5';
                }
            });
        }
    });

    // Form validation
    document.getElementById('testimonyForm').addEventListener('submit', function(e) {
        // Get form fields
        const pseudoField = document.getElementById('pseudo');
        const messageField = document.getElementById('message');
        
        // Validate pseudo
        const pseudo = pseudoField.value.trim();
        if (!pseudo) {
            e.preventDefault();
            alert('Pseudonym is required');
            pseudoField.focus();
            pseudoField.style.border = '2px solid red';
            setTimeout(function() {
                pseudoField.style.border = '';
            }, 3000);
            return false;
        }
        
        // Validate message
        const message = messageField.value.trim();
        if (!message) {
            e.preventDefault();
            alert('Message is required');
            messageField.focus();
            messageField.style.border = '2px solid red';
            setTimeout(function() {
                messageField.style.border = '';
            }, 3000);
            return false;
        }
        
        // Make sure the hidden input has the value before submitting
        if (!ratingInput.value && selectedRating > 0) {
            ratingInput.value = selectedRating;
        }
        
        // Validate rating is selected
        if (!ratingInput.value || ratingInput.value < 1 || ratingInput.value > 5) {
            e.preventDefault();
            alert('Please select a rating from 1 to 5 stars by clicking on the stars above');
            // Highlight the stars to draw attention
            document.getElementById('rating').style.border = '2px solid red';
            document.getElementById('rating').style.padding = '5px';
            document.getElementById('rating').style.borderRadius = '5px';
            setTimeout(function() {
                document.getElementById('rating').style.border = '';
                document.getElementById('rating').style.padding = '';
                document.getElementById('rating').style.borderRadius = '';
            }, 3000);
            return false;
        }
        
        // Log for debugging
        console.log('Submitting testimonial with rating:', ratingInput.value);
    });
});