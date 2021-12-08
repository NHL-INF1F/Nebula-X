<?php

function getSuite(int $id): ?Suite
{
    global $conn;
    if (!$result = $conn->query("SELECT * FROM suite WHERE ID = '$id'")) {
        echo "Error met het ophalen van suite.";
        return null;
    }
    if ($row = $result->fetch_assoc()) {
        return new Suite($row);
    }
    return null;
}

function getSuites(): ?array
{
    global $conn;
    $suites = [];
    if (!$result = $conn->query("SELECT * FROM suite")) {
        echo "Error met het ophalen van suites.";
        return null;
    }
    while ($row = $result->fetch_assoc()) {
        $suite = new Suite($row);
        array_push($suites, $suite);
    }
    return $suites;
}

function getFreeSuites($startDate, $endDate): ?array {
    global $conn;
    $suites = [];
    if (!$result = $conn->query("SELECT suite.* FROM reservation 
    INNER JOIN suite ON suite.ID = reservation.SUITE_ID WHERE
    '$startDate' < reservation.date_from OR '$endDate' > reservation.date_to;")) {
        echo "Error met het ophalen van suites.";
        return null;
    }
    while ($row = $result->fetch_assoc()) {
        $suite = new Suite($row);
        array_push($suites, $suite);
    }
    return $suites;
}