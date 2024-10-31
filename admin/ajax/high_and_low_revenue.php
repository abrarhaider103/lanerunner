<?php
include("../../config.php");

try {
    if(isset($_POST['lane']) && isset($_POST['valuesHL'])) {

        $lane = $_POST['lane'];
        $valuesHL = $_POST['valuesHL'];
        $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT high_revenue_text FROM high_and_low_revenue_lanes_data WHERE lane = :lane AND valuesHL = :valuesHL";
        $stmt = $con->prepare($sql);
        $stmt->bindParam(":lane", $lane, PDO::PARAM_STR);
        $stmt->bindParam(":valuesHL", $valuesHL, PDO::PARAM_STR);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_OBJ);
        if ($result !== false) {
            echo urldecode($result->high_revenue_text);
        } else {
            echo "No data found.";
        }
    }
} catch (PDOException $e) {
    // Handle PDO exception
    echo "Error: " . $e->getMessage();
}
?>
