document.addEventListener("DOMContentLoaded", () => {
  const visitDate = document.getElementById("visitDate");
  const visitTime = document.getElementById("visitTime");
  if (visitDate && visitTime) {
    const now = new Date();
    visitDate.valueAsDate = now;
    visitTime.value = now.toTimeString().slice(0, 5);
  }

  if (document.getElementById("painLevel")) {
    initializePainScale();
  }

  if (document.getElementById("darkModeToggle")) {
    initializeDarkMode();
  }

  if (document.getElementById("weight") && document.getElementById("height")) {
    initializeBMICalculator();
  }

  if (document.getElementById("patientAssessmentForm")) {
    initializeFormHandlers();
  }
});

function initializeFormHandlers() {
  initializeFormValidation();
  if (document.getElementById("allergiesInput")) {
    initializeAllergies();
  }

  const conditionOther = document.getElementById("conditionOther");
  if (conditionOther) {
    conditionOther.addEventListener("change", function () {
      document.getElementById("otherConditionContainer").style.display = this.checked ? "block" : "none";
    });
  }

  const resetButton = document.getElementById("resetButton");
  if (resetButton) {
    resetButton.addEventListener("click", () => {
      if (confirm("Are you sure you want to reset the form? All entered data will be lost.")) {
        document.getElementById("patientAssessmentForm").reset();
        document.getElementById("allergiesList").innerHTML = "";
        document.getElementById("allergies").value = "";
        document.getElementById("bmi").value = "";
        document.getElementById("alertsContainer").innerHTML = "";
        document.getElementById("alertDoctorButton").disabled = true;
        document.getElementById("otherConditionContainer").style.display = "none";
        const abnormalInputs = document.querySelectorAll(".abnormal");
        abnormalInputs.forEach((input) => input.classList.remove("abnormal"));
        updatePainScaleDisplay(0);
      }
    });
  }

  const form = document.getElementById("patientAssessmentForm");
  if (form) {
    form.addEventListener("submit", function (e) {
        console.log(validateForm);
      // if (!validateForm()) {
      //   e.preventDefault();
      // }
    });
  }

  const alertDoctorButton = document.getElementById("alertDoctorButton");
  if (alertDoctorButton) {
    alertDoctorButton.addEventListener("click", () => {
      showNotification("Alert sent to doctor!", "warning");
    });
  }

  const notificationClose = document.getElementById("notificationClose");
  if (notificationClose) {
    notificationClose.addEventListener("click", () => {
      document.getElementById("notification").classList.add("hidden");
    });
  }

  const vitalSignInputs = ["temperature", "systolic", "diastolic", "heartRate", "respiratoryRate", "oxygenSaturation"];
  vitalSignInputs.forEach((id) => {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener("input", function () {
        validateVitalSign(id, this.value);
      });
    }
  });
}

function initializePainScale() {
  const painSlider = document.getElementById("painLevel");
  if (!painSlider) return;
  painSlider.addEventListener("input", function () {
    updatePainScaleDisplay(this.value);
  });
  updatePainScaleDisplay(painSlider.value);
}

function updatePainScaleDisplay(value) {
  const painValue = document.getElementById("painValue");
  const painText = document.getElementById("painText");
  if (!painValue || !painText) return;
  painValue.textContent = value;
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
  ];
  painText.textContent = painDescriptions[value];
  if (value >= 7) {
    painValue.className = "abnormal-text";
    painText.className = "abnormal-text";
  } else {
    painValue.className = "";
    painText.className = "";
  }
}

function initializeDarkMode() {
  const darkModeToggle = document.getElementById("darkModeToggle");
  if (!darkModeToggle) return;
  const savedTheme = localStorage.getItem("theme");
  if (savedTheme === "dark" || (!savedTheme && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
    document.body.classList.add("dark-mode");
  }
  darkModeToggle.addEventListener("click", () => {
    document.body.classList.toggle("dark-mode");
    const isDarkMode = document.body.classList.contains("dark-mode");
    localStorage.setItem("theme", isDarkMode ? "dark" : "light");
  });
}

function initializeBMICalculator() {
  const weightInput = document.getElementById("weight");
  const heightInput = document.getElementById("height");
  const weightUnitSelect = document.getElementById("weightUnit");
  const heightUnitSelect = document.getElementById("heightUnit");
  const bmiInput = document.getElementById("bmi");
  if (!weightInput || !heightInput || !weightUnitSelect || !heightUnitSelect || !bmiInput) return;

  const calculateBMI = () => {
    const weight = Number.parseFloat(weightInput.value);
    const height = Number.parseFloat(heightInput.value);
    if (isNaN(weight) || isNaN(height) || weight <= 0 || height <= 0) {
      bmiInput.value = "";
      return;
    }
    let weightKg = weight;
    if (weightUnitSelect.value === "lb") {
      weightKg = weight * 0.453592;
    }
    let heightM = height;
    if (heightUnitSelect.value === "cm") {
      heightM = height / 100;
    } else if (heightUnitSelect.value === "ft") {
      heightM = height * 0.3048;
    }
    const bmi = weightKg / (heightM * heightM);
    bmiInput.value = bmi.toFixed(1);
    if (bmi < 18.5 || bmi >= 25) {
      bmiInput.classList.add("abnormal");
    } else {
      bmiInput.classList.remove("abnormal");
    }
  };
  weightInput.addEventListener("input", calculateBMI);
  heightInput.addEventListener("input", calculateBMI);
  weightUnitSelect.addEventListener("change", calculateBMI);
  heightUnitSelect.addEventListener("change", calculateBMI);
}

function initializeAllergies() {
  const input = document.getElementById("allergiesInput");
  const dropdown = document.getElementById("allergiesDropdown");
  if (!input || !dropdown) return;
  input.addEventListener("keydown", function (e) {
    if (e.key === "Enter" || e.key === ",") {
      e.preventDefault();
      const value = this.value.trim();
      if (value) {
        addAllergyTag(value);
        this.value = "";
      }
    }
  });
  dropdown.addEventListener("change", function () {
    const selectedValue = this.value;
    if (selectedValue) {
      addAllergyTag(selectedValue);
      this.value = "";
    }
  });
}

function addAllergyTag(allergy) {
  const allergiesList = document.getElementById("allergiesList");
  const allergiesInput = document.getElementById("allergies");
  if (!allergiesList || !allergiesInput) return;
  const existingAllergies = allergiesInput.value ? allergiesInput.value.split(",") : [];
  if (existingAllergies.includes(allergy)) {
    return;
  }
  const tagElement = document.createElement("div");
  tagElement.className = "tag";
  tagElement.innerHTML = `${allergy} <span class="tag-remove" onclick="removeAllergyTag(this, '${allergy}')">&times;</span>`;
  allergiesList.appendChild(tagElement);
  existingAllergies.push(allergy);
  allergiesInput.value = existingAllergies.join(",");
}

function removeAllergyTag(element, allergy) {
  const allergiesInput = document.getElementById("allergies");
  if (!allergiesInput) return;
  const existingAllergies = allergiesInput.value.split(",");
  const index = existingAllergies.indexOf(allergy);
  if (index > -1) {
    existingAllergies.splice(index, 1);
  }
  allergiesInput.value = existingAllergies.join(",");
  element.parentElement.remove();
}

function validateVitalSign(id, value) {
  const input = document.getElementById(id);
  if (!input) return;
  let isAbnormal = false;
  const normalRanges = {
    temperature: { min: 36.1, max: 37.2 },
    systolic: { min: 90, max: 120 },
    diastolic: { min: 60, max: 80 },
    heartRate: { min: 60, max: 100 },
    respiratoryRate: { min: 12, max: 20 },
    oxygenSaturation: { min: 95, max: 100 },
  };
  if (id === "temperature") {
    const tempUnit = document.getElementById("tempUnit").value;
    if (tempUnit === "fahrenheit") {
      const celsius = ((Number.parseFloat(value) - 32) * 5) / 9;
      isAbnormal = celsius < normalRanges.temperature.min || celsius > normalRanges.temperature.max;
    } else {
      isAbnormal = Number.parseFloat(value) < normalRanges.temperature.min || Number.parseFloat(value) > normalRanges.temperature.max;
    }
  } else if (normalRanges[id]) {
    isAbnormal = Number.parseFloat(value) < normalRanges[id].min || Number.parseFloat(value) > normalRanges[id].max;
  }
  if (isAbnormal && value !== "") {
    input.classList.add("abnormal");
  } else {
    input.classList.remove("abnormal");
  }
  checkForAbnormalVitalSigns();
}

function checkForAbnormalVitalSigns() {
  const abnormalInputs = document.querySelectorAll(".abnormal");
  const alertDoctorButton = document.getElementById("alertDoctorButton");
  const alertsContainer = document.getElementById("alertsContainer");
  if (!alertDoctorButton || !alertsContainer) return;
  alertsContainer.innerHTML = "";
  if (abnormalInputs.length > 0) {
    alertDoctorButton.disabled = false;
    abnormalInputs.forEach((input) => {
      let alertMessage = "";
      let alertType = "warning";
      switch (input.id) {
        case "temperature":
          const tempUnit = document.getElementById("tempUnit").value;
          alertMessage = `Abnormal temperature detected (${input.value}°${tempUnit === "celsius" ? "C" : "F"})`;
          if (Number.parseFloat(input.value) > (tempUnit === "celsius" ? 38.5 : 101.3)) {
            alertType = "danger";
          }
          break;
        case "systolic":
        case "diastolic":
          const systolic = document.getElementById("systolic").value;
          const diastolic = document.getElementById("diastolic").value;
          if (systolic && diastolic) {
            alertMessage = `Abnormal blood pressure detected (${systolic}/${diastolic} mmHg)`;
            if (Number.parseInt(systolic) > 140 || Number.parseInt(diastolic) > 90) {
              alertType = "danger";
            }
          }
          break;
        case "heartRate":
          alertMessage = `Abnormal heart rate detected (${input.value} BPM)`;
          if (Number.parseInt(input.value) > 120 || Number.parseInt(input.value) < 50) {
            alertType = "danger";
          }
          break;
        case "respiratoryRate":
          alertMessage = `Abnormal respiratory rate detected (${input.value} breaths/min)`;
          if (Number.parseInt(input.value) > 24 || Number.parseInt(input.value) < 10) {
            alertType = "danger";
          }
          break;
        case "oxygenSaturation":
          alertMessage = `Low oxygen saturation detected (${input.value}%)`;
          if (Number.parseInt(input.value) < 92) {
            alertType = "danger";
          }
          break;
        case "bmi":
          const bmi = Number.parseFloat(input.value);
          if (bmi < 18.5) {
            alertMessage = `Low BMI detected (${bmi} kg/m²)`;
          } else if (bmi >= 30) {
            alertMessage = `High BMI detected (${bmi} kg/m²)`;
            alertType = "danger";
          } else if (bmi >= 25) {
            alertMessage = `Elevated BMI detected (${bmi} kg/m²)`;
          }
          break;
      }
      if (alertMessage && !document.querySelector(`[data-alert="${input.id}"]`)) {
        const alertElement = document.createElement("div");
        alertElement.className = `alert alert-${alertType}`;
        alertElement.setAttribute("data-alert", input.id);
        alertElement.innerHTML = `<div class="alert-icon">⚠️</div><div>${alertMessage}</div>`;
        alertsContainer.appendChild(alertElement);
      }
    });
  } else {
    alertDoctorButton.disabled = true;
  }
}

function validateForm() {
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
  ];
  const missing = [];
  let isValid = true;
  const getLabelText = (input) => {
    if (!input) return "";
    if (input.labels && input.labels.length) {
      return input.labels[0].textContent.trim();
    }
    const groupLabel = input.closest(".form-group")?.querySelector("label");
    return groupLabel ? groupLabel.textContent.trim() : input.id;
  };
  requiredFields.forEach((field) => {
    const input = document.getElementById(field);
    if (input && !input.value) {
      input.classList.add("abnormal");
      isValid = false;
      missing.push(getLabelText(input));
    } else if (input) {
      input.classList.remove("abnormal");
    }
  });
  const radioGroups = [
    { name: "fall_risk", labelId: "fallRiskLow" },
    { name: "smoking_status", labelId: "smokingNever" },
  ];
  radioGroups.forEach(({ name, labelId }) => {
    const checked = document.querySelector(`input[name="${name}"]:checked`);
    const label = document.querySelector(`label[for="${labelId}"]`);
    if (!checked) {
      isValid = false;
      if (label) {
        label.classList.add("abnormal-text");
        missing.push(label.textContent.trim());
      }
    } else {
      if (label) label.classList.remove("abnormal-text");
    }
  });
  const alcoholUse = document.getElementById("alcoholUse");
  if (alcoholUse && !alcoholUse.value) {
    alcoholUse.classList.add("abnormal");
    isValid = false;
    missing.push(getLabelText(alcoholUse));
  } else if (alcoholUse) {
    alcoholUse.classList.remove("abnormal");
  }
  const otherCondition = document.getElementById("otherCondition");
  const conditionOther = document.getElementById("conditionOther");
  if (conditionOther && conditionOther.checked && otherCondition && !otherCondition.value) {
    otherCondition.classList.add("abnormal");
    isValid = false;
    missing.push(getLabelText(otherCondition));
  } else if (otherCondition) {
    otherCondition.classList.remove("abnormal");
  }
  if (!isValid) {
    const msg = missing.length
      ? `Please fill in: ${missing.join(", ")}`
      : "Please fill in all required fields";
    showNotification(msg, "warning");
  }
  console.log(isValid);
  return isValid;
}

function showNotification(message, type = "success") {
  const notification = document.getElementById("notification");
  const notificationMessage = document.getElementById("notificationMessage");
  if (!notification || !notificationMessage) return;
  notificationMessage.textContent = message;
  notification.className = "notification";
  if (type === "warning") {
    notification.style.borderLeft = "4px solid var(--warning-color)";
  } else if (type === "error") {
    notification.style.borderLeft = "4px solid var(--danger-color)";
  } else {
    notification.style.borderLeft = "4px solid var(--success-color)";
  }
  setTimeout(() => {
    notification.classList.remove("hidden");
  }, 10);
  setTimeout(() => {
    notification.classList.add("hidden");
  }, 5000);
}

function initializeFormValidation() {
  // Placeholder for additional validation
}
