
<html>
	<head>
		<title>ACKWARD Calendar</title>
		<link type="text/css" rel="stylesheet" href="css/bootstrap.css"/>
		<link type="text/css" rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Lobster" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		
		<style>
			* {
			  margin: 0;
			  padding: 0;
			}
			body{
				background-image:url('bg.jpg');
				background-repeat: no-repeat;
				background-attachment: fixed;
				background-position:center;
				background-size:cover;
			}
			
			.fieldset1 fieldset{
				float:left;
				margin-left:10%;
				margin-top:5%;
				border: none;
			}
			.fieldset2{
				float:right;
				margin-right:10%;
				margin-top:5%;
			}
			
			fieldset{
				border: solid 2px white;  
				display:inline;
			}
			#header h1{
				padding:5px;
				font-family:Lobster;
			}
			#header {
				background-color:#2887c1;
				color:white;
				text-align:center;
				padding: 0%;
			}
			.input-block-level { 
				-webkit-border-radius: 5px; 
				-moz-border-radius: 5px; 
				border-radius: 5px; 
				border: 1px solid #848484; 
				outline:0; 
				width: 250px;
				height: 30px;
				margin: 7px;
				font-size: 18px;
		   } 
		   
		   .myButton {
				background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #33bdef), color-stop(1, #019ad2));
				background:-moz-linear-gradient(top, #33bdef 5%, #019ad2 100%);
				background:-webkit-linear-gradient(top, #33bdef 5%, #019ad2 100%);
				background:-o-linear-gradient(top, #33bdef 5%, #019ad2 100%);
				background:-ms-linear-gradient(top, #33bdef 5%, #019ad2 100%);
				background:linear-gradient(to bottom, #33bdef 5%, #019ad2 100%);
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#33bdef', endColorstr='#019ad2',GradientType=0);
				background-color:#33bdef;
				-moz-border-radius:6px;
				-webkit-border-radius:6px;
				border-radius:6px;
				border:1px solid #057fd0;
				display:inline-block;
				cursor:pointer;
				color:#ffffff;
				font-family:Arial;
				font-size:15px;
				font-weight:bold;
				padding:6px 24px;
				text-decoration:none;
				margin-bottom:10px;
			}
			.myButton:hover {
				background:-webkit-gradient(linear, left top, left bottom, color-stop(0.05, #019ad2), color-stop(1, #33bdef));
				background:-moz-linear-gradient(top, #019ad2 5%, #33bdef 100%);
				background:-webkit-linear-gradient(top, #019ad2 5%, #33bdef 100%);
				background:-o-linear-gradient(top, #019ad2 5%, #33bdef 100%);
				background:-ms-linear-gradient(top, #019ad2 5%, #33bdef 100%);
				background:linear-gradient(to bottom, #019ad2 5%, #33bdef 100%);
				filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#019ad2', endColorstr='#33bdef',GradientType=0);
				background-color:#019ad2;
			}
			.myButton:active {
				position:relative;
				top:1px;
			}


		</style>
	</head>
	<body>
		<div id="header">
			<h1>Ackward Calendar</h1>
		</div>
		
		<div class="fieldset1">
			<fieldset>
				<p>
					*insert text introducing Ackward calendar*
				</p>
			</fieldset>
		</div>
		<div class="fieldset2">
			<form action="#" class="form-signin" method="post">
				<fieldset>
					<legend>Sign in</legend>
					<input type="text" name="username" class="input-block-level" placeholder="Username"/>
					<br>
					<input type="password" name="password" class="input-block-level" placeholder="Password"/>
					<br>
					<center>
					<input type="submit" name="login" class="myButton" id="btn-login" style="color: #fffff" value="Sign In"/>
					</center>
				</fieldset>
			</form>
			<br>
			<form action="#" class="form-signup" method="post">
				<fieldset>
					<legend>New to Ackward? Sign up</legend>
					<input type="text" name="username" class="input-block-level" placeholder="Username"/>
					<br>
					<input type="password" name="password" class="input-block-level" placeholder="Password"/>
					<br>
					<center>
					<input type="submit" name="login" class="myButton" id="btn-login" style="color: #fffff" value="Sign Up"/>
					</center>
				</fieldset>
			</form>
		</div>
	</body>
</html>