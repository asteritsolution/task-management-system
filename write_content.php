<?php
// Include database connection
include('db_connect.php');

// Check if the form is submitted for adding new record
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Extract data from POST request
    $clientName = $_POST['client_name'];
    $festival = $_POST['festival'];
    $staticContent = $_POST['static_content'];
    $reelContent = $_POST['reel_content'];

    // Prepare SQL statement to insert data into client_base table
    $sql = "INSERT INTO client_base (client_name, festival, static_content, reel_content) VALUES ('$clientName', '$festival', '$staticContent', '$reelContent')";

    // Execute SQL statement
    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

?>

<div class="container">
    <h2>Add New Record</h2>
    <form method="post" action="#">
        <div style="cursor: pointer;" class="form-group">
            <label for="clientName">Select Client name</label>
            <select class="form-control" id="clientName" name="client_name">
                <?php
                // Query to fetch client names from the database
                $sql = "SELECT name FROM client";
                $result = $conn->query($sql);
                // If there are results, display them in the dropdown
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option>" . $row["name"] . "</option>";
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
                $sql = "SELECT important_days FROM calendar";
                $result = $conn->query($sql);

                // If there are results, display them in the dropdown
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option>" . $row["important_days"] . "</option>";
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="staticContent">Static Content</label>
            <textarea type="text" class="form-control" id="staticContent" name="static_content" aria-describedby="emailHelp" placeholder="Enter static content"></textarea>
        </div>
        <div class="form-group">
            <label for="reelContent">Reel Content</label>
            <textarea type="text" class="form-control" id="reelContent" name="reel_content" aria-describedby="emailHelp" placeholder="Enter reel content"></textarea>
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>

<div class="container">
    <h2>Existing Records</h2>
    <?php
    // Get today's date in the format matching your database
    $currentDate = date("Y-m-d");

    // Execute a SELECT query for the specified columns, filtered by today's date
    $query = "SELECT id, date, client_name, reel_content, static_content FROM client_base WHERE DATE(date) = '$currentDate'";
    $result = $conn->query($query);

    // Check if there are results
    if ($result->num_rows > 0) {
        echo "<table class='table table-dark'>";
        echo "<thead>";
        echo "<tr>
              <th>Date</th>
              <th>Client Name</th>
              <th>Reel Content</th>
              <th>Static Content</th>
              <th>Edit</th> <!-- New column for Edit button -->
          </tr>";
        echo "</thead>";
        echo "<tbody>";
        // Output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                      <td style='width:60px;'>" . date("d/m/y", strtotime($row["date"])) . "</td>
                      <td style='width:130px;'>{$row["client_name"]}</td>
                      <td>{$row["reel_content"]}</td>
                      <td>{$row["static_content"]}</td>
                      <td>
                        <a href='edit.php?id={$row["id"]}' class='btn btn-primary'>Edit</a>
                      </td> <!-- Edit button with link to edit.php -->
                  </tr>";
        }
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p>No content available for today</p>";
    }

    // Close connection
    $conn->close();
    ?>
</div>