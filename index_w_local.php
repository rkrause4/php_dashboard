<!-- Specialty 45 1 1 1 Sporting Goods-->

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Dashboard | Home</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
	    crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
	    crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
	    crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
	    crossorigin="anonymous"></script>
	<link rel="stylesheet" href="style.css">
</head>



<body>
	<header>
		<h1>Sporting Goods Stores</h2>
	</header>
	<div class="container">
		<!-- Restart on html/php. Write html in php -->
		<form action="index.php" id="years-nav" method="get">

			<!-- Should be able to get away with the form ending before the script since we are placing only the years in the form -->


			<!--- PHP Starts -->
			<?php
function connect_Database()
{
    static $dbcon;
    // Connection to database

    $DATABASE_HOST = "localhost";
    $DATABASE_USERNAME = "username";
    $DATABASE_PASSWORD = "password";
    $DATABASE_NAME = "db_name";
    $dbcon = mysqli_connect($DATABASE_HOST, $DATABASE_USERNAME, $DATABASE_PASSWORD, $DATABASE_NAME);
    return $dbcon;

    if (!$dbcon) {
        die("Connection failed: " . mysqli_connect_error());
    } else {
    }
}

$dbcon = connect_Database();

//Get button and keys
function get_Btn_Keys()
{
    $mybtn = array_values($_GET);
    $mykey = array_keys($_GET);

    return $mybtn;
    return $mykey;
}

//creates $mybtn and $mykey
get_Btn_Keys();

//echos years as buttons
display_years();

// creates all years from db
function display_years()
{
    $dbcon = connect_Database();

    //sql statement to select all transaction years
    $sql_all_years = "SELECT CT_Year FROM Company_Transactions WHERE CT_Sector = 45 AND CT_Industry = 1 AND CT_Specoality = 1 AND CT_Subspeciality = 1";

    $results = mysqli_query($dbcon, $sql_all_years);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_row($results)) {
            $str = "<input type='submit' class='year-btn btn' value='" . $row[0] . "' name='year' id='year-" . $row[0] . "' title='" . $row[0] . "'>";
            echo $str;
        }
        return $str;
    } else {
        echo "No Results.";
    }

}

?>
			<!--- Ends the form for buttons for all years  -->
		</form>

		<!--- PHP Starts -->
		<?php
// echos the year selected
display_date();

function display_date()
{
    $dbcon = connect_Database();
    $mybtn = get_Btn_Keys();

    if (empty($mybtn)) {
        $date = 2015;
    } else {
        $date = $mybtn[0];
    }

    $sql_latest_date = "SELECT CT_Year FROM Company_Transactions WHERE CT_Year = $date AND CT_Sector = 45 AND CT_Industry = 1 AND CT_Specoality = 1 AND CT_Subspeciality = 1";
    $result = mysqli_query($dbcon, $sql_latest_date);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            $str1 = "$row[0]";
            echo "<div class='year'><h2>Displaying Data for the year " . $date . "</h2></div>";
        }

    } else {
        echo "No Results";
    }

}

// Displays Profits, purchases and sales
?>

			<!-- Creates the row for BS columns -->
			<div class='row'>

				<?php

display_Profits();
display_Sales();
display_purchases();

function display_Profits()
{
    $dbcon = connect_Database();

    $mybtn = get_Btn_Keys();
    if (empty($mybtn)) {
        $date = 2015;
    } else {
        $date = $mybtn[0];
    }

    $sql_bus_sales = "SELECT CT_Sales FROM Company_Transactions WHERE CT_Year = $date AND CT_Sector = 45 AND CT_Industry = 1 AND CT_Specoality = 1 AND CT_Subspeciality = 1";

    $sql_bus_purch = "SELECT CT_Purchases FROM Company_Transactions WHERE CT_Year = $date AND CT_Sector = 45 AND CT_Industry = 1 AND CT_Specoality = 1 AND CT_Subspeciality = 1";

    $result1 = mysqli_query($dbcon, $sql_bus_sales);
    if (mysqli_num_rows($result1) > 0) {
        while ($row = mysqli_fetch_row($result1)) {
            $sales = "$row[0]";
        }
    } else {
        echo "No Results";
    }

    $result2 = mysqli_query($dbcon, $sql_bus_purch);
    if (mysqli_num_rows($result2) > 0) {
        while ($row = mysqli_fetch_row($result2)) {
            $purchases = "$row[0]";
        }
    } else {
        echo "No Results";
    }

    $profits = ($sales - $purchases);

    echo "<div class='profits'>";
    echo "<div class='col-lg-6'><h2>Profits</h2>";
    if ($profits < 0) {
        echo "<h3 class='negative'>$" . $profits . "</h3>";
    } else {
        echo "<h3 class='positive'>$" . $profits . "</h3>";
    }

    echo "</div> </div>";
}

function display_Sales()
{
    $dbcon = connect_Database();

    $mybtn = get_Btn_Keys();
    if (empty($mybtn)) {
        $date = 2015;
    } else {
        $date = $mybtn[0];
    }

    $sql_bus_profits = "SELECT CT_Sales FROM Company_Transactions WHERE CT_Year = $date AND CT_Sector = 45 AND CT_Industry = 1 AND CT_Specoality = 1 AND CT_Subspeciality = 1";

    $result = mysqli_query($dbcon, $sql_bus_profits);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            $str1 = "$row[0]";
            echo "<div class='sales'>";
            echo "<div class='col-lg-6'><h2>Sales</h2>";
            echo "<h3>" . "$" . $str1 . "</h3></div>";
            echo "</div>";
            //use $str1 and set a $row[0] to a SELECT Query to get business profits
        }

    } else {
        echo "No Results";
    }
}

function display_purchases()
{
    $dbcon = connect_Database();

    $mybtn = get_Btn_Keys();
    if (empty($mybtn)) {
        $date = 2015;
    } else {
        $date = $mybtn[0];
    }

    $sql_bus_profits = "SELECT CT_Purchases FROM Company_Transactions WHERE CT_Year = $date AND CT_Sector = 45 AND CT_Industry = 1 AND CT_Specoality = 1 AND CT_Subspeciality = 1";
    $result = mysqli_query($dbcon, $sql_bus_profits);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_row($result)) {
            $str1 = "$row[0]";
            echo "<div class='purchases'>";
            echo "<div class='col-lg-6'><h2>Purchases</h2>";
            echo "<h3>" . "$" . $str1 . "</h3></div>";
            echo "</div>";
            //use $str1 and set a $row[0] to a SELECT Query to get business profits
        }

    } else {
        echo "No Results";
    }
}

?>
			</div>

			<?php
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;

}

$stateErr = "";
$state = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //validation

    if (empty($_POST["state"])) {
        $stateErr = "State Abbrievation is required";
    } else {
        $state = test_input($_POST["state"]);
    }
}
?>

			<div class="row input">
				<!-- Have the user search for which businesses are in what states. Type in illinois, or il -->
				<div class="col-lg-12 input_form">
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
						<p>Enter the State Abbreviation you would like to see the businesses for.</p>
						<label for="state">State Abbreviation</label>

						<input type="text" id="state" name="state" placeholder="State Abbreviation">
						<span class="required">*
							<?php echo $stateErr; ?>
						</span>
						<br>
						<input type="submit" id="submit" value="Submit" class="btn">
					</form>
				</div>

				<?php

echo "<div class='col-lg-12 container'>";
display_input($state);

function display_input($state)
{
    $dbcon = connect_Database();
    $sql_user_query = "SELECT CN_BUS_ID, MC_BUS_Name, MC_BUS_City, MC_BUS_State
				  FROM Master_Companies, Company_NAICS
				  WHERE CN_NAICS_Sector = 45
				  AND CN_NAICS_Industry = 1
				  AND CN_NAICS_Speciality = 1
				  AND CN_NAICS_Subspeciality = 1
				  AND CN_BUS_ID = MC_ID
				  AND MC_BUS_State =  '$state';";

//        echo $sql_user_query;

    $result2 = mysqli_query($dbcon, $sql_user_query);
    if (mysqli_num_rows($result2) > 0) {
        echo "<table class='table table-striped table-bordered'><thead>";
        echo "<th scope='col'>ID</th>";
        echo "<th scope='col'>Business Name</th>";
        echo "<th scope='col'>City</th>";
        echo "<th scope='col'>State</th>";
        echo "</tr></thead>";
        echo "<tbody>";
        while ($row2 = mysqli_fetch_row($result2)) {
            $count = 0;
            $count++;
            // return $row2;
            echo "<tr>";
            echo "<td>" . $row2[0] . "</td>";
            echo "<td>" . $row2[1] . "</td>";
            echo "<td>" . $row2[2] . "</td>";
            echo "<td>" . $row2[3] . "</td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";
    } else {
        echo "Sorry, there were no businesses in that State.";
    }

}

echo "</div>";

?>


			</div>
	</div>
</body>

</html>