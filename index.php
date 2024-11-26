<?php
// Define the API endpoint URL
$URL = "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";

// Use file_get_contents to get the JSON data from the API
$response = file_get_contents($URL);

// Check if the response was successfully retrieved
if ($response === FALSE) {
    die("Error retrieving data.");
}

// Decode the JSON response into an associative array
$result = json_decode($response, true);

// Check if the decoding was successful
if ($result === NULL) {
    die("Error decoding JSON.");
}

// Extract the records from the response (assuming 'records' key contains the data)
$data = $result['records'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UOB Students Nationalities</title>
    <link href="https://unpkg.com/picocss@1.5.1/dist/pico.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet"> <!-- Link to your custom CSS if any -->
</head>
<body>

    <h1>University of Bahrain - Students Enrollment by Nationality</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Nationality</th>
                <th>Number of Students</th>
                <th>Program</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Iterate through the records and display the data in table rows
            foreach ($data as $record) {
                // Retrieve nationality, number of students, and program
                $nationality = $record['fields']['nationality'];
                $num_students = $record['fields']['number_of_students'];
                $program = $record['fields']['the_programs'];
                
                echo "<tr>";
                echo "<td>" . htmlspecialchars($nationality) . "</td>";
                echo "<td>" . htmlspecialchars($num_students) . "</td>";
                echo "<td>" . htmlspecialchars($program) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
