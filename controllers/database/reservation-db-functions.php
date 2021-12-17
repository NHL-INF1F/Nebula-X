<?php

function getSuite(int $id): ?array
{
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM suite WHERE ID = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    if (!$result = $stmt->get_result()) {
        echo "Error getting suite from database.";
        $stmt->close();
        $conn->next_result();
        return null;
    }
    if ($row = $result->fetch_assoc()) {
        //Tijdelijk
        $row['description'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pharetra neque tincidunt velit congue tempus. Mauris neque libero, aliquam non lorem ultricies, aliquet sagittis erat. Nunc finibus fermentum erat, nec vulputate nunc luctus vulputate. Donec ultrices sagittis felis ut malesuada. Mauris vitae viverra tellus. Nulla eleifend hendrerit venenatis. Praesent feugiat porttitor nisi, sed mollis tellus aliquet a. Duis convallis mauris ut dapibus condimentum. Aenean et egestas purus. Praesent bibendum dignissim ligula, non venenatis leo iaculis nec. Suspendisse diam tellus, tempor quis felis a, interdum tristique orci. Nulla egestas orci et varius lobortis. Fusce sed nisi lectus. Nullam sagittis, tellus eu euismod hendrerit, mauris neque posuere libero, quis facilisis elit diam id orci. Nunc at risus eu enim posuere euismod sed in tortor.";
        $stmt->close();
        $conn->next_result();
        return $row;
    }
    return null;
}

function bookSuite($userID, $suiteID, $dateFrom, $dateTo)
{
    global $conn;

    $stmt = $conn->prepare("INSERT INTO 
    reservation (`USER_ID`, `SUITE_ID`, `date_from`, `date_to`) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiss", $userID, $suiteID, $dateFrom, $dateTo);

    if (!$stmt->execute()) {
        $stmt->close();
        die("Error booking suite.");
    }
    $stmt->close();
    $conn->next_result();
}


function getFreeSuites($startDate, $endDate): ?array {
    //Get the dbconnect mysqli object from outside the function.
    global $conn;
    //Create an empty array.
    $suites = [];

    //Get all suites from the database.
    //This is needed because the second query does not return suites with no reservations.
    $stmt = $conn->prepare("SELECT suite.* FROM suite");
    $stmt->execute();


    if (!$result = $stmt->get_result()) {
        echo "Error getting suites from database.";
        $stmt->close();
        return null;
    }

    //Add all suites to the associative array.
    //The key is the ID, the value is the whole db row.
    while ($row = $result->fetch_assoc()) {
        //Temporarily set description here because it will be removed from the database and will be loaded from the language files.
        $row['description'] = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris pharetra neque tincidunt velit congue tempus. Mauris neque libero, aliquam non lorem ultricies, aliquet sagittis erat. Nunc finibus fermentum erat, nec vulputate nunc luctus vulputate. Donec ultrices sagittis felis ut malesuada. Mauris vitae viverra tellus. Nulla eleifend hendrerit venenatis. Praesent feugiat porttitor nisi, sed mollis tellus aliquet a. Duis convallis mauris ut dapibus condimentum. Aenean et egestas purus. Praesent bibendum dignissim ligula, non venenatis leo iaculis nec. Suspendisse diam tellus, tempor quis felis a, interdum tristique orci. Nulla egestas orci et varius lobortis. Fusce sed nisi lectus. Nullam sagittis, tellus eu euismod hendrerit, mauris neque posuere libero, quis facilisis elit diam id orci. Nunc at risus eu enim posuere euismod sed in tortor.";
        $suites[$row['ID']] = $row;
    }

    //Close the statement for the next one.
    $stmt->close();
    $conn->next_result();

    //Get all suites that have reservations between the given dates.

    $stmt = $conn->prepare("SELECT DISTINCT suite.ID FROM reservation 
    INNER JOIN suite ON suite.ID = reservation.SUITE_ID WHERE
    (reservation.date_from BETWEEN ? AND ?) AND 
    (reservation.date_to BETWEEN ? AND ?)");
    $stmt->bind_param("ssss", $startDate, $endDate, $startDate, $endDate);
    $stmt->execute();

    if (!$result = $stmt->get_result()) {
        echo "Error getting suites from database.";
        $stmt->close();
        return null;
    }

    //Loop through all suites with reservations and remove them from the array, so we are only left with suites with no reservations between the dates..
    while ($row = $result->fetch_assoc()) {
        unset ($suites[$row['ID']]);
    }
    $stmt->close();
    $conn->next_result();
    return $suites;
}