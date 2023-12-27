<?php
// Include database configuration file
include('connection.php');

// Initialize variables for filter values
$end_year = $topic = $sector = $region = $pest = $source = $swot = $country = $city = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch the filter values from the form
    $end_year = $_POST['end_year'];
    $topic = $_POST['topic'];
    $sector = $_POST['sector'];
    $region = $_POST['region'];
    $pest = $_POST['pest'];
    $source = $_POST['source'];
    $swot = $_POST['swot'];
    $country = $_POST['country'];
    $city = $_POST['city'];

    // Construct the SQL query based on the provided filters
    $sql = "SELECT * FROM data WHERE 
        end_year LIKE '%$end_year%' 
        AND topic LIKE '%$topic%' 
        AND sector LIKE '%$sector%' 
        AND region LIKE '%$region%' 
        AND pestle LIKE '%$pest%' 
        AND source LIKE '%$source%' 
        AND swot LIKE '%$swot%' 
        AND country LIKE '%$country%' 
        AND city LIKE '%$city%'";
} else {
    // If the form is not submitted, fetch all data
    $sql = "SELECT * FROM data";
}

// Fetch filtered or all data from the database
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Visualization Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- Include D3.js -->
    <script src="https://d3js.org/d3.v7.min.js"></script>
</head>
<body>

    <div class="container mt-4">
        <h2>Apply one filter at time and no filter to get complete data</h2>
        <form method="POST">
            <!-- Filter fields -->
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="end_year">End Year:</label>
                        <input type="text" name="end_year" class="form-control" value="<?php echo $end_year; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="topic">Topic:</label>
                        <input type="text" name="topic" class="form-control" value="<?php echo $topic; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="sector">Sector:</label>
                        <input type="text" name="sector" class="form-control" value="<?php echo $sector; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="region">Region:</label>
                        <input type="text" name="region" class="form-control" value="<?php echo $region; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="pest">PEST:</label>
                        <input type="text" name="pest" class="form-control" value="<?php echo $pest; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="source">Source:</label>
                        <input type="text" name="source" class="form-control" value="<?php echo $source; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="swot">SWOT:</label>
                        <input type="text" name="swot" class="form-control" value="<?php echo $swot; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="country">Country:</label>
                        <input type="text" name="country" class="form-control" value="<?php echo $country; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="city">City:</label>
                        <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                    </div>
                </div>
            </div>
            <input type="submit" value="Apply Filters" class="btn btn-primary">
        </form>
    </div>

    <div class="container mt-4">
        <h2>Data Table</h2>
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <!-- Display table headers -->
                    <?php
                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        foreach (array_keys($row) as $column) {
                            echo "<th>$column</th>";
                        }
                    } else {
                        echo "<th>No data found</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <!-- Display table data -->
                    <?php
                    if ($result->num_rows > 0) {
                        // Reset the pointer back to the beginning after fetching column names
                        mysqli_data_seek($result, 0);
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            foreach ($row as $col) {
                                echo "<td>" . $col . "</td>";
                            }
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='" . count($row) . "'>No data found</td></tr>";
                    }
                    ?>
                </tr>
            </tbody>
        </table>
    </div>

    

</body>
</html>
