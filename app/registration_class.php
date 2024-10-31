<?php

class Registration
{
    private $he;
    private $sa;

    private $firstName;
    private $lastName;
    private $email;
    private $pass1;
    private $pass2;
    private $license;
    private $token;
    private $customer_firstName;
    private $customer_lastName;
    private $customer_email;
    private $customer_password;
    private $customer_password2;
    private $valor;
    private $want_to_learn;

    public function reset_pass(){
        if($this->customer_password === $this->customer_password2) {
            try {
                $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
                $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "UPDATE customers SET customer_password  = AES_ENCRYPT(:customer_password, '" . PWHASH . "') WHERE customer_email = :email";
                $stmt = $con->prepare($sql);
                $stmt->bindValue("customer_password", $this->customer_password, PDO::PARAM_STR);
                $stmt->bindValue("email", $this->email, PDO::PARAM_STR);
                $stmt->execute();

                return 1;
            } catch (PDOException $e) {
                //echo $e->getMessage();
                //echo "add customer function error";
                return 2;
            }
        }
        else {
            return 3;
        }
    }


    public static function getThisAll($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $sql;
            return 0;
        }
    }

    public function storeFormValues($params)
    {
        $this->__construct($params);
    }

    public function __construct($data = array())
    {
        if (isset($data['valor'])) {
            $this->valor = stripslashes(strip_tags($data['valor']));
        }

        if (isset($data['token'])) {
            $this->token = stripslashes(strip_tags($data['token']));
        }
        if (isset($data['customer_name'])) {
            $this->customer_firstName = stripslashes(strip_tags($data['customer_name']));
        }
        if (isset($data['customer_lastName'])) {
            $this->customer_lastName = stripslashes(strip_tags($data['customer_lastName']));
        }
        if (isset($data['customer_email'])) {
            $this->customer_email = stripslashes(strip_tags($data['customer_email']));
        }
        if (isset($data['customer_password2'])) {
            $this->customer_password2 = stripslashes(strip_tags($data['customer_password2']));
        }
        if (isset($data['customer_password'])) {
            $this->customer_password = stripslashes(strip_tags($data['customer_password']));
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
        if (isset($data['pass1'])) {
            $this->pass1 = stripslashes(strip_tags($data['pass1']));
        }
        if (isset($data['pass2'])) {
            $this->pass2 = stripslashes(strip_tags($data['pass2']));
        }
        if (isset($data['license'])) {
            $this->license = stripslashes(strip_tags($data['license']));
        }
        if (isset($data['want_to_learn'])) {
            $this->want_to_learn = stripslashes(strip_tags($data['want_to_learn']));
        }
    }

    public function inserto_customer()
    {
        // primero, que las pass sean iguales
        if ($this->pass1 !== $this->pass2) {
            return 0;
        }
        try {
            $teamId = null;

            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select company_id from licenses where license_key = :license";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("license", $this->license, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            $company_id = $row->company_id;

            $sql = "select count(*) as total from licenses where company_id = :company_id";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("company_id", $company_id, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_OBJ);
            $totalLicenses = $row->total;
            if ($totalLicenses > 1) {
                $sql = "select id from teams where reference_company_id = :reference_company_id";
                $stmt = $con->prepare($sql);
                $stmt->bindValue("reference_company_id", $company_id, PDO::PARAM_STR);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_OBJ);
                if ($row) {
                    $teamId = $row->id;
                } else {
                    $sql = "select company_name from subscribers where company_id = :company_id";
                    $stmt = $con->prepare($sql);
                    $stmt->bindValue("company_id", $company_id, PDO::PARAM_STR);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_OBJ);
                    $company_name = $row->company_name;

                    $sql = "INSERT INTO teams SET name = :name, reference_company_id = :company_id, is_active = :is_active, created_at = NOW(), updated_at = NOW()";
                    $stmt = $con->prepare($sql);
                    $stmt->bindValue("name", $company_name, PDO::PARAM_STR);
                    $stmt->bindValue("company_id", $company_id, PDO::PARAM_STR);
                    $stmt->bindValue("is_active", 1, PDO::PARAM_STR);
                    $stmt->execute();
                    $teamId = $con->lastInsertId();
                }
            }

            $sql = "INSERT INTO customers SET
                           customer_firstName = :firstName,
                           customer_lastName = :lastName,
                           customer_email = :email,
                           team_id = :team_id,
                           customer_registered_on = CURDATE(),
                           customer_password = AES_ENCRYPT(:pass1, '" . PWHASH . "'),
                           customer_active = 1 ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("firstName", $this->firstName, PDO::PARAM_STR);
            $stmt->bindValue("lastName", $this->lastName, PDO::PARAM_STR);
            $stmt->bindValue("email", $this->email, PDO::PARAM_STR);
            $stmt->bindValue("team_id", $teamId, PDO::PARAM_STR);
            $stmt->bindValue("pass1", $this->pass1, PDO::PARAM_STR);
            $stmt->execute();
            $new_user = $con->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }

        try {
            $sql = "UPDATE licenses SET already_taken = $new_user WHERE license_key = :license";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("license", $this->license, PDO::PARAM_STR);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }
    }

    public function doThis($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "doThis error";
            return 0;
        }
    }

    public function veoveo()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT *, AES_DECRYPT(customer_password, '" . PWHASH . "') as pass FROM customers WHERE 1 ";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetchAll(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }
    }

    public function set_token($token, $user_id)
    {
        $sql = "UPDATE customers SET app_token = '$token' WHERE customer_id = $user_id";
        self::doThis($sql);
    }

    public function login_token()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT customer_id,
                           customer_firstName,
                           customer_lastName,
                           customer_email,
                           customer_active,
                           customer_phone,
                           customer_subscription_to,
                           customer_dismiss_modal,
                           app_token,
                           want_to_learn
                    FROM customers WHERE app_token = :token ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("token", $this->token, PDO::PARAM_STR);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return 0;
        }
    }


    public function check_used_license(){
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT already_taken FROM licenses WHERE license_key = :license";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("license", $this->valor, PDO::PARAM_STR);
            $stmt->execute();
            $license = $stmt->fetch(PDO::FETCH_OBJ);
            //   $stmt->debugDumpParams();
            return $license;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 1;
        }
    }

    public function check_customer_mail()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT COUNT(*) as hay FROM customers WHERE customer_email = :customer_email ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_email", $this->valor, PDO::PARAM_STR);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            //  $stmt->debugDumpParams();
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }
    }

    public function login_customer()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT customer_id,
                           customer_firstName,
                           customer_lastName,
                           customer_email,
                           customer_active,
                           customer_dismiss_modal,
                           customer_stripe_customer,
                           customer_stripe_plan,
                           customer_phone,
                           customer_type_subscription,
                           want_to_learn,
                           customer_registered_on,
                           number_of_searches,
                           customer_active,
                           teams.is_active as team_active
                    FROM customers LEFT JOIN teams on customers.team_id = teams.id WHERE customer_email = :customer_email AND customer_password  = AES_ENCRYPT(:customer_password, '" . PWHASH . "') ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_email", $this->customer_email, PDO::PARAM_STR);
            $stmt->bindValue("customer_password", $this->customer_password, PDO::PARAM_STR);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            //  $stmt->debugDumpParams();
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }
    }

    function setAuthSessionId($customerId)
    {
        $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE customers SET auth_session_id = :auth_session_id WHERE customer_id = :customer_id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue("auth_session_id", session_id(), PDO::PARAM_STR);
        $stmt->bindValue("customer_id", $customerId, PDO::PARAM_STR);
        $stmt->execute();
    }

    function getAuthSessionId($customerId)
    {
        $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT auth_session_id FROM customers WHERE customer_id = :customer_id";
        $stmt = $con->prepare($sql);
        $stmt->bindValue("customer_id", $customerId, PDO::PARAM_STR);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        return $row->auth_session_id;
    }

    public function upd()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE customers SET customer_password  = AES_ENCRYPT('!@#cornea', '" . PWHASH . "')
                         WHERE customer_email = 'tim@lanerunner.com'";
            $stmt = $con->prepare($sql);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "add customer function error";
        }
    }

    public function addo_customer($email, $pass)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT IGNORE INTO customers SET  
                                                     customer_password  = AES_ENCRYPT('$pass', '" . PWHASH . "'),
                                                     customer_email = '$email',
                                                     customer_active = 1,
                                                     customer_registered_on = CURDATE()";
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $nUser = $con->lastInsertId();
            return $nUser;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "add customer function error";
        }
    }

    public function add_customer()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT IGNORE INTO customers SET customer_firstName = :customer_firstName,  
                                                     customer_lastName = :customer_lastName, 
                                                     customer_password  = AES_ENCRYPT(:customer_password, '" . PWHASH . "'), 
                                                     customer_email = :customer_email, 
                                                     customer_active = 1,
                                                     customer_registered_on = CURDATE()";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_firstName", $this->customer_firstName, PDO::PARAM_STR);
            $stmt->bindValue("customer_lastName", $this->customer_lastName, PDO::PARAM_STR);
            $stmt->bindValue("customer_password", $this->customer_password, PDO::PARAM_STR);
            $stmt->bindValue("customer_email", $this->customer_email, PDO::PARAM_STR);
            $stmt->execute();
            $nUser = $con->lastInsertId();
            return $nUser;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "add customer function error";
        }
    }

    public function getLoginToken($customer_id)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT customer_token FROM customer_token WHERE customer_id = :customer_id ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_id", $customer_id, PDO::PARAM_INT);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return 0;
        }
    }

    public function getCountCustomerLoginToken($customer_id)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT count(*) as allacount 
                    FROM customer_token WHERE customer_id = :customer_id ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_id", $customer_id, PDO::PARAM_STR);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            //echo $e->getMessage();
            return 0;
        }
    }

    public function setLoginToken($customer_id, $customer_token)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO customer_token SET customer_id = :customer_id,
                                                    customer_token = :customer_token,  
                                                    customer_date = CURDATE()";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_id", $customer_id, PDO::PARAM_INT);
            $stmt->bindValue("customer_token", $customer_token, PDO::PARAM_STR);
            $stmt->execute();
            $nUser = $con->lastInsertId();
            return $nUser;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "add customer_token error";
        }
    }

    public function upd_loginToken($customer_id, $customer_token)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE customer_token SET customer_token = :customer_token,  
                                                     customer_date = CURDATE()
                                                     WHERE customer_id = :customer_id";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_id", $customer_id, PDO::PARAM_INT);
            $stmt->bindValue("customer_token", $customer_token, PDO::PARAM_STR);
            $stmt->execute();
            $nUser = $con->lastInsertId();
            return $nUser;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "add customer_token error";
        }
    }

    public function getThis1($sql)
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
            echo $sql;
            return 0;
        }
    }

    public function getThis1Array($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_ASSOC);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $sql;
            return 0;
        }
    }

    public function getThisAllArray($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            $valid = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $sql;
            return 0;
        }
    }

    public function check_email()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT COUNT(*) as hay FROM customers WHERE customer_email = :email ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("email", $this->email, PDO::PARAM_STR);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return 0;
        }
    }

    public function hashEmail() {
        $salt = bin2hex(random_bytes(32)); // Generate a random salt
        $hashedEmail = hash('sha256', $this->email . $salt); // Hash email with salt
        return [$hashedEmail, $salt];
    }

}

$rp = new Registration;
