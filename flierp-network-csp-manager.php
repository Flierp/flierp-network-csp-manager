<?php
/**
 * Plugin Name: Flierp CSP Manager
 * Description: Adds a Content Security Policy (CSP) header to the website and allows dynamic CSP modification.
 * Version: 1.0
 * Author: Your Name
 */

// USAGE 
// modify_custom_csp('script-src', "'self' 'unsafe-inline' example.com");
// modify_custom_csp('img-src', "'self' img.example.com");

class Custom_CSP_Header {
    private static $csp_values = [
        'default-src' => "'self'", // Initial default value
        // Add other policies here as needed
    ];

    public function __construct() {
        add_action('send_headers', [$this, 'add_csp_header']);
    }

    // Function to add the CSP header based on $csp_values
    public function add_csp_header() {
        $csp_header = '';
        foreach (self::$csp_values as $directive => $value) {
            $csp_header .= "$directive $value; ";
        }
        header("Content-Security-Policy: $csp_header");
    }

    // Public static method to add or modify CSP values, callable from other projects
    public static function modify_csp($directive, $value) {
        self::$csp_values[$directive] = $value;
    }
}

// Initialize the CSP header class
new Custom_CSP_Header();

// Example usage: Call this function from other projects to add/modify CSP values
function modify_custom_csp($directive, $value) {
    Custom_CSP_Header::modify_csp($directive, $value);
}
