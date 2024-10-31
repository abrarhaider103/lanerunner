<?php
require_once('../config.php');

function searchCities($cityQuery, $transformForDropdown = false) {
    $sql = 'SELECT population, CONCAT(city, ", ", state_id) as city FROM uscities WHERE city LIKE :city ORDER BY population DESC';
    $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES UTF8"));
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':city', '%' . $cityQuery . '%', PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$transformForDropdown) {
        $results = array_map(function($result) {
            return [
                'id' => $result['city'],
                'text' => $result['city'],
            ];
        }, $results);
    }

    return $results;
}