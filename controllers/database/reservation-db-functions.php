<?php

function getSuite(int $id): ?array {
    global $conn;
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT * FROM suite WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    if (!$result = mysqli_stmt_get_result($stmt)) {
        echo "Error getting suite from database.";
        mysqli_stmt_close($stmt);
        mysqli_next_result($conn);
        return null;
    }
    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        mysqli_next_result($conn);
        return $row;
    }
    return null;
}

function getReservation(int $suiteID, int $userID, string $dateFrom, string $dateTo){
    global $conn;
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT ID FROM reservation WHERE USER_ID = ? AND SUITE_ID = ? AND date_from = ? AND date_to = ?");

    mysqli_stmt_bind_param($stmt, "iiss", $userID, $suiteID, $dateFrom, $dateTo);
    mysqli_stmt_execute($stmt);

    if (!$result = mysqli_stmt_get_result($stmt)) {
        mysqli_stmt_close($stmt);
        mysqli_next_result($conn);
        return null;
    }
    if ($row = mysqli_fetch_assoc($result)) {
        mysqli_stmt_close($stmt);
        mysqli_next_result($conn);
        return $row['ID'];
    }
    return null;
}

function bookSuite($userID, $suiteID, $dateFrom, $dateTo): bool {
    global $conn;
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "INSERT INTO 
    reservation (`USER_ID`, `SUITE_ID`, `date_from`, `date_to`) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iiss", $userID, $suiteID, $dateFrom, $dateTo);

    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return false;
    }
    mysqli_stmt_close($stmt);
    mysqli_next_result($conn);
    return true;
}


function getFreeSuites($startDate, $endDate): ?array {
    //Get the dbconnect mysqli object from outside the function.
    global $conn;
    //Create an empty array.
    $suites = [];

    //Get all suites from the database.
    //This is needed because the second query does not return suites with no reservations.
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT suite.* FROM suite");
    mysqli_stmt_execute($stmt);

    if (!$result = mysqli_stmt_get_result($stmt)) {
        echo "Error getting suites from database.";
        mysqli_stmt_close($stmt);
        return null;
    }

    //Add all suites to the associative array.
    //The key is the ID, the value is the whole db row.
    while ($row = mysqli_fetch_assoc($result)) {
        $suites[$row['ID']] = $row;
    }

    //Close the statement for the next one.
    mysqli_stmt_close($stmt);
    mysqli_next_result($conn);

    //Get all suites that have reservations between the given dates.
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT DISTINCT suite.ID FROM reservation 
    INNER JOIN suite ON suite.ID = reservation.SUITE_ID WHERE
    (reservation.date_from BETWEEN ? AND ?) AND 
    (reservation.date_to BETWEEN ? AND ?)");

    mysqli_stmt_bind_param($stmt, "ssss", $startDate, $endDate, $startDate, $endDate);
    mysqli_stmt_execute($stmt);

    if (!$result = mysqli_stmt_get_result($stmt)) {
        echo "Error getting suites from database.";
        mysqli_stmt_close($stmt);
        return null;
    }

    //Loop through all suites with reservations and remove them from the array, so we are only left with suites with no reservations between the dates..
    while ($row = mysqli_fetch_assoc($result)) {
        unset ($suites[$row['ID']]);
    }
    mysqli_stmt_close($stmt);
    mysqli_next_result($conn);
    return $suites;
}