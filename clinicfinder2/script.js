
document.getElementById('category-filter').addEventListener('change', (event) => {
    const category = event.target.value;
    const clinics = document.querySelectorAll('.clinic');
    clinics.forEach(clinic => {
        if (category === 'all' || clinic.getAttribute('data-category') === category) {
            clinic.style.display = 'block';
        } else {
            clinic.style.display = 'none';
        }
    });
});

document.getElementById('search-bar').addEventListener('input', (event) => {
    const searchQuery = event.target.value.toLowerCase(); // Get the search query
    const clinics = document.querySelectorAll('.clinic'); // Get all clinic elements

    clinics.forEach(clinic => {
        const clinicName = clinic.querySelector('.clinic-name').textContent.toLowerCase(); // Get the clinic's name
        // If the clinic name matches the search query, display it, otherwise hide it
        if (clinicName.includes(searchQuery)) {
            clinic.style.display = 'block';
        } else {
            clinic.style.display = 'none';
        }
    });
});

function showDirections(clinicId) {
    const map = document.getElementById(`map-${clinicId}`);
    if (map.style.display === 'block') {
        map.style.display = 'none';
    } else {
        map.style.display = 'block';
    }
}

const clinics = [
    {
      name: "OASIS DIAGNOSTIC & LABORATORY CENTER",
      location: { lat: 11.048747, lng: 124.003222 },
      mapEmbed: `
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d885.9134666921996!2d124.0032223695349!3d11.048747415566881!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a8696faea9d943%3A0xa1223980eb7e3fa8!2sOASIS%20DIAGNOSTIC%20%26%20LABORATORY%20CENTER!5e1!3m2!1sen!2sph!4v1731390007231!5m2!1sen!2sph" 
          width="600" 
          height="450" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      `,
    },
    {
      name: "Bogo Clinical Laboratory",
      location: { lat: 11.048754, lng: 124.001291 },
      mapEmbed: `
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3543.6537874285!2d124.00129117452198!3d11.048753985246345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a868cf3f62f563%3A0xdacf18c5dee904d1!2sBogo%20Clinical%20Laboratory!5e1!3m2!1sen!2sph!4v1731390043221!5m2!1sen!2sph" 
          width="600" 
          height="450" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      `,
    },
    {
      name: "Verdida Optical Clinic",
      location: { lat: 11.048754, lng: 124.001291 },
      mapEmbed: `
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3543.6537874285!2d124.00129117452198!3d11.048753985246345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a868cf3f62f563%3A0xdacf18c5dee904d1!2sBogo%20Clinical%20Laboratory!5e1!3m2!1sen!2sph!4v1731390043221!5m2!1sen!2sph" 
          width="600" 
          height="450" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      `,
    },
    {
      name: "Mayol Dental Clinic",
      location: { lat: 11.049110, lng: 124.004254 },
      mapEmbed: `
        <iframe 
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d685.35369439317!2d124.00425360472885!3d11.049110250932626!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33a8693ed402351b%3A0x736ea2c1aca223c3!2sMayol%20Dental%20Clinic!5e1!3m2!1sen!2sph!4v1731389972933!5m2!1sen!2sph" 
          width="600" 
          height="450" 
          style="border:0;" 
          allowfullscreen="" 
          loading="lazy" 
          referrerpolicy="no-referrer-when-downgrade">
        </iframe>
      `,
    },
  ];
  
  document.getElementById("clinics-near-me").addEventListener("click", () => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showNearestClinic, showError);
    } else {
      alert("Geolocation is not supported by this browser.");
    }
  });
  
  function showNearestClinic(position) {
    const userLat = position.coords.latitude;
    const userLng = position.coords.longitude;
  
    let nearestClinic = null;
    let shortestDistance = Infinity;
  
    clinics.forEach(clinic => {
      const distance = getDistanceFromLatLonInKm(
        userLat,
        userLng,
        clinic.location.lat,
        clinic.location.lng
      );
      if (distance < shortestDistance) {
        shortestDistance = distance;
        nearestClinic = clinic;
      }
    });
  
    if (nearestClinic) {
      const suggestedClinicDiv = document.getElementById("suggested-clinic");
      suggestedClinicDiv.classList.remove("hidden");
      document.getElementById("clinic-details").
      innerHTML = `
      <h4>${nearestClinic.name}</h4>
      <div>${nearestClinic.mapEmbed}</div>
    `;
  } else {
    alert("No clinics found nearby.");
  }
}

function showError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      alert("User denied the request for Geolocation.");
      break;
    case error.POSITION_UNAVAILABLE:
      alert("Location information is unavailable.");
      break;
    case error.TIMEOUT:
      alert("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
      alert("An unknown error occurred.");
      break;
  }
}

// Helper function to calculate the distance between two coordinates
function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
  const R = 6371; // Radius of the Earth in km
  const dLat = deg2rad(lat2 - lat1);
  const dLon = deg2rad(lon2 - lon1);
  const a =
    Math.sin(dLat / 2) * Math.sin(dLat / 2) +
    Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
    Math.sin(dLon / 2) * Math.sin(dLon / 2);
  const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
  return R * c; // Distance in km
}

function deg2rad(deg) {
  return deg * (Math.PI / 180);
}
  