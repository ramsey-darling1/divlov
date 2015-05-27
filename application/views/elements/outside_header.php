<!doctype html>
<html>
<head>
<meta name="author" content="Ramsey Darling" />
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
<title>DivLov (Diverse Love)</title>
 <!--Import materialize.css-->
      <link type="text/css" rel="stylesheet" href="/assets/bower_components/materialize/dist/css/materialize.min.css"  media="screen,projection"/>

<!--css-->
<link href="/assets/css/main.css" type="text/css" rel="stylesheet"/>

</head>
<body>
<div class="container">
<?php
//display messages if any
    if($this->session->userdata('message')){
        //echo the message
        echo '<div id="response_wrap">'.$this->session->userdata('message').'</div>';
        $this->session->unset_userdata('message');
    }
?>
<div id="head_wrap">
    <div id="header" class="fit_width">
        <div id="logo">
            <h1>DivLov</h1>
        </div>
        <div id="eyebrow" class="link_style1">
			<ul class="inline">
				<?php
					if(isset($login)){
						echo '<li>Need an account? <a href="/index.php">Register</a></li>';
					}else{
						echo '<li>Already a Member? <a href="/index.php/users/login">Sign In</a></li>';
					}
				?>
			</ul>
		</div>
        <div class="brick"></div>
    </div>
</div>

<div id="maincontent">
	<div id="innermaincontent" class="fit_width">
