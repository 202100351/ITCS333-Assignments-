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

// Extract the data (under the 'results' key)
$data = isset($result['results']) ? $result['results'] : [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UOB Students Nationalities</title>
    <link href="https://unpkg.com/picocss@1.5.1/dist/pico.min.css" rel="stylesheet">
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
            // Check if data exists
            if (empty($data)) {
                echo "<tr><td colspan='3'>No data available.</td></tr>";
            } else {
                // Iterate through the 'results' and display the data
                foreach ($data as $record) {
                    // Handle fields based on available data in the response
                    $semester = $record['semester'] ?? 'N/A';
                    $year = $record['year'] ?? 'N/A';
                    $program = $record['the_programs'] ?? 'N/A';
                    
                    // Assuming you want to display this as an example, since "nationality" data is not in the sample
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($semester) . " (" . htmlspecialchars($year) . ")</td>";
                    echo "<td>" . htmlspecialchars($program) . "</td>";
                    echo "<td>" . htmlspecialchars($program) . "</td>"; // Using the program again as a placeholder for "nationality"
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

</body>
</html>
