jQuery(document).ready(function($) {
    // Handle Like button clicks
    $('.like-button').on('click', function() {
        var $button = $(this);
        // Prevent multiple likes
        if ($button.hasClass('liked')) {
            return;
        }

        var post_id = $button.data('post-id');
        var nonce = $button.data('nonce');

        // Send AJAX request to like the post
        $.ajax({
            url: tasteDelivery.ajaxurl,
            type: 'POST',
            data: {
                action: 'taste_delivery_like_post',
                post_id: post_id,
                nonce: nonce
            },
            success: function(response) {
                if (response.success) {
                    $button.addClass('liked');
                    $button.find('.like-text').text('Liked');
                    var $counter = $button.find('.like-counter');
                    var currentCount = parseInt($counter.text().replace(/[()]/g, '')) || 0;
                    $counter.text('(' + (currentCount + 1) + ')');
                } else {
                    alert(response.data);
                }
            },
            error: function(xhr, status, error) {
                console.error('Like AJAX error:', status, error);
                alert('An error occurred. Please try again.');
            }
        });
    });

    // Handle Contact Us form submission
    $('#contact-form').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        var $form = $(this);
        var $messageDiv = $form.find('.form-message');

        // Send AJAX request to submit the form
        $.ajax({
            url: tasteDelivery.ajaxurl,
            type: 'POST',
            data: {
                action: 'contact_form_submit',
                nonce: $form.find('input[name="nonce"]').val(),
                name: $form.find('#name').val(),
                email: $form.find('#email').val(),
                message: $form.find('#message').val()
            },
            success: function(response) {
                if (response.success) {
                    $messageDiv.text(response.data).css('color', 'green').show();
                    $form[0].reset(); // Clear the form
                } else {
                    $messageDiv.text(response.data).css('color', 'red').show();
                }
            },
            error: function(xhr, status, error) {
                console.error('Contact form AJAX error:', status, error);
                $messageDiv.text('An error occurred. Please try again.').css('color', 'red').show();
            }
        });
    });
});