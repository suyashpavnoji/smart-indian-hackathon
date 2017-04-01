<?php

require 'dbconnect.php';
if(isset($_GET['PNR']))
{
        $PNR = $_GET['PNR'];
		if ($result = $mysqli->query("SELECT departure FROM Users WHERE PNR='".$PNR."'")) 
        {
            if( $result->num_rows == 1)
            {
                 $check = mysqli_fetch_array($result,MYSQLI_ASSOC);
                 if($check['departure'] === "1")
                 {
                    if ($result = $mysqli->query("SELECT PNR, UFNAME, ULNAME, checking, security, boarding, belt, domestic, immigration, Departure.flightno, departure,fname,destination,via,checkin,status,etd,dod FROM `Users`,`Departure` Where Users.flightno = Departure.flightno and PNR='".$PNR."'"))
                    	{
                        	echo json_encode(mysqli_fetch_array($result,MYSQLI_ASSOC));
                      	}	
                  }
            
                  else
                  {
                    if ($result = $mysqli->query("SELECT PNR, UFNAME, ULNAME, checking, security, boarding, Users.belt, domestic, immigration, Arrival.flightno, departure,fname,origin,via,Arrival.belt,status,eta,doa FROM `Users`,`Arrival` Where Users.flightno = Arrival.flightno and PNR='".$PNR."'"))
                    // if ($result = $mysqli->query("SELECT PNR, UFNAME, ULNAME, checking, security, boarding, belt, domestic, immigration, Arrival.flightno, departure, fname, origin,via,belt,status,eta,doa FROM `Users`,`Arrival` Where Users.flightno = Arrival.flightno and PNR='".$PNR."'"))
                	   {
                         	echo json_encode(mysqli_fetch_array($result,MYSQLI_ASSOC));
                 	    }
           	      }
            }
            else if($result->num_rows == 0)
              echo json_encode(array("error" => "no_data"));
           	$mysqli->close();
 	
          }
       //echo json_encode(mysqli_fetch_array($result,MYSQLI_ASSOC));
	else 
 		echo json_encode(array("error" => "no_data"));
    /* free result set */
    
}
else
echo json_encode(array("error" => "no_data"));

?>