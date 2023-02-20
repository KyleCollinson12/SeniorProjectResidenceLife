<head>
    <meta charset="UTF-8">
        <title> SBU ResLife </title>
    </head>
    <body>
    <div class = img> <!--Picture of LEGENDARY SBU NFT-->
            <img src="sbu.png" width = "20%" alt ="SBU"/>
    </div>

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

<html>

<form action="TheBig.php" method="get">
        <select name="page">
        <option value>Select View</option>
        <option value="detail">Detailed</option>
        <option value="signinout">Sign In Out</option>
        <option value="total">Total View</option>
        </select>
        <input type="submit" value="Go">
    </form>

<body>
    <?php
    //Credentials for MySQL Login
    $user = 'root';
    $pass = 'seniorprojectreslife457345'; 
    $db = 'seniorprojectcurfew';

    //connect to database and check for errors
    $conn = mysqli_connect('localhost', $user, $pass, $db) or die ("unable to connect");
    if(!$conn){
        echo 'Connection Error: ' .mysqli_connect_error();
    }
    
    function Detailed(){
        //this is the HTML for the Detailed view and all the functions that come with it
        echo 
        '<div class = dropdown> 
        <label for="dorm">Select Dorm, Date Range, and View:</label>
        <form action = "TheBig.php" method = "POST">
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
            min="2022-01-01" max="2300-12-31"/>

        <label for="start"></label><!--The Calendar End Date-->
        <input type="date" id="start" name="tripend"
            value="yyyy-mm-dd"
            min="2022-01-01" max="2100-12-31"/>
       
        <input type="submit">
        </form>
        </div>';
    }
    function SignInOut(){

    }
    function Total(){

    }

    $currentPage = $_GET['page'];

    switch($currentPage){
        case 'detail': 
            Detailed();
            break;
            
        case 'signinout': 
            SignInOut();
            break;


        case 'total': 
            Total();
            break;
        }
        ?>  
</body>
</html>