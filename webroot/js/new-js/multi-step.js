// script.js
let currentStep = 0;
const steps = document.querySelectorAll('.step');

function showStep(step) {
  steps.forEach((section, index) => {
    section.style.display = 'none';
    if(index === step) {
      section.style.display = 'block';
    }
  });
}

// Get all the dots
const dots = document.querySelectorAll('.dot');

function setActiveDot(step) {
  dots.forEach((dot, index) => {
    if(index === step) {
      dot.classList.add('active');
    } else {
      dot.classList.remove('active');
    }
  });
}

function nextStep() {
  if(currentStep < steps.length - 1) {
    currentStep++;
    showStep(currentStep);
    setActiveDot(currentStep);
  }
}

function prevStep() {
  if(currentStep > 0) {
    currentStep--;
    showStep(currentStep);
    setActiveDot(currentStep);
  }
}

// Initialize the form with the first step and dot active
showStep(0);
setActiveDot(0);

