document.getElementById('signOutButton').addEventListener('click', function () {
    // Clear session or token
    alert('You have been signed out.'); // Optional: Display a confirmation message
    window.location.href = 'login.html'; // Redirect to login page
});