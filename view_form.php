<?php
session_start();
include("config.php");
include("firebaseRDB.php");


if (!isset($_GET['id'])) {
 	echo "<div class='alert alert-danger'>No record ID provided.</div>";
 	exit;
}

$db = new firebaseRDB($databaseURL);
$id = $_GET['id'];
$retrieve = $db->retrieve("schedule/$id");
$data = json_decode($retrieve, 1);

if (!$data) {
 	echo "<div class='alert alert-danger'>Record not found.</div>";
 	exit;
}


$startTime24 = isset($data['startTime']) ? date("H:i", strtotime($data['startTime'])) : '';
$endTime24 = isset($data['endTime']) ? date("H:i", strtotime($data['endTime'])) : '';
?>

<div class="card shadow-sm">
 	<div class="card-header bg-light">
 		<h5 class="mb-0">View Faculty Record</h5>
 	</div>
 	<div class="card-body">
 		<div class="row">
 			<div class="col-md-6">
 				
 				<div class="row mb-3">
 					<div class="col-md-4">
 						<label for="lastName" class="form-label">Last Name</label>
 						<input type="text" class="form-control" id="lastName" value="<?php echo htmlspecialchars($data['lastName'] ?? ''); ?>" disabled>
 					</div>
 					<div class="col-md-4">
 						<label for="firstName" class="form-label">First Name</label>
 						<input type="text" class="form-control" id="firstName" value="<?php echo htmlspecialchars($data['firstName'] ?? ''); ?>" disabled>
 					</div>
 					<div class="col-md-4">
 						<label for="middleName" class="form-label">Middle Name</label>
 						<input type="text" class="form-control" id="middleName" value="<?php echo htmlspecialchars($data['middleName'] ?? ''); ?>" disabled>
 					</div>
 				</div>
 				
 				
 				<div class="mb-3">
 					<label for="rank" class="form-label">Rank</label>
 					<select class="form-select" id="rank" disabled>
 						<option <?php if($data['rank'] == 'Full Time') echo 'selected'; ?>>Full Time</option>
 						<option <?php if($data['rank'] == 'Part Time') echo 'selected'; ?>>Part Time</option>
 						<option <?php if($data['rank'] == 'Permanent') echo 'selected'; ?>>Permanent</option>
 						<option <?php if($data['rank'] == 'Temporary') echo 'selected'; ?>>Temporary</option>
 					</select>
 				</div>
 				<div class="mb-3">
 					<label for="section" class="form-label">Section</label>
 					<input type="text" class="form-control" id="section" value="<?php echo htmlspecialchars($data['section'] ?? ''); ?>" disabled>
 				</div>
 				<div class="mb-3">
 					<label for="subject" class="form-label">Subject Code</label>
 					<input type="text" class="form-control" id="subject" value="<?php echo htmlspecialchars($data['subject'] ?? ''); ?>" disabled>
 				</div>
 				<div class="mb-3">
 					<label for="room" class="form-label">Room / Mode</label>
 					<input type="text" class="form-control" id="room" value="<?php echo htmlspecialchars($data['room'] ?? ''); ?>" disabled>
 				</div>
 				<div class="mb-3">
 					<label for="day" class="form-label">Days of Week</label>
 					<select class="form-select" id="day" disabled>
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
 						<input type="time" class="form-control" id="startTime" value="<?php echo $startTime24; ?>" disabled>
 					</div>
 					<div class="col-6">
 						<label for="endTime" class="form-label">Time To</label>
 						<input type="time" class="form-control" id="endTime" value="<?php echo $endTime24; ?>" disabled>
 					</div>
 				</div>
 			</div>

 			<div class="col-md-6">
 				<div class="mb-3">
 					<label for="date" class="form-label">Attendance Date</label>
 					<input type="date" class="form-control" id="date" value="<?php echo htmlspecialchars($data['attendanceDate'] ?? ''); ?>" disabled>
 				</div>
 				<div class="mb-3">
 					<label for="modality" class="form-label">Learning Modality</label>
 					<select class="form-select" id="modality" disabled>
 						<option <?php if($data['modality'] == 'F2F Class') echo 'selected'; ?>>F2F Class</option>
 						<option <?php if($data['modality'] == 'Online') echo 'selected'; ?>>Online</option>
 					</select>
 				</div>
 				<div class="mb-3">
 					<label for="meetLink" class="form-label">Online Class Meeting Link</label>
 					<div class="input-group">
 						<input type="url" class="form-control" id="meetLink" value="<?php echo htmlspecialchars($data['meetingLink'] ?? ''); ?>" placeholder="N/A" disabled>
 						<button class="btn btn-outline-secondary" type="button" onclick="window.open('<?php echo htmlspecialchars($data['meetingLink'] ?? ''); ?>', '_blank')" <?php if(empty($data['meetingLink'])) echo 'disabled'; ?>>Go to link</button>
 					</div>
 				</div>
 				<div class="mb-3">
 					<label for="facultyAttendance" class="form-label">Faculty Attendance</label>
 					<select class="form-select" id="facultyAttendance" disabled>
 						<option <?php if($data['facultyAttendance'] == 'Present') echo 'selected'; ?>>Present</option>
 						<option <?php if($data['facultyAttendance'] == 'Absent') echo 'selected'; ?>>Absent</option>
 						<option <?php if($data['facultyAttendance'] == 'Late') echo 'selected'; ?>>Late</option>
 						<option <?php if($data['facultyAttendance'] == 'Excused') echo 'selected'; ?>>Excused</option>
 						<option <?php if($data['facultyAttendance'] == '') echo 'selected'; ?>></option>
 					</select>
 				</div>
 				<div class="mb-3">
 					<label for="dressCode" class="form-label">Dress Code</label>
 					<select class="form-select" id="dressCode" disabled>
 						<option <?php if($data['dressCode'] == 'Filipiniana') echo 'selected'; ?>>Filipiniana</option>
 						<_option <?php if($data['dressCode'] == 'Casual') echo 'selected'; ?>>Casual</_option>
 						<option <?php if($data['dressCode'] == 'Department Uniform') echo 'selected'; ?>>Department Uniform</option>
 						<option <?php if($data['dressCode'] == '') echo 'selected'; ?>></option>
 					</select>
 				</div>
 				<div class="mb-3">
 					<label for="remarks" class="form-label">Remarks</label>
 					<textarea class="form-control" id="remarks" rows="2" disabled><?php echo htmlspecialchars($data['remarks'] ?? ''); ?></textarea>
 				</div>
 			</div>
 		</div>
 	</div>
 	</div>