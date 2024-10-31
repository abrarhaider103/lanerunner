<?php
include("login_check.php");
include("config.php");
include("assets/php/quote_class.php");
include("assets/php/svg_class.php");


$sql = "INSERT into customers SET 
                           customer_firstName = 'Reviewer',
                           customer_lastName = 'Reviewer',
                           customer_email = 'Reviewer@developer.com',
                           customer_active = 1,
                           customer_registered_on = '2023-01-01',
                           customer_subscription_from = '2023-01-01',
                           customer_subscription_to = '2033-01-01',
                           customer_dismiss_modal = 1,
                           customer_stripe_customer = 'aaa',
                           customer_stripe_plan = 'aaa',
                           customer_phone = '0303456',
                           customer_type_subscription = 'full',
                           want_to_learn = 0,
                           customer_password  = AES_ENCRYPT('reviewer2023_1!$&l', '" . PWHASH . "') ";

//$quote->doThis($sql);
