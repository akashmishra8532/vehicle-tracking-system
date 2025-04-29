<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Route Tracking</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
    </style>
</head>
<body>

<h2>Live Vehicle Tracking</h2>
<div id="map"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Set default coordinates (example: Delhi)
    const defaultLat = 28.6139;
    const defaultLng = 77.2090;

    // Create map and set view
    const map = L.map('map').setView([defaultLat, defaultLng], 13);

    // Add OpenStreetMap layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    let marker;
    const vehicleId = 1;

    async function fetchLocation() {
        const response = await fetch(`/api/vehicle/${vehicleId}/location`);
        const data = await response.json();

        if (!data) return;

        const { latitude, longitude } = data;

        if (marker) {
            marker.setLatLng([latitude, longitude]);
        } else {
            marker = L.marker([latitude, longitude]).addTo(map)
                      .bindPopup("Vehicle is here").openPopup();
        }

        map.setView([latitude, longitude], 15);
    }

    fetchLocation(); // Initial fetch
    setInterval(fetchLocation, 5000); // Update every 5 seconds
</script>

</body>
</html>
