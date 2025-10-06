// Sample data (for client-side filtering; in a real app, fetch via AJAX)


// DOM Elements
const mobileMenuToggle = document.getElementById("mobileMenuToggle");
const sidebar = document.getElementById("sidebar");
const searchInput = document.getElementById("searchInput");
const tabButtons = document.querySelectorAll(".tab-btn");
const tabContents = document.querySelectorAll(".tab-content");
const navItems = document.querySelectorAll(".nav-item");
const metricCards = document.querySelectorAll(".metric-card");
const consultationForm = document.getElementById("consultationForm");
const profileDropdownToggle = document.getElementById("profileDropdownToggle");
const profileDropdownMenu = document.getElementById("profileDropdownMenu");

// Initialize the application
document.addEventListener("DOMContentLoaded", () => {
    initializeApp();
    setupEventListeners();
});

function initializeApp() {
    const now = new Date();
    const dateInput = document.getElementById("appointmentDate");
    if (dateInput) {
        dateInput.min = now.toISOString().slice(0, 16);
    }
}

function setupEventListeners() {
    // mobileMenuToggle.addEventListener("click", toggleMobileMenu);
    tabButtons.forEach((button) => {
        button.addEventListener("click", () => switchTab(button.dataset.content));
    });
    navItems.forEach((item) => {
        item.addEventListener("click", (e) => {
            e.preventDefault();
            setActiveNavItem(item);
        });
    });
    metricCards.forEach((card) => {
        card.addEventListener("click", () => handleMetricClick(card.dataset.metric));
    });
    // searchInput.addEventListener("input", handleSearch);
    // consultationForm.addEventListener("submit", handleConsultationSubmit);

    if (profileDropdownToggle) {
        profileDropdownToggle.addEventListener("click", (e) => {
            e.stopPropagation();
            profileDropdownMenu.classList.toggle("show");
        });
    }

    document.addEventListener("click", (e) => {
        if (
            profileDropdownMenu &&
            !profileDropdownMenu.contains(e.target) &&
            e.target !== profileDropdownToggle
        ) {
            profileDropdownMenu.classList.remove("show");
        }
    });

    document.querySelectorAll(".patient-item").forEach((item) => {
        item.addEventListener("click", () => {
            const patientId = item.dataset.patientId;
            viewPatientDetails(patientId);
        });
    });

    document.querySelectorAll(".schedule-item").forEach((item) => {
        item.addEventListener("click", () => {
            const appointmentId = item.dataset.appointmentId;
            handleAppointmentClick(appointmentId);
        });
    });

    setupPatientFilters();
    setupInventoryFilters();
}

function toggleMobileMenu() {
    sidebar.classList.toggle("active");
}

function switchTab(tabName) {
    tabButtons.forEach((btn) => {
        btn.classList.toggle("active", btn.dataset.content === tabName);
    });
    tabContents.forEach((content) => {
        content.classList.toggle("active", content.id === tabName);
    });
}

function setActiveNavItem(activeItem) {
    navItems.forEach((item) => {
        item.classList.remove("active");
    });
    activeItem.classList.add("active");
}

function setupPatientFilters() {
    const searchInput = document.getElementById("patientSearch");
    const statusFilter = document.getElementById("statusFilter");
    const doctorFilter = document.getElementById("doctorFilter");

    if (searchInput) searchInput.addEventListener("input", filterPatients);
    if (statusFilter) statusFilter.addEventListener("change", filterPatients);
    if (doctorFilter) doctorFilter.addEventListener("change", filterPatients);
}

function setupInventoryFilters() {
    const searchInput = document.getElementById("inventorySearch");
    const categoryFilter = document.getElementById("categoryFilter");
    const stockFilter = document.getElementById("stockFilter");

    if (searchInput) searchInput.addEventListener("input", filterInventory);
    if (categoryFilter) categoryFilter.addEventListener("change", filterInventory);
    if (stockFilter) stockFilter.addEventListener("change", filterInventory);
}

function filterPatients() {
    const searchTerm = document.getElementById("patientSearch")?.value.toLowerCase() || "";
    const statusFilter = document.getElementById("statusFilter")?.value || "";
    const doctorFilter = document.getElementById("doctorFilter")?.value || "";

    document.querySelectorAll(".patient-row").forEach((row) => {
        const patientId = row.dataset.patientId;
        const patient = samplePatients.find((p) => p.id == patientId);

        if (patient) {
            const matchesSearch =
                patient.name.toLowerCase().includes(searchTerm) ||
                patient.procedure.toLowerCase().includes(searchTerm) ||
                patient.email.toLowerCase().includes(searchTerm);
            const matchesStatus = !statusFilter || patient.status === statusFilter;
            const matchesDoctor = !doctorFilter || patient.doctor === doctorFilter;

            row.style.display = matchesSearch && matchesStatus && matchesDoctor ? "" : "none";
        }
    });
}

function filterInventory() {
    const searchTerm = document.getElementById("inventorySearch")?.value.toLowerCase() || "";
    const categoryFilter = document.getElementById("categoryFilter")?.value || "";
    const stockFilter = document.getElementById("stockFilter")?.value || "";

    document.querySelectorAll(".inventory-row").forEach((row) => {
        const itemId = row.dataset.itemId;
        const item = inventoryData.find((i) => i.id == itemId);

        if (item) {
            const matchesSearch =
                item.name.toLowerCase().includes(searchTerm) ||
                item.brand.toLowerCase().includes(searchTerm) ||
                item.supplier.toLowerCase().includes(searchTerm);
            const matchesCategory = !categoryFilter || item.category === categoryFilter;
            const matchesStock = !stockFilter || item.status === stockFilter;

            row.style.display = matchesSearch && matchesCategory && matchesStock ? "" : "none";
        }
    });
}

function viewPatientDetails(patientId) {
    const patient = samplePatients.find((p) => p.id == patientId);
    if (patient) {
        document.getElementById("patientDetailsContent").innerHTML = `
            <p><strong>Name:</strong> ${patient.name}</p>
            <p><strong>Age:</strong> ${patient.age}</p>
            <p><strong>Procedure:</strong> ${patient.procedure}</p>
            <p><strong>Doctor:</strong> ${patient.doctor}</p>
            <p><strong>Next Appointment:</strong> ${formatDate(patient.nextAppointment)}</p>
            <p><strong>Vitals:</strong></p>
            <ul>
                <li>BP: ${patient.vitals.bp}</li>
                <li>HR: ${patient.vitals.hr}</li>
                <li>Temp: ${patient.vitals.temp}</li>
            </ul>
        `;
        new bootstrap.Modal(document.getElementById("patientDetailsModal")).show();
    }
}

function editPatient(patientId) {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Edit patient form for ID: ${patientId} would go here.</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function scheduleAppointment(patientId) {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Schedule appointment form for ID: ${patientId} would go here.</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function viewMedicalRecords(patientId) {
    const patient = samplePatients.find((p) => p.id == patientId);
    if (patient) {
        document.getElementById("patientDetailsContent").innerHTML = `
            <p><strong>Medical Records for ${patient.name}:</strong></p>
            <ul>
                ${patient.medicalHistory.map(item => `<li>${item}</li>`).join("")}
            </ul>
        `;
        new bootstrap.Modal(document.getElementById("patientDetailsModal")).show();
    }
}

function viewSurgeryDetails(surgeryId) {
    const surgery = surgicalSchedule.find((s) => s.id == surgeryId);
    if (surgery) {
        document.getElementById("surgeryDetailsContent").innerHTML = `
            <p><strong>Procedure:</strong> ${surgery.procedure}</p>
            <p><strong>Patient:</strong> ${surgery.patient}</p>
            <p><strong>Surgeon:</strong> ${surgery.surgeon}</p>
            <p><strong>Room:</strong> ${surgery.room}</p>
            <p><strong>Time:</strong> ${surgery.time}</p>
            <p><strong>Duration:</strong> ${surgery.duration}</p>
            <p><strong>Anesthesia:</strong> ${surgery.anesthesia}</p>
            <p><strong>Notes:</strong> ${surgery.notes}</p>
        `;
        new bootstrap.Modal(document.getElementById("surgeryDetailsModal")).show();
    }
}

function editSurgery(surgeryId) {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Edit surgery form for ID: ${surgeryId} would go here.</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function cancelSurgery(surgeryId) {
    if (confirm("Are you sure you want to cancel this surgery?")) {
        document.getElementById("inventoryActionsContent").innerHTML = `<p>Surgery ${surgeryId} has been cancelled.</p>`;
        new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
    }
}

function printSurgerySchedule(surgeryId) {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Printing surgery schedule for ID: ${surgeryId}.</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function addInventoryItem() {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Add inventory item form would go here.</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function editInventoryItem(itemId) {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Edit inventory item form for ID: ${itemId} would go here.</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function reorderItem(itemId) {
    const item = inventoryData.find((i) => i.id == itemId);
    if (item) {
        document.getElementById("inventoryActionsContent").innerHTML = `
            <p>Reorder ${item.name} from ${item.supplier}?</p>
            <p>Suggested quantity: ${item.maxStock - item.quantity} ${item.unit}</p>
        `;
        new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
    }
}

function moveItem(itemId) {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Move item form for ID: ${itemId} would go here.</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function viewItemHistory(itemId) {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Item history for ID: ${itemId} would go here.</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function viewLowStock() {
    const lowStockItems = inventoryData.filter((item) => item.status === "low" || item.status === "critical");
    document.getElementById("inventoryActionsContent").innerHTML = `
        <p><strong>Low Stock Items (${lowStockItems.length}):</strong></p>
        <ul>
            ${lowStockItems.map(item => `<li>${item.name}: ${item.quantity} ${item.unit}</li>`).join("")}
        </ul>
    `;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function viewExpiring() {
    const expiringItems = inventoryData.filter((item) => getDaysUntilExpiry(item.expiryDate) < 30);
    document.getElementById("inventoryActionsContent").innerHTML = `
        <p><strong>Expiring Items (${expiringItems.length}):</strong></p>
        <ul>
            ${expiringItems.map(item => `<li>${item.name}: Expires ${formatDate(item.expiryDate)}</li>`).join("")}
        </ul>
    `;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function viewControlled() {
    const controlledItems = inventoryData.filter((item) => item.category === "Controlled");
    document.getElementById("inventoryActionsContent").innerHTML = `
        <p><strong>Controlled Substances (${controlledItems.length}):</strong></p>
        <ul>
            ${controlledItems.map(item => `<li>${item.name}: ${item.quantity} ${item.unit} in ${item.location}</li>`).join("")}
        </ul>
    `;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function generateReport() {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Generating monthly inventory report...</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function handleConsultationSubmit(event) {
    event.preventDefault();
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Consultation scheduled successfully!</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
    bootstrap.Modal.getInstance(document.getElementById("consultationModal")).hide();
}

function handleMetricClick(metric) {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Metric details for: ${metric}</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function handleSearch() {
    // Global search functionality (to be implemented)
}

function handleAppointmentClick(appointmentId) {
    document.getElementById("inventoryActionsContent").innerHTML = `<p>Appointment details for ID: ${appointmentId}</p>`;
    new bootstrap.Modal(document.getElementById("inventoryActionsModal")).show();
}

function formatDate(date) {
    return new Date(date).toLocaleDateString();
}

function getDaysUntilExpiry(expiryDate) {
    const today = new Date();
    const expiry = new Date(expiryDate);
    const diffTime = expiry - today;
    return Math.ceil(diffTime / (1000 * 60 * 60 * 24));
}
