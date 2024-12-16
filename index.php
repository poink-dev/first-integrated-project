<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Data Submission</title>
    <link rel="stylesheet" href="styles.css">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>

<?php
session_start();
?>

<body>
    <div class="container">
        <h1>Submit Elapsed Time</h1>
        <form id="sensorForm" action="submit.php" method="POST">
            <input type="text" name="name" id="name" class='form-control' placeholder="type the name of user">
            <br>
            <button class="btn btn-success" onclick="sentName()">start</button>
            <!-- <label for="elapsedTime">Elapsed Time (ms):</label> -->
            <!-- <input type="number" id="elapsedTime" name="elapsedTime" step="0.01" required> -->

            <!-- <button type="submit">Submit Data</button> -->
        </form>
        <div id="response"></div>

        <h2>Latest Elapsed Time</h2>
        <div><?php $_SESSION['elapsedTime'] ?></div>
        <div id="latestElapsedTime">Loading...</div>
    </div>

    <script>
        function sentName() {
            let name = $('#name').val()
            if (name == '') {
                alert('Please enter a name')
            } else {
                $.ajax({
                    url: './includes/data-sent.php.php',
                    method: 'POST',
                    data: {
                        name,
                    },
                    dataType: '',
                    success: function() {
                        console.log('yes');

                    }

                })
            }
        }


        document.getElementById('sensorForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('./includes/data-sent.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    document.getElementById('response').innerHTML = data;
                    loadData(); // Reload data after submitting new data
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        });

        // Load the latest elapsed time when the page loads
        $(document).ready(function() {
            loadData();
        });

        // Function to load the latest elapsed time
        function loadData() {
            $.ajax({
                url: './includes/recieve-data.php',
                method: 'POST',
                dataType: 'json',
                success: function(data) {
                    if (data && data.elapsedTime !== undefined) {
                        document.getElementById('latestElapsedTime').innerText = data.elapsedTime + " ms";
                    } else {
                        document.getElementById('latestElapsedTime').innerText = "No data available";
                    }
                },
                error: function() {
                    console.log('Error retrieving elapsed time');
                    document.getElementById('latestElapsedTime').innerText = "Error retrieving data";
                }
            });
        }
    </script>
</body>

</html>