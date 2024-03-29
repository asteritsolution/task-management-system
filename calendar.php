<?php
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');
$countryCode = isset($_GET['country']) ? $_GET['country'] : 'IN'; // Country code for India
$api_key = 'ZMrZXYDX9bsJiJJNfJq3ZZrQraFbBAha'; // Replace with your Calendarific API key
$calendarificApiUrl = "https://calendarific.com/api/v2/holidays?api_key=$api_key&country=$countryCode&year=$year";

// Make API request
$response = file_get_contents($calendarificApiUrl);
if ($response !== false) {
    // Decode JSON response
    $holidaysData = json_decode($response, true);
    if (isset($holidaysData['response']['holidays'])) {
        // Convert the holidays data to a format compatible with the calendar
        $festivalData = [];
        foreach ($holidaysData['response']['holidays'] as $holiday) {
            $date = $holiday['date']['iso'];
            $name = $holiday['name'];
            $festivalData[$date] = $name;
        }
        // Generate calendar
        generateCalendar($year, $festivalData);
    } else {
        echo "Error retrieving holidays from the Calendarific API.";
        echo "Error details: " . print_r($holidaysData, true); // Debugging information
    }
} else {
    echo "Unable to fetch holiday data from the Calendarific API.";
}

function generateCalendar($year, $festivalData) {
    // Get current month and year
    $currentMonth = date('n');
    $currentYear = date('Y');

    // Output HTML for each month side by side
    for ($month = 1; $month <= 12; $month++) {
        // Skip past months if current year
        if ($year == $currentYear && $month < $currentMonth)
            continue;

        // Get the first day of the month
        $firstDay = mktime(0, 0, 0, $month, 1, $year);
        // Get the number of days in the month
        $daysInMonth = date('t', $firstDay);
        
        // Start container div for the month
        echo "<div style='display: flex; margin-bottom: 20px;'>";

        // Output calendar for the month
        echo "<div style='flex: 1;'>";
        echo "<h2>" . date('F Y', $firstDay) . "</h2>";
        echo "<table border='1'>";
        echo "<tr>";
        
        // Output day names
        $dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        foreach ($dayNames as $day) {
            echo "<th>$day</th>";
        }
        echo "</tr><tr>";
        
        // Output blank cells for the days before the first day of the month
        for ($i = 0; $i < date('w', $firstDay); $i++) {
            echo "<td></td>";
        }
        
        // Output the days of the month
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
            $festival = isset($festivalData[$currentDate]) ? $festivalData[$currentDate] : '';
            
            // Determine the style for the cell based on the festival presence
            $cellStyle = empty($festival) ? '' : 'style="color: red;"';
            
            echo "<td $cellStyle>";
            echo "$day";
            echo "</td>";
            
            // Start a new row if it's the last day of the week
            if (date('w', mktime(0, 0, 0, $month, $day, $year)) == 6) {
                echo "</tr><tr>";
            }
        }
        
        // Output blank cells for the remaining days in the last week
        for ($i = date('w', mktime(0, 0, 0, $month, $day, $year)); $i < 6; $i++) {
            echo "<td></td>";
        }
        
        echo "</tr></table>";
        echo "</div>"; // End calendar div

        // Display festivals for the current month on the right side
        echo "<div style='flex: 1;'>";
        echo "<h3>Festivals</h3>";
        echo "<ul style='list-style-type:none; color: red;'>";
        foreach ($festivalData as $date => $festival) {
            $festivalMonth = date('n', strtotime($date));
            if ($festivalMonth == $month) {
                echo "<li>" . date('F j, Y', strtotime($date)) . ": $festival</li>";
            }
        }
        echo "</ul>";
        echo "</div>"; // End festivals div

        echo "</div>"; // End container div
    }
}
