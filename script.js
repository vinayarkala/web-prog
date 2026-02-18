document.getElementById('submitBtn').addEventListener('click', function () {
    const formData = new FormData(document.getElementById('stockForm'));

    fetch('insert_stock.php', {
        method: 'POST',
        body: formData,
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Data inserted successfully!');
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the form.');
        });
});


