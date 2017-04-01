<?php

require 'dbconnect.php';
if(isset($_GET['PNR']))
{
    $PNR = $_GET['PNR'];
    if ($result = $mysqli->query("UPDATE Users SET checking='1' WHERE PNR='".$PNR."'") === TRUE) 
    {
        if($mysqli->affected_rows == 1)
        {
          if($result = $mysqli->query("SELECT rID FROM Users WHERE PNR='".$PNR."'"))
          { 
              if($result->num_rows == 1)
              {
                  $data = mysqli_fetch_array($result,MYSQLI_ASSOC);
                  $result->close();
                  //Perform Push Notification
                  $content = array(
                    "en" => "Your Check-In is completed."
                    );
                  
                  $fields = array(
                    'app_id' => "df075db6-793f-42ba-9277-556d05400f3e",
                    'include_player_ids' => array($data['rID']),
                    'data' => array("step1" => "TRUE"),
                    'contents' => $content
                  );
                  
                  $fields = json_encode($fields);
                    //print("\nJSON sent:\n");
                    //print($fields);
                  
                  $ch = curl_init();
                  curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
                                         'Authorization: Basic NmFiZDJkNzAtMTM0ZS00YjM3LWE0OTQtOGRlYjllYzZhYzE0'));
                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                  curl_setopt($ch, CURLOPT_HEADER, FALSE);
                  curl_setopt($ch, CURLOPT_POST, TRUE);
                  curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);

                  $response = curl_exec($ch);
                  curl_close($ch);
                  //echo json_encode($response,JSON_UNESCAPED_SLASHES);
                  print_r($response);
                  //End Push Notification
              }
          }
          else 
          {
              echo json_encode(array("warning" => "no_data"));
          }
        }
        else 
          {
            if($mysqli->query("SELECT rID FROM Users WHERE PNR='".$PNR."'"))
            {
              echo json_encode(array("error" => "Already Checked-In"));
            }
            else
              echo json_encode(array("error" => "Invalid PNR"));
          }
      $mysqli->close();
    }
    else json_encode(array("error" => "Not Updated"));
}
?>