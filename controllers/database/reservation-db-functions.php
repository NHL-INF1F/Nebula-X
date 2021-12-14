<?php

function getSuite(int $id): ?array
{
    global $conn;
    if (!$result = $conn->query("SELECT * FROM suite WHERE ID = '$id'")) {
        echo "Error getting suite from database.";
        return null;
    }
    if ($row = $result->fetch_assoc()) {
        return $row;
    }
    return null;
}

function getSuites(): ?array
{
    global $conn;
    $suites = [];
    if (!$result = $conn->query("SELECT * FROM suite")) {
        echo "Error getting suites from database.";
        return null;
    }
    while ($row = $result->fetch_assoc()) {
        array_push($suites, $row);
    }
    return $suites;
}

function getFreeSuites($startDate, $endDate): ?array {
    global $conn;
    $suites = [];
    if (!$result = $conn->query("SELECT suite.* FROM reservation 
    INNER JOIN suite ON suite.ID = reservation.SUITE_ID WHERE
    '$startDate' < reservation.date_from OR '$endDate' > reservation.date_to;")) {
        echo "Error getting suites from database.";
        return null;
    }
    while ($row = $result->fetch_assoc()) {
        array_push($suites, $row);
    }
    return $suites;
}