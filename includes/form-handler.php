<?php
function mpc_calculate_price() {
    // Implementați logica de calcul aici
    // Aceasta este doar o implementare de bază
    $distance = 10; // Presupunem o distanță de 10 mile
    $price_per_mile = 5; // 5 lire pe milă
    $total_price = $distance * $price_per_mile;
    
    echo $total_price;
    wp_die();
}
add_action('wp_ajax_calculate_price', 'mpc_calculate_price');
add_action('wp_ajax_nopriv_calculate_price', 'mpc_calculate_price');