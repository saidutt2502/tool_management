<!DOCTYPE html>
<html lang="en">
<head>
  <title>About Us</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div style="padding-top:60px !important;" class="container">

	<div class="row">
		<div class="col-md-6" style="padding-left: 70px;" >
			<div class="jumbotron" id="saidutt" style="height:500px; width:450px;">
				<h1 id="heading_text_saidutt">Saidutt Redkar</h1>      
				<p id="p_saidutt"><br><br>saiduttredkar@gmail.com<br>
				+91-7020171433<br>
				<a href="https://www.facebook.com/saidutt.redkar">Facebook</a></p>
			</div>
			
		</div>

		<div class="col-md-6" style="padding-left:50px;" >
			<div class="jumbotron" id="aman" style="height:500px; width:450px;">
				<h1 id="heading_text_aman">Aman Sharma</h1>      
				<p id="p_aman"><br><br>armslive1904@gmail.com <br>
				+91-8007780783</br>
				<a href="https://www.facebook.com/amansharma1904">Facebook</a></p>
			</div>
			
		</div> 
		
	</div>
	
	 <footer>
          <div>
           <font color="white"><center> Developed for <b> Rosenberger | India </font></b></center>
          </div>
          <div class="clearfix"></div>
        </footer>
		

</div>

<script> 
$(document).ready(function(){
    $("#aman").hover(function(){
		 $('#heading_text_aman').toggle();
        $("#aman").toggleClass('aman');
     
    });
	
	 $("#saidutt").hover(function(){
		 $('#heading_text_saidutt').toggle();
        $("#saidutt").toggleClass('saidutt');
	
    });
});
</script> 

<style>
body, html {
  
	 background-image: url("/images/bg.jpg");

    /* Full height */


    /* Center and scale the image nicely */
    background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}

.saidutt{
background: url("/images/saidutt.jpg"); no-repeat ;
 background-position: center; 
}


.aman{
background: url("/images/aman.jpg"); no-repeat ;
 background-position: center; 
}



</style>

</body>
</html>
