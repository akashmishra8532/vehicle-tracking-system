<!DOCTYPE html>
<html>
<head>
    <title>Live Vehicle Tracking</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map { height: 100vh; }
    </style>
</head>
<body>

    <div id="map"></div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const vehicleId = 1; // Change as needed

        const map = L.map('map').setView([28.6139, 77.2090], 13); // Initial center (Delhi)

        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        // Marker for vehicle
        let marker = L.marker([28.6139, 77.2090]).addTo(map)
            .bindPopup('Vehicle Location')
            .openPopup();

        // Function to fetch location from Laravel route
        async function fetchLocation() {
            const res = await fetch(`/get-location/${vehicleId}`);
            const data = await res.json();

            if (data.lat && data.lng) {
                const lat = parseFloat(data.lat);
                const lng = parseFloat(data.lng);
                marker.setLatLng([lat, lng]);
                map.setView([lat, lng], 13);
            }
        }

        // Initial fetch
        fetchLocation();

        // Update location every 5 seconds
        setInterval(fetchLocation, 5000);
    </script>

</body>
</html>