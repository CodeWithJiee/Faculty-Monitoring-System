<?php
session_start();

include("config.php");
include("firebaseRDB.php");


if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
 	header("Location: index.php");
 	exit(); 
}


$db = new firebaseRDB($databaseURL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<title>Faculty Monitoring Dashboard</title>
 	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
 	<style>
 		:root {
 			--primary-color: #2c3e50; 
 			--secondary-color: #27ae60; 
 			--light-bg: #ecf0f1; 	 	
 			--card-bg: #ffffff;
 			--border-color: #e0e0e0;
 			--text-color: #34495e;
 			--sidebar-text: #ffffff;
 			--hover-bg: #34495e1a; 
 			--shadow-color: rgba(0, 0, 0, 0.07);
 		}

 		body {
 			background-color: var(--light-bg);
 			font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
 			color: var(--text-color);
 		}

 		.dashboard-layout {
 			display: flex;
 			min-height: 100vh;
 		}

 		.sidebar {
 			width: 260px;
 			background-color: var(--primary-color);
 			color: var(--sidebar-text);
 			padding: 1.5rem 0;
 			display: flex;
 			flex-direction: column;
 			position: fixed;
 			height: 100%;
 			left: 0;
 			top: 0;
 		}
 		.sidebar-header {
 			padding: 0 1.5rem 1.5rem 1.5rem;
 			margin-bottom: 1.5rem;
 			border-bottom: 1px solid #4a627a;
 		}
 		.sidebar-header h4 {
 			margin: 0;
 			font-weight: 600;
 		}
 		.sidebar-nav a {
 			display: block;
 			color: var(--sidebar-text);
 			text-decoration: none;
 			padding: 0.8rem 1.5rem;
 			transition: background-color 0.2s ease;
 			cursor: pointer;
 		}
 		.sidebar-nav a:hover {
 			background-color: #34495e;
 		}
 		.sidebar-nav a.active {
 			background-color: var(--secondary-color);
 			border-left: 4px solid #ffffff;
 			padding-left: calc(1.5rem - 4px);
 		}

 		.main-content {
 			flex-grow: 1;
 			margin-left: 260px;
 			padding: 2rem;
 		}

 		.content-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            position: sticky;
            top: 0;
            z-index: 200;
            background-color: var(--light-bg);
            padding: 1rem 0;
        }

 		.filter-card {
            background-color: var(--card-bg);
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 4px 15px var(--shadow-color);
            position: sticky;
            top: 70px;
            z-index: 150;
        }
 		.content-header h2 {
 			margin: 0;
 			color: var(--primary-color);
 			font-weight: 600;
 		}
 		
 		.card {
 			border: none;
 			border-radius: 8px;
 			box-shadow: 0 4px 15px var(--shadow-color);
 		}

 		.table thead {
 			background-color: var(--primary-color);
 			color: white;
 		}
 		
 		.table th {
            font-size: .8rem;
 			text-align: center;
 		}
 		.table td {
 			text-align: center; 
 			vertical-align: middle;
 			font-size: 0.9rem;
 			padding: 0.75rem;
 		}
 		.table .action-icons {
 			text-align: center; 
 		}

 		.table tbody tr:hover {
 			background-color: var(--hover-bg);
 			
 		}

 		.btn-primary {
 			background-color: var(--secondary-color);
 			border-color: var(--secondary-color);
 		}
 		.btn-primary:hover {
 			background-color: #218c54;
 			border-color: #218c54;
 		}

 		.action-icons a {
 			margin: 0 4px;
 		}

 		.btn:focus, .form-control:focus, .form-select:focus {
 			box-shadow: 0 0 0 0.25rem rgba(39, 174, 96, 0.5); 
 			border-color: var(--secondary-color);
 		}
 	</style>
</head>
<body>

<div class="dashboard-layout">

 	<aside class="sidebar">
 		<div class="sidebar-header">
 			<h4>Dashboard</h4>
 		</div>
 		<nav class="sidebar-nav"> 	 	 	 	
 			<a href="dashboard.php" class="active">Schedule</a>
 			<a href="attendance.php">Attendance</a>
 			<a href="logout.php">Log out</a>
 		</nav>
 	</aside>

 	<main class="main-content">
 		
 		<div class="content-header">
 			<h2 id="content-title">Faculty Schedule (View Only)</h2>
 			</div>

 		<div id="page-content">
 			<div class="filter-card">
 				 	<div class="d-flex flex-wrap align-items-center gap-3">
 				 		<div class="d-flex align-items-center gap-2">
 				 			<label for="dayFilter" class="form-label mb-0">Filter by Day:</label>
 				 			<select class="form-select" id="dayFilter" style="width: auto;">
 				 				<option value="">All Days</option>
 				 				<option value="Monday">Monday</option>
 				 				<option value="Tuesday">Tuesday</option>
 				 				<option>Wednesday</option>
 				 				<option>Thursday</option>
 				 				<option>Friday</option>
 				 				<option>Saturday</option>
 				 				<option>Sunday</option>
 				 			</select>
 				 		</div>
 				 		<div class="d-flex align-items-center gap-2">
 				 			<label for="dateFilter" class="form-label mb-0">Filter by Date:</label>
 				 			<input type="date" class="form-control" id="dateFilter" style="width: auto;">
 				 		</div>
 				 		<button id="resetBtn" class="btn btn-secondary">Show All</button>
 				 	</div>
 			</div>

 			<div class="card">
 				<div class="card-body">
 					<div class="table-responsive">
 						<table id="dataTable" class="table table-hover">
 							<thead>
 								<tr class="text-center">
 									<th>Faculty Name</th>
 									<th>Room</th>
 									<th>Day</th>
 									<th>Start Time</th>
 									<th>End Time</th>
 									<th>Attendance Date</th>
 									<th>Modality</th>
 									<th>Meeting Link</th>
 									<th>Attendance</th>
 									<th>View</th>
 								</tr>
 							</thead>
 							<tbody>
 								<?php
 								$data = $db->retrieve("schedule");
 								$data = json_decode($data, 1);

 								if (is_array($data)) {
 									foreach ($data as $id => $schedule) {
 										$day_value = htmlspecialchars($schedule['day'] ?? '');
 										$attendance_date_value = htmlspecialchars($schedule['attendanceDate'] ?? '');
 										
 										echo "<tr data-day='" . $day_value . "' data-date='" . $attendance_date_value . "'>
 											<td>" . htmlspecialchars($schedule['facultyName'] ?? '') . "</td>
 											<td>" . htmlspecialchars($schedule['room'] ?? '') . "</td>
 	
 											<td>" . $day_value . "</td>
 											<td>" . htmlspecialchars($schedule['startTime'] ?? '') . "</td>
 											<td>" . htmlspecialchars($schedule['endTime'] ?? '') . "</td>
 											<td>" . $attendance_date_value . "</td>
 											<td>" . htmlspecialchars($schedule['modality'] ?? '') . "</td>
 											<td>";
 										if (!empty($schedule['meetingLink'])) {
 											echo "<a href='" . htmlspecialchars($schedule['meetingLink']) . "' target='_blank'>Go to Link</a>";
 										} else {
 											echo "N/A";
 										}
 										echo "</td>
 											<td>" . htmlspecialchars($schedule['facultyAttendance'] ?? '') . "</td>
 											<td class='text-center'>
 												<button type='button' class='btn btn-sm btn-outline-info view-btn' 
 														data-bs-toggle='modal' data-bs-target='#viewRecordModal' 
 														data-id='" . htmlspecialchars($id) . "' title='View Details'>
 													<i class='bi bi-eye-fill'></i>
 												</button>
 											</td>
 										</tr>";
 									}
 								} else {
 									echo "<tr><td colspan='10' class='text-center'>No records found.</td></tr>";
 								}
 								?>
 							</tbody>
 						</table>
 					</div>
 				</div>
 			</div>
 		</div>
 	</main>
</div>

<div class="modal fade" id="viewRecordModal" tabindex="-1" aria-labelledby="viewRecordModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
 	<div class="modal-content">
 	  <div class="modal-header">
 		<h5 class="modal-title" id="viewRecordModalLabel">View Schedule Details</h5>
 		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
 	  </div>
 	  <div class="modal-body" id="viewModalContent">
 		<div class="text-center py-5">
 			<div class="spinner-border text-primary" role="status"></div>
 			<p class="mt-2">Loading details...</p>
 		</div>
 	  </div>
 	  <div class="modal-footer">
 		<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
 	  </div>
 	</div>
  </div>
</div>


<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
 	 <div id="addToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
 		<div class="toast-header bg-primary text-white">
 			<i class="bi bi-check-circle-fill me-2"></i>
 			<strong class="me-auto">Success!</strong>
 			<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
 		</div>
 		<div class="toast-body">
 			New record has been added successfully.
 		</div>
 	</div>
 	<div id="updateToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
 		<div class="toast-header bg-success text-white">
 			<i class="bi bi-check-circle-fill me-2"></i>
 			<strong class="me-auto">Success!</strong>
 			<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
 		</div>
 		<div class="toast-body">
 			The record has been updated successfully.
 		</div>
 	</div>
 	<div id="errorToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
 		<div class="toast-header bg-danger text-white">
 			<i class="bi bi-x-circle-fill me-2"></i>
 			<strong class="me-auto">Error!</strong>
 			<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
 		</div>
 		<div class="toast-body">
 			Something went wrong. The record was not updated.
 		</div>
 	</div>
 	<div id="deleteToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
 		<div class="toast-header bg-success text-white">
 			<i class="bi bi-check-circle-fill me-2"></i>
 			<strong class="me-auto">Success!</strong>
 			<button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
 		</div>
 		<div class="toast-body">
 			The record has been successfully deleted.
 		</div>
 	</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="schedule_view_script.js?v=<?php echo time(); ?>"></script>
 
</body>
</html>