
    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th>Date</th>
                <th>Client Name</th>
                <th>Reel Content</th>
                <th>Static Content</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Include the database connection
            include('db_connect.php');
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Execute a SELECT query for the specified columns, ordered by date in descending order
            $query = "SELECT date, client_name, reel_content, static_content FROM client_base ORDER BY date DESC";
            $result = $conn->query($query);

            // Check if there are results
            if ($result->num_rows > 0) {
                // Output data of each row
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td style='width:60px;'>" . date("d/m/y", strtotime($row["date"])) . "</td>
                            <td style='width:130px;'>{$row["client_name"]}</td>
                            <td>{$row["reel_content"]}</td>
                            <td>{$row["static_content"]}</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4'>0 results</td></tr>";
            }

            // Close connection
            $conn->close();
            ?>
        </tbody>
    </table>