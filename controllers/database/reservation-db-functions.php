<?php

/**
 * Gets the data for the given suite.
 *
 * @param int $id The ID of the suite.
 * @return array|null A array containing the suite data.
 */
function getSuite(int $id): ?array {
    global $conn;
    $stmt = mysqli_stmt_init($conn);
    mysqli_stmt_prepare($stmt, "SELECT * FROM suite WHERE ID = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);

    if (!$result = mysqli_stmt_get_result($stmt)) {
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

/**
 * Checks if the given reservation exists in the database.
 *
 * @param int $suiteID The suite ID of the reservation.
 * @param int $userID The user ID of the reservation.
 * @param string $dateFrom The start date of the reservation.
 * @param string $dateTo The end date of the reservation.
 *
 * @return string|null Returns the ID of the reservation exists and null if it does not.
 */
function getReservation(int $suiteID, int $userID, string $dateFrom, string $dateTo): ?string {
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

/**
 * Adds a reservation using the given arguments.
 *
 * @param int $userID The ID of the user.
 * @param int $suiteID The ID of the suite.
 * @param string $dateFrom The start date of the reservation/
 * @param string $dateTo The end date of the reservation.
 * @return bool Returns if the booking was successful.
 */
function bookSuite(int $userID, int $suiteID, string $dateFrom, string $dateTo): bool {
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
