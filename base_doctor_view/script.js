// Sample data
const recentPatientsData = [
  {
    id: 1,
    name: "Sarah Johnson",
    procedure: "Rhinoplasty",
    status: "Pre-op",
    date: "2024-01-15",
    avatar: "https://images.unsplash.com/photo-1494790108755-2616b612b786?w=40&h=40&fit=crop&crop=face",
    progress: 75,
  },
  {
    id: 2,
    name: "Michael Chen",
    procedure: "Facelift",
    status: "Post-op",
    date: "2024-01-14",
    avatar: "https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=40&h=40&fit=crop&crop=face",
    progress: 90,
  },
  {
    id: 3,
    name: "Emma Davis",
    procedure: "Breast Augmentation",
    status: "Consultation",
    date: "2024-01-13",
    avatar: "https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=40&h=40&fit=crop&crop=face",
    progress: 25,
  },
  {
    id: 4,
    name: "James Wilson",
    procedure: "Liposuction",
    status: "Recovery",
    date: "2024-01-12",
    avatar: "https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=40&h=40&fit=crop&crop=face",
    progress: 60,
  },
]

const upcomingAppointmentsData = [
  { time: "09:00", patient: "Alice Brown", procedure: "Consultation", type: "New Patient" },
  { time: "10:30", patient: "Robert Taylor", procedure: "Follow-up", type: "Post-op" },
  { time: "14:00", patient: "Lisa Anderson", procedure: "Botox Treatment", type: "Procedure" },
  { time: "15:30", patient: "David Miller", procedure: "Pre-op Assessment", type: "Surgery Prep" },
]

const inventoryData = [
  { item: "Botox (100 units)", stock: 15, threshold: 10, status: "Good" },
  { item: "Hyaluronic Acid Filler", stock: 8, threshold: 12, status: "Low" },
  { item: "Silicone Implants (Round)", stock: 25, threshold: 15, status: "Good" },
  { item: "Surgical Sutures", stock: 5, threshold: 20, status: "Critical" },
]

const upcomingSurgeriesData = [
  {
    patient: "Sarah Johnson",
    procedure: "Rhinoplasty",
    date: "Tomorrow, 9:00 AM",
    location: "OR 1",
    status: "Confirmed",
  },
  {
    patient: "Michael Chen",
    procedure: "Facelift",
    date: "Jan 17, 2:00 PM",
    location: "OR 2",
    status: "Prep Required",
  },
  {
    patient: "Emma Davis",
    procedure: "Breast Augmentation",
    date: "Jan 18, 10:00 AM",
    location: "OR 1",
    status: "Confirmed",
  },
]

// DOM Elements
const sidebar = document.getElementById("sidebar")
const userMenu = document.getElementById("userMenu")
const dropdownMenu = document.getElementById("dropdownMenu")

// Initialize the application
document.addEventListener("DOMContentLoaded", () => {
  initializeNavigation()
  initializeTabs()
  populateRecentPatients()
  populateTodaySchedule()
  populateInventoryAlerts()
  populatePatientsTable()
  populateInventoryTable()
  populateUpcomingSurgeries()
  initializeSearch()
})

// Navigation functionality
function initializeNavigation() {
  const navItems = document.querySelectorAll(".nav-item")

  navItems.forEach((item) => {
    item.addEventListener("click", function (e) {
      e.preventDefault()

      // Remove active class from all items
      navItems.forEach((nav) => nav.classList.remove("active"))

      // Add active class to clicked item
      this.classList.add("active")

      // Update header title based on selection
      const title = this.querySelector("span").textContent
      document.querySelector(".header-title h1").textContent = title
    })
  })
}

// Tab functionality
function initializeTabs() {
  const tabBtns = document.querySelectorAll(".tab-btn")
  const tabContents = document.querySelectorAll(".tab-content")

  tabBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      const targetTab = this.getAttribute("data-tab")

      // Remove active class from all tabs and contents
      tabBtns.forEach((tab) => tab.classList.remove("active"))
      tabContents.forEach((content) => content.classList.remove("active"))

      // Add active class to clicked tab and corresponding content
      this.classList.add("active")
      document.getElementById(targetTab).classList.add("active")
    })
  })
}

// Sidebar toggle
function toggleSidebar() {
  sidebar.classList.toggle("show")
}

// User menu toggle
function toggleUserMenu() {
  userMenu.classList.toggle("show")
}

// Close menus when clicking outside
document.addEventListener("click", (e) => {
  if (!e.target.closest(".user-profile") && !e.target.closest(".user-menu")) {
    userMenu.classList.remove("show")
  }

  if (!e.target.closest(".action-btn") && !e.target.closest(".dropdown-menu")) {
    dropdownMenu.classList.remove("show")
  }
})

// Populate recent patients
function populateRecentPatients() {
  const container = document.getElementById("recentPatients")

  container.innerHTML = recentPatientsData
    .map(
      (patient) => `
        <div class="patient-item">
            <div class="patient-info">
                <div class="patient-avatar">
                    <img src="${patient.avatar}" alt="${patient.name}">
                </div>
                <div class="patient-details">
                    <h4>${patient.name}</h4>
                    <p>${patient.procedure}</p>
                </div>
            </div>
            <div class="patient-status">
                <span class="badge ${getBadgeClass(patient.status)}">${patient.status}</span>
                <p style="font-size: 0.75rem; color: #64748b; margin-top: 0.25rem;">${patient.date}</p>
            </div>
        </div>
    `,
    )
    .join("")
}

// Populate today's schedule
function populateTodaySchedule() {
  const container = document.getElementById("todaySchedule")

  container.innerHTML = upcomingAppointmentsData
    .map(
      (appointment) => `
        <div class="appointment-item">
            <div class="appointment-time">${appointment.time}</div>
            <div class="appointment-details">
                <h5>${appointment.patient}</h5>
                <p>${appointment.procedure}</p>
            </div>
            <span class="badge badge-outline">${appointment.type}</span>
        </div>
    `,
    )
    .join("")
}

// Populate inventory alerts
function populateInventoryAlerts() {
  const container = document.getElementById("inventoryAlerts")
  const alertItems = inventoryData.filter((item) => item.status !== "Good")

  container.innerHTML = alertItems
    .map(
      (item) => `
        <div class="alert-item">
            <div class="alert-info">
                <div class="alert-indicator ${item.status.toLowerCase()}"></div>
                <div class="alert-details">
                    <h5>${item.item}</h5>
                    <p>Current stock: ${item.stock} units</p>
                </div>
            </div>
            <span class="badge ${item.status === "Critical" ? "badge-danger" : "badge-warning"}">${item.status}</span>
        </div>
    `,
    )
    .join("")
}

// Populate patients table
function populatePatientsTable() {
  const tbody = document.getElementById("patientsTable")

  tbody.innerHTML = recentPatientsData
    .map(
      (patient) => `
        <tr>
            <td>
                <div class="patient-info">
                    <div class="patient-avatar">
                        <img src="${patient.avatar}" alt="${patient.name}">
                    </div>
                    <div class="patient-details">
                        <h4>${patient.name}</h4>
                        <p>ID: ${patient.id.toString().padStart(4, "0")}</p>
                    </div>
                </div>
            </td>
            <td>${patient.procedure}</td>
            <td><span class="badge ${getBadgeClass(patient.status)}">${patient.status}</span></td>
            <td>${patient.date}</td>
            <td>
                <div class="progress-container">
                    <div class="progress-bar">
                        <div class="progress-fill" style="width: ${patient.progress}%"></div>
                    </div>
                    <span class="progress-text">${patient.progress}%</span>
                </div>
            </td>
            <td>
                <button class="action-btn" onclick="showDropdown(event)">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </td>
        </tr>
    `,
    )
    .join("")
}

// Populate inventory table
function populateInventoryTable() {
  const tbody = document.getElementById("inventoryTable")

  tbody.innerHTML = inventoryData
    .map(
      (item) => `
        <tr>
            <td style="font-weight: 500;">${item.item}</td>
            <td>${item.stock} units</td>
            <td>${item.threshold} units</td>
            <td><span class="badge ${getInventoryBadgeClass(item.status)}">${item.status}</span></td>
            <td>2 hours ago</td>
            <td>
                <button class="action-btn" onclick="showDropdown(event)">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
            </td>
        </tr>
    `,
    )
    .join("")
}

// Populate upcoming surgeries
function populateUpcomingSurgeries() {
  const container = document.getElementById("upcomingSurgeries")

  container.innerHTML = upcomingSurgeriesData
    .map(
      (surgery) => `
        <div class="surgery-item">
            <div class="surgery-details">
                <h5>${surgery.patient} - ${surgery.procedure}</h5>
                <p>${surgery.date} - ${surgery.location}</p>
            </div>
            <span class="badge ${surgery.status === "Confirmed" ? "badge-success" : "badge-outline"}">${surgery.status}</span>
        </div>
    `,
    )
    .join("")
}

// Initialize search functionality
function initializeSearch() {
  const searchInputs = document.querySelectorAll(".search-input")

  searchInputs.forEach((input) => {
    input.addEventListener("input", (e) => {
      const searchTerm = e.target.value.toLowerCase()
      // Implement search logic here
      console.log("Searching for:", searchTerm)
    })
  })
}

// Show dropdown menu
function showDropdown(event) {
  event.stopPropagation()

  const rect = event.target.getBoundingClientRect()
  dropdownMenu.style.top = `${rect.bottom + window.scrollY}px`
  dropdownMenu.style.left = `${rect.left + window.scrollX - 120}px`
  dropdownMenu.classList.add("show")
}

// Helper functions
function getBadgeClass(status) {
  switch (status) {
    case "Pre-op":
      return "badge-default"
    case "Post-op":
      return "badge-secondary"
    case "Recovery":
      return "badge-outline"
    case "Consultation":
      return "badge-default"
    default:
      return "badge-default"
  }
}

function getInventoryBadgeClass(status) {
  switch (status) {
    case "Good":
      return "badge-success"
    case "Low":
      return "badge-warning"
    case "Critical":
      return "badge-danger"
    default:
      return "badge-default"
  }
}

// Responsive sidebar handling
function handleResize() {
  if (window.innerWidth > 768) {
    sidebar.classList.remove("show")
  }
}

window.addEventListener("resize", handleResize)

// Add smooth scrolling for better UX
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    e.preventDefault()
    const target = document.querySelector(this.getAttribute("href"))
    if (target) {
      target.scrollIntoView({
        behavior: "smooth",
      })
    }
  })
})

// Add loading states for better UX
function showLoading(element) {
  element.innerHTML =
    '<div style="text-align: center; padding: 2rem; color: #64748b;"><i class="fas fa-spinner fa-spin"></i> Loading...</div>'
}

// Simulate data loading with loading states
function simulateDataLoad() {
  const containers = ["recentPatients", "todaySchedule", "inventoryAlerts"]

  containers.forEach((containerId) => {
    const container = document.getElementById(containerId)
    if (container) {
      showLoading(container)

      setTimeout(() => {
        switch (containerId) {
          case "recentPatients":
            populateRecentPatients()
            break
          case "todaySchedule":
            populateTodaySchedule()
            break
          case "inventoryAlerts":
            populateInventoryAlerts()
            break
        }
      }, 500)
    }
  })
}

// Add keyboard shortcuts
document.addEventListener("keydown", (e) => {
  // Ctrl/Cmd + K for search
  if ((e.ctrlKey || e.metaKey) && e.key === "k") {
    e.preventDefault()
    const searchInput = document.querySelector(".search-input")
    if (searchInput) {
      searchInput.focus()
    }
  }

  // Escape to close menus
  if (e.key === "Escape") {
    userMenu.classList.remove("show")
    dropdownMenu.classList.remove("show")
    sidebar.classList.remove("show")
  }
})

// Add notification system
function showNotification(message, type = "info") {
  const notification = document.createElement("div")
  notification.className = `notification notification-${type}`
  notification.innerHTML = `
        <div style="display: flex; align-items: center; gap: 0.5rem;">
            <i class="fas fa-${type === "success" ? "check-circle" : type === "error" ? "exclamation-circle" : "info-circle"}"></i>
            <span>${message}</span>
        </div>
    `

  // Add notification styles
  notification.style.cssText = `
        position: fixed;
        top: 1rem;
        right: 1rem;
        background: ${type === "success" ? "#f0fdf4" : type === "error" ? "#fef2f2" : "#eff6ff"};
        color: ${type === "success" ? "#16a34a" : type === "error" ? "#dc2626" : "#3b82f6"};
        border: 1px solid ${type === "success" ? "#bbf7d0" : type === "error" ? "#fecaca" : "#dbeafe"};
        border-radius: 0.5rem;
        padding: 1rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        animation: slideIn 0.3s ease;
    `

  document.body.appendChild(notification)

  setTimeout(() => {
    notification.style.animation = "slideOut 0.3s ease"
    setTimeout(() => {
      document.body.removeChild(notification)
    }, 300)
  }, 3000)
}

// Add CSS animations
const style = document.createElement("style")
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`
document.head.appendChild(style)

// Example usage of notifications
setTimeout(() => {
  showNotification("Welcome to MedClinic Pro!", "success")
}, 1000)
