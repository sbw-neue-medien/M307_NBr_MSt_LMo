document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(event) {
            const requiredFields = ['customer_name', 'contact_person', 'email', 'phone', 'street', 'postal_code', 'city', 'customer_class'];
            let isValid = true;

            requiredFields.forEach(field => {
                const element = document.getElementById(field);
                if (!element.value.trim()) {
                    alert(`${field.replace('_', ' ')} is required.`);
                    isValid = false;
                }
            });

            // Email validation
            const email = document.getElementById('email');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.value && !emailRegex.test(email.value)) {
                alert('Invalid email format.');
                isValid = false;
            }

            // Phone validation
            const phone = document.getElementById('phone');
            const phoneRegex = /^[\d\s\-\(\)]+$/;
            if (phone.value && !phoneRegex.test(phone.value)) {
                alert('Invalid phone format.');
                isValid = false;
            }

            if (!isValid) {
                event.preventDefault();
            }
        });
    }
});