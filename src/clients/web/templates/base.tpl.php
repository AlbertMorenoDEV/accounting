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
			}
		</style>
		
		<!-- compiled and minified CSS -->
		<link rel="stylesheet" href="../../components/bootstrap/css/bootstrap.min.css">

		<!-- theme -->
		<link rel="stylesheet" href="../../components/bootstrap/css/bootstrap-theme.min.css">

		<!-- compiled and minified JavaScript -->
		<script src="../../components/bootstrap/js/bootstrap.min.js"></script>
		
	</head>
	<body>
		<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
			<div class="container">
				<ul class="nav nav-pills">
					<li role="presentation" class="active"><a href="<?=BASE_URL;?>/">Home</a></li>
					<li role="presentation"><a href="<?=BASE_URL;?>/ListAccounts">List of Accounts</a></li>
					<li role="presentation"><a href="<?=BASE_URL;?>/CreateAccountForm">New Account</a></li>
				</ul>
			</div>
		</nav>
		<div class="container">
			<div class="page-header">
				<h1><?=$title?> <small>ver. <?=$version;?></small></h1>
			</div>
			<div class="starter-template">
				<?=$content?>
			</div>
		</div>
	</body>
</html>