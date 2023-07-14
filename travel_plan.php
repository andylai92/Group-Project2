<?php require_once('config.php'); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Covid Shield Travel Planner</title>
        <!-- add a reference to the external stylesheet -->
        <link rel="stylesheet" href="https://bootswatch.com/4/united/bootstrap.min.css">
    </head>

    <body>
        <!-- START -- Add HTML code for the top menu section (navigation bar) -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="main.php">Covid Shield</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarColor01">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login User Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="travel_plan.php">Travel Plan</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="country_information.php">Country Information</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="infection_rate.php">Infection Rate</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="popular_travel_destinations.php">Popular Travel Destinations</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- END -- Add HTML code for the top menu section (navigation bar) -->
        <div class="jumbotron">
            <p class="lead">You can find your travel plan here.</p>
            <hr class="my-4">
            <form method="GET" action="travel_plan.php">
                <label for="userEmail">Email:</label>
                <input type="email" id="userEmail" name="userEmail" required>
                <button type="submit">Search</button>
            </form>
            <form method="POST" action="travel_plan.php">
                <?php if (isset($_GET['userEmail'])) { ?>
                <input type="hidden" name="userEmail" value="<?php echo $_GET['userEmail']; ?>">
                <?php } ?>

                <br>
                <label for="travelCountry">Travel Country:</label>
                <select id="travelCountry" name="travelCountry">
                    <?php
                       $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                       if(mysqli_connect_errno()){
                           die(mysqli_connect_error());
                       }

                       // Retrieve list of countries from database
                       $sql = "SELECT country_name FROM country ORDER BY country_name";
                       $result = mysqli_query($connection, $sql);

                       // Display each country as an option in the dropdown list
                       while($row = mysqli_fetch_assoc($result))
                       {
                           echo "<option value='" . $row['country_name'] . "'>" . $row['country_name'] . "</option>";
                       }

                       // Release the memory used by the result set
                       mysqli_free_result($result);
                       mysqli_close($connection);
                    ?>
                </select>
                <br>
                <label for="travelDate">Travel Date:</label>
                <input type="date" id="travelDate" name="travelDate">
                <button type="submit" name="add">Add</button>

                <span id="add-message"></span>
                <br>
                <span id="result"></span>
            </form>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET")
                {
                    if (isset($_GET['userEmail']) )
                    {
                        // Connect to the database
                        $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                        if (mysqli_connect_errno())
                        {
                            die(mysqli_connect_error());
                        }

                        // Retrieve user information
                        $sql = "SELECT u.user_id, u.first_name, u.last_name, c.country_name, u.user_doseNum
                        FROM user u
                        JOIN country c ON u.user_country = c.country_id
                        WHERE u.user_email = '{$_GET['userEmail']}'";
                        $result = mysqli_query($connection, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $user_id = $row['user_id'];
                        $first_name = $row['first_name'];
                        $last_name = $row['last_name'];
                        $user_country = $row['country_name'];
                        $user_doseNum = $row['user_doseNum'];

                        // Retrieve travel plan information
                        $sql = "SELECT u.user_country AS 'Depart Country', u.user_doseNum AS 'User Dose',
                                CONCAT(c.country_name, ' (', tp.TravelPlan_date, ')') AS 'Destination', r.restriction_type AS 'Restriction Type',
                                r.requirement_doseNum AS 'Restriction Dose Number', r.restriction_quarantine AS 'Quarantine',
                                CASE WHEN (r.requirement_doseNum IS NULL OR u.user_doseNum >= r.requirement_doseNum) THEN 'Yes' ELSE 'No' END AS 'Good to Go?'
                                FROM user u
                                JOIN travelplan tp ON u.user_id = tp.user_id
                                JOIN country c ON tp.country_id = c.country_id
                                LEFT JOIN restrictions r ON c.country_id = r.country_id AND r.entry_coutry_id = u.user_country
                                WHERE u.user_email = '{$_GET['userEmail']}'
                                GROUP BY c.country_name, tp.TravelPlan_date
                                ORDER BY tp.TravelPlan_date;";
                        $result = mysqli_query($connection, $sql);
                        // Display user and travel plan information in a table
                ?>
                <p>&nbsp;</p>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-success">
                            <th scope="col">Depart Country</th>
                            <th scope="col">User Dose</th>
                            <th scope="col">Destination</th>
                            <th scope="col">Restriction Type</th>
                            <th scope="col">Restriction Dose Number</th>
                            <th scope="col">Quarantine</th>
                            <th scope="col">Good to Go?</th>
                        </tr>
                    </thead>
                    <?php
                        while($row = mysqli_fetch_assoc($result))
                        {
                    ?>
                    <tr>
                        <td><?php echo $user_country ?></td>
                        <td><?php echo $user_doseNum ?></td>
                        <td><?php echo $row['Destination'] ?></td>
                        <td><?php echo $row['Restriction Type'] ?? 'No Restriction' ?></td>
                        <td><?php echo $row['Restriction Dose Number'] ?? '0' ?></td>
                        <td><?php echo $row['Quarantine'] ?? 'No Needed' ?></td>
                        <td><?php echo $row['Good to Go?'] ?></td>
                    </tr>

                    <?php
                        }
                    ?>
                </table>
                <?php
                        // Release the memory used by the result sets
                        mysqli_free_result($result);
                        mysqli_close($connection);
                    }
                }
                ?>

            <form method="POST" action="travel_plan.php">
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add'])) {
                    // Get input values
                    $userEmail = $_POST['userEmail'];
                    $travelCountry = $_POST['travelCountry'];
                    $travelDate = $_POST['travelDate'];

                    // Convert date format from DD/MM/YYYY to YYYY-MM-DD
                    $travelDate = str_replace('/', '-', $travelDate);
                    $travelDate = date('Y-m-d', strtotime($travelDate));

                    // Connect to database
                    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                    if (mysqli_connect_errno()) {
                        echo "<script>alert('Connect failed: " . mysqli_connect_error() . "');</script>";
                    }

                    // Get user ID from email
                    $sql = "SELECT user_id FROM user WHERE user_email = '$userEmail'";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $userID = $row['user_id'];

                    // Get country ID from country name
                    $sql = "SELECT country_id FROM country WHERE country_name = '$travelCountry'";
                    $result = mysqli_query($connection, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $countryID = $row['country_id'];

                    if (!empty($userID) && !empty($countryID)) {
                        // Get the last ID from the travelplan table
                        $sql = "SELECT MAX(TravelPlan_id) as max_id FROM travelplan";
                        $result = mysqli_query($connection, $sql);
                        $row = mysqli_fetch_assoc($result);
                        $newID = $row['max_id'] + 1;

                        // Add travel plan to database
                        $sql = "INSERT INTO travelplan (TravelPlan_id, user_id, country_id, TravelPlan_date) VALUES ('$newID', '$userID', '$countryID', '$travelDate')";

                        if(mysqli_query($connection, $sql)){
                            echo "Travel Plan Added Successfully";
                        } else {
                            echo "Travel Plan Failed to Add";
                        }
                    } else {
                        echo "Invalid user email or travel country";
                    }

                    // Close database connection
                    mysqli_close($connection);
                }
                ?>
            </form>
        </div>
    </body>
</html>