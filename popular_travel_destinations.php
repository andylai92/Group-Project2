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
            <p class="lead">You can find the most popular travel destinations here.</p>
            <hr class="my-4">
            <form method="GET" action="popular_travel_destinations.php">
                <?php
                $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                if (mysqli_connect_errno())
                {
                    die(mysqli_connect_error());
                }

                $sql = "SELECT country.country_name AS Country, count(travelplan.country_id) AS 'popularity'
                FROM country
                JOIN travelplan ON country.country_id = travelplan.country_id
                GROUP BY country.country_name
                ORDER BY `popularity` DESC";
                $result = mysqli_query($connection, $sql);
                ?>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-success">
                            <th scope="col">Country</th>
                            <th scope="col">Number of Travel Plans</th>
                        </tr>
                    </thead>
                    <?php
                    while($row = mysqli_fetch_assoc($result))
                    {
                    ?>
                    <tr>
                        <td><?php echo $row['Country'] ?></td>
                        <td><?php echo $row['popularity'] ?></td>
                    </tr>
                    <?php
                    }
                    mysqli_free_result($result);
                    mysqli_close($connection);
                    ?>
                </table>
            </form>
        </div>

    </body>
</html>