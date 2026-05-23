// Wait until the HTML page is fully loaded before running JavaScript.
document.addEventListener('DOMContentLoaded', function () {
    // Find the refresh button by its id from index.php.
    const refreshButton = document.getElementById('refreshButton');

    // Stop the script if the button cannot be found.
    if (!refreshButton) {
        return;
    }

    // Reload the page when the refresh button is clicked.
    refreshButton.addEventListener('click', function () {
        window.location.reload();
    });
});
