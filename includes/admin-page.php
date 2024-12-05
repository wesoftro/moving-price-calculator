<?php


function mpc_admin_page_content() {
    ?>
    <div class="wrap">
        <h1>Moving Price Calculator Settings</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('mpc_settings');
            do_settings_sections('mpc-settings');
            ?>
            <h2>Price Per Miles in Pounds</h2>
            <?php echo generate_price_per_mile_fields(); ?>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

function create_price_per_miles_settings() {
    return array(
        "0-20 miles" => "price_0_20",
        "21-40 miles" => "price_21_40",
        "41-60 miles" => "price_41_60",
        "61-80 miles" => "price_61_80",
        "81-100 miles" => "price_81_100",
        "101-150 miles" => "price_101_150",
        ">=151 miles" => "price_151_plus"
    );
}

function generate_price_per_mile_fields() {
    $fields = create_price_per_miles_settings();
    $html = '<div class="mpc-price-fields">';
    foreach ($fields as $label => $id) {
        $value = get_option($id, ''); // Get saved value or default to empty
        $html .= "<div class='mpc-price-field'>
            <label for=\"$id\">$label:</label>
            <input type=\"number\" id=\"$id\" name=\"$id\" value=\"$value\" step=\"0.01\" class='mpc-price-input'>
        </div>";
    }
    $html .= '</div>';
    return $html;
}



