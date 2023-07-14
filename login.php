<?php
    require_once('config.php');
    session_start();
?>
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
            <p class="lead">Login</p>
            <hr class="my-4">
            <form method="POST" action="process_login.php">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </body>
</html>