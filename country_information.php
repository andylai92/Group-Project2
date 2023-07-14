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
        <div class="jumbotron">
            <p class="lead">You can find case number and vaccination data here<p>
            <hr class="my-4">
            <form method="GET" action="country_information.php">
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
                            <th scope="col">Country Name</th>
                            <th scope="col">Population</th>
                            <th scope="col">Total Case Number</th>
                            <th scope="col">Total Death Number</th>
                            <th scope="col">Number of At Least 1 Dose</th>
                            <th scope="col">Rate of At Least 1 Dose</th>
                            <th scope="col">Number of Fully Vaccinated</th>
                            <th scope="col">Rate of Fully Vaccinated</th>
                        </tr>
                    </thead>
                    <?php
                        if ( mysqli_connect_errno() )
                        {
                            die( mysqli_connect_error() );
                        }
                        $sql = "SELECT *, vaccine_total / country_population * 100 AS vaccine_rate, vaccine_booster / country_population * 100 AS booster_rate
                                FROM country
                                WHERE country_id = {$_GET['country']}";

                        if ($result = mysqli_query($connection, $sql))
                        {
                            while($row = mysqli_fetch_assoc($result))
                            {
                    ?>
                    <tr>
                        <td><?php echo $row['country_name'] ?></td>
                        <td><?php echo $row['country_population'] ?></td>
                        <td><?php echo $row['caseNum_total'] ?></td>
                        <td><?php echo $row['death_total'] ?></td>
                        <td><?php echo $row['vaccine_total'] ?></td>
                        <td><?php echo $row['vaccine_rate'] ?></td>
                        <td><?php echo $row['vaccine_booster'] ?></td>
                        <td><?php echo $row['booster_rate'] ?></td>
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
        <div style="width:50%;hieght:20%;text-align:center">
            <div><?php echo $name; ?> </div>
            <canvas  id="chartjs_line"></canvas>
        </div>
    </body>

    <?php
    $con  = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    if ( mysqli_connect_errno() )
    {
        die( mysqli_connect_error() );
    }
    $sql ="SELECT *
           FROM CaseNum
           JOIN country ON CaseNum.country_id = country.country_id
           WHERE CaseNum.country_id = {$_GET['country']}
           ORDER BY CaseNum.date DESC";

    $result = mysqli_query($con,$sql);
    $chart_data="";

    while ($row = mysqli_fetch_array($result)) {

        $name=$row['country_name'];
        $month[] = date_format(date_create( $row['date']),"M, Y")  ;
        $case[] = $row['case_num'];
        $death[] = $row['death_num'];
    }
    ?>
    <script src="//code.jquery.com/jquery-1.9.1.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
    <script type="text/javascript">
    var ctx = document.getElementById("chartjs_line").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels:<?php echo json_encode($month); ?>,
            datasets: [{
                data:<?php echo json_encode($case); ?>,
                fill:false,
                borderColor:'blue',
                label: 'cases'
            },{
                data:<?php echo json_encode($death); ?>,
                fill:false,
                borderColor:'red',
                label: 'deaths'
            },
        ]},
        options: {
            scales: {
                 yAxes: [{
                    ticks:{
                            max:1000
                            }

                 }]
            },
            legend: {
                display: true,
                position: 'bottom',
                labels: {
                    fontColor: '#71748d',
                    fontFamily: 'Circular Std Book',
                    fontSize: 14,
                }
            },
        }
    });
    </script>
</html>