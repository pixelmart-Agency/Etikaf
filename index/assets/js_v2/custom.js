
// button toggle-password
document.getElementById('toggle-password').addEventListener('click', function () {
    let passwordField = this.nextElementSibling;

    // Check if the next sibling is an input element
    if (passwordField && passwordField.tagName.toLowerCase() === 'input') {
        // Toggle the input type and update the icon
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            this.setAttribute('aria-pressed', 'true');
            this.setAttribute('aria-label', 'Hide password');
        } else {
            passwordField.type = 'password';
            this.setAttribute('aria-pressed', 'false');
            this.setAttribute('aria-label', 'Show password');
        }
    }

});
