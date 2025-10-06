document.querySelectorAll('.nav-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        const tabId = this.getAttribute('data-tab');
        
        // Remove active class from all tabs and content
        document.querySelectorAll('.nav-tab').forEach(t => t.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(content => content.classList.remove('active'));
        
        // Add active class to clicked tab and corresponding content
        this.classList.add('active');
        document.getElementById(tabId).classList.add('active');
    });
});

// Collapsible Sections
function toggleCollapsible(header) {
    const content = header.nextElementSibling;
    const arrow = header.querySelector('span:last-child');
    
    if (content.classList.contains('active')) {
        content.classList.remove('active');
        arrow.textContent = '▼';
    } else {
        content.classList.add('active');
        arrow.textContent = '▲';
    }
}

// Table Sorting
function sortTable(header, columnIndex) {
    const table = header.closest('table');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    
    // Skip if no data rows or only placeholder row
    if (rows.length <= 1 || rows[0].cells.length === 1) return;
    
    const isAscending = header.classList.contains('sort-asc');
    
    // Remove sort classes from all headers
    table.querySelectorAll('th').forEach(th => {
        th.classList.remove('sort-asc', 'sort-desc');
    });
    
    // Add appropriate sort class
    header.classList.add(isAscending ? 'sort-desc' : 'sort-asc');
    
    rows.sort((a, b) => {
        const aText = a.cells[columnIndex].textContent.trim();
        const bText = b.cells[columnIndex].textContent.trim();
        
        // Try to parse as numbers first
        const aNum = parseFloat(aText.replace(/[^0-9.-]/g, ''));
        const bNum = parseFloat(bText.replace(/[^0-9.-]/g, ''));
        
        if (!isNaN(aNum) && !isNaN(bNum)) {
            return isAscending ? bNum - aNum : aNum - bNum;
        }
        
        // Fall back to string comparison
        return isAscending ? bText.localeCompare(aText) : aText.localeCompare(bText);
    });
    
    // Re-append sorted rows
    rows.forEach(row => tbody.appendChild(row));
}

// Search Functionality
document.querySelector('.search-bar input').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    console.log('Searching for:', searchTerm);
});

// Progress Bar Animation
window.addEventListener('load', function() {
    setTimeout(() => {
        document.querySelectorAll('.progress-fill').forEach(bar => {
            const width = bar.style.width;
            bar.style.width = '0%';
            setTimeout(() => {
                bar.style.width = width;
            }, 100);
        });
    }, 500);
});

// Action Button Handlers
document.querySelector('.action-icon:nth-child(2)').addEventListener('click', function() {
    window.print();
});

document.querySelector('.action-icon:nth-child(3)').addEventListener('click', function() {
    alert('Patient record saved successfully!');
});

document.querySelector('.action-icon:nth-child(1)').addEventListener('click', function() {
    alert('Edit mode activated. In a real application, this would enable form editing.');
});

// Form Submissions (Demo)
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('btn-primary') || e.target.classList.contains('btn-success')) {
        if (e.target.textContent.includes('Add') || e.target.textContent.includes('Schedule') || 
            e.target.textContent.includes('Create') || e.target.textContent.includes('Process') ||
            e.target.textContent.includes('Order')) {
            e.preventDefault();
            alert('Form submitted successfully! In a real application, this would save to the database.');
        }
    }
});

// Video Call Controls (Demo)
document.querySelectorAll('.video-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        alert('Video call feature activated. In a real application, this would connect to video service.');
    });
});

// Mark Medication as Taken
document.addEventListener('click', function(e) {
    if (e.target.textContent === 'Mark Taken') {
        e.target.textContent = 'Taken';
        e.target.classList.remove('btn-primary');
        e.target.classList.add('btn-success');
        e.target.disabled = true;
    }
});
