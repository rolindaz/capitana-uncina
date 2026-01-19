// Toggle timing variables in the form based on the project status

const statusSelect = document.getElementById('status');
const startedDiv = document.querySelector('.started');
const completedDiv = document.querySelector('.completed');
const executionTimeDiv = document.querySelector('.execution_time');

function toggleFields() {
    if (!statusSelect || !completedDiv || !executionTimeDiv) return;

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

if (statusSelect) {
    statusSelect.addEventListener('change', toggleFields);
    toggleFields(); // Run on page load
}

// Add a new row of yarn selection in the form

const addYarnBtn = document.getElementById('add-yarn-btn');
const yarnsContainer = document.getElementById('yarns-container');

const baseYarnSelect = document.getElementById('yarn_id_0');
const baseColorwaySelect = document.getElementById('colorway_id_0');

const baseYarnOptionsHtml = baseYarnSelect ? baseYarnSelect.innerHTML : '';
const baseColorwayOptionsHtml = baseColorwaySelect ? baseColorwaySelect.innerHTML : '';

let yarnRowCount = document.querySelectorAll('#yarns-container .yarn-row').length;

if (addYarnBtn && yarnsContainer) {
    addYarnBtn.addEventListener('click', function(e) {
        e.preventDefault();

        if (!baseYarnOptionsHtml || !baseColorwayOptionsHtml) {
            console.warn('Missing base yarn/colorway selects to clone options from.');
            return;
        }
        
        const newYarnRow = document.createElement('div');
        newYarnRow.className = 'yarns d-flex align-items-center mt-3';
        newYarnRow.innerHTML = `
            <div class="yarn-row gold-border d-flex form-control justify-content-between gap-3">
                <div class="yarn-column">
                    <label for="yarn_id_${yarnRowCount}">
                        Filato
                    </label>
                    <select class="ms-2 form-select" name="yarns[${yarnRowCount}][yarn_id]" id="yarn_id_${yarnRowCount}">
                        ${baseYarnOptionsHtml}
                    </select>
                </div>
                <div class="yarn-column">
                    <label for="colorway_id_${yarnRowCount}">
                        Colore
                    </label>
                    <select class="ms-2 form-select" name="yarns[${yarnRowCount}][colorway_id]" id="colorway_id_${yarnRowCount}">
                        ${baseColorwayOptionsHtml}
                    </select>
                </div>
                <div class="yarn-column">
                    <label for="quantity_${yarnRowCount}">
                        Quantità
                    </label>
                    <input class="ms-2 form-select" type="number" name="yarns[${yarnRowCount}][quantity]" id="quantity_${yarnRowCount}"/>
                </div>
                <button type="button" class="btn btn-sm btn-danger remove-yarn-btn">Rimuovi</button>
            </div>
        `;
        
        yarnsContainer.appendChild(newYarnRow);
        yarnRowCount++;
        
        // Add remove functionality to the new row
        newYarnRow.querySelector('.remove-yarn-btn').addEventListener('click', function(e) {
            e.preventDefault();
            newYarnRow.remove();
        });
    });
}

// Add remove button functionality to any existing remove buttons
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-yarn-btn')) {
        e.preventDefault();
        e.target.closest('.yarns').remove();
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

/* // create new yarn button logic

const createYarnBtn = document.getElementById('create-yarn-btn');
const newYarnFormContainer = document.querySelector('.create-yarn-form');

if (createYarnBtn && newYarnFormContainer) {
    const cancelYarnBtn = newYarnFormContainer.querySelector('.btn-danger');
    
    createYarnBtn.addEventListener('click', (e) => {
        e.preventDefault();
        newYarnFormContainer.style.display = newYarnFormContainer.style.display === 'none' ? 'block' : 'none';
    });
    
    if (cancelYarnBtn) {
        cancelYarnBtn.addEventListener('click', (e) => {
            e.preventDefault();
            newYarnFormContainer.style.display = 'none';
        });
    }
} */


