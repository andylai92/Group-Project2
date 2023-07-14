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

    <body scroll="no" style="overflow: hidden">
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
            <p class="lead">User Information</p>
            <hr class="my-4">
            <form method="GET" action="user_profile.php">
                <select style="display:none" name="userp" onchange='this.form.submit()'>
                    <option selected>Select a name</option>

                    <?php
                    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                    if ( mysqli_connect_errno() )
                    {
                        die( mysqli_connect_error() );
                    }
                    $sql = "SELECT user_id, first_name, last_name, user_email, user_country, user_doseNum FROM user
                            INNER JOIN country ON user.user_country = country.country_id
                            ORDER BY first_name ASC";
                    if ($result = mysqli_query($connection, $sql))
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo '<option value="' . $row['user_id'] . '">';
                            echo $row['first_name']. ' ' . $row['last_name'];
                            echo "</option>";
                        }
                        mysqli_free_result($result);
                    }
                    ?>
                </select>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET")
                {
                    if (isset($_GET['userp']) )
                    {
                ?>
                <p>&nbsp;</p>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-success">
                            <th scope="col">First Name</th>
                            <th scope="col">Last Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Country Origin</th>
                            <th scope="col">Number of Dose(s)</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <?php
                        if ( mysqli_connect_errno() )
                        {
                            die( mysqli_connect_error() );
                        }
                        $sql = "SELECT user.user_id, user.first_name AS 'First Name', user.last_name AS 'Last Name', user.user_email AS 'Email',
                                country.country_name AS 'Country Origin', user.user_doseNum AS 'Number of Dose(s)', country2.country_name AS 'Travel Plan',
                                travelplan.TravelPlan_date AS 'Travel Date'
                                FROM user
                                INNER JOIN country ON user.user_country = country.country_id
                                LEFT JOIN travelplan ON user.user_id = travelplan.user_id
                                LEFT JOIN country AS country2 ON travelplan.country_id = country2.country_id
                                WHERE user.user_id = '{$_GET['userp']}'";


                        if ($result = mysqli_query($connection, $sql))
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                    ?>
                    <tr>
                        <td><?php echo $row['First Name'] ?></td>
                        <td><?php echo $row['Last Name'] ?></td>
                        <td><?php echo $row['Email'] ?></td>
                        <td><?php echo $row['Country Origin'] ?></td>
                        <td><?php echo $row['Number of Dose(s)'] ?></td>
                        <td>
                            <a href="edit_user.php?userp=<?php echo $row['user_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        </td>
                    </tr>
                    <?php
                            }
                            mysqli_free_result($result);
                        }
                    } // end if (isset)
                } // end if ($_SERVER)
                    ?>
                </table>
            </form>
        </div>
    </body>
</html>