

<!DOCTYPE html>
<html lang="en">
  <head>
    <title> SBU ResLife</title>
    
  </head>
  <style>
		.home-button {
			position: fixed;
			top: 10px;
			right: 10px;
			padding: 10px;
			background-color: #333;
			color: #fff;
			text-decoration: none;
			font-weight: bold;
			border-radius: 5px;
		}
   
	</style>
  
    <a href="indexNumOne.php" class="home-button">Home</a>
    <div class="img">
      <img src="sbu.png" width="20%" alt="SBU" />
    </div>

    <div class="dropdown">
      <form action="signout.php" method="POST">
        <select name="dorm" id="dorm" onchange="this.form.submit()">
          <option value="">Dorm</option>
          <option value="6" <?php $dorm =0; if ($dorm == 6) echo "selected"; ?>>
            Meyer
          </option>
          <option value="7" <?php if ($dorm == 7) echo "selected"; ?>>
            Plaster
          </option>
          <option value="5" <?php if ($dorm == 5) echo "selected"; ?>>
            Landen
          </option>
          <option value="3" <?php if ($dorm == 3) echo "selected"; ?>>
            Leslie
          </option>
          <option value="2" <?php if ($dorm == 2) echo "selected"; ?>>
            Beasley
          </option>
          <option value="4" <?php if ($dorm == 4) echo "selected"; ?>>
            Woody/Gott
          </option>
        </select>
       <?php echo "<p>Please select a dorm from the dropdown above.</p>"; ?>
      </form>
    </div>

    <?php
  $dorm = isset($_POST['dorm']) ? (int)$_POST['dorm'] : 0;
  $start_date = isset($_POST['start_date']) ? $_POST['start_date'] : null;
  $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : null;
 
  $user = 'root';
  $pass = 'seniorprojectreslife457345';
  $db = 'seniorprojectcurfew';

  $conn = mysqli_connect('localhost', $user, $pass, $db) or die ("unable to connect");
  if (!$conn) {
      echo 'Connection Error: ' . mysqli_connect_error();
  }
  // retrieves names from database and displays the stuents on curfew next to a checkbox
  if ($dorm != 0) {
    $sql = "SELECT FNAME, LName FROM oncurfew WHERE Dorm = $dorm";
    $result = mysqli_query($conn, $sql);
    $people = mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo "<form action='signout.php' method='POST'>";
    echo "<label for='start_date'>Start Date or Single Date:</label>";
    echo "<input type='date' id='start_date' name='start_date' value='$start_date'><br>";
    echo "<label for='end_date'>End Date:</label>";
    echo "<input type='date' id='end_date' name='end_date' value='$end_date'><br>";
    foreach ($people as $person) {
      echo "<input type='checkbox' name='person[]' value='$person[FNAME] $person[LName]'> $person[FNAME] $person[LName]<br>";
    }
    echo "<input type='submit' value='Submit'>";
    
    echo "</form>";
  
  }
   // Check if at least one checkbox is checked and a start date is selected
   if (empty($_POST['person']) || empty($start_date)) {
    echo "<p>Please select at least one person and a start date.</p>";
    exit();
}


  // Process form data. Any user input that the user is not suppose to do will not be entered into the database. 
  if (isset($_POST['person']) && is_array($_POST['person'])) {
    $selected_people = $_POST['person'];
  } else {
    $selected_people = array();
  }

  //Date feature 
  if ($start_date && $end_date) {
    $date_range = array();
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);
    $interval = new DateInterval('P1D');
    $period = new DatePeriod($start, $interval, $end->modify('+1 day'));
    foreach ($period as $date) {
      $date_range[] = $date->format('Y-m-d');
    }
  } else if ($start_date && !$end_date) {
    $date_range = array();
    $date_range[] = $start_date;
  } else {
    $date_range = array();
  }

  
//takes user inputted results and updates the database
  foreach ($selected_people as $person) {
    

// Get the StudentID from the oncurfew table using the selected first and last name
$name_parts = explode(" ", $person);
$first_name = $name_parts[0];
$last_name = $name_parts[1];
$sql = "SELECT StudentID FROM oncurfew WHERE FName='$first_name' AND LName='$last_name'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$student_id = $row['StudentID'];

// Update the status column in the checkintracker table for each selected person and date
foreach ($date_range as $date) {
 
  $sql = "UPDATE checkintracker SET Status='Signed Out' WHERE StudentID='$student_id' AND DATE(Date)='$date'";

  mysqli_query($conn, $sql);
}

// Insert a new row into the soinprsn table for each selected person and date
foreach ($date_range as $date) {
  $datetime = "$date 21:00:00.000";
  $sql = "INSERT INTO soinprsn (StudentID, Date, InPerson, SignedOut) VALUES ('$student_id', '$datetime', '0' ,'1')";
  mysqli_query($conn, $sql);
}
}
?>
  </body>
</html>
