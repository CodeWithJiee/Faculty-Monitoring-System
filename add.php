<?php
session_start();
?>
<div class="card shadow-sm">
 	<div class="card-header bg-light">
 		<h5 class="mb-0">Add New Faculty Record</h5>
 	</div>
 	<div class="card-body">
 		<form method="post" action="action_add.php" id="main-form">
 			<div class="row">
 				<div class="col-md-6">
 					
 					<div class="row">
 						<div class="col-md-4">
 							<label for="lastName" class="form-label">Last Name</label>
 							<input type="text" class="form-control" id="lastName" name="lastName" required>
 						</div>
 						<div class="col-md-4">
 							<label for="firstName" class="form-label">First Name</label>
 							<input type="text" class="form-control" id="firstName" name="firstName" required>
 						</div>
 						<div class="col-md-4">
 							<label for="middleName" class="form-label">Middle Name</label>
 							<input type="text" class="form-control" id="middleName" name="middleName">
 						</div>

 					</div>
 					
 					 	
 					<div class="mb-3">
 						<label for="rank" class="form-label">Rank</label>
 						<select class="form-select" id="rank" name="rank" required>
 							<option selected value="">Rank</option>
 							<option>Full Time</option>
 							<option>Part Time</option>
 							<option>Permanent</option>
 							<option>Temporary</option>
 							
 						</select>
 					</div>
 					<div class="mb-3">
 						<label for="section" class="form-label">Section</label>
 						<input type="text" class="form-control" id="section" name="section" required>
 					</div>
 					<div class="mb-3">
 						<label for="subject" class="form-label">Subject Code</label>
 						<input type="text" class="form-control" id="subject" name="subject" required>
 					</div>
 					<div class="mb-3">
 						<label for="room" class="form-label">Room / Mode</label>
 						<input type="text" class="form-control" id="room" name="room" required>
 					</div>
 					<div class="mb-3">
 						<label for="day" class="form-label">Days of Week</label>
 						<select class="form-select" id="day" name="day" required>
 							<option selected value="">Choose day</option>
 							<option>Monday</option>
 							<option>Tuesday</option>
 							<option>Wednesday</option>
 							<option>Thursday</option>
 							<option>Friday</option>
 							<option>Saturday</option>
 							<option>Sunday</option>
 							
 						</select>
 					</div>
 					<div class="row">
 						<div class="col-6">
 							<label for="startTime" class="form-label">Time From</label>
 							<input type="time" class="form-control" id="startTime" name="startTime" required>
 						</div>
 						<div class="col-6">
 							<label for="endTime" class="form-label">Time To</label>
 							<input type="time" class="form-control" id="endTime" name="endTime" required>
 						</div>
 					</div>
 				</div>

 				<div class="col-md-6">
 					<div class="mb-3">
 						<label for="date" class="form-label">Attendance Date</label>
 						<input type="date" class="form-control" id="date" name="date" required>
 					</div>
 					<div class="mb-3">
 						<label for="modality" class="form-label">Learning Modality</label>
 						<select class="form-select" id="modality" name="modality" required>
 							<option>F2F Class</option>
 							<option>Online</option>
 						</select>
 					</div>
 					<div class="mb-3">
 						<label for="meetLink" class="form-label">Online Class Meeting Link</label>
 						<div class="input-group">
 							<input type="url" class="form-control" id="meetLink" name="meetLink" placeholder="https://meet.google.com/...">
 							<button class="btn btn-outline-secondary" type="button" id="goToLinkBtn">Go to link</button>
 						</div>
 					</div>
 					<div class="mb-3">
 						<label for="facultyAttendance" class="form-label">Faculty Attendance</label>
 						<select class="form-select" id="facultyAttendance" name="facultyAttendance">
 							<option selected value=""></option>
 							<option>Present</option>
 							<option>Absent</option>
 							<option>Late</option>
 							<option>Excused</option>
 						</select>

 					</div>
 					<div class="mb-3">
 						<label for="dressCode" class="form-label">Dress Code</label>
 						<select class="form-select" id="dressCode" name="dressCode">
 							<option>Filipiniana</option>
 							<option>Casual</option>
 							<option>Department Uniform</option>
 							<option selected value=""></option>
 						</select>
 					</div>
 					<div class="mb-3">
 						<label for="remarks" class="form-label">Remarks</label>
 						<textarea class="form-control" id="remarks" name="remarks" rows="2"></textarea>
 					</div>
 				</div>
 			</div>
 		</form>
 	</div>
 	<div class="card-footer text-end">
 		<a href="attendance.php" class="btn btn-secondary">Back to List</a>
 		<button type="submit" form="main-form" class="btn btn-primary">Save Record</button>
 	</div>
</div>