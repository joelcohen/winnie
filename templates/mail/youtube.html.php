<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" class="plain">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="<?php echo WINNIE_URL; ?>css/mail.css" type="text/css" media="screen" title="Winnie" charset="utf-8">

	<title><?php echo $subject; ?></title>
	
</head>

<body class="youtube">
	
	<?php echo $inputMessage?"<p>$inputMessage</p>":''; ?>
	
	<p><a id="url" href="<?php echo $url; ?>"><?php echo $url; ?></a></p>
	
	<object width="425" height="344"><param name="movie" value="<?php echo $embedUrl; ?>"></param><embed src="<?php echo $embedUrl; ?>" type="application/x-shockwave-flash" width="425" height="344"></embed></object>
		
	<div id="Footer">
		<?php echo BOT_SIGNATURE;?>
	</div>
</body>
</html>