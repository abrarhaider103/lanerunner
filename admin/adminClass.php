<?php

class Adm
{
    private $laner_id;
    private $userName;
    private $password;
    private $fullName;
    private $email;
    private $rol;
    private $uId;
    private $user_id;
    private $user_active;
    private $reply;
    private $mid;
    private $title;
    private $receiver;
    private $subject;
    private $message_text;
    private $market_text_encoded;
    private $lane;
    private $pointOnVertex;
    private $valuesHL;
    private $types;



    public function __construct($data = array())
    {
        if (isset($data['laner_id'])) {
            $this->laner_id = stripslashes(strip_tags($data['laner_id']));
        }
        if (isset($data['userName'])) {
            $this->userName = stripslashes(strip_tags($data['userName']));
        }
        if (isset($data['password'])) {
            $this->password = stripslashes(strip_tags($data['password']));
        }
        if (isset($data['fullName'])) {
            $this->fullName = stripslashes(strip_tags($data['fullName']));
        }
        if (isset($data['email'])) {
            $this->email = stripslashes(strip_tags($data['email']));
        }
        if (isset($data['rol'])) {
            $this->rol = stripslashes(strip_tags($data['rol']));
        }
        if (isset($data['uId'])) {
            $this->uId = stripslashes(strip_tags($data['uId']));
        }
        if (isset($data['user_id'])) {
            $this->user_id = stripslashes(strip_tags($data['user_id']));
        }
        if (isset($data['user_active'])) {
            $this->user_active = stripslashes(strip_tags($data['user_active']));
        }
        if (isset($data['reply'])) {
            $this->reply = stripslashes(strip_tags($data['reply']));
        }
        if (isset($data['mid'])) {
            $this->mid = stripslashes(strip_tags($data['mid']));
        }
        if (isset($data['title'])) {
            $this->title = stripslashes(strip_tags($data['title']));
        }
        if (isset($data['receiver'])) {
            $this->receiver = stripslashes(strip_tags($data['receiver']));
        }
        if (isset($data['subject'])) {
            $this->subject = stripslashes(strip_tags($data['subject']));
        }
        if (isset($data['message_text'])) {
            $this->message_text = stripslashes(strip_tags($data['message_text']));
        }
        if (isset($data['market_text_encoded'])) {
            $this->market_text_encoded = stripslashes(strip_tags($data['market_text_encoded']));
        }
        if (isset($data['lane'])) {
            $this->lane = stripslashes(strip_tags($data['lane']));
        }
        if (isset($data['valuesHL'])) {
            $this->valuesHL = stripslashes(strip_tags($data['valuesHL']));
        }
        if (isset($data['types'])) {
            $this->types = stripslashes(strip_tags($data['types']));
        }


    }

    /*
Array
(
    [receiver] => 20
    [subject] => test
    [message_text] => message new
)
*/

    public function storeFormValues($params)
    {
        $this->__construct($params);
    }


    /*
   Array
(
    [laner_id] => 20
    [userName] => Lanerunner 20 Memphis Expert (HOT LANE)
    [email] => laner20@lanerunner.com
    [fullName] => 
    [password] => laner20@lanerunner.com111
    [user_active] => 1
)

            */

    public function save_market_text($sql = null){
        if(!isset($sql)){
            $sql = "UPDATE market_conditions_data SET market_conditions_text = :market_text_encoded WHERE id = 1";
        }
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->bindValue("market_text_encoded", $this->market_text_encoded, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "update function error";
        }
    }
    public function save_high_value_lanes_text(){
        $sql = "UPDATE high_and_low_revenue_lanes_data SET high_revenue_text = :high_revenue_text Where lane = :lane AND valuesHL = :valuesHL";
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":high_revenue_text", $this->market_text_encoded, PDO::PARAM_STR);
            $stmt->bindValue(":lane", $this->lane, PDO::PARAM_STR);
            $stmt->bindValue(":valuesHL", $this->valuesHL, PDO::PARAM_STR);
            $stmt->execute();
            echo "Record Updated Successfully";
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "update function error";
        }
    }
    public function save_mob_and_mockup(){
        $sql = "UPDATE app_and_membership_mockup SET texto = :market_text_encoded Where types = :types";
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":types", $this->types, PDO::PARAM_STR);
            $stmt->bindValue(":market_text_encoded", $this->market_text_encoded, PDO::PARAM_STR);
            $stmt->execute();
            echo "Record Updated Successfully";
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false; // Return false indicating an error occurred
        }
    }



    public function editLaner()
    {
        $sql = "UPDATE laners SET full_name = :userName,
                                          email = :email,
                                          laner_name = :fullName,
                                          active_status = :user_active,
                                          password = AES_ENCRYPT(:password,'" . PWHASH . "')
                                          WHERE laner_id = $this->laner_id";

        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->bindValue("userName", $this->userName, PDO::PARAM_STR);
            $stmt->bindValue("password", $this->password, PDO::PARAM_STR);
            $stmt->bindValue("fullName", $this->fullName, PDO::PARAM_STR);
            $stmt->bindValue("email", $this->email, PDO::PARAM_STR);
            $stmt->bindValue("user_active", $this->user_active, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "update function error";
        }
    }

    public function get_laners()
    {
        $sql = "SELECT * FROM laners WHERE 1";
        return self::getThisAll($sql);
    }

    public function get_laner($laner_id)
    {
        $sql = "SELECT *, AES_DECRYPT(password,'" . PWHASH . "') as pass FROM laners WHERE laner_id = $laner_id";
        $laner['data'] = self::getThis1($sql);
        $sql = "SELECT a.fantasy_name, a.lane_id, b.region_name as origin, c.region_name as destination FROM lanes a JOIN master_regions b ON a.origin = b.region_id 
                                                                                                                     JOIN master_regions c ON a.destination = c.region_id 
                                                                                                                     JOIN lanes_assigned d ON a.lane_id = d.lane_id 
                                                                                                                     WHERE d.laner_id = $laner_id ORDER BY origin, destination";
        $laner['lanes'] = self::getThisAll($sql);
        return $laner;
    }

    public function get_all_lanes()
    {
        $sql = "SELECT a.fantasy_name, a.lane_id, b.region_name as origin, c.region_name as destination, a.lane_cost FROM lanes a JOIN master_regions b ON a.origin = b.region_id JOIN master_regions c ON a.destination = c.region_id WHERE 1";
        return self::getThisAll($sql);
    }

    public function save_first_message()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO messages SET sender = :sender, receiver = :receiver, message_text = :message_text, message_title = :subject, sent_on = NOW()";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("sender", $this->user_id, PDO::PARAM_STR);
            $stmt->bindValue("receiver", $this->receiver, PDO::PARAM_STR);
            $stmt->bindValue("message_text", $this->message_text, PDO::PARAM_STR);
            $stmt->bindValue("subject", $this->subject, PDO::PARAM_STR);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "error graba mensaje";
        }
    }

    public function save_message_reply()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO messages SET sender = :sender, receiver = :receiver, message_text = :reply, message_title = :title, reply_id = :mid, sent_on = NOW()";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("sender", $this->user_id, PDO::PARAM_STR);
            $stmt->bindValue("receiver", $this->receiver, PDO::PARAM_STR);
            $stmt->bindValue("reply", $this->reply, PDO::PARAM_STR);
            $stmt->bindValue("title", $this->title, PDO::PARAM_STR);
            $stmt->bindValue("mid", $this->mid, PDO::PARAM_STR);
            $stmt->execute();
            return 1;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "error graba mensaje";
        }
    }


    public function get_replies($mid)
    {
        $sql = "SELECT  a.*, b.userName as sender_username FROM messages a JOIN users b ON a.sender = b.user_id WHERE reply_id = $mid AND msg_id != $mid ";
        $msg = self::getThisAll($sql);
        return $msg;
    }

    public function get_this_message($mid, $user_id)
    {

        $sql = "SELECT  a.*, b.userName as sent_from FROM messages a JOIN users b ON a.receiver = b.user_id WHERE msg_id = $mid";
        $msg = self::getThis1($sql);

        if ($msg) {
            $sql = "UPDATE messages SET read_on = NOW() WHERE msg_id = $mid";
            self::doThis($sql);
            return $msg;
        } else {
            return 0;
        }
    }


    public function check_messages($user_id)
    {
        $sql = "SELECT  *, count(*) as total FROM messages WHERE receiver = $user_id OR sender = $user_id GROUP BY reply_id ORDER BY sent_on DESC  LIMIT 10";
        return self::getThisAll($sql);
    }

    public function editUser()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE users SET userName = :userName,  password  = AES_ENCRYPT(:password, '" . PWHASH . "'), fullName = :fullName, email = :email,  user_rol  = :rol, user_active = :user_active WHERE user_id = $this->user_id  ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("userName", $this->userName, PDO::PARAM_STR);
            $stmt->bindValue("password", $this->password, PDO::PARAM_STR);
            $stmt->bindValue("fullName", $this->fullName, PDO::PARAM_STR);
            $stmt->bindValue("email", $this->email, PDO::PARAM_STR);
            $stmt->bindValue("rol", $this->rol, PDO::PARAM_INT);
            $stmt->bindValue("user_active", $this->user_active, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "update function error";
        }
    }

    public function getAvailableRegions($region_id_origin)
    {
        $sql = "SELECT region_id, region_name FROM master_regions WHERE region_id NOT IN (SELECT region_id_destination FROM regions_assigned WHERE region_id_origin = $region_id_origin) AND canada = 0 AND region_name != '' ORDER BY RIGHT(region_name, 2) ASC";
        return self::getThisAllArray($sql);
    }

    public function getAllRegionNames()
    {
        $sql = "SELECT region_id, region_name FROM master_regions WHERE canada = 0 AND region_name != '' ORDER BY RIGHT(region_name, 2) ASC;";
        return self::getThisAll($sql);
    }
    public function getRegionsAssigned()
    {
        $sql = "SELECT  a.quote_assignment, a.fantasy_name as internal_name, a.user_assigned, a.origin, b.userName FROM quote_assignment a JOIN users b ON a.user_assigned = b.user_id";
        return self::getThisAll($sql);
    }

    public function getRegionByUser()
    {
        $sql = "SELECT user_id, userName FROM users WHERE user_active = 1";
        $usrs = self::getThisAll($sql);

        foreach ($usrs as $v) {
            $regions_assigned[$v->user_id]['name'] = $v->userName;
            $sql0 = "SELECT COUNT(DISTINCT(region_id_origin)) as origin, COUNT(DISTINCT(region_id_destination)) as destination FROM regions_assigned WHERE user_id = $v->user_id";
            $reg = self::getThis1($sql0);
            if (!empty($reg)) {
                $regions_assigned[$v->user_id]['origin'] = $reg->origin;
                $regions_assigned[$v->user_id]['destination'] = $reg->destination;
            } else {
                $regions_assigned[$v->user_id]['origin'] = 0;
                $regions_assigned[$v->user_id]['destination'] = 0;
            }
        }


        return $regions_assigned;
    }


    public function addUser()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT IGNORE INTO users SET userName = :userName,  password  = AES_ENCRYPT(:password, '" . PWHASH . "'), fullName = :fullName, email = :email,  user_rol  = :rol, user_active = 1  ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("userName", $this->userName, PDO::PARAM_STR);
            $stmt->bindValue("password", $this->password, PDO::PARAM_STR);
            $stmt->bindValue("fullName", $this->fullName, PDO::PARAM_STR);
            $stmt->bindValue("email", $this->email, PDO::PARAM_STR);
            $stmt->bindValue("rol", $this->rol, PDO::PARAM_INT);
            $stmt->execute();
            $nUser =  $con->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "login function error";
        }
    }


    public function getThisUser($user_id)
    {
        $sql = "SELECT userName, fullName, email, user_rol, user_active, AES_DECRYPT(password, '" . PWHASH . "') as password FROM users WHERE user_id = $user_id";
        return self::getThis1($sql);
    }

    public function getAllUsers()
    {
        $sql = "SELECT * FROM users WHERE 1";
        return self::getThisAll($sql);
    }


    public function deleteUser()
    {
        $sql = "DELETE FROM users WHERE user_id = $this->uId";
        return self::doThis($sql);
    }


    function pointInPolygon($point, $polygon, $pointOnVertex = true)
    {
        $this->pointOnVertex = $pointOnVertex;

        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array();
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex);
        }

        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            //return "vertex";
            return 1;
        }

        // Check if the point is inside the polygon or on the boundary
        $intersections = 0;
        $vertices_count = count($vertices);

        for ($i = 1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i - 1];
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                //return "boundary";
                return 1;
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) {
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x'];
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    //return "boundary";
                    return 1;
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++;
                }
            }
        }
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            //return "inside";
            return 1;
        } else {
            //return "outside";
            return 0;
        }
    }
    function pointOnVertex($point, $vertices)
    {
        foreach ($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
    }

    function pointStringToCoordinates($pointString)
    {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }

    public function login3()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO users SET userName = 'guti2', password  = AES_ENCRYPT('guti2', '" . PWHASH . "'), fullName = 'Tidddm', email = 'tiddm@lanerunner.com', user_active = 1";
            $stmt = $con->prepare($sql);
            
            $stmt->execute();
            
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "login functidsfsdfsdfon error";
        }
    }


    public function login()
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT * FROM users WHERE userName = :userName AND password  = AES_ENCRYPT(:password, '" . PWHASH . "') ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("userName", $this->userName, PDO::PARAM_STR);
            $stmt->bindValue("password", $this->password, PDO::PARAM_STR);
            $stmt->execute();
            $valid = $stmt->fetch(PDO::FETCH_OBJ);
            return $valid;
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "login function error";
        }
    }



    public function getAllRegions()
    {
        $s0 = "SELECT * FROM master_regions";
        $s = self::getThisAll($s0);
        return $s;
    }

    public function getAllUsRegions()
    {
        $s0 = "SELECT * FROM master_regions WHERE canada = 0 and region_name != '' ORDER BY region_name";
        $s = self::getThisAll($s0);
        return $s;
    }

    public function get_coupons(){
        $sql = "SELECT * FROM coupons WHERE 1";
        return self::getThisAll($sql);
    }
    public function getAllStates()
    {
        $s0 = "SELECT DISTINCT(state_name) as state, state_id FROM cities WHERE 1";
        $s = self::getThisAll($s0);
        return $s;
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
            echo $e->getMessage();
            echo $sql;
            return 0;
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



    public function insertReturnLastId($sql)
    {
        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $con->prepare($sql);
            $stmt->execute();
            return $con->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo "laconcw";
            echo $sql;
        }
    }

    public function addCustomer($data)
    {
        try {
            $customerpassword =$data['password'];
            $customer_firstName = $data['firstName'];
            $customer_lastName = $data['lastName'];
            $customer_phone =$data['mobile_number'];
            $customer_email =$data['email'];
            $team_id =$data['team_id'];
            $source ='portal';
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO customers SET
                customer_firstName = :customer_firstName,
                customer_lastName = :customer_lastName,
                customer_email = :customer_email,
                customer_phone = :customer_phone,
                team_id = :team_id,
                source = :source,
                customer_registered_on = CURDATE(),
                customer_password = AES_ENCRYPT(:customerpassword, '" . PWHASH . "'),
                customer_active = 1 ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_firstName", $customer_firstName, PDO::PARAM_STR);
            $stmt->bindValue("customer_lastName", $customer_lastName, PDO::PARAM_STR);
            $stmt->bindValue("customer_email", $customer_email, PDO::PARAM_STR);
            $stmt->bindValue("customer_phone", $customer_phone, PDO::PARAM_STR);
            $stmt->bindValue("team_id", $team_id, PDO::PARAM_STR);
            $stmt->bindValue("source", $source, PDO::PARAM_STR);
            $stmt->bindValue("customerpassword", $customerpassword, PDO::PARAM_STR);
            $stmt->execute();
            return $con->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $sql;

        }
    }

    public function updateCustomer($data)
    {
        try {
            $customerpassword =$data['password'];
            $customer_firstName = $data['firstName'];
            $customer_lastName = $data['lastName'];
            $customer_phone =$data['mobile_number'];
            $customer_email =$data['email'];
            $customer_active =$data['customer_active'];
            $team_id =$data['team_id'];

            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE  customers SET
                customer_firstName = :customer_firstName,
                customer_lastName = :customer_lastName,
                customer_email = :customer_email,
                customer_phone = :customer_phone,
                team_id = :team_id,";
            if($customerpassword){
                $sql .=  "customer_password = AES_ENCRYPT(:customerpassword, '" . PWHASH . "'),";
            }
            $sql .="customer_active = :customer_active WHERE customer_id= ".$data['cid']."";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("customer_firstName", $customer_firstName, PDO::PARAM_STR);
            $stmt->bindValue("customer_lastName", $customer_lastName, PDO::PARAM_STR);
            $stmt->bindValue("customer_email", $customer_email, PDO::PARAM_STR);
            $stmt->bindValue("customer_phone", $customer_phone, PDO::PARAM_STR);
            $stmt->bindValue("team_id", $team_id, PDO::PARAM_STR);
            if($customerpassword){
                $stmt->bindValue("customerpassword", $customerpassword, PDO::PARAM_STR);}
            $stmt->bindValue("customer_active", $customer_active, PDO::PARAM_STR);
            $stmt->execute();
            return $con->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $sql;

        }
    }

    public function getThisCustomer($customer_id)
    {
        $sql = "SELECT * FROM customers WHERE customer_id = $customer_id";
        return self::getThis1($sql);
    }

    public function getAllCustomer()
    {
        $sql = "SELECT * FROM customers 
       left join teams as t on t.id= customers.team_id
         WHERE 1";
        return self::getThisAll($sql);
    }
    public function deleteCustomer($id)
    {
        $sql = "DELETE FROM customers WHERE customer_id = $id";
        return self::doThis($sql);
    }

    // team work
    public function addTeam($data)
    {
        try {
            $name =$data['name'];
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO teams SET
                    name = :name
                    ";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("name", $name, PDO::PARAM_STR);

            $stmt->execute();
            return $con->lastInsertId();
        } catch (PDOException $e) {

            echo $e->getMessage();
            echo $sql;

        }
    }
    public function updateTeam($data)
    {
        try {
            $name =$data['name'];
            $is_active = $data['is_active'];
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE  teams SET
                    name = :name,
                    is_active = :is_active 
                WHERE id= ".$data['tid']."";
            $stmt = $con->prepare($sql);
            $stmt->bindValue("name", $name, PDO::PARAM_STR);
            $stmt->bindValue("is_active", $is_active, PDO::PARAM_STR);
            $stmt->execute();
            return $con->lastInsertId();
        } catch (PDOException $e) {
            echo $e->getMessage();
            echo $sql;

        }
    }
    public function getThisTeam($team_id)
    {
        $sql = "SELECT * FROM teams WHERE id = $team_id";
        return self::getThis1($sql);
    }
    public function getAllTeams()
    {
        $sql = "SELECT * FROM teams WHERE 1";
        return self::getThisAll($sql);
    }
    public function deleteTeam($id)
    {
        $sql = "DELETE FROM teams WHERE id = $id";
        $sql11 = "DELETE FROM customers WHERE team_id = $id";
        self::doThis($sql11);
        return self::doThis($sql);
    }
    public function getCustomerByTeamid($id)
    {
        $sql = "SELECT * FROM customers 
         left join teams as t on t.id= customers.team_id
        WHERE team_id = $id";
        return self::getThisAll($sql);
    }
}
$adm = new Adm;
