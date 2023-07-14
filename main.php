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
            <h1 class="display-4">Welcome to Covid Shield</h1>
            <p></p>
            <img src="https://i.ibb.co/KVpCys8/Covid-Shield-Logo-Tranparent.png" alt="Covid Shield Logo" title="Covid Shield Logo" width="32%" height="32%">
            <p></p>
            <p class="lead">Overview: Our objective is to create a comprehensive database of Covid-19 information to aid individuals for travel planning.<p>
            <hr class="my-3">
            <p>Project description: This project will provide individuals to make informed decisions about planning to travel during Covid-19, as well as the user profile, the information for each country, the infection rate, and the popular travel destinations.</p>
            <hr class="my-3">
            <p>Members’ contact information:</p>
            <p>Yihan Ma: yihan112@uw.edu | Jacky Fong: jackyhny@uw.edu | Andy Lai: yufulai@uw.edu | Kemeria Redwan: kemerm@uw.edu</p>
            <p class="lead">
            </p>
        </div>
    </body>
</html>