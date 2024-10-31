<?php
include("../../config.php");
include("../../registration_class.php");

//h=ec53f5b66b10317ffae7a131bef48090b63768f165cdd620a70e2a61225e7146
//&s=9d415aead342eaa623cc55bf6e668933f9b8e38f90f7b09a39b902fef797ed86
//&e=gutibs@gmail.com


$rp->storeFormValues($_GET);

if (isset($_GET['he']) && isset($_GET['sa'])) {
    $encodedEmail = $_GET['he'];
    $encodedSalt = $_GET['sa'];

    // Decode the values
    $hashedEmail = urldecode($encodedEmail);
    $salt = urldecode($encodedSalt);

    // Verify the email address
    list($hashedEmail, $salt) = $rp->hashEmail(); // Same hashing function as above

    if ($hashedEmail === hash('sha256', $_GET['he'] . $salt)) {
        // Email address is valid
        // You can continue processing here
    } else {
        // Invalid email address
    }
} else {
    echo "Email not provided via GET";
}