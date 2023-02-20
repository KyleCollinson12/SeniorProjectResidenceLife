<!--A.J. Kammerer, Kyle Collinson, CJ Glaze-->
<!--Last edited by: A.J. Kammerer -->
<!--Last Edited Date: 2/15/2023 -->
<!--Connect and query with the SBU database and MySQL database -->
<!DOCTYPE html>

<html lang="en">
  <head>
    <title> SBU ResLife</title>
    </head>
    <body>
    <div class = img> <!--Picture of LEGENDARY SBU NFT-->
         <img src="sbu.png" width = "20%" alt ="SBU"/>
    </div>
   
    </div>
         <div class = dropdown> 
         <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

         <select name="action">
                <option value >View</option>
               <option value="Detailed">Detailed</option>
               <option value="Sign Out">Sign Out</option>
               <option value="Inperson Checkin">Inperson Checkin</option>
               <option value="Edit">Edit</option>
               <option value="Total">Total</option>
         </select> 

         <select name="dorm" id="dorm">
            <option value >Dorm</option>
            <option value=6 >Meyer</option>
            <option value=7 >Plaster</option>
            <option value=5 >Landen</option>
            <option value=3 >Leslie</option>
            <option value=2 >Beasley</option>
            <option value=4 >Woody/Gott</option>
        </select>

        <select name="missed" id="missed">
            <option value >No Filter</option>
            <option value= 'Checked In'>Checked In</option>
            <option value= 'Missed'>Missed</option>
            <option value= 'Signed Out'>Signed Out</option>
            <option value= 'Scanned After'>Scanned After</option>
        </select>

        <label for="first_name">First Name:</label>
<input type="text" id="first_name" name="first_name" pattern="[A-Za-z]+" oninvalid="this.setCustomValidity('Please enter a valid first name')" oninput="this.setCustomValidity('')">

<label for="last_name">Last Name:</label>
<input type="text" id="last_name" name="last_name" pattern="[A-Za-z]+" oninvalid="this.setCustomValidity('Please enter a valid last name')" oninput="this.setCustomValidity('')">

        

        
         
         <label for="start"></label><!--The Calendar Start Date -->
        <input type="date" id="start" name="tripstart"
            value="yyyy-mm-dd"
            min="2022-01-01" max="2100-12-31"/>

        <label for="start"></label><!--The Calendar End Date-->
        <input type="date" id="start" name="tripend"
            value="yyyy-mm-dd"
            min="2022-01-01" max="2100-12-31"/>

            <input type="submit" value="Submit">


         </form>

    </div>

    

   <!------------------------------------------------------------------------------------------------------------------->



<?php

//This code checks if the "first_name" and "last_name" keys exist in the $_POST array before trying to access them, and sets default values for $first_name and $last_name if they do not exist.
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';


if (!empty($first_name) && !empty($last_name)) {
    // Both first name and last name have been entered
    if (!ctype_alpha($first_name) || !ctype_alpha($last_name)) {
        // Invalid input: first and last name should only contain alphabet letters
        $firstNameCheck = false; 
        $lastNameCheck = false; 
    } else {
        // Valid input: first and last name only contain alphabet letters
        $firstNameCheck = true;
        $lastNameCheck = true;
    }
} else {
    // One or both names are empty
    $firstNameCheck = false;
    $lastNameCheck = false;
    
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && $firstNameCheck = true && $lastNameCheck = true) {
    $action = $_POST['action'];

    switch ($action) {
        case 'Detailed':
            $dorm = $_POST['dorm'];          // all these variables dorm, tripstart, etc. need to put in the case so that the user input can be applied to the variable so that variable($dorm for example) will have the user input and be used in the corresponding view file
            $tripstart = $_POST['tripstart'];
            $tripend = $_POST['tripend'];
            $missed = $_POST['missed'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            include 'detailed.php';
            break;
         case 'Sign Out':
            $dorm = $_POST['dorm'];
            $tripstart = $_POST['tripstart'];
            $tripend = $_POST['tripend'];
            include 'signout.php';
            break;
        case 'Inperson Checkin':
            $dorm = $_POST['dorm'];
            $tripstart = $_POST['tripstart'];
            $tripend = $_POST['tripend'];
            include 'inperson.php';
            break;
        case 'Edit':
            $dorm = $_POST['dorm'];
            $tripstart = $_POST['tripstart'];
            $tripend = $_POST['tripend'];
            include 'Edit.php';
            break;
        case 'Total':
            $dorm = $_POST['dorm'];
            $tripstart = $_POST['tripstart'];
            $tripend = $_POST['tripend'];
            include 'Edit.php';
            break;
        
        default: 
            // code to execute for any other action 
        break;
    }
}
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
 
