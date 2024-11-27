<?php
// API URL for retrieving UOB student data
$api_url = 'https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100';

// Fetch the JSON data from the API
$response = file_get_contents($api_url);

// Check if the API request was successful
if ($response === FALSE) {
    die('Error occurred while fetching data from the API');
}

// Decode the JSON response into a PHP array
$data = json_decode($response, true);

// Check if data is available
if (empty($data['records'])) {
    die('No data available');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UOB Student Nationality Data</title>
    <!-- Link to the external CSS file -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>UOB Students Enrollment by Nationality</h1>
        <p>Displaying student enrollment data for Bachelor programs at the College of IT.</p>

        <!-- Data Table -->
        <table>
            <thead>
                <tr>
                    <th>Year</th>
                    <th>Semester</th>
                    <th>Program</th>
                    <th>Nationality</th>
                    <th>College</th>
                    <th>Number of Students</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Loop through the API data and display it in the table
                foreach ($data['records'] as $record) {
                    // Extract relevant fields from the record
                    $year = $record['fields']['academic_year'];
                    $semester = $record['fields']['semester'];
                    $program = $record['fields']['the_programs'];
                    $nationality = $record['fields']['nationality'];
                    $college = $record['fields']['colleges'];
                    $student_count = $record['fields']['number_of_students'];

                    // Display the record in the table
                    echo "<tr>
                            <td data-label='Year'>$year</td>
                            <td data-label='Semester'>$semester</td>
                            <td data-label='Program'>$program</td>
                            <td data-label='Nationality'>$nationality</td>
                            <td data-label='College'>$college</td>
                            <td data-label='Number of Students'>$student_count</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
