document.addEventListener('DOMContentLoaded', function () {
  document.querySelector('.form').addEventListener('submit', function (e) {
    e.preventDefault();
    
    const pickupLocation = document.getElementById('pickup-location').value;
    const dropoffLocation = document.getElementById('dropoff-location').value;
    const rideTime = document.getElementById('ride-time').value;
    const carType = document.getElementById('car-type').value;

    if (pickupLocation && dropoffLocation && rideTime && carType) {
      showNotification(`
        <strong>Taxi Booking Confirmed!</strong><br>
        Pickup: ${pickupLocation}<br>
        Dropoff: ${dropoffLocation}<br>
        Time: ${rideTime}<br>
        Car Type: ${carType}
      `);
    } else {
      alert('Please fill out all fields.');
    }
  });
});

function showNotification(message) {
  const notification = document.querySelector('.notification');
  notification.innerHTML = message;
  notification.style.display = 'block';
  setTimeout(function () {
    notification.style.display = 'none';
  }, 5000);
}
