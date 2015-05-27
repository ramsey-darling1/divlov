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
<header>
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
<div class="row">
        <div id="logo" class="col s8">
            <h1>DivLov</h1>            
        </div>
        <div id="eyebrow" class="link_style1 col s4">
			<ul class="inline">
				<li>Welcome <?php echo @$username; ?> | </li>
				<li><a href="/index.php/users/logout">Log Out</a></li>
			</ul>
		</div>
</div>
<div class="">
        <nav id="main_nav" class="link_style1">
            <ul class="inline nav-wrapper">
				<li><a href="/index.php/pages/home">Home</a></li>
				<li><a href="/index.php/pages/messaging">Messaging
				<?php if(!empty($message_num)): ?>
				(<?php echo $message_num; ?>)
				<?php endif;?>
				</a></li>
				<li><a href="/index.php/pages/people">People</a></li>
				<li><a href="/index.php/pages/favorites">Favorites</a></li>
				<li><a href="/index.php/pages/blog">Blog</a></li>
				<li><a href="/index.php/pages/hiwall">DivLove wall</a></li>
				<li><a href="/index.php/pages/myhitest">Custom Test</a></li>
			</ul>
        </nav>
</div>
        <div class="brick"></div>
    </div>
</div>
</header>
<main>
<div id="maincontent">
	<div id="innermaincontent" class="fit_width">
		<div id="back_to_top" class="link_style2 disappear"><a href="#maincontent">back to top</a></div>
