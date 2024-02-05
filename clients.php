<?php
// Include the database connection
include('db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = isset($_POST['name']) ? mysqli_real_escape_string($conn, $_POST['name']) : '';
    $assignto = isset($_POST['assignto']) ? mysqli_real_escape_string($conn, $_POST['assignto']) : '';

    // Perform validation if needed

    // Insert data into the 'client' table using a prepared statement
    $insertQuery = "INSERT INTO client (name, assignto) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $insertQuery);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ss', $name, $assignto);
        $insertResult = mysqli_stmt_execute($stmt);

        if ($insertResult) {
            echo 'Data inserted successfully.';
        } else {
            echo 'Error: ' . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo 'Error: ' . mysqli_error($conn);
    }

    // Delete data if delete button is clicked
    if (isset($_POST['delete_id'])) {
        $deleteId = mysqli_real_escape_string($conn, $_POST['delete_id']);
        $deleteQuery = "DELETE FROM client WHERE id = ?";
        $deleteStmt = mysqli_prepare($conn, $deleteQuery);

        if ($deleteStmt) {
            mysqli_stmt_bind_param($deleteStmt, 'i', $deleteId);
            $deleteResult = mysqli_stmt_execute($deleteStmt);

            if ($deleteResult) {
                echo 'Record deleted successfully.';
            } else {
                echo 'Error deleting record: ' . mysqli_stmt_error($deleteStmt);
            }

            mysqli_stmt_close($deleteStmt);
        } else {
            echo 'Error preparing delete statement: ' . mysqli_error($conn);
        }
    }
}

// Fetch client data from the database
$query = "SELECT * FROM client";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Display the task management system with client information
    echo '<table class="table">
    <thead>
        <tr>
            <th scope="col">SR No.</th>
            <th scope="col">Name</th>
            <th scope="col">Assign To</th>
            <th scope="col">Edit</th>
            <th scope="col">Delete</th>
        </tr>
    </thead>';
    echo '<tbody>'; // Move tbody outside the loop
    $serialNumber = 1;
    // Loop through each row in the result set
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>
                <td>' . $serialNumber . '</td>
                <td>' . htmlspecialchars($row['name']) . '</td>
                <td>' . htmlspecialchars($row['assignto']) . '</td>
                <td><a href="edit.php?id=' . $row['id'] . '">Edit</a></td>
                <td>
                    <form method="post" action="clients.php" onsubmit="return confirm(\'Are you sure you want to delete this record?\');">
                        <input type="hidden" name="delete_id" value="' . $row['id'] . '">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
              </tr>';
        $serialNumber++;
    }
    echo '</tbody>'; // Close tbody outside the loop
    echo '</table>';
} else {
    // Display an error message if the query fails
    echo 'Error: ' . mysqli_error($conn);
}

// Close the database connection
// mysqli_close($conn);
?>







<?php if ($_SESSION['login_type'] == 1) : ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <style>
        .addclinth {
            margin-top: 120px;
            text-align: center;
            color: #007bff;
            font-size: 30px;
            text-transform: uppercase;
        }
        .clientformstyle {
            border: 2px solid #007bff;
            padding: 15px 25px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        #clintnm {
            width: 60vh;
            border: 1px solid #007bff;
            border-radius: 5px;
        }
        .btn {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <h2 class="addclinth">Add Client</h2>
    <form class="clientformstyle" method="post" action="">
        <label for="name">Client Name:</label>
        <input id="clintnm" type="text" name="name" placeholder="Enter Client Name" required>

        <?php
        // Fetch users from the database
        $sql = "SELECT firstname, lastname FROM users";
        $result = mysqli_query($conn, $sql);

        // Populate the select element
        echo '<label for="assignto">Assign To:</label>';
        echo '<select name="assignto" id="assignto">';
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<option value="' . $row['firstname'] . ' ' . $row['lastname'] . '">' . $row['firstname'] . ' ' . $row['lastname'] . '</option>';
            }
        }
        echo '</select>';
        mysqli_close($conn);
        
        ?>

        <input type="submit" class="btn" value="Add Client">
    </form>
</body>
</html>
<?php endif; ?>