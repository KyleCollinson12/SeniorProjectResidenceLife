<?php
// Connecting to SBU Database
$serverName = "windsx.sbuniv.edu";
$connectionOptions = array("Database"=>"AcsLog",
    "Uid"=>"DSXCLW", "PWD"=>"SeniorProject");
$conn = sqlsrv_connect($serverName, $connectionOptions);
if($conn == false){
    die(FormatErrors(sqlsrv_errors()));
}else{
   echo"yo";
}
 
//Query to the SBU Database
$tsql = "SELECT LName ";
$tsql .= "FROM [AcsLog].[dbo].[EvnLog]";
$tsql .= "WHERE Loc = '13' and Code != '0' and Opr > '0' and TimeDate BETWEEN '2022-11-16 09:30:00.000' AND '2022-11-16 11:30:00.000'";

//The result of the Query is stored here and converts to string
$result = sqlsrv_query ($conn , $tsql) or die(mysql_error());

//Converts the data sent into a string array
while($column = sqlsrv_fetch_array($result)) {
   $names[] = $column['LName'];
}

//Loop var for the size of the var
$sizeOfNames = count($names);

//Loop to print out The query results.
for ( $i = 0; $i < $sizeOfNames; $i++){
   echo implode(" ",$names);
}


sqlsrv_free_stmt ($result);
sqlsrv_close($conn);


//Connecting to MySQL database
$user = 'root';
$pass = 'seniorprojectreslife457345'; 
$db = 'seniorprojectcurfew';

$db = new mysqli ('localhost', $user, $pass, $db) or die ("unable to connect");

echo" What is up";
?> 