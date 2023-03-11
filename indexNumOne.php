<!--A.J. Kammerer, Kyle Collinson, CJ Glaze-->
<!--Last edited by: A.J. Kammerer -->
<!--Last Edited Date: 2/15/2023 -->
<!--Connect and query with the SBU database and MySQL database -->
<!DOCTYPE html>
<html lang="en">
<head>
	<title> SBU ResLife</title>
	<meta charset="UTF-8">
	<style>
		.button {
			display: inline-block;
			padding: 10px;
			margin: 10px;
			background-color: rgb(111, 84, 172);
			color: white;
			border: 2px solid black;
			border-radius: 5px;
            font-family: 'Gill Sans', 'Gill Sans MT',
            ' Calibri', 'Trebuchet MS', 'sans-serif';
		}

		.button:hover {
			background-color: black;
			color: white;
			border: 2px solid white;
		}

		.button:active {
			transform: translateY(2px);
			box-shadow: 0px 2px 0px #333;
			background-color: purple;
			color: black;
			border: 2px solid black;
		}
	</style>
</head>
<body>
	<div class="img"> <!--Picture of LEGENDARY SBU NFT-->
		<img src="sbu.png" width="20%" alt="SBU">
	</div>

	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
		<div style="text-align:center;">
			<button class="button" name="action" value="detailed">Detailed</button>
			<button class="button" name="action" value="sign-out">Sign Out</button>
			<button class="button" name="action" value="inperson-checkin">Inperson Checkin</button>
			<button class="button" name="action" value="edit">Edit</button>
			<button class="button" name="action" value="total">Total</button>
			
		</div>
	</form>
</body>
</html>

    
       
    

   <!------------------------------------------------------------------------------------------------------------------->



<?php





if ($_SERVER["REQUEST_METHOD"] == "POST" ) {
    $action = $_POST['action'];

    switch ($action) {
        case 'detailed':
         header ("Location: detailed.php");
         exit();
        break;
         case 'sign-out':
          
            include 'signout.php';
            header("Location: signout.php");
            exit();
            break;
        case 'inperson-checkin':
          
            include 'inperson.php';
            break;
        case 'edit':
           
            include 'Edit.php';
            break;
        case 'total':
          
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
 
