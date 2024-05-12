<!DOCTYPE html>
<html>
<head>
    <title>Real-time Stopwatch</title>
    <script>
        // Function to update the stopwatch display
        function updateStopwatch(startTime) {
            var currentTime = new Date().getTime();
            var elapsedTime = (currentTime - startTime) / 1000; // Convert to seconds

            // Calculate hours, minutes, and seconds
            var hours = Math.floor(elapsedTime / 3600);
            var minutes = Math.floor((elapsedTime % 3600) / 60);
            var seconds = Math.floor(elapsedTime % 60);

            // Format the time
            var timeString = pad(hours) + ":" + pad(minutes) + ":" + pad(seconds);

            // Update the stopwatch display
            document.getElementById("stopwatch").innerHTML = "Elapsed time: " + timeString;
        }

        // Function to pad single digits with leading zeros
        function pad(number) {
            if (number < 10) {
                return "0" + number;
            }
            return number;
        }

        // Function to start the stopwatch
        function startStopwatch() {
            var startTime = new Date().getTime();
            setInterval(function() {
                updateStopwatch(startTime);
            }, 1000); // Update every second
        }
    </script>
</head>
<body onload="startStopwatch()">
    <h1>Real-time Stopwatch</h1>
    <div id="stopwatch"></div>
</body>
</html>
