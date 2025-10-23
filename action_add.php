<?php

session_start();

include("config.php");
include("firebaseRDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $db = new firebaseRDB($databaseURL);
    
    
    $all_data = $db->retrieve("schedule");
    $all_data = json_decode($all_data, 1);
    
    $highest_id = 0;
    if (is_array($all_data)) {
        foreach (array_keys($all_data) as $id) {
            $parts = explode('_', $id);
            $numeric_part = (int)$parts[0]; 
            if ($numeric_part > $highest_id) {
                $highest_id = $numeric_part;
            }
        }
    }
    $new_id_number = $highest_id + 1;
    $formatted_id_number = str_pad($new_id_number, 3, "0", STR_PAD_LEFT);
    $facultyName = $_POST['lastName'] . ", " . $_POST['firstName'] . " " . $_POST['middleName'];
    $facultyName_safe = str_replace(' ', '_', preg_replace('/[^a-zA-Z0-9\s]/', '', $facultyName));
    $custom_id = $formatted_id_number . "_" . $facultyName_safe . "_" . $_POST['day'];
   
 
  
    $startTime12 = date("h:i A", strtotime($_POST['startTime']));
    $endTime12   = date("h:i A", strtotime($_POST['endTime']));
    
    $data_to_insert = [
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

    $result = $db->update("schedule", $custom_id, $data_to_insert);

    if ($result) {
        
        $_SESSION['status'] = 'added';
    } else {
        $_SESSION['status'] = 'error';
    }

   
    header("Location: dashboard.php"); //connected to meetLink must stay here
    exit();

} else {
    echo "Invalid request.";
}
?>