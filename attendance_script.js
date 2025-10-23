document.addEventListener('DOMContentLoaded', function() {
  console.log('✅ DOM loaded, script running');
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


const addModalEl = document.getElementById('addRecordModal');


if (addModalEl) {

  addModalEl.addEventListener('show.bs.modal', function () {
    const content = document.getElementById('addModalContent');
    if (!content) return;

 
    content.innerHTML = `
      <div class="text-center py-5">
        <div class="spinner-border text-primary" role="status"></div>
        <p class="mt-2">Loading form...</p>
      </div>
    `;

   
    fetch('add.php')
      .then(response => response.text())
      .then(html => {
        content.innerHTML = html;
        initMeetLinkToggle(); 
      })
      .catch(error => {
        content.innerHTML = "<div class='alert alert-danger'>Error loading form.</div>";
        console.error('Error loading form:', error);
      });
  });
}



 //pang-disable ng meet-link kapag mag-add tas face to face modality
  function initMeetLinkToggle() {
    const goButton = document.getElementById('goToLinkBtn');
    const linkInput = document.getElementById('meetLink');
    const modalitySelect = document.getElementById('modality');

    if (goButton && linkInput && modalitySelect) {
      goButton.addEventListener('click', function() {
        const url = linkInput.value;
        if (url) {
          window.open(url, '_blank');
        } else {
          alert('Please enter a link first.');
        }
      });

      function toggleMeetLink() {
        if (modalitySelect.value === 'F2F Class') {
          linkInput.readOnly = true;
          linkInput.value = '';
          linkInput.placeholder = 'Not applicable for F2F classes';
        }
         else {
          linkInput.readOnly = false;
          linkInput.required = true;
          linkInput.placeholder = 'https://meet.google.com/...';
        }
      }

      modalitySelect.addEventListener('change', toggleMeetLink);
      toggleMeetLink();
    }
  }

  //pang set ng status para sa pop-up or toast after add, delete, update
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
