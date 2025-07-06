<?php

//  define('RAZORPAY_KEY_ID', 'rzp_test_bIhNkWUJxQ5Gew'); // Replace with your Razorpay Key ID
//  define('RAZORPAY_KEY_SECRET', 'MlJdk4iT6fq26gGIX1plJmBU'); // Replace with your Razorpay Key Secret

define('RAZORPAY_KEY_ID', 'rzp_live_rd0Eox84yvY9lR'); // Replace with your Razorpay Key ID
define('RAZORPAY_KEY_SECRET', 'ExXUjdY3pCzSlBSoAoklnU0l'); // Replace with your Razorpay Key Secret


// ==========================
// Razorpay Configuration
// ==========================

// Switch between 'test' and 'live'
// $mode = 'test'; // Change to 'live' in production


// Configuration for both modes
// $config = [
//     'test' => [
//         'keyId' => 'rzp_test_bIhNkWUJxQ5Gew',
//         'keySecret' => 'MlJdk4iT6fq26gGIX1plJmBU',
//         'displayCurrency' => 'INR', 
//     ],
//     'live' => [
//         'keyId' => 'rzp_live_rd0Eox84yvY9lR',
//         'keySecret' => 'ExXUjdY3pCzSlBSoAoklnU0l',
//         'displayCurrency' => 'INR',
//     ]
// ];

// Select the correct config
// $keyId = $config[$mode]['keyId'];
// $keySecret = $config[$mode]['keySecret'];
// $displayCurrency = $config[$mode]['displayCurrency'];

// ==========================
// Error Reporting (for development)
// ==========================

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// In production, disable error display
// ini_set('display_errors', 0);

?>
