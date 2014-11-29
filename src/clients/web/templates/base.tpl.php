<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title><?=$title?></title>
		<link rel="stylesheet" href="css/style.css" type="text/css">
		
		<style type="text/css" media="screen">
			body {
				padding-top: 50px;
			}
			.starter-template {
				padding: 40px 15px;
				text-align: center;
			}
		</style>
		
		<!-- compiled and minified CSS -->
		<link rel="stylesheet" href="../../vendor/components/bootstrap/css/bootstrap.min.css">

		<!-- theme -->
		<link rel="stylesheet" href="../../vendor/components/bootstrap/css/bootstrap-theme.min.css">

		<!-- compiled and minified JavaScript -->
		<script src="../../vendor/components/bootstrap/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		<div class="container">
			<div class="starter-template">
				<h1><?=$title?></h1>
				<?=$content?>
			</div>
		</div>
	</body>
</html>