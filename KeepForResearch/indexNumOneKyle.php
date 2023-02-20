<!--A.J. Kammerer, Kyle Collinson, CJ Glaze-->
<!--Last edited by: A.J. Kammerer, Kyle Collinson -->
<!--Last Edited Date: 12/4/2022 -->
<!--Connect and query with the SBU database and MySQL database -->
<!DOCTYPE html>

<html lang="en">
  <head>
    <title> SBU ResLife </title>
    </head>
    <body>
    <div class = img> <!--Picture of LEGENDARY SBU NFT-->
         <img src="sbu.png" width = "20%" alt ="SBU"/>
    </div>
   
    <!--The dropdown class contains the dorm and date selection and their vars-->
    <div class = dropdown> 
        <label for="dorm">Select Dorm, Date Range, and View:</label>
        <form action = "indexNumOne.php" method = "POST">
        <select name="dorm" id="dorm">
            <option value >Dorm</option>
            <option value=6 >Meyer</option>
            <option value=7 >Plaster</option>
            <option value=5 >Landen</option>
            <option value=3 >Leslie</option>
            <option value=2 >Beasley</option>
            <option value=4 >Woody/Gott</option>
        </select>
   
   
       

         
 

        <label for="start"></label><!--The Calendar Start Date -->
        <input type="date" id="start" name="tripstart"
            value="yyyy-mm-dd"
            min="2022-01-01" max="2100-12-31"/>

        <label for="start"></label><!--The Calendar End Date-->
        <input type="date" id="start" name="tripend"
            value="yyyy-mm-dd"
            min="2022-01-01" max="2100-12-31"/>
       
        <input type="submit">
        </form>
</div>
   <!------------------------------------------------------------------------------------------------------------------->



<?php 
//Connecting to SBU Database but once
// $serverName = "windsx.sbuniv.edu";
// $connectionOptions = array("Database"=>"AcsLog",
//     "Uid"=>"DSXCLW", "PWD"=>"SeniorProject", "ReturnDatesAsStrings"=>true);
// $conn = sqlsrv_connect($serverName, $connectionOptions);
// if($conn == false){
//     die(FormatErrors(sqlsrv_errors()));
// }else{
//    echo"Connection Working";
// }

//-------------------------------------------------------------------------------

//Query to the SBU Database
// $tsql = "SELECT [TimeDate],[LName],[FName]";
// $tsql .= "FROM [AcsLog].[dbo].[EvnLog]";
// $tsql .= "WHERE Loc = '13' and Code != '0' and Opr > '0' and TimeDate BETWEEN '2022-11-16 09:30:00.000' AND '2022-11-16 11:30:00.000' AND LName = 'Collinson'";

// //The result of the Query is stored here
//$result = sqlsrv_query ($conn , $tsql) or die(sqlsrv_errors());

// //Converts the data sent into a string array 
// while($column = sqlsrv_fetch_array($result)) {
//   $names[] = $column['LName'];
//   $names2[] = $column['FName'];
//   $timedate[] = $column['TimeDate'];
 

//  }

// //Loop var for the size of the var
//$sizeOfNames = count($names);


// //Loop to print out The query results.
// for ( $i = 0; $i < $sizeOfNames; $i++){
//    echo implode(" ",$names);
//    echo implode(" ",$names2);
//    echo implode(" ",$timedate);
   
// }

// //free up the ram for the next set of data and close the connection
// sqlsrv_free_stmt($result);
// sqlsrv_close($conn);




//----------------------------------------------------------------------------------------------------------
//Connecting to MySQL database
//Changing the value of the dorm to an int from a String to allow it to be used as a search parameter
//Also pulling the values that were chosen from the webpage to be used in our query
$dorm = 0;  
$tripstart = 0; 
$tripend = 0;

// Checks if value is set, so errors are not thrown when page loads
if(isset($_POST['tripstart'])){
    $tripstart = $_POST['tripstart'];
}
if(isset($_POST['dorm'])){
    $dorm = $_POST['dorm'];
}
if(isset($_POST['tripend'])){
    $tripend = $_POST['tripend'];
}
//force the dorm string into an int and assign null at the start of the webpage
$dorm = (int) $dorm;
if($dorm == 0){
    $dorm = NULL;
}


//testing the values we recieved/ ^setting to Null for when it is select dorm
//echo($dorm);
//echo($tripstart);
//echo($tripend);
// if($tripend == NULL){
//     echo(1);
// }

//Credentials for MySQL Login
$user = 'root';
$pass = 'seniorprojectreslife457345'; 
$db = 'seniorprojectcurfew';

//connect to database and check for errors
$conn = mysqli_connect('localhost', $user, $pass, $db) or die ("unable to connect");
    if(!$conn){
        echo 'Connection Error: ' .mysqli_connect_error();
    }
// Queries our database from user input via the starter page.
if($tripend == NULL){
// SBU Query for a single date
    $sql = "SELECT oncurfew.FName, oncurfew.LName, checkintracker.Dorm, checkintracker.Date, checkintracker.Status FROM checkintracker INNER JOIN oncurfew WHERE checkintracker.StudentID = oncurfew.StudentID AND checkintracker.Dorm = '$dorm' AND LEFT(checkintracker.Date, 10) = '$tripstart'";
}else{
    // SBU query for date range
    $sql = "SELECT oncurfew.FName, oncurfew.LName, checkintracker.Dorm, checkintracker.Date, checkintracker.Status 
    FROM checkintracker 
    INNER JOIN oncurfew 
    ON checkintracker.StudentID = oncurfew.StudentID 
    WHERE checkintracker.Dorm = '$dorm' 
    AND LEFT(checkintracker.Date, 10) BETWEEN '$tripstart' AND '$tripend'";
}

//Stores our query data and converts it to nice readable string
$result = mysqli_query($conn, $sql);
$studentData = mysqli_fetch_all($result, MYSQLI_ASSOC); //Fetches results and stores in variable 



//set up and send another query to allow for the checking and changing of missed and checked in status
$sql1 = "SELECT IDNum, RIGHT(Date,12), Status FROM checkintracker";
$result1 = mysqli_query($conn, $sql1);
$verify = mysqli_fetch_all($result1, MYSQLI_ASSOC);

//for loop to go through all of the datbase vars that need to be assigned either Checked in or missed the curfew time
foreach ($verify as $verify){
    
    //echo $verify['RIGHT(Date,12)'];
    $num = $verify['IDNum']; //Takes IDNum from checkerintracker table
    $currenttime= $verify['RIGHT(Date,12)'];
    $beforetime = '20:00:00.000'; // 8:00PM
    $aftertime = '24:00:00.000';// 12:00PM
    
    //Formats time into variable
    $date1 = DateTime::createFromFormat('H:i:s.000', $currenttime);
    $date2 = DateTime::createFromFormat('H:i:s.000', $beforetime);
    $date3 = DateTime::createFromFormat('H:i:s.000', $aftertime);
    
    //WHEN WE ARE DONE WITH TESTING OUR DATABASE AND START WRITING SCRIPT, THE QUERY WILL BE CHANGED FROM UPDATE TO INSERT TO WORK WITH THE SBU DATABASE
    if ($date1 > $date2 && $date1 < $date3){ // Checks if time is good
            $sql2 = "UPDATE checkintracker SET Status = 'Checked In' WHERE $num = IDNum";
            
   }else{ // If time is bad
      
      $sql2 = "UPDATE checkintracker SET Status = 'Missed' WHERE $num = IDNum"; 
        
    }
      $result2 = mysqli_query($conn, $sql2);
    //   if($resSult2 === TRUE){ This is used for testing
    //     echo "New Record";
    //   }else{
    //     echo "Error: ";S
    // }
}


//assigns dorms string based on how they are stored in SBU Database
if($dorm == 2){
    $dorm = "Beasley";      
}
elseif($dorm == 3){
    $dorm = "Leslie";
}
elseif($dorm == 4){
    $dorm = "Woody Gott";
}
elseif($dorm == 5){
    $dorm = "Landen";
}
elseif($dorm == 6){
    $dorm = "Meyer";
}
elseif($dorm == 7){
    $dorm = "Plaster";
}
elseif($dorm == 10){
    $dorm = "Memorial";
}
//free up memory for next query
mysqli_free_result($result);

//Quit connection for each instance
mysqli_close($conn);

//Test connection
//echo" What is up";


//---------------------------------------------------------------------------------------------------------------------------------------------

//end of start php block
?>

<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <title>All the goodies for our viewing pleasure</title>
    <!-- CSS FOR STYLING THE WebPage -->
    <style>
        
        /* body{
            background-color: rgb(115, 42, 146);
        } */
        
        .dropdown{
            text-align: center;
        }

        img{
            text-align: center; 
        }
        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid black;
        }
 
        h1 {
            text-align: center;
            color:  rgb(111, 84, 172);
            font-size: xx-large;
            font-family: 'Gill Sans', 'Gill Sans MT',
            ' Calibri', 'Trebuchet MS', 'sans-serif';
        }
 
        td {
            background-color:hsl(248, 100%, 80%); /*I really like how this color turned out - A.J.*/
            border: 1px solid black;
        }
 
        th,
        td {
            font-weight: bold;
            border: 1px solid black;
            padding: 10px;
            text-align: center;
        }
 
        td {
            color: black;
            font-weight: lighter;
        }
    </style>
</head>
 
<body>
    <section>
        <h1>Detailed View</h1>
        <!-- TABLE CONSTRUCTION -->
        <table>
            <tr> <!--Table Header-->
                <th>FirstName</th>
                <th>LastName</th>
                <th>Dorm</th>
                <th>Date and Time</th>
                <th>Status</th>
            </tr>
            <!-- PHP CODE TO FETCH DATA FROM OUR CURFEW DATABASE -->
            <?php
                // LOOP TILL END OF DATA
                foreach($studentData as $studentData)
                {
            ?>
            <tr>
                <!-- FETCHING DATA FROM EACH
                    ROW OF EVERY COLUMN -->
                <td><?php echo $studentData['FName'];?></td>
                <td><?php echo $studentData['LName'];?></td>
                <td><?php echo $dorm;?></td>
                <td><?php echo $studentData['Date'];?></td>
                <td><?php echo $studentData['Status'];?></td>
            </tr>
            <?php
                }
            ?>
        </table>
    </section>
</body>
 
