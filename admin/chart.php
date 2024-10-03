<?php
include 'conn.php';
// Query for monthly data from direct_complaints
$directComplaints = [];
$sql = "SELECT YEAR(submission_date) AS year, MONTH(submission_date) AS month, COUNT(*) AS total_complaints 
        FROM direct_complaints 
        GROUP BY YEAR(submission_date), MONTH(submission_date)";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $directComplaints[] = $row;
}

// Query for monthly data from civil_matter_registration
$civilMatters = [];
$sql = "SELECT YEAR(created_at) AS year, MONTH(created_at) AS month, COUNT(*) AS total_civil_matters 
        FROM civil_matter_registration 
        GROUP BY YEAR(created_at), MONTH(created_at)";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $civilMatters[] = $row;
}

// Query for monthly data from cases
$cases = [];
$sql = "SELECT YEAR(registration_date) AS year, MONTH(registration_date) AS month, COUNT(*) AS total_cases 
        FROM cases 
        GROUP BY YEAR(registration_date), MONTH(registration_date)";
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
    <title>Monthly Data Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    
    <canvas id="monthlyChart" width="400" height="200"></canvas>

    <script>
        // Data from PHP (replace with actual data from queries)
        const directComplaintsData = <?php echo json_encode($directComplaints); ?>;
        const civilMattersData = <?php echo json_encode($civilMatters); ?>;
        const casesData = <?php echo json_encode($cases); ?>;

        // Prepare labels (months)
        const months = [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December'
        ];

        // Get labels by combining year and month
        const labels = directComplaintsData.map(data => {
            return months[data.month - 1] + ' ' + data.year;
        });

        // Extract counts from each dataset
        const directComplaintsCounts = directComplaintsData.map(data => data.total_complaints);
        const civilMattersCounts = civilMattersData.map(data => data.total_civil_matters);
        const casesCounts = casesData.map(data => data.total_cases);

        // Initialize Chart.js
        const ctx = document.getElementById('monthlyChart').getContext('2d');
        const monthlyChart = new Chart(ctx, {
            type: 'bar', // You can also use 'line', 'pie', etc.
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
