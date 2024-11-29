document.getElementById('toggle-password').addEventListener('change', function () {
    const passwordField = document.getElementById('password-signup');
    if (this.checked) {
        passwordField.type = 'text'; 
    } else {
        passwordField.type = 'password'; 
    }
});

const passwordError = document.getElementById('password-error');

// Fusha e emrit
const firstNameInput = document.getElementById('first-name');
firstNameInput.addEventListener('input', function() {
    this.value = this.value.replace(/\s/g, ''); // Heq të gjitha hapësirat
});

// Kontrollo passwordin për të paktën 8 karaktere, dhe të ketë shkronja dhe numra
const passwordInput = document.getElementById('password-signup');
passwordInput.addEventListener('keydown', function(e) {
    if (e.key === 'Enter') {
        const password = this.value;

        // Kontrollo nëse fjalëkalimi ka të paktën 8 karaktere dhe përmban shkronja dhe numra
        const isValidPassword = /^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/.test(password);
        
        if (!isValidPassword) {
            e.preventDefault(); // Ndalon dërgimin e formularit
            passwordError.textContent = "Password should have at least 8 characters and contain letters and numbers."; // Mesazhi i gabimit
            passwordError.style.display = 'block'; // Bëhet i dukshëm
        } else {
            passwordError.style.display = 'none'; // Fshihet gabimi nëse fjalëkalimi është valid
        }
    }
});

// Kontrollo nëse ka hapësira në emër, mbiemër ose email dhe shfaq gabim
const emailInput = document.getElementById('email-login');
const lastNameInput = document.getElementById('last-name');
const firstNameInputForCheck = document.getElementById('first-name');

const showInputError = (inputField, errorMessage) => {
    if (inputField.value.includes(" ")) {
        inputField.setCustomValidity(errorMessage);
    } else {
        inputField.setCustomValidity('');
    }
};

firstNameInputForCheck.addEventListener('input', () => {
    showInputError(firstNameInputForCheck, "First name cannot contain spaces");
});

lastNameInput.addEventListener('input', () => {
    showInputError(lastNameInput, "Last name cannot contain spaces");
});

emailInput.addEventListener('input', () => {
    showInputError(emailInput, "Email cannot contain spaces");
});
