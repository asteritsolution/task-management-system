<?php
// Include database connection
include('db_connect.php');

// Initialize $id variable
$id = "";

// Check if the 'id' parameter is passed in the URL
if(isset($_GET['id'])) {
    // Retrieve the 'id' parameter from the URL
    $id = $_GET['id'];
} else {
    // Redirect to an error page or display an error message
    echo "Error: ID parameter is missing in the URL";
    exit(); // Stop further execution
}

// Check if the form is submitted for updating existing record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Extract data from POST request
    $id = $_POST['id']; // Retrieve 'id' from hidden input field
    $clientName = $_POST['client_name'];
    $festival = $_POST['festival'];
    $staticContent = $_POST['static_content'];
    $reelContent = $_POST['reel_content'];

    // Prepare SQL statement to update data in client_base table
    $sql = "UPDATE client_base SET client_name='$clientName', festival='$festival', static_content='$staticContent', reel_content='$reelContent' WHERE id=$id";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert alert-success" role="alert">
        <strong> Hii Admin </strong> Record updated successfully now Go Back !
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>';
      
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Retrieve data for the selected row from the database
$sql = "SELECT * FROM client_base WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Record</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div style="margin-top: 50px;" class="container">
        <h2 style="text-align: center;">Edit Record</h2>
        <form method="post" action="#">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <div style="cursor: pointer;" class="form-group">
                <label for="clientName">Select Client name</label>
                <select class="form-control" id="clientName" name="client_name">
                <?php
                // Query to fetch client names from the database
                $sql_client = "SELECT name FROM client";
                $result_client = $conn->query($sql_client);
                // If there are results, display them in the dropdown
                if ($result_client->num_rows > 0) {
                    while ($row_client = $result_client->fetch_assoc()) {
                        $selected = ($row['client_name'] == $row_client['name']) ? 'selected' : '';
                        echo "<option $selected>" . $row_client["name"] . "</option>";
                    }
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="clientfestival">Festival</label>
                <select class="form-control" id="clientfestival" name="festival">
                <?php
                // Query to fetch festivals from the database
                $sql_calendar = "SELECT important_days FROM calendar";
                $result_calendar = $conn->query($sql_calendar);

                // If there are results, display them in the dropdown
                if ($result_calendar->num_rows > 0) {
                    while ($row_calendar = $result_calendar->fetch_assoc()) {
                        $selected = ($row['festival'] == $row_calendar['important_days']) ? 'selected' : '';
                        echo "<option $selected>" . $row_calendar["important_days"] . "</option>";
                    }
                }
                ?>
                </select>
            </div>
            <div class="form-group">
                <label for="staticContent">Static Content</label>
                <textarea type="text" class="form-control" id="staticContent" name="static_content" aria-describedby="emailHelp" placeholder="Enter static content"><?php echo $row['static_content']; ?></textarea>
            </div>
            <div class="form-group">
                <label for="reelContent">Reel Content</label>
                <textarea type="text" class="form-control" id="reelContent" name="reel_content" aria-describedby="emailHelp" placeholder="Enter reel content"><?php echo $row['reel_content']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="update">Update</button>
        </form>
    </div>
</body>
</html>
<?php
} else {
    echo "No record found with ID: $id";
}

// Close connection
$conn->close();
?>