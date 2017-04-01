<?php

	session_start();

	if(!isset($_GET['PNR']))
	{
		if(!isset($_SESSION['PNR'])){
			?>
					<!DOCTYPE html>
					<html>
					<head>
						<title>Oops</title>
						<link rel="stylesheet" type="text/css" href="error.css">
					</head>
					<body>
					<div class="text-wrapper">
					    <div class="title" data-content="404">
					        Oops...
					    </div>

					    <div class="subtitle">
					        PNR not provided.
					    </div>

					    <div class="buttons">
					        <a class="button" href="#">Go to homepage</a>
					    </div>
					</div>
					</body>
					</html>
			<?php
			
		}
		else
		{
			$PNR = $_SESSION['PNR'];
		}
	}
	else
	{
		$PNR = $_GET['PNR'];
	}
	if(isset($PNR))
	{
		
		
		$_SESSION['PNR'] = $PNR;
		$ch = curl_init();
 
		//Set the URL that you want to GET by using the CURLOPT_URL option.
		curl_setopt($ch, CURLOPT_URL, "http://localhost/SmartPort/user.php?PNR=".$PNR);
		 
		//Set CURLOPT_RETURNTRANSFER so that the content is returned as a variable.
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		 
		//Set CURLOPT_FOLLOWLOCATION to true to follow redirects.
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		 
		//Execute the request.
		$data = curl_exec($ch);
		$data = json_decode($data,true);
		//Close the cURL handle.
		curl_close($ch);
		
		if(!array_key_exists('error', $data))
		{
				$name = $data['UFNAME']." ".$data['ULNAME'];
				$flightNo = $data['flightno'];
				$flightName = $data['fname'];
				$via = $data['via'];
			if($data['departure'] == 0)
			{
				$origin = $data['origin'];
				$status = $data['status'];
				$eta = $data['eta'];
				$doa = $data['doa'];
			}
			else
			{
				$destination = $data['destination'];
				$status = $data['status'];
				$checkIn = $data['checkin'];
				$etd = $data['etd'];
				$dod = $data['dod'];
			}


?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Passenger Portal</title>
			  <link rel="manifest" href="/manifest.json">
			<link rel="stylesheet" type="text/css" href="style.css">
		  	<script src="jquery.min.js"></script>
		  	<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
		  	<script type="text/javascript">
						  		// JS for setting the "active" step class
					$( document ).ready(function() {
						var i=0;
						var OneSignal = window.OneSignal || [];
						OneSignal.push(["init", {
		    			allowLocalhostAsSecureOrigin: true,
		      			appId: "df075db6-793f-42ba-9277-556d05400f3e",
		      			autoRegister : true,
		     	 		httpPermissionRequest :{
		      				enable : true
		      			},
		      			notifyButton: {
		        			enable: false /* Set to false to hide */
		    			}
		    		}]);
						OneSignal.push(function() {
		  					OneSignal.registerForPushNotifications();
						});
						// var d = new Date();
						// $("#date").html(d.toDateString());
						// "Next" buttons:
						$(".next").click(function(){
						  var oParent = $(this).closest(".step");
						  setActiveStep(oParent.next());
						});

						// "Back" buttons:
						$(".back").click(function(){
						  var oParent = $(this).closest(".step");
						  setActiveStep(oParent.prev());
						});


						function setActiveStep(p_oDiv){
						  
						  // Set styles:  
						  $(".step.active").removeClass("active");
						  $(".step.inactive").removeClass("inactive");
						  $(p_oDiv).addClass("active");
						  $(p_oDiv).nextAll().addClass("inactive");

						  // Scroll to active step:
						  if(i != 0){
						    $("html, body").animate({
						        scrollTop: $(p_oDiv).offset().top
						    }, 500);
							}
							i=1;
						}
						//Init the first step:
						setActiveStep($(".step")[0]);
						//$(".next")[0].click();

					});
		  	</script>
		</head>
		<body>
		<h1><?php echo $name; ?></h1>
		<h1><?php echo $flightName; ?> | 
		<?php
			if($data['departure'] == 0)
				echo "Origin : ".$data['origin'];
			else
				echo "Destination : ".$data['destination'];
		?>
		</h1>
		<h1>Flight No : <span id="fl_no"><?php echo $flightNo; ?></span> | PNR : <span id="pnr"><?php echo $PNR; ?></span></h1>
		<h1><span id="date">
		<?php  
			if($data['departure'] == 0)
				echo "Date : ".$data['doa']." | ETA : ".$data['eta'];
			else
				echo "Date : ".$data['dod']." | ETA : ".$data['etd'];
		?>
		</span></h1>
		<div class="step active">
		  <h2 data-step-id="1">Document Verification</h2>
		  <p>Please verify your ticket.</p>
		  <button class="next"></button>
		</div>
		<div class="step">
		  <h2 data-step-id="2">Security</h2>
		  <p>Please keep the following documents ready for Security Check-In<ul><li>Identification Proof</li>
		  <li>Ticket</li></ul></p>
		  <button class="next"></button>
		</div>
		<div class="step">
		  <h2 data-step-id="3">Almost there</h2>
		  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam inventore quas, nisi cum laboriosam. Deserunt animi perferendis quidem, maxime, minima atque at est suscipit modi sit, aliquid perspiciatis! Vitae, magnam.</p>
		  <button class="next"></button>
		</div>
		<div class="step">
		  <h2 data-step-id="4">Complete it now</h2>
		  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quibusdam inventore quas, nisi cum laboriosam. Deserunt animi perferendis quidem, maxime, minima atque at est suscipit modi sit, aliquid perspiciatis! Vitae, magnam.</p>
		  <button class="next"></button>
		</div>
		<div class="step">
		  <h2 data-step-id="✓">Done!</h2>
		  <p>Congratulations! You completed all steps.</p>
		</div>
		</body>
		</html>
<?php
}
else 
{
		?>
		<!DOCTYPE html>
		<html>
		<head>
			<title>Oops</title>
			<link rel="stylesheet" type="text/css" href="error.css">
		</head>
		<body>
		<div class="text-wrapper">
		    <div class="title" data-content="404">
		        Oops...
		    </div>

		    <div class="subtitle">
		        Looks like the PNR you entered is invalid.
		    </div>

		    <div class="buttons">
		        <a class="button" href="#">Go to homepage</a>
		    </div>
		</div>
		</body>
		</html>
	<?php
		}
}
?>