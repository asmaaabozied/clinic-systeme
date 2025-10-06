document.addEventListener("DOMContentLoaded", () => {
  // Set default date and time
  const now = new Date()
  document.getElementById("visitDate").valueAsDate = now
  document.getElementById("visitTime").value = now.toTimeString().slice(0, 5)

  // Initialize pain scale
  initializePainScale()

  // Initialize dark mode toggle
  initializeDarkMode()

  // Initialize BMI calculator
  initializeBMICalculator()

  // Initialize form validation
  initializeFormValidation()

  // Initialize allergies functionality
  initializeAllergies()

  // Initialize other condition toggle
  document.getElementById("conditionOther").addEventListener("change", function () {
    document.getElementById("otherConditionContainer").style.display = this.checked ? "block" : "none"
  })

  // Reset button
  document.getElementById("resetButton").addEventListener("click", () => {
    if (confirm("Are you sure you want to reset the form? All entered data will be lost.")) {
      document.getElementById("patientAssessmentForm").reset()
      document.getElementById("allergiesList").innerHTML = ""
      document.getElementById("allergies").value = ""
      document.getElementById("bmi").value = ""
      document.getElementById("alertsContainer").innerHTML = ""
      document.getElementById("alertDoctorButton").disabled = true
      document.getElementById("otherConditionContainer").style.display = "none"

      // Reset abnormal highlighting
      const abnormalInputs = document.querySelectorAll(".abnormal")
      abnormalInputs.forEach((input) => input.classList.remove("abnormal"))

      // Update pain scale display
      updatePainScaleDisplay(0)
    }
  })

  // Submit button
  document.getElementById("patientAssessmentForm").addEventListener("submit", function (e) {
    e.preventDefault()

    if (validateForm()) {
      // In a real application, this would send data to a server
      showNotification("Patient assessment saved successfully!")

      // For demo purposes, log the form data
      const formData = new FormData(this)
      const formDataObj = {}
      formData.forEach((value, key) => {
        if (formDataObj[key]) {
          if (!Array.isArray(formDataObj[key])) {
            formDataObj[key] = [formDataObj[key]]
          }
          formDataObj[key].push(value)
        } else {
          formDataObj[key] = value
        }
      })

      console.log("Form Data:", formDataObj)
    }
  })

  // Alert doctor button
  document.getElementById("alertDoctorButton").addEventListener("click", () => {
    // In a real application, this would trigger an alert to the doctor
    showNotification("Alert sent to doctor!", "warning")
  })

  // Notification close button
  document.getElementById("notificationClose").addEventListener("click", () => {
    document.getElementById("notification").classList.add("hidden")
  })

  // Vital signs inputs for validation
  const vitalSignInputs = ["temperature", "systolic", "diastolic", "heartRate", "respiratoryRate", "oxygenSaturation"]

  vitalSignInputs.forEach((id) => {
    document.getElementById(id).addEventListener("input", function () {
      validateVitalSign(id, this.value)
    })
  })
})

function initializePainScale() {
  const painSlider = document.getElementById("painLevel")

  painSlider.addEventListener("input", function () {
    updatePainScaleDisplay(this.value)
  })

  // Initialize with default value
  updatePainScaleDisplay(painSlider.value)
}

function updatePainScaleDisplay(value) {
  const painValue = document.getElementById("painValue")
  const painText = document.getElementById("painText")

  painValue.textContent = value

  // Update pain description based on value
  const painDescriptions = [
    "No Pain",
    "Minimal",
    "Mild",
    "Uncomfortable",
    "Moderate",
    "Distracting",
    "Distressing",
    "Severe",
    "Intense",
    "Excruciating",
    "Worst Possible",
  ]

  painText.textContent = painDescriptions[value]

  // Change color based on pain level
  if (value >= 7) {
    painValue.className = "abnormal-text"
    painText.className = "abnormal-text"
  } else if (value >= 4) {
    painValue.className = ""
    painText.className = ""
  } else {
    painValue.className = ""
    painText.className = ""
  }
}

function initializeDarkMode() {
  const darkModeToggle = document.getElementById("darkModeToggle")

  // Check for saved theme preference or use system preference
  const savedTheme = localStorage.getItem("theme")
  if (savedTheme === "dark" || (!savedTheme && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
    document.body.classList.add("dark-mode")
  }

  // Toggle dark mode
  darkModeToggle.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode")
    const isDarkMode = document.body.classList.contains("dark-mode")
    localStorage.setItem("theme", isDarkMode ? "dark" : "light")
  })
}

function initializeBMICalculator() {
  const weightInput = document.getElementById("weight")
  const heightInput = document.getElementById("height")
  const weightUnitSelect = document.getElementById("weightUnit")
  const heightUnitSelect = document.getElementById("heightUnit")
  const bmiInput = document.getElementById("bmi")

  const calculateBMI = () => {
    const weight = Number.parseFloat(weightInput.value)
    const height = Number.parseFloat(heightInput.value)

    if (isNaN(weight) || isNaN(height) || weight <= 0 || height <= 0) {
      bmiInput.value = ""
      return
    }

    // Convert weight to kg if needed
    let weightKg = weight
    if (weightUnitSelect.value === "lb") {
      weightKg = weight * 0.453592
    }

    // Convert height to meters if needed
    let heightM = height
    if (heightUnitSelect.value === "cm") {
      heightM = height / 100
    } else if (heightUnitSelect.value === "ft") {
      heightM = height * 0.3048
    }

    // Calculate BMI
    const bmi = weightKg / (heightM * heightM)
    bmiInput.value = bmi.toFixed(1)

    // Highlight abnormal BMI
    if (bmi < 18.5 || bmi >= 25) {
      bmiInput.classList.add("abnormal")
    } else {
      bmiInput.classList.remove("abnormal")
    }
  }

  weightInput.addEventListener("input", calculateBMI)
  heightInput.addEventListener("input", calculateBMI)
  weightUnitSelect.addEventListener("change", calculateBMI)
  heightUnitSelect.addEventListener("change", calculateBMI)
}

function initializeAllergies() {
  // Allergies input
  document.getElementById("allergiesInput").addEventListener("keydown", function (e) {
    if (e.key === "Enter" || e.key === ",") {
      e.preventDefault()
      const value = this.value.trim()
      if (value) {
        addAllergyTag(value)
        this.value = ""
      }
    }
  })

  // Allergies dropdown
  document.getElementById("allergiesDropdown").addEventListener("change", function () {
    const selectedValue = this.value
    if (selectedValue) {
      addAllergyTag(selectedValue)
      this.value = ""
    }
  })
}

function addAllergyTag(allergy) {
  const allergiesList = document.getElementById("allergiesList")
  const allergiesInput = document.getElementById("allergies")

  // Check if allergy already exists
  const existingAllergies = allergiesInput.value ? allergiesInput.value.split(",") : []
  if (existingAllergies.includes(allergy)) {
    return
  }

  // Create tag element
  const tagElement = document.createElement("div")
  tagElement.className = "tag"
  tagElement.innerHTML = `
    ${allergy}
    <span class="tag-remove" onclick="removeAllergyTag(this, '${allergy}')">&times;</span>
  `

  allergiesList.appendChild(tagElement)

  // Update hidden input
  existingAllergies.push(allergy)
  allergiesInput.value = existingAllergies.join(",")
}

function removeAllergyTag(element, allergy) {
  const allergiesInput = document.getElementById("allergies")
  const existingAllergies = allergiesInput.value.split(",")

  // Remove from array
  const index = existingAllergies.indexOf(allergy)
  if (index > -1) {
    existingAllergies.splice(index, 1)
  }

  // Update hidden input
  allergiesInput.value = existingAllergies.join(",")

  // Remove tag element
  element.parentElement.remove()
}

function validateVitalSign(id, value) {
  const input = document.getElementById(id)
  let isAbnormal = false

  // Define normal ranges
  const normalRanges = {
    temperature: { min: 36.1, max: 37.2 }, // Celsius
    systolic: { min: 90, max: 120 },
    diastolic: { min: 60, max: 80 },
    heartRate: { min: 60, max: 100 },
    respiratoryRate: { min: 12, max: 20 },
    oxygenSaturation: { min: 95, max: 100 },
  }

  // Handle temperature unit conversion
  if (id === "temperature") {
    const tempUnit = document.getElementById("tempUnit").value
    if (tempUnit === "fahrenheit") {
      // Convert Fahrenheit to Celsius for comparison
      const celsius = ((Number.parseFloat(value) - 32) * 5) / 9
      isAbnormal = celsius < normalRanges.temperature.min || celsius > normalRanges.temperature.max
    } else {
      isAbnormal =
        Number.parseFloat(value) < normalRanges.temperature.min ||
        Number.parseFloat(value) > normalRanges.temperature.max
    }
  } else if (normalRanges[id]) {
    isAbnormal = Number.parseFloat(value) < normalRanges[id].min || Number.parseFloat(value) > normalRanges[id].max
  }

  // Update UI
  if (isAbnormal && value !== "") {
    input.classList.add("abnormal")
  } else {
    input.classList.remove("abnormal")
  }

  // Check all vital signs for abnormalities
  checkForAbnormalVitalSigns()
}

function checkForAbnormalVitalSigns() {
  const abnormalInputs = document.querySelectorAll(".abnormal")
  const alertDoctorButton = document.getElementById("alertDoctorButton")
  const alertsContainer = document.getElementById("alertsContainer")

  // Clear previous alerts
  alertsContainer.innerHTML = ""

  // Enable alert doctor button if there are abnormal values
  if (abnormalInputs.length > 0) {
    alertDoctorButton.disabled = false

    // Create alerts for abnormal values
    abnormalInputs.forEach((input) => {
      let alertMessage = ""
      let alertType = "warning"

      switch (input.id) {
        case "temperature":
          const tempUnit = document.getElementById("tempUnit").value
          alertMessage = `Abnormal temperature detected (${input.value}°${tempUnit === "celsius" ? "C" : "F"})`
          if (Number.parseFloat(input.value) > (tempUnit === "celsius" ? 38.5 : 101.3)) {
            alertType = "danger"
          }
          break
        case "systolic":
        case "diastolic":
          const systolic = document.getElementById("systolic").value
          const diastolic = document.getElementById("diastolic").value
          if (systolic && diastolic) {
            alertMessage = `Abnormal blood pressure detected (${systolic}/${diastolic} mmHg)`
            if (Number.parseInt(systolic) > 140 || Number.parseInt(diastolic) > 90) {
              alertType = "danger"
            }
          }
          break
        case "heartRate":
          alertMessage = `Abnormal heart rate detected (${input.value} BPM)`
          if (Number.parseInt(input.value) > 120 || Number.parseInt(input.value) < 50) {
            alertType = "danger"
          }
          break
        case "respiratoryRate":
          alertMessage = `Abnormal respiratory rate detected (${input.value} breaths/min)`
          if (Number.parseInt(input.value) > 24 || Number.parseInt(input.value) < 10) {
            alertType = "danger"
          }
          break
        case "oxygenSaturation":
          alertMessage = `Low oxygen saturation detected (${input.value}%)`
          if (Number.parseInt(input.value) < 92) {
            alertType = "danger"
          }
          break
        case "bmi":
          const bmi = Number.parseFloat(input.value)
          if (bmi < 18.5) {
            alertMessage = `Low BMI detected (${bmi} kg/m²)`
          } else if (bmi >= 30) {
            alertMessage = `High BMI detected (${bmi} kg/m²)`
            alertType = "danger"
          } else if (bmi >= 25) {
            alertMessage = `Elevated BMI detected (${bmi} kg/m²)`
          }
          break
      }

      // Only add alert if we have a message and it's not a duplicate
      if (alertMessage && !document.querySelector(`[data-alert="${input.id}"]`)) {
        const alertElement = document.createElement("div")
        alertElement.className = `alert alert-${alertType}`
        alertElement.setAttribute("data-alert", input.id)
        alertElement.innerHTML = `
          <div class="alert-icon">⚠️</div>
          <div>${alertMessage}</div>
        `
        alertsContainer.appendChild(alertElement)
      }
    })
  } else {
    alertDoctorButton.disabled = true
  }
}

function validateForm() {
  // Basic form validation
  const requiredFields = [
    "patientName",
    "patientId",
    "patientAge",
    "patientGender",
    "visitDate",
    "visitTime",
    "temperature",
    "systolic",
    "diastolic",
    "heartRate",
    "respiratoryRate",
    "oxygenSaturation",
    "weight",
    "height",
  ]

  let isValid = true

  requiredFields.forEach((field) => {
    const input = document.getElementById(field)
    if (!input.value) {
      input.classList.add("abnormal")
      isValid = false
    } else {
      input.classList.remove("abnormal")
    }
  })

  // Check radio button groups
  const radioGroups = ["fallRisk", "smokingStatus"]
  radioGroups.forEach((group) => {
    const checked = document.querySelector(`input[name="${group}"]:checked`)
    if (!checked) {
      isValid = false
      // Highlight the group label
      const label =
        document.querySelector(`label[for="${group}Low"]`) || document.querySelector(`label[for="${group}Never"]`)
      if (label) {
        label.classList.add("abnormal-text")
      }
    } else {
      const label =
        document.querySelector(`label[for="${group}Low"]`) || document.querySelector(`label[for="${group}Never"]`)
      if (label) {
        label.classList.remove("abnormal-text")
      }
    }
  })

  // Check select fields
  if (!document.getElementById("alcoholUse").value) {
    document.getElementById("alcoholUse").classList.add("abnormal")
    isValid = false
  } else {
    document.getElementById("alcoholUse").classList.remove("abnormal")
  }

  // Check if "Other" condition is checked but not specified
  if (document.getElementById("conditionOther").checked && !document.getElementById("otherCondition").value) {
    document.getElementById("otherCondition").classList.add("abnormal")
    isValid = false
  } else {
    document.getElementById("otherCondition").classList.remove("abnormal")
  }

  if (!isValid) {
    showNotification("Please fill in all required fields", "warning")
  }

  return isValid
}

function showNotification(message, type = "success") {
  const notification = document.getElementById("notification")
  const notificationMessage = document.getElementById("notificationMessage")

  notificationMessage.textContent = message
  notification.className = "notification"

  if (type === "warning") {
    notification.style.borderLeft = "4px solid var(--warning-color)"
  } else if (type === "error") {
    notification.style.borderLeft = "4px solid var(--danger-color)"
  } else {
    notification.style.borderLeft = "4px solid var(--success-color)"
  }

  // Show notification
  setTimeout(() => {
    notification.classList.remove("hidden")
  }, 10)

  // Hide after 5 seconds
  setTimeout(() => {
    notification.classList.add("hidden")
  }, 5000)
}

function initializeFormValidation() {
  // This function is a placeholder for any additional form validation setup
}
