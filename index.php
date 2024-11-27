<?php
// API URL for retrieving UOB student data
$api_url = 'https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100';

// Use cURL to fetch data from the API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// Check if the API request was successful
if ($response === FALSE) {
    die('Error occurred while fetching data from the API');
}

// Decode the JSON response into a PHP array
$data = json_decode($response, true);

// Check if the 'results' key exists and contains data
if (empty($data['results'])) {
    die('No data available');
}

// Array to hold grouped data
$grouped_data = [];

// Loop through the results and group data by year, semester, nationality, and program
foreach ($data['results'] as $record) {
    $year = $record['year'] ?? 'N/A';
    $semester = $record['semester'] ?? 'N/A';
    $program = $record['the_programs'] ?? 'N/A';
    $nationality = $record['nationality'] ?? 'N/A';
    $college = $record['colleges'] ?? 'N/A';
    $student_count = $record['number_of_students'] ?? 0;

    // Group data by year, semester, nationality, and program
    $key = "$year|$semester|$nationality|$program";
    
    if (!isset($grouped_data[$key])) {
        $grouped_data[$key] = [
            'year' => $year,
            'semester' => $semester,
            'program' => $program,
            'nationality' => $nationality,
            'college' => $college,
            'student_count' => 0
        ];
    }

    // Add student count to the grouped data
    $grouped_data[$key]['student_count'] += $student_count;
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
    <style>
        /* Basic styling for the table */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
            color: #2a2a2a; /* Change this to your desired color */
        }
        td {
            color: #333; /* Default text color for the table data */
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
    </style>
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
                // Loop through the grouped data and display it in the table
                foreach ($grouped_data as $data_row) {
                    // Extract relevant fields from the grouped data
                    $year = $data_row['year'];
                    $semester = $data_row['semester'];
                    $program = $data_row['program'];
                    $nationality = $data_row['nationality'];
                    $college = $data_row['college'];
                    $student_count = $data_row['student_count'];

                    // Display the record in the table
                    echo "<tr>
                            <td>$year</td>
                            <td>$semester</td>
                            <td>$program</td>
                            <td>$nationality</td>
                            <td>$college</td>
                            <td>$student_count</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
