// Client-side validation
document.getElementById('customerForm').addEventListener('submit', function(event) {
    let isValid = true;
    const errors = [];

    // Required fields
    const requiredFields = ['customer_name', 'contact_name', 'email', 'phone', 'street', 'postal_code', 'city', 'customer_class_id'];
    requiredFields.forEach(field => {
        const element = document.getElementById(field);
        if (!element.value.trim()) {
            errors.push(`${field.replace('_', ' ')} is required.`);
            isValid = false;
        }
    });

    // Email validation
    const email = document.getElementById('email').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email && !emailRegex.test(email)) {
        errors.push('Please enter a valid email address.');
        isValid = false;
    }

    // Phone validation
    const phone = document.getElementById('phone').value;
    const phoneRegex = /^\+?[0-9\s\-\(\)]+$/;
    if (phone && !phoneRegex.test(phone)) {
        errors.push('Please enter a valid phone number.');
        isValid = false;
    }

    if (!isValid) {
        event.preventDefault();
        alert('Validation errors:\n' + errors.join('\n'));
    }
});