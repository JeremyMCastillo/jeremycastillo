<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->
<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title><?php echo $title; ?></title>
<base href="<?php echo $base; ?>" />
<?php if ($description) { ?>
<meta name="description" content="<?php echo $description; ?>" />
<?php } ?>
<?php if ($keywords) { ?>
<meta name="keywords" content= "<?php echo $keywords; ?>" />
<?php } ?>
<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="catalog/view/javascript/jquery/jquery-ui.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<link href="//fonts.googleapis.com/css?family=Open+Sans:400,400i,300,700" rel="stylesheet" type="text/css" />
<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">
<link href="catalog/view/theme/default/stylesheet/simple-line-icons-master/css/simple-line-icons.css" rel="stylesheet" />
<?php foreach ($styles as $style) { ?>
<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
<?php } ?>
<script src="catalog/view/javascript/common.js" type="text/javascript"></script>
<?php foreach ($links as $link) { ?>
<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />
<?php } ?>
<?php foreach ($scripts as $script) { ?>
<script src="<?php echo $script; ?>" type="text/javascript"></script>
<?php } ?>
<?php foreach ($analytics as $analytic) { ?>
<?php echo $analytic; ?>
<?php } ?>
</head>
<body class="<?php echo $class; ?>">
<header id="header">
	<div class="row">
		<nav id="menu" class="col-lg-12 text-center">
                        <span class="home-logo"><a href="<?php echo $base; ?>"><img src="<?php echo $image; ?>" alt="Home" /></a></span>
			<ul>
                            <li class="menu-item"><a href="<?php echo $about; ?>">About</a></li>
                            <li class="menu-item"><a href="<?php echo $blog; ?>">Blog</a></li>
                            <li class="menu-item"><a id="contact-link">Contact</a></li>
                            <li class="menu-item"><a href="<?php echo $portfolio; ?>">Projects</a></li>
			</ul>
                        <span id="menu-icon"><i class="icon-menu"></i></span>
		</nav>
	</div>
</header>
    
<script type="text/javascript">
    $("#contact-link").on("click", function(){
        if($("#contact-form").length > 0){
            $("html, body").animate({
                scrollTop: $("#contact-form").offset().top
            }, 2000, 'easeOutExpo');
        }
        else{
            window.location = "<?php echo HTTP_SERVER . '#contact-form'; ?>";
        }
    });
</script>