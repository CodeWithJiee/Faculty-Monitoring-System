<?php

session_start();

include("config.php");
include("firebaseRDB.php");

$db = new firebaseRDB($databaseURL);
$id = $_GET['id'];
$retrieve = $db->retrieve("schedule/$id");
$data = json_decode($retrieve, 1);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>Edit Faculty Monitoring</title>
</head>

<body>
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0">Edit Faculty Daily Monitoring</h5>
        </div>
        <div class="card-body">
            <form method="post" action="action_edit.php" id="main-form">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="lastName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="<?php echo htmlspecialchars($data['lastName'] ?? ''); ?>">
                            </div>
                         <div class="col-md-4">
                                <label for="firstName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="<?php echo htmlspecialchars($data['firstName'] ?? ''); ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="middleName" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middleName" name="middleName" value="<?php echo htmlspecialchars($data['middleName'] ?? ''); ?>">
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="rank" class="form-label">Rank</label>
                            <select class="form-select" id="rank" name="rank">
                                <option <?php if($data['rank'] == 'Full Time') echo 'selected'; ?>>Full Time</option>
                                <option <?php if($data['rank'] == 'Part Time') echo 'selected'; ?>>Part Time</option>
                                <option <?php if($data['rank'] == 'Permanent') echo 'selected'; ?>>Permanent</option>
                                <option <?php if($data['rank'] == 'Temporary') echo 'selected'; ?>>Temporary</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="section" class="form-label">Section</label>
                            <input type="text" class="form-control" id="section" name="section" value="<?php echo htmlspecialchars($data['section'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label">Subject Code</label>
                            <input type="text" class="form-control" id="subject" name="subject" value="<?php echo htmlspecialchars($data['subject'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="room" class="form-label">Room / Mode</label>
                            <input type="text" class="form-control" id="room" name="room" value="<?php echo htmlspecialchars($data['room'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="day" class="form-label">Days of Week</label>
                            <select class="form-select" id="day" name="day">
                                <option <?php if($data['day'] == 'Monday') echo 'selected'; ?>>Monday</option>
                                <option <?php if($data['day'] == 'Tuesday') echo 'selected'; ?>>Tuesday</option>
                                <option <?php if($data['day'] == 'Wednesday') echo 'selected'; ?>>Wednesday</option>
                                <option <?php if($data['day'] == 'Thursday') echo 'selected'; ?>>Thursday</option>
                                <option <?php if($data['day'] == 'Friday') echo 'selected'; ?>>Friday</option>
                                <option <?php if($data['day'] == 'Saturday') echo 'selected'; ?>>Saturday</option>
                                <option <?php if($data['day'] == 'Sunday') echo 'selected'; ?>>Sunday</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="startTime" class="form-label">Time From</label>
                            
                                <input type="time" class="form-control" id="startTime" name="startTime" value="<?php echo date("H:i", strtotime($data['startTime'] ?? '')); ?>">
                            </div>
                            <div class="col-6">
                                <label for="endTime" class="form-label">Time To</label>
                                <input type="time" class="form-control" id="endTime" name="endTime" value="<?php echo date("H:i", strtotime($data['endTime'] ?? '')); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="date" class="form-label">Attendance Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="<?php echo htmlspecialchars($data['attendanceDate'] ?? ''); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="modality" class="form-label">Learning Modality</label>
                            <select class="form-select" id="modality" name="modality">
                                <option <?php if($data['modality'] == 'F2F Class') echo 'selected'; ?>>F2F Class</option>
                                <option <?php if($data['modality'] == 'Online') echo 'selected'; ?>>Online</option>
                            </select>
                        </div>
                        <div class="mb-3">
                           <label for="meetLink" class="form-label">Online Class Meeting Link</label>
                           <div class="input-group">
                                <input type="url" class="form-control" id="meetLink" name="meetLink" value="<?php echo htmlspecialchars($data['meetingLink'] ?? ''); ?>" placeholder="https://meet.google.com/...">
                                <button class="btn btn-outline-secondary" type="button" id="goToLinkBtn">Go to link</button>
                           </div>
                        </div>
                        <div class="mb-3">
                            <label for="facultyAttendance" class="form-label">Faculty Attendance</label>
                            <select class="form-select" id="facultyAttendance" name="facultyAttendance">
                                <option <?php if($data['facultyAttendance'] == 'Present') echo 'selected'; ?>>Present</option>
                                <option <?php if($data['facultyAttendance'] == 'Absent') echo 'selected'; ?>>Absent</option>
                                <option <?php if($data['facultyAttendance'] == 'Late') echo 'selected'; ?>>Late</option>
                                <option <?php if($data['facultyAttendance'] == 'Excused') echo 'selected'; ?>>Excused</option>
                                <option <?php if($data['facultyAttendance'] == '') echo 'selected'; ?>></option>
                            </select>
                        </div>
                       <div class="mb-3">
                            <label for="dressCode" class="form-label">Dress Code</label>
                            <select class="form-select" id="dressCode" name="dressCode">
                                <option <?php if($data['dressCode'] == 'Filipiniana') echo 'selected'; ?>>Filipiniana</option>
                                <option <?php if($data['dressCode'] == 'Casual') echo 'selected'; ?>>Casual</option>
                                <option <?php if($data['dressCode'] == 'Department Uniform') echo 'selected'; ?>>Department Uniform</option>
                                <option <?php if($data['dressCode'] == '') echo 'selected'; ?>></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="remarks" class="form-label">Remarks</label>
                            <textarea class="form-control" id="remarks" name="remarks" rows="2"><?php echo htmlspecialchars($data['remarks'] ?? ''); ?></textarea>
                        </div>
                    </div>

                </div>
            </form>
        </div>
        <div class="card-footer text-end">
            <a href="attendance.php" class="btn btn-secondary">Back to List</a>
            <button type="submit" form="main-form" class="btn btn-primary">Save Changes</button>
        </div>
    </div>
</div>

<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="updateToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="toast-header bg-info text-white">
            <i class="bi bi-check-circle-fill me-2"></i>
            <strong class="me-auto">Success!</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            The record has been updated successfully.
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js"></script>



<script>
document.getElementById('goToLinkBtn').addEventListener('click', function() {
    const link = document.getElementById('meetLink').value;
    if (link) {
        window.open(link, '_blank');
    } else {
        alert('No meeting link provided.');
    }
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    <?php
  
    if (isset($_SESSION['status']) && $_SESSION['status'] === 'updated') {
   
        echo "const toastEl = document.getElementById('updateToast');";
        echo "const toast = new bootstrap.Toast(toastEl);";
        echo "toast.show();";
       
        unset($_SESSION['status']);
    }
    ?>
});
</script>

</body>
</html>