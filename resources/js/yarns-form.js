// Add a new row of yarn selection in the form

const addFiberBtn = document.getElementById('add-fiber-btn');
const fibersContainer = document.getElementById('fibers-container');

const baseFiberSelect = document.getElementById('fiber_id_0');
const baseFiberOptionsHtml = baseFiberSelect ? baseFiberSelect.innerHTML : '';

let fiberRowCount = document.querySelectorAll('#fibers-container .fiber-row').length;

if (!addFiberBtn || !fibersContainer) {
    console.warn('Missing #add-fiber-btn or #fibers-container.');
} else {
addFiberBtn.addEventListener('click', function(e) {
    e.preventDefault();

    if (!baseFiberOptionsHtml) {
        console.warn('Missing base Fiber selects to clone options from.');
        return;
    }
    
    const newFiberRow = document.createElement('div');
    newFiberRow.className = 'fibers d-flex align-items-center mt-3';
    newFiberRow.innerHTML = `
        <div class="fiber-row d-flex form-control justify-content-between gap-3">
                    <div class="fiber-column">
                        <label class="text-danger" for="fiber_id_${fiberRowCount}">
                            Fibra
                        </label>
                        <select class="ms-2 form-select" name="fibers[${fiberRowCount}][fiber_id]" id="fiber_id_${fiberRowCount}">
                            ${baseFiberOptionsHtml}
                        </select>
                    </div>
                    <div class="fiber-column">
                        <label class="text-danger" for="percentage_${fiberRowCount}">
                            Percentuale
                        </label>
                        <input class="ms-2 form-select" type="number" name="fibers[${fiberRowCount}][percentage]" id="percentage_${fiberRowCount}"/>
                    </div>
                    <button type="button" class="btn btn-sm btn-danger remove-fiber-btn">Rimuovi</button>
                </div>
            `;
    
    fibersContainer.appendChild(newFiberRow);
    fiberRowCount++;
    
    // Add remove functionality to the new row
    newFiberRow.querySelector('.remove-fiber-btn').addEventListener('click', function(e) {
        e.preventDefault();
        newFiberRow.remove();
    });
});
}

// Add remove button functionality to any existing remove buttons
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-fiber-btn')) {
        e.preventDefault();
        e.target.closest('.fibers').remove();
    }
}, true); // Use capture phase to ensure this runs first

// Ensure form can submit
const form = document.querySelector('form');
if (form) {
    form.addEventListener('submit', function(e) {
        // Allow form to submit normally
        console.log('Form submitted');
    });
}