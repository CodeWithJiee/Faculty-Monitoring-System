document.addEventListener('DOMContentLoaded', function() {
  console.log('✅ DOM loaded, schedule_view_script running');
  console.log('Bootstrap Modal:', typeof bootstrap?.Modal);
});

document.addEventListener('DOMContentLoaded', function() {


  const urlParams = new URLSearchParams(window.location.search);
  const status = urlParams.get('status');
  if (status === 'deleted') {
 	const toastEl = document.getElementById('deleteToast');
 	if (toastEl) {
 	  const toast = new bootstrap.Toast(toastEl);
 	  toast.show();
 	}
  }
 

  
  const dateFilter = document.getElementById('dateFilter');
  const dayFilter = document.getElementById('dayFilter'); 
  const resetBtn = document.getElementById('resetBtn');
  const dataTable = document.getElementById('dataTable');

  if (dateFilter && dayFilter && resetBtn && dataTable) {
 	const tableRows = dataTable.querySelectorAll('tbody tr');

 	function applyFilters() {
 	  const selectedDate = dateFilter.value;
 	  const selectedDay = dayFilter.value.toLowerCase();

 	  tableRows.forEach(row => {
 		const rowDay = (row.getAttribute('data-day') || '').toLowerCase();
 		const rowDate = row.getAttribute('data-date') || '';

 		const matchesDay = !selectedDay || rowDay === selectedDay;
 		const matchesDate = !selectedDate || rowDate === selectedDate;

 		row.style.display = (matchesDay && matchesDate) ? '' : 'none';
 	  });
 	}

 	dateFilter.addEventListener('change', applyFilters);
 	dayFilter.addEventListener('change', applyFilters);
 	resetBtn.addEventListener('click', () => {
 	  dateFilter.value = '';
 	  dayFilter.value = '';
 	  applyFilters();
 	});

 	applyFilters();
  }

 
  const viewModalEl = document.getElementById('viewRecordModal');
  if (viewModalEl) {
 	viewModalEl.addEventListener('show.bs.modal', function (event) {
 		const button = event.relatedTarget; 
 		const recordId = button.getAttribute('data-id'); 
 		const content = document.getElementById('viewModalContent');

 	
 		content.innerHTML = `
 		  <div class="text-center py-5">
 			<div class="spinner-border text-primary" role="status"></div>
 			<p class="mt-2">Loading details...</p>
 		  </div>
 		`;

 		
 		fetch('view_form.php?id=' + recordId)
 			.then(response => {
 				if (!response.ok) {
 					throw new Error('Network response was not ok');
 				}
 				return response.text();
 			})
 			.then(html => {
 				content.innerHTML = html;
 			})
 			.catch(error => {
 				content.innerHTML = "<div class='alert alert-danger'>Error loading details. Please try again.</div>";
 				console.error('Error loading form:', error);
 			});
 	});
  }


  fetch('status.php')
  .then(res => res.json())
  .then(data => {
 	if (data.status === 'updated') {
 	  const el = document.getElementById('updateToast');
 	  if (el) new bootstrap.Toast(el).show();
 	} else if (data.status === 'error') {
 	  const el = document.getElementById('errorToast');
 	  if (el) new bootstrap.Toast(el).show();
 	}
 	else if (data.status === 'added') {
 		const el = document.getElementById('addToast');
 		if (el) new bootstrap.Toast(el).show();
 	  }
   })
  
  .catch(console.error);

});