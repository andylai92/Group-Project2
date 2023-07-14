<?php require_once('config.php'); ?>
<!-- TCSS 445 : Autumn 2020 -->
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
        <div style="width:60%;hieght:20%;text-align:center">
            <div><?php echo $name; ?> </div>
            <canvas  id="chartjs_line"></canvas>
        </div>
        <div class="jumbotron">
            <p class="lead">You can check a country to see the different types of viruses and the details<p>
            <hr class="my-4">
            <form method="GET" action="infection_rate.php">
                <select name="country" onchange='this.form.submit()'>
                    <option selected>Select a country</option>
                    <?php
                    $connection = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
                    if ( mysqli_connect_errno() )
                    {
                        die( mysqli_connect_error() );
                    }
                    $sql = "select country_name, country_id from country";
                    if ($result = mysqli_query($connection, $sql))
                    {
                        // loop through the data
                        while($row = mysqli_fetch_assoc($result))
                        {
                            echo '<option value="' . $row['country_id'] . '">';
                            echo $row['country_name'];
                            echo "</option>";
                        }
                        // release the memory used by the result set
                        mysqli_free_result($result);
                    }
                    ?>
                </select>
                <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET")
                {
                    if (isset($_GET['country']) )
                    {
                ?>
                <p>&nbsp;</p>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-success">
                            <th scope="col">Virus Type</th>
                            <th scope="col">Virus Death Rate</th>
                            <th scope="col">Virus Detail</th>
                        </tr>
                    </thead>
                    <?php
                        if ( mysqli_connect_errno() )
                        {
                            die( mysqli_connect_error() );
                        }
                        $sql = "SELECT *
                                FROM infection
                                JOIN viruses ON infection.virus_id = viruses.virus_id
                                WHERE infection.country_id = {$_GET['country']}
                                ORDER BY viruses.death_rate DESC";

                        if ($result = mysqli_query($connection, $sql))
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                    ?>
                    <tr>
                        <td><?php echo $row['virus_name'] ?></td>
                        <td><?php echo $row['death_rate'] ?></td>
                        <td><?php echo $row['virus_detail'] ?></td>
                    </tr>
                    <?php
                            }
                            // release the memory used by the result set
                            mysqli_free_result($result);
                        }
                    } // end if (isset)
                } // end if ($_SERVER)
                    ?>
                </table>
            </form>
        </div>
        <?php
        $con  = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
        if ( mysqli_connect_errno() )
        {
            die( mysqli_connect_error() );
        }
        $sql ="SELECT *
               FROM infection
               JOIN viruses ON infection.virus_id = viruses.virus_id
               WHERE infection.country_id = {$_GET['country']}
               ORDER BY infection.infection_percentage DESC";

        $result = mysqli_query($con,$sql);
        $chart_data="";

        while ($row = mysqli_fetch_array($result)) {

            $infection_percentage[]= $row['infection_percentage'];
            $virus_name[]=$row['virus_name'];
            $tooltips[$row['virus_name']][]=$row['death_rate'].' '.$row['virus_detail'];
        }
        ?>
        <script src="//code.jquery.com/jquery-1.9.1.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
        <script type="text/javascript">
            var ctx = document.getElementById("chartjs_line").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'horizontalBar',
                data: {
                    labels:<?php echo json_encode($virus_name); ?>,
                    datasets: [{
                        data:<?php echo json_encode($infection_percentage); ?>,
                        fill:false,
                    },
                ]},
                options: {
                    scales: {
                        xAxes: [{
                            ticks:{
                                max:100
                            }
                        }]
                    },
                    legend: {
                        display: false,
                    },
                }
            });
        </script>
    </body>
</html>