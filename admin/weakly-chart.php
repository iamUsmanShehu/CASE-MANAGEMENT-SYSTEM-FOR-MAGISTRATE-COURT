<?php
include 'conn.php';
// Query for weekly data from direct_complaints
$directComplaints = [];
$sql = "SELECT YEAR(submission_date) AS year, WEEK(submission_date, 1) AS week, COUNT(*) AS total_complaints 
        FROM direct_complaints 
        GROUP BY YEAR(submission_date), WEEK(submission_date, 1)";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $directComplaints[] = $row;
}

// Query for weekly data from civil_matter_registration
$civilMatters = [];
$sql = "SELECT YEAR(created_at) AS year, WEEK(created_at, 1) AS week, COUNT(*) AS total_civil_matters 
        FROM civil_matter_registration 
        GROUP BY YEAR(created_at), WEEK(created_at, 1)";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $civilMatters[] = $row;
}

// Query for weekly data from cases
$cases = [];
$sql = "SELECT YEAR(registration_date) AS year, WEEK(registration_date, 1) AS week, COUNT(*) AS total_cases 
        FROM cases 
        GROUP BY YEAR(registration_date), WEEK(registration_date, 1)";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $cases[] = $row;
}

// Close connection
$conn->close();
?>

<!-- Step 2: HTML and Chart.js Visualization -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weekly Data Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    
    <canvas id="weeklyChart" width="400" height="200"></canvas>

    <script>
        // Data from PHP
        const directComplaintsData = <?php echo json_encode($directComplaints); ?>;
        const civilMattersData = <?php echo json_encode($civilMatters); ?>;
        const casesData = <?php echo json_encode($cases); ?>;

        // Prepare labels (weeks)
        const labels = [];
        const weekCount = Math.max(directComplaintsData.length, civilMattersData.length, casesData.length);

        for (let i = 0; i < weekCount; i++) {
            const weekNumber = directComplaintsData[i]?.week || civilMattersData[i]?.week || casesData[i]?.week;
            const year = directComplaintsData[i]?.year || civilMattersData[i]?.year || casesData[i]?.year;
            if (weekNumber && year) {
                labels.push(`Week ${weekNumber} ${year}`);
            }
        }

        // Extract counts from each dataset
        const directComplaintsCounts = directComplaintsData.map(data => data.total_complaints || 0);
        const civilMattersCounts = civilMattersData.map(data => data.total_civil_matters || 0);
        const casesCounts = casesData.map(data => data.total_cases || 0);

        // Initialize Chart.js
        const ctx = document.getElementById('weeklyChart').getContext('2d');
        const weeklyChart = new Chart(ctx, {
            type: 'line', // You can also use 'line', 'pie', etc.
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Direct Complaints',
                        data: directComplaintsCounts,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Civil Matters',
                        data: civilMattersCounts,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Cases',
                        data: casesCounts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>
</html>
