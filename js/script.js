jQuery(document).ready(function($) {
    $('#moving-price-calculator').on('submit', function(e) {
        e.preventDefault();
        
        // Colectați datele formularului
        var formData = $(this).serialize();
        
        // Trimiteți datele la server pentru calcul
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                action: 'calculate_price',
                form_data: formData
            },
            success: function(response) {
                // Afișați rezultatul
                alert('Prețul estimat: ' + response);
            }
        });
    });
});