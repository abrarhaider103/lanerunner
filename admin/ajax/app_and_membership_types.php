<?php
include("../../config.php");
include("../adminClass.php");

try {
    // $types = $_POST['types'];
    // $res = $adm->getThis1($sql);
    // return $res;
    if(isset($_POST['types'])) {
        $types = $_POST['types'];
        $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT texto FROM app_and_membership_mockup WHERE types = :types"; // Use named placeholder
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":types", $types, PDO::PARAM_STR); // Bind the parameter
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if ($result !== false) {
            echo urldecode($result->texto); // Correct variable name
        } else {
            echo "No data found.";
        }
    }
    

} catch (PDOException $e) {
    // Handle PDO exception
    echo "Error: " . $e->getMessage();
}
?>
