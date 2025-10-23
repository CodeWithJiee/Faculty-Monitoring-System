<?php

session_start();

include("config.php");
include("firebaseRDB.php");

$db = new firebaseRDB($databaseURL);
$id = $_POST['id'];

// Convert time to 12-hour format
$startTime12 = date("h:i A", strtotime($_POST['startTime']));
$endTime12   = date("h:i A", strtotime($_POST['endTime']));
$facultyName = $_POST['lastName'] . ", " . $_POST['firstName'] . " " . $_POST['middleName'];

$updateData = [
    "facultyName"       => $facultyName,
    "lastName"          => $_POST['lastName'],
    "firstName"         => $_POST['firstName'],
    "middleName"       => $_POST['middleName'],
    "rank"              => $_POST['rank'],
    "section"           => $_POST['section'],
    "subject"           => $_POST['subject'],
    "room"              => $_POST['room'],
    "day"               => $_POST['day'],
    "startTime"         => $startTime12, 
    "endTime"           => $endTime12,   
    "attendanceDate"    => $_POST['date'],
    "modality"          => $_POST['modality'],
    "meetingLink"       => $_POST['meetLink'],
    "facultyAttendance" => $_POST['facultyAttendance'],
    "dressCode"         => $_POST['dressCode'],
    "remarks"           => $_POST['remarks']
];


$update = $db->update("schedule", $id, $updateData);

if ($update) {
    $_SESSION['status'] = 'updated';
    
} else {
    $_SESSION['status'] = 'error';
   
}
header("Location: dashboard.php"); //connected to meetLink must stay here

exit();
?>