<?php
/**
 * Common utility functions
 */

// Sanitize and safely escape output
function escape($data) {
    // Handle null input gracefully
    if (!isset($data)) {
        return '';
    }

    // Trim, strip slashes, and escape special characters
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data, ENT_QUOTES | ENT_SUBSTITUTE, "UTF-8");
}
