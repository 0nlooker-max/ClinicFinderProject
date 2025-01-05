function performSearch() {
    const query = document.getElementById('search-bar').value;
    const resultsContainer = document.getElementById('search-results');

    // Clear previous results
    resultsContainer.innerHTML = '';

    if (query.trim() === '') {
        resultsContainer.innerHTML = '<p>Please enter a search query.</p>';
        return;
    }

    // Perform AJAX request
    fetch(`..ResidentSide\backhompage.php?query=${encodeURIComponent(query)}`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                resultsContainer.innerHTML = '<p>No clinics found.</p>';
                return;
            }

            // Display the results
            data.forEach(clinic => {
                const clinicCard = document.createElement('div');
                clinicCard.classList.add('clinic-card');
                clinicCard.innerHTML = `
                    <h3>${clinic.name}</h3>
                    <p>Address: ${clinic.address}</p>
                    <p>Services: ${clinic.services}</p>
                    <button onclick="viewDetails(${clinic.clinic_id})">View Details</button>
                `;
                resultsContainer.appendChild(clinicCard);
            });
        })
        .catch(error => {
            console.error('Error:', error);
            resultsContainer.innerHTML = '<p>An error occurred while searching.</p>';
        });
}

function viewDetails(clinicId) {
    // Redirect to clinic details page or handle dynamic display
    window.location.href = `..\ResidentSide\indexs.php?page=clinicDetails&id=${clinicId}`;
}
