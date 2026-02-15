<?php
$plugin_meta = [
    'Plugin Name'       => 'Duitku',
    'Description'       => 'Accept Duitku payments directly from customers. Fast and secure payment processing for Indonesia.',
    'Version'           => '1.0.0',
    'Author'            => 'PipraPay',
    'Author URI'        => 'https://piprapay.com/',
    'License'           => 'GPL-2.0+',
    'License URI'       => 'http://www.gnu.org/licenses/gpl-2.0.txt',
    'Requires at least' => '1.0.0',
    'Plugin URI'        => 'https://duitku.com',
    'Text Domain'       => '',
    'Domain Path'       => '',
    'Requires PHP'      => '7.2'
];

// Load the admin UI rendering function
function duitku_admin_page() {
    $viewFile = __DIR__ . '/views/admin-ui.php';

    if (file_exists($viewFile)) {
        include $viewFile;
    } else {
        echo "<div class='alert alert-warning'>Admin UI not found.</div>";
    }
}

// Load the checkout UI rendering function
function duitku_checkout_page($payment_id) {
    $viewFile = __DIR__ . '/views/checkout-ui.php';

    if (file_exists($viewFile)) {
        include $viewFile;
    } else {
        echo "<div class='alert alert-warning'>Checkout UI not found.</div>";
    }
}
