
const decreaseBtn = document.getElementById('decrease');
const increaseBtn = document.getElementById('increase');
const countInput = document.getElementById('item-count');

// Set minimum and maximum values
const MIN_COUNT = 1;
const MAX_COUNT = 99;

// Initialize count
let count = parseInt(countInput.value) || 1;

// Update display
function updateDisplay() {
    countInput.value = count;
    
    // Disable at min max
    decreaseBtn.disabled = count <= MIN_COUNT;
    increaseBtn.disabled = count >= MAX_COUNT;
}

// Event Handlers
decreaseBtn.addEventListener('click', (e) => {
    e.preventDefault(); // Prevent form submission
    if (count > MIN_COUNT) {
        count--;
        updateDisplay();
    }
});

increaseBtn.addEventListener('click', (e) => {
    e.preventDefault(); // Prevent form submission
    if (count < MAX_COUNT) {
        count++;
        updateDisplay();
    }
});

// Handle direct input
countInput.addEventListener('change', () => {
    let newValue = parseInt(countInput.value) || 1;
    count = Math.min(Math.max(newValue, MIN_COUNT), MAX_COUNT);
    updateDisplay();
});

// Initial display update
updateDisplay();