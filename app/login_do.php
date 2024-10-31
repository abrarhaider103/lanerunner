<?php
session_start();
include("config.php");
include("registration_class.php");

//$rp->addo_customer();
//exit;

$rp->storeFormValues($_POST);
$customer = $rp->login_customer();

if (!$customer) {
    header("location:index.php?e=1");
} else {
    if ($customer->customer_active == 2 || $customer->team_active == 2) {
        header("location:index.php?e=2");
        return;
    }

    $rp->setAuthSessionId($customer->customer_id);
    $_SESSION['logged'] = 1;
    $_SESSION['customer'] = $customer;

    // $loginToken = getLoginToken(10);
    // $_SESSION['loginToken'] = $loginToken;
    /*
        //Ckeck customer token
        $result_loginToken = $rp->getCountCustomerLoginToken($customer->customer_id);
        if ($result_loginToken->allacount > 0) {
            $rp->upd_loginToken($customer->customer_id, $loginToken);
        } else {
            $rp->setLoginToken($customer->customer_id, $loginToken);
        }
    */
    $_SESSION['want_to_learn'] = $customer->want_to_learn;
    header("location:dashboard.php");
}


// Generar loginToken
function getLoginToken($longitud)
{
    $loginToken = "";
    $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
    $codeAlphabet .= "0123456789";
    $max = strlen($codeAlphabet); // editado
    for ($i = 0; $i < $longitud; $i++) {
        $loginToken .= $codeAlphabet[random_int(0, $max - 1)];
    }
    return $loginToken;
}



//header("location:dashboard.php");

/*
 *        [customer_id] => 5
            [customer_firstName] => gustavo
            [customer_email] => gutibs2@gmail.com
            [customer_password] => /PZP�2~rM]�V+
            [customer_active] => 0
            [customer_registered_on] => 2021-03-04
            [customer_subscription_from] =>
            [customer_subscription_to] =>
            [customer_dismiss_modal] => 1
            [customer_lastName] =>
            [customer_stripe_customer] =>
            [customer_stripe_plan] =>
            [customer_phone] =>
            [customer_type_subscription] =>
            [pass] => 123

 */

/* nueva funcion de ingreso con stripe para validar suscripcion
<?php
include("../config.php");
include("registration_class.php");
//include("../class/class_customer.php");

$rp->storeFormValues($_POST);
$customer = $rp->login_customer();

require_once('../vendor/autoload.php'); // Include the Stripe library

\Stripe\Stripe::setApiKey(STRIPE_SECRET);

function checkSubscriptionStatus($subscriptionId)
{
    try {
        $subscription = \Stripe\Subscription::retrieve($subscriptionId);
        $status = $subscription->status;
        return $status;
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Handle any errors that occur
        return $e->getMessage();
    }
}

if (!$reg) {
    header("location:index.php?v=1");
} else {

    session_start();
    $_SESSION['logged'] = 1;
    $_SESSION['customer'] = $customer;
    $_SESSION['plan'] = $customer->customer_type_subscription;

    $subscriptionId = $customer->customer_stripe_plan;
    $subscriptionStatus = checkSubscriptionStatus($subscriptionId);
    $subscriptionStatus = 'canceleed';
    if ($subscriptionStatus === 'active' || $subscriptionStatus === 'trialing') {
        header("location:dashboard.php");
        exit;
    } else {
        header("location:vencida.php");
        exit;
    }
}
*/