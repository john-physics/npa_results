   // Function to show the message and fade it out after a few seconds
        function showReport() {
            var report = document.getElementById('report');
            report.style.display = 'block'; // Show the message
            setTimeout(function() {
                report.style.opacity = 0; // Start fading
            }, 3000); // Wait 3 seconds before starting the fade

            setTimeout(function() {
                report.style.display = 'none'; // Hide the message after it fades
            }, 5000); // Wait 5 seconds for the fade to complete
        }

        // Call the function to show the message when the page loads
        window.onload = function() {
            showReport();
        };