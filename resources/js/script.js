document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent default form submission

    // Get username and password values
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;

    // You can add your login logic here
    // For example, you can send an AJAX request to your server to authenticate the user
    // This is just a basic example

    // If you want to redirect user after successful login, you can use window.location.href = 'redirect-url';
});
