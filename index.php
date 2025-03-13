<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $origin = $_POST["origin"];
        $destination = $_POST["destination"];

        function getDirections($origin, $destination) {
            $apiKey = "AlzaSycuuw0n7eTWpVDgojE9FplAsIr_i3RBlRi";
            $url = "https://maps.gomaps.pro/maps/api/directions/json?origin=" . urlencode($origin) . "&destination=" . urlencode($destination) . "&key=" . $apiKey;
        
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            
            $response = curl_exec($ch);
            curl_close($ch);
        
            return json_decode($response, true);
        }
        $directions = getDirections($origin, $destination);
        if ($directions['status'] == "OK") {
            $route = $directions['routes'][0];
            $leg = $route['legs'][0];

            echo "<h3>Route Details</h3>";
            echo "Distance: " . $leg['distance']['text'] . "<br>";
            echo "Duration: " . $leg['duration']['text'] . "<br>";
        } else {
            echo "<p>Error: " . $directions['status'] . "</p>";
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directions with Autocomplete</title>
    <script src="https://maps.gomaps.pro/maps/api/js?key=AlzaSycuuw0n7eTWpVDgojE9FplAsIr_i3RBlRi&libraries=places"></script>
</head>
<body>

    <h2>Get Directions</h2>
    <form method="POST" action="">
        <label for="origin">Enter Origin:</label>
        <input type="text" id="origin" name="origin" required>
        
        <label for="destination">Enter Destination:</label>
        <input type="text" id="destination" name="destination" required>
        
        <button type="submit">Get Directions</button>
    </form>
    <script>
        function initAutocomplete() {
            let originInput = document.getElementById("origin");
            let destinationInput = document.getElementById("destination");

            new google.maps.places.Autocomplete(originInput);
            new google.maps.places.Autocomplete(destinationInput);
        }

        google.maps.event.addDomListener(window, "load", initAutocomplete);
    </script>
</body>
</html>