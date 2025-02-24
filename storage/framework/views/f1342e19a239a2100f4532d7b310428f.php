<div id="map" style="height: <?php echo e($height ?? '400px'); ?>"></div>
<input type="hidden" id="location" name="location" value="<?php echo e($location ?? '21.4225,39.8262'); ?>">

<script>
    let map;
    let marker;

    // Initialize the map after the API is loaded
    async function initMap() {
        let location = document.getElementById("location");
        let lat = location.value.split(',')[0];
        let lng = location.value.split(',')[1];

        // Import the Maps library in a modular way
        const {
            Map
        } = await google.maps.importLibrary("maps");

        // Create the map object
        map = new Map(document.getElementById("map"), {
            center: {
                lat: parseFloat(lat),
                lng: parseFloat(lng),
            },
            zoom: 14,
        });

        // Add a marker to the map based on the initial location value
        marker = new google.maps.Marker({
            position: {
                lat: parseFloat(lat),
                lng: parseFloat(lng),
            },
            map: map,
            title: "Click to change location",
        });

        // Add a click event listener to update the location and marker
        map.addListener("click", (event) => {
            // Get the latitude and longitude of the click
            const lat = event.latLng.lat();
            const lng = event.latLng.lng();

            // Update the position of the marker
            marker.setPosition({
                lat,
                lng
            });

            // Update the hidden input field with the new location
            document.getElementById("location").value = `${lat},${lng}`;
        });
    }

    // Load the Google Maps API with async and defer
    // This ensures that the map is only initialized after the API is loaded
    window.initMap = initMap; // Ensure initMap is accessible globally for the callback
</script>

<!-- Load the Google Maps JavaScript API with async and defer -->
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo e(env('GOOGLE_MAP_KEY')); ?>&callback=initMap" async defer>
</script>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/inputs/map.blade.php ENDPATH**/ ?>