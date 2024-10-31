<?php
require '../vendor/autoload.php'; // Include Composer's autoloader
require_once('../config.php');
require_once('../helpers/product.helper.php');

use Ramsey\Uuid\Uuid;

class Customer
{
    private $contact_name;
    private $company_email;

    private $company_name;

    private $billing_address;
    private $billing_address2;
    private $billing_city;
    private $billing_zip_code;
    private $billing_state;
    private $contact_phone;
    private $stripe_customer_id;
    private $coupon_code;
    private $coupon_id;
    private $subscription_id;

    private $plan;
    private $firstName;
    private $lastName;
    private $email;
    private $phone;

    private $token;
    private $stripeToken;
    private $customer_id;
    /*private $customer_firstName;
    private $customer_lastName;
    private $customer_email;
    private $customer_phone;*/
    private $customer_type_subscription;
    private $customer_status;

    private $fullName;
    private $password;
    private $category;

    private $completo;
    private $ultimo;
    private $texto;

    private $stripe_plan_id;
    private $amount;
    private $currency;
    private $status;
    private $interval;
    private $interval_count;
    private $created;
    private $current_period_start;
    private $current_period_end;
    private $licenses = 1;
    private $product;

    public function storeFormValues($params)
    {
        $this->__construct($params);
    }

    public function __construct($data = array())
    {
        if (isset($data['contact_name'])) {
            $this->contact_name = stripslashes(strip_tags($data['contact_name']));
        }

        if (isset($data['company_email'])) {
            $this->company_email = stripslashes(strip_tags($data['company_email']));
        }
        if (isset($data['company_name'])) {
            $this->company_name = stripslashes(strip_tags($data['company_name']));
        }
        if (isset($data['billing_address'])) {
            $this->billing_address = stripslashes(strip_tags($data['billing_address']));
        }
        if (isset($data['billing_address2'])) {
            $this->billing_address2 = stripslashes(strip_tags($data['billing_address2']));
        }
        if (isset($data['billing_city'])) {
            $this->billing_city = stripslashes(strip_tags($data['billing_city']));
        }
        if (isset($data['billing_zip_code'])) {
            $this->billing_zip_code = stripslashes(strip_tags($data['billing_zip_code']));
        }
        if (isset($data['billing_state'])) {
            $this->billing_state = stripslashes(strip_tags($data['billing_state']));
        }
        if (isset($data['contact_phone'])) {
            $this->contact_phone = stripslashes(strip_tags($data['contact_phone']));
        }
        if (isset($data['plan'])) {
            $this->plan = stripslashes(strip_tags($data['plan']));
            $products = getProducts();
            $this->product = $products[$this->plan];
        }
        if (isset($data['firstName'])) {
            $this->firstName = stripslashes(strip_tags($data['firstName']));
        }
        if (isset($data['lastName'])) {
            $this->lastName = stripslashes(strip_tags($data['lastName']));
        }
        if (isset($data['email'])) {
            $this->email = stripslashes(strip_tags($data['email']));
        }
        if (isset($data['phone'])) {
            $this->phone = stripslashes(strip_tags($data['phone']));
        }
        if (isset($data['pass'])) {
            $this->password = stripslashes(strip_tags($data['pass']));
        }

        if (isset($data['customer_id'])) {
            $this->customer_id = stripslashes(strip_tags($data['customer_id']));
        }
        //if (isset($data['customer_firstName'])) {   $this->customer_firstName = stripslashes(strip_tags($data['customer_firstName']));   }
        //if (isset($data['customer_lastName']))  {   $this->customer_lastName = stripslashes(strip_tags($data['customer_lastName']));     }
        //if (isset($data['customer_email']))     {   $this->customer_email = stripslashes(strip_tags($data['customer_email']));     }
        //if (isset($data['customer_phone']))     {   $this->customer_phone = stripslashes(strip_tags($data['customer_phone']));     }

        if (isset($data['customer_type_subscription'])) {
            $this->customer_type_subscription = stripslashes(strip_tags($data['customer_type_subscription']));
        }
        if (isset($data['customer_status'])) {
            $this->customer_status = stripslashes(strip_tags($data['customer_status']));
        }

        if (isset($data['password'])) {
            $this->password = stripslashes(strip_tags($data['password']));
        }
        if (isset($data['category'])) {
            $this->category = stripslashes(strip_tags($data['category']));
        }

        if (isset($data['token'])) {
            $this->token = stripslashes(strip_tags($data['token']));
        }
        if (isset($data['stripeToken'])) {
            $this->stripeToken = stripslashes(strip_tags($data['stripeToken']));
        }

        if (isset($data['texto'])) {
            $this->texto = stripslashes(strip_tags($data['texto']));
        }
        if (isset($data['completo'])) {
            $this->completo = stripslashes(strip_tags($data['completo']));
        }
        if (isset($data['ultimo'])) {
            $this->ultimo = stripslashes(strip_tags($data['ultimo']));
        }

        if (isset($data['stripe_customer_id'])) {
            $this->stripe_customer_id = stripslashes(strip_tags($data['stripe_customer_id']));
        }

        if (!empty($data['licenses'])) {
            $this->licenses = stripslashes(strip_tags($data['licenses']));
        }

        if (!empty($data['coupon_code'])) {
            $this->coupon_code = stripslashes(strip_tags($data['coupon_code']));
        }
        
        if (!empty($data['coupon_id'])) {
            $this->coupon_id = stripslashes(strip_tags($data['coupon_id']));
        }

        /*if (isset($data['stripe_subscription_id']))        {   $this->stripe_subscription_id = stripslashes(strip_tags($data['stripe_subscription_id']));     }
        if (isset($data['amount']))          {   $this->amount = stripslashes(strip_tags($data['amount'])); }
        if (isset($data['currency']))        {   $this->currency = stripslashes(strip_tags($data['currency'])); }
        if (isset($data['status']))          {   $this->status = stripslashes(strip_tags($data['status'])); }
        if (isset($data['interval']))        {   $this->interval = stripslashes(strip_tags($data['interval'])); }
        if (isset($data['interval_count']))  {   $this->interval_count = stripslashes(strip_tags($data['interval_count'])); }
        if (isset($data['created']))         {   $this->created = stripslashes(strip_tags($data['created'])); }
        if (isset($data['current_period_start']))  {   $this->current_period_start = stripslashes(strip_tags($data['current_period_start'])); }
        if (isset($data['current_period_end']))    {   $this->current_period_end = stripslashes(strip_tags($data['current_period_end'])); }*/
    }

    public function check_mail_existance()
    {

        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT COUNT(*) as hay FROM subscribers WHERE company_email = :company_email ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("company_email", $this->company_email, PDO::PARAM_STR);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 1;
        }

    }

    public function generar_customer()
    {

        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO customers SET customer_firstName = :firstName,
                                         customer_email = :email,
                                         customer_password  = AES_ENCRYPT(:password, '" . PWHASH . "'),
                                         customer_active = 1,
                                         customer_registered_on = :created,
                                         customer_subscription_from = :current_period_start,
                                         customer_subscription_to = :current_period_end,
                                         customer_lastName = :lastName,
                                         customer_stripe_customer = :stripe_customer_id,
                                         customer_stripe_plan = :subscription_id,
                                         customer_phone = :phone,
                                         customer_type_subscription = :plan
                            ON DUPLICATE KEY UPDATE customer_active = 1,
                                        customer_subscription_from = :current_period_start,
                                        customer_subscription_to = :current_period_end,
                                        customer_stripe_customer = :stripe_customer_id,
                                        customer_stripe_plan = :subscription_id,
                                        customer_type_subscription = :plan";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("firstName", $this->firstName, PDO::PARAM_STR);
            $stmt->bindValue("email", $this->email, PDO::PARAM_STR);
            $stmt->bindValue("password", $this->password, PDO::PARAM_STR);
            $stmt->bindValue("created", $this->created, PDO::PARAM_STR);
            $stmt->bindValue("current_period_start", $this->current_period_start, PDO::PARAM_STR);
            $stmt->bindValue("current_period_end", $this->current_period_end, PDO::PARAM_STR);
            $stmt->bindValue("lastName", $this->lastName, PDO::PARAM_STR);
            $stmt->bindValue("stripe_customer_id", $this->stripe_customer_id, PDO::PARAM_STR);
            $stmt->bindValue("subscription_id", $this->subscription_id, PDO::PARAM_STR);
            $stmt->bindValue("phone", $this->phone, PDO::PARAM_STR);
            $stmt->bindValue("plan", $this->plan, PDO::PARAM_STR);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }

    }

    public function proceso_stripe($stripe_plan)
    {
        require_once('../vendor/autoload.php');
        require_once('../config.php');

        \Stripe\Stripe::setApiKey(STRIPE_API_KEY);
        // print_r(['STRIPE_API_KEY' => STRIPE_API_KEY]);

        $redirectUrl = "https://www.lanerunner.com/subscription/thank-you.php";

        try {
            $customer = \Stripe\Customer::create([
                'source' => $this->token,
                'name' => $this->company_name,
                'email' => $this->company_email,
                'phone' => $this->contact_phone,
                'metadata' => [
                    'contact name' => $this->contact_name
                ],
            ]);

            //print_r(['customer' => $customer]);
        }
        catch (\Stripe\Exception\CardException $e) {
            $error = $e->getError();

            switch ($error['code']) {
                case 'card_declined':
                    $errorMessage = 'Payment card declined, please try with another card.';
                    break;
                case 'incorrect_number':
                    $errorMessage = 'Invalid card number, please try again.';
                    break;
                case 'invalid_expiry_month':
                    $errorMessage = 'Invalid expiry date, please try again.';
                    break;
                case 'invalid_expiry_year':
                    $errorMessage = 'Invalid expiry date, please try again.';
                    break;
                case 'invalid_cvc':
                    $errorMessage = 'Invalid cvc number, please try again.';
                    break;
                default:
                    $errorMessage = 'Error on form submission, please try again.';
                    break;
            }
            $res = array("error" => 1, "mensaje" => $errorMessage);

            echo json_encode($res);
            exit;

        } catch (\Stripe\Exception\StripeException $e) {
            $errorMessage = 'Error on form submission, please try again in a few minutes.';
            $res = array("error" => 1, "mensaje" => $errorMessage);
            echo json_encode($res);
            exit;

        }
        $this->stripe_customer_id = $customer->id;
        
        

        try {

            if ($stripe_plan === "LIFETIME") {

                try {
                    $totalAmount = $this->product['price'] * $this->licenses;
                    $description = 'Lifetime membership';

                    if (!empty($this->coupon_code)) {
                        $coupon = \Stripe\Coupon::retrieve($c_id);
                        $discountAmount = ($coupon->percent_off / 100) * $totalAmount;
                        $totalAmount = $totalAmount - $discountAmount;
                        $description .= " with coupon code: {$this->coupon_code}";
                    }

                    \Stripe\Charge::create([
                        'amount' => floor($totalAmount * 100),
                        'currency' => 'usd',
                        'description' => $description,
                        'customer' => $this->stripe_customer_id, // Use the customer ID
                    ]);


//                    $invoiceItem = \Stripe\InvoiceItem::create([
//                        'customer' => $this->stripe_customer_id,
//                        'amount' => floor($totalAmount * 100),
//                        'currency' => 'usd',
//                        'description' => $description,
//                    ]);
//
//                    $invoice = \Stripe\Invoice::create([
//                        'customer' => $this->stripe_customer_id,
//                        'auto_advance' => true,
//                        'collection_method' => 'charge_automatically',
//                        'amount' => floor($totalAmount * 100),
//                        'currency' => 'usd',
//                    ]);
//                    $r = $invoice->pay();
                } catch (\Stripe\Exception\CardException $e) {
                    // Payment failed
                    $error = "aca".$e->getError()->message;
                    // You can handle errors here

                    $res = array("error" => 1, "mensaje" => "aca".$e->getMessage());
                    echo json_encode($res);
                    exit;

                }


            } else {
                $payload = [
                    'customer' => $this->stripe_customer_id,
                    'items' => [
                        [
                            'price' => $this->product['priceId'],
                            'quantity' => $this->licenses,
                        ],
                    ],
                    'trial_period_days' => TRIAL_PERIOD,
                ];
                if (!empty($this->coupon_code)) {
                    // Please don't remove this line, it's used to apply the coupon code
                    $payload['discounts'] = [['coupon' => $this->coupon_code]];
                }
                $subscription = \Stripe\Subscription::create($payload);

                $this->subscription_id = $subscription->id;
                $this->status = $subscription->status;
            }


        } catch (\Stripe\Exception\ApiErrorException $e) {
            $res = array("error" => 1, "mensaje" => $e->getMessage(), "fullError" => $e->getLine());
            echo json_encode($res);
            exit;

        }


        // salio tordo ok de stripe, ahora inserto en la tabla de la empresa


        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO subscribers SET company_email = :company_email,
                                            contact_name = :contact_name,
                                            company_name = :company_name,
                                            billing_address = :billing_address,
                                            billing_zip_code = :billing_zip_code,
                                            contact_phone = :contact_phone,
                                            stripe_plan = '$stripe_plan',
                                            stripe_user = '$this->stripe_customer_id',
                                            billing_address2 = :billing_address2,
                                            billing_city = :billing_city,
                                            billing_state = :billing_state";


            $stmt = $con->prepare($sql);
            $stmt->bindValue("company_email", $this->company_email, PDO::PARAM_STR);
            $stmt->bindValue("contact_name", $this->contact_name, PDO::PARAM_STR);
            $stmt->bindValue("company_name", $this->company_name, PDO::PARAM_STR);
            $stmt->bindValue("billing_address", $this->billing_address, PDO::PARAM_STR);
            $stmt->bindValue("billing_zip_code", $this->billing_zip_code, PDO::PARAM_STR);
            $stmt->bindValue("contact_phone", $this->contact_phone, PDO::PARAM_STR);
            $stmt->bindValue("billing_address2", $this->billing_address2, PDO::PARAM_STR);
            $stmt->bindValue("billing_city", $this->billing_city, PDO::PARAM_STR);
            $stmt->bindValue("billing_state", $this->billing_state, PDO::PARAM_STR);

            $stmt->execute();
            $company = $con->lastInsertId();
            //  $stmt->debugDumpParams();

            $res = array("error" => 0, "company" => $company, 'redirectUrl' => $redirectUrl);
        } catch (PDOException $e) {
            //  echo $e->getMessage();
            $res = array("error" => 1, "mensaje" => $e->getMessage());

        }


        return json_encode($res);
    }

    public function generar_suscripcion()
    {


        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO subsc_transactions 
                    (`stripe_customer_id`, `stripe_subscription_id`, `stripe_plan_id`, `amount`, `currency`, `status`, `interval`, `interval_count`, `created_at`, `current_period_start`, `current_period_end`)
                    VALUES
                    (:stripe_customer_id, :subscription_id, :stripe_plan_id, :amount, :currency, :status, :interval, :interval_count, :created, :current_period_start, :current_period_end)";

            /*$sql = "INSERT INTO subsc_transactions SET stripe_customer_id = :stripe_customer_id,
                                             stripe_subscription_id = :subscription_id,
                                             stripe_plan_id = :stripe_plan_id,
                                             amount = :amount,
                                             currency = :currency,
                                             status = :status,
                                             'interval' = :interval,
                                             interval_count = :interval_count,
                                             created_at = :created,
                                             current_period_start = :current_period_start,
                                             current_period_end = :current_period_end";*/
            $stmt = $con->prepare($sql);
            $stmt->bindValue("stripe_customer_id", $this->stripe_customer_id, PDO::PARAM_STR);
            $stmt->bindValue("subscription_id", $this->subscription_id, PDO::PARAM_STR);
            $stmt->bindValue("stripe_plan_id", $this->stripe_plan_id, PDO::PARAM_STR);
            $stmt->bindValue("amount", $this->amount, PDO::PARAM_STR);
            $stmt->bindValue("currency", $this->currency, PDO::PARAM_STR);
            $stmt->bindValue("status", $this->status, PDO::PARAM_STR);
            $stmt->bindValue("interval", $this->interval, PDO::PARAM_STR);
            $stmt->bindValue("interval_count", $this->interval_count, PDO::PARAM_STR);
            $stmt->bindValue("created", $this->created, PDO::PARAM_STR);
            $stmt->bindValue("current_period_start", $this->current_period_start, PDO::PARAM_STR);
            $stmt->bindValue("current_period_end", $this->current_period_end, PDO::PARAM_STR);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }

    }

    public function update_expiry($user, $dt)
    {
        $sql = "UPDATE `subscribers` SET `expiry` = '$dt' WHERE `stripe_user` = '$user'";
        self::do_this($sql);
    }

    public function graba_mensaje()
    {
        $ahora = time();

        $sql = "INSERT INTO messages SET sender = 0, 
                                           receiver = $this->customer_id, 
                                           message_text = '$this->texto', 
                                           read_on = 0, 
                                           send_on = $ahora";
        self::do_this($sql);
    }

    public function do_this($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            //  echo "doThis error";
            return 0;
        }
    }

    public function generar_licencias($compania, $licencias)
    {


        $truncatedKey = array();

        for ($i = 0; $i < $licencias; $i++) {
            $uuid = Uuid::uuid4();
            $uuidString = $uuid->toString();
            $uuidString2 = $uuid->toString();

            $fin = $uuidString . $uuidString2;


            $llave = substr($fin, 0, 50);
            $truncatedKey[] = $llave;

            $sql = "INSERT INTO licenses SET company_id = $compania, license_key = '$llave'";
            self::do_this($sql);


        }

        return $truncatedKey;
    }

    public function trae_mensajes()
    {
        if ($this->completo === "1") {
            $sql = "SELECT * FROM messages WHERE sender = $this->customer_id OR receiver = $this->customer_id ORDER BY send_on ";
            return self::get_this_all($sql);
        } else {
            $sql = "SELECT * FROM messages WHERE send_on > $this->ultimo AND (sender = $this->customer_id OR receiver = $this->customer_id) ORDER BY send_on ";
            // echo $sql;
            return self::get_this_all($sql);
        }
    }

    public function get_this_all($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            //echo $sql;
            return 0;
        }
    }

    public function trae_cola_mensajes()
    {
        $sql = "SELECT * FROM customers WHERE customer_active = 1";
        $cc = self::get_this_all($sql);
        $cola = array();

        foreach ($cc as $v) {
            $sql = "SELECT * FROM messages WHERE dender = $v->customer_id OR receiver = $v->customer_id ORDER BY send_on DESC LIMIT 1";
            $habia = self::get_this_1($sql);
            if ($habia) {
                $habia->customer_firstName = $v->customer_firstName . " " . $v->customer_lastName;
                $habia->customer_id = $v->customer_id;
                $cola[] = $habia;
            }
        }
        return json_encode($cola);
    }


    /*public function login()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT customer_id, customer_nombre, customer_email, customer_tipo_suscripcion, customer_estado FROM customers WHERE customer_email = :email AND pass  = AES_ENCRYPT(:pass, '" . PWHASH . "') AND customer_estado = 1";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("email", $this->email, PDO::PARAM_STR);
            $stmt->bindValue("pass", $this->password, PDO::PARAM_STR);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "login function error";
        }
    }



    public function nuevoUsuario()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT IGNORE INTO usuarios_admin SET email = 'admin@admin.com', password  = AES_ENCRYPT('123', '" . PWHASH . "')";
            $stmt = $con->prepare($sql);
            $stmt->execute();

            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo $e->getMessage();
            // echo "login function error";
        }
    }*/

    public function get_this_1($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "getThis1 function error";
            return 0;
        }
    }

    public function traer_este_customer()
    {
        $ci = $_SESSION['customer']->customer_id;
        $sql = "SELECT *, AES_DECRYPT(customer_password, '" . PWHASH . "') as pass FROM customers WHERE customer_id = $ci";
        return self::get_this_1($sql);
    }

    public function traer_customers()
    {
        $sql = "SELECT * FROM customers WHERE 1";
        return self::get_this_all($sql);
    }

    public function insert_return_last_id($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $con->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }
    }
}

$customer = new Customer;