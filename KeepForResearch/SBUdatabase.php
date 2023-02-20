<?php 
//Connecting to SBU Database but once
$serverName = "windsx.sbuniv.edu";
$connectionOptions = array("Database"=>"AcsLog",
    "Uid"=>"DSXCLW", "PWD"=>"SeniorProject", "ReturnDatesAsStrings"=>true);
$conn = sqlsrv_connect($serverName, $connectionOptions);
if($conn == false){
    die(FormatErrors(sqlsrv_errors()));
}else{
   echo"Connection Working";
}

//-------------------------------------------------------------------------------

//Query to the SBU Database
$tsql = "SELECT [TimeDate],[LName],[FName]";
$tsql .= "FROM [AcsLog].[dbo].[EvnLog]";
$tsql .= "WHERE Loc = '13' and Code != '0' and Opr > '0' and TimeDate BETWEEN '2022-11-16 09:30:00.000' AND '2022-11-16 11:30:00.000' AND LName = 'Collinson'";

// //The result of the Query is stored here
$result = sqlsrv_query ($conn , $tsql) or die(sqlsrv_errors());

// //Converts the data sent into a string array 
while($column = sqlsrv_fetch_array($result)) {
  $names[] = $column['LName'];
  $names2[] = $column['FName'];
  $timedate[] = $column['TimeDate'];
 

  }

//Loop var for the size of the var
$sizeOfNames = count($names);

 //Loop to print out The query results.
for ( $i = 0; $i < $sizeOfNames; $i++){
   echo implode(" ",$names);
   echo implode(" ",$names2);
   echo implode(" ",$timedate);
   
}

// //free up the ram for the next set of data and close the connection
sqlsrv_free_stmt($result);
sqlsrv_close($conn);