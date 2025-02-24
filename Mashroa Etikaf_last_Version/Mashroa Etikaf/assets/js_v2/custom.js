
// button toggle-password
function togglePasswordHandler(_this) {
    let passwordField = _this.nextElementSibling;

    // Check if the next sibling is an input element
    if (passwordField && passwordField.tagName.toLowerCase() === 'input') {
        // Toggle the input type and update the icon
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            _this.setAttribute('aria-pressed', 'true');
            _this.setAttribute('aria-label', 'Hide password');
        } else {
            passwordField.type = 'password';
            _this.setAttribute('aria-pressed', 'false');
            _this.setAttribute('aria-label', 'Show password');
        }
    }
}
document.getElementById('toggle-password').addEventListener('click', function () {
    togglePasswordHandler(this);
});
document.getElementById('toggle-password-confirm').addEventListener('click', function () {
    togglePasswordHandler(this);
});
