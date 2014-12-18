<!doctype html>
<html>
<head>
<meta name="author" content="Ramsey Darling,Frugal Development" />
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>DivLov (Diverse Love)</title>
<!--css-->
<link href="/assets/css/main.css" type="text/css" rel="stylesheet"/>

<!--jquery ui-->
<link href="/assets/js/jquery.ui/css/custom-theme/jquery-ui-1.10.0.custom.css" rel="stylesheet">
	
<!-- Loading Bootstrap -->
<link href="/assets/flatui/bootstrap/css/bootstrap.css" rel="stylesheet">

<!-- Loading Flat UI -->
<link href="/assets/flatui/css/flat-ui.css" rel="stylesheet">    

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/flatui/js/html5shiv.js"></script>
  <script src="/assets/flatui/js/respond.min.js"></script>
<![endif]-->
</head>
<body>
<div class="container">
<?php
//display messages if any
    if(@$this->session->userdata('message')){
        //echo the message
        echo '<div id="response_wrap">'.$this->session->userdata('message').'</div>';
        $this->session->unset_userdata('message');
    }
?>
<div id="loading" class=""></div>
<div id="head_wrap">
    <div id="header" class="fit_width">
        <div id="logo">
            <h1>DivLov</h1>            
        </div>
        <div id="eyebrow" class="link_style1">
			<ul class="inline">
				<li>Welcome <?php echo @$username; ?> | </li>
				<li><a href="/index.php/users/logout">Log Out</a></li>
			</ul>
		</div>
        <nav id="main_nav" class="link_style1">
            <ul class="inline">
				<li><a href="/index.php/pages/home">Home</a> | </li>
				<li><a href="/index.php/pages/messaging">Messaging
				<?php if(!empty($message_num)): ?>
				(<?php echo $message_num; ?>)
				<?php endif;?>
				</a> | </li>
				<li><a href="/index.php/pages/people">People</a> | </li>
				<!--<li><a href="">Hearts</a> | </li>-->
				<li><a href="/index.php/pages/favorites">Favorites</a> | </li>
				<li><a href="/index.php/pages/blog">Blog</a> | </li>
				<li><a href="/index.php/pages/hiwall">DivLove wall</a> | </li>
				<li><a href="/index.php/pages/myhitest">Custom Test</a></li>
			</ul>
        </nav>
        <div class="brick"></div>
    </div>
</div>

<div id="maincontent">
	<div id="innermaincontent" class="fit_width">
		<div id="back_to_top" class="link_style2 disappear"><a href="#maincontent">back to top</a></div>