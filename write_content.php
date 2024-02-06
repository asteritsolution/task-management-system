<?php
// Include database connection
include('db_connect.php');

// Check if the form is submitted
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
?>

<div class="container">
    <form method="post" action="#" method="post">
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
            <textarea type="text" class="form-control" id="staticContent" name="static_content" aria-describedby="emailHelp" placeholder="Enter static content"> </textarea>
        </div>

        <div class="form-group">
            <label for="reelContent">Reel Content</label>
            <textarea type="text" class="form-control" id="reelContent" name="reel_content" aria-describedby="emailHelp" placeholder="Enter reel content"></textarea>
        </div>

        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>
</div>
