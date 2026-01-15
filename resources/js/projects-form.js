const statusSelect = document.getElementById('status');
const startedDiv = document.querySelector('.started');
const completedDiv = document.querySelector('.completed');
const executionTimeDiv = document.querySelector('.execution_time');

function toggleFields() {
    if (statusSelect.value === 'Completed' || statusSelect.value === 'Completato') {
        /* startedDiv.style.display = 'block'; */
        completedDiv.style.display = 'flex';
        executionTimeDiv.style.display = 'block';
    } else {
        /* startedDiv.style.display = 'none'; */
        completedDiv.style.display = 'none';
        executionTimeDiv.style.display = 'none';
    }
}

statusSelect.addEventListener('change', toggleFields);
toggleFields(); // Run on page load
