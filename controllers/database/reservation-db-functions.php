<?php

function getSuite(int $id): ?array {
    global $conn;
    if (!$result = $conn->query("SELECT * FROM suite WHERE ID = '$id'")) {
        echo "Error getting suite from database.";
        return null;
    }
    if ($row = $result->fetch_assoc()) {
        //Tijdelijk
        $row['description'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pharetra neque tincidunt velit congue tempus. Mauris neque libero, aliquam non lorem ultricies, aliquet sagittis erat. Nunc finibus fermentum erat, nec vulputate nunc luctus vulputate. Donec ultrices sagittis felis ut malesuada. Mauris vitae viverra tellus. Nulla eleifend hendrerit venenatis. Praesent feugiat porttitor nisi, sed mollis tellus aliquet a. Duis convallis mauris ut dapibus condimentum. Aenean et egestas purus. Praesent bibendum dignissim ligula, non venenatis leo iaculis nec. Suspendisse diam tellus, tempor quis felis a, interdum tristique orci. Nulla egestas orci et varius lobortis. Fusce sed nisi lectus. Nullam sagittis, tellus eu euismod hendrerit, mauris neque posuere libero, quis facilisis elit diam id orci. Nunc at risus eu enim posuere euismod sed in tortor.";
        return $row;
    }
    return null;
}

function getSuites(): ?array {
    global $conn;
    $suites = [];
    if (!$result = $conn->query("SELECT * FROM suite")) {
        echo "Error getting suites from database.";
        return null;
    }
    while ($row = $result->fetch_assoc()) {
        //Tijdelijk
        $row['description'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pharetra neque tincidunt velit congue tempus. Mauris neque libero, aliquam non lorem ultricies, aliquet sagittis erat. Nunc finibus fermentum erat, nec vulputate nunc luctus vulputate. Donec ultrices sagittis felis ut malesuada. Mauris vitae viverra tellus. Nulla eleifend hendrerit venenatis. Praesent feugiat porttitor nisi, sed mollis tellus aliquet a. Duis convallis mauris ut dapibus condimentum. Aenean et egestas purus. Praesent bibendum dignissim ligula, non venenatis leo iaculis nec. Suspendisse diam tellus, tempor quis felis a, interdum tristique orci. Nulla egestas orci et varius lobortis. Fusce sed nisi lectus. Nullam sagittis, tellus eu euismod hendrerit, mauris neque posuere libero, quis facilisis elit diam id orci. Nunc at risus eu enim posuere euismod sed in tortor.";
        array_push($suites, $row);
    }
    return $suites;
}

function bookSuite($userID, $suiteID, $dateFrom, $dateTo){
    global $conn;
    $sql = "INSERT INTO reservation (`USER_ID`, `SUITE_ID`, `date_from`, `date_to`) VALUES
  ('" . $userID . "', '" . $suiteID . "',
'" . $dateFrom . "', '" . $dateTo . "')";

    if ($conn->query($sql) !== TRUE) {
        die("Error booking suite.");
    }
}

function getFreeSuites($startDate, $endDate): ?array {
    global $conn;
    $suites = [];
    $sql = "SELECT DISTINCT suite.* FROM reservation 
    INNER JOIN suite ON suite.ID = reservation.SUITE_ID WHERE
    (reservation.date_from NOT BETWEEN '" . $startDate . "' AND '" . $endDate . "') AND 
    (reservation.date_to NOT BETWEEN '" . $startDate . "' AND '" . $endDate . "')";
    if (!$result = $conn->query($sql)) {
        echo "Error getting suites from database.";
        return null;
    }
    while ($row = $result->fetch_assoc()) {
        array_push($suites, $row);
    }
    return $suites;
}