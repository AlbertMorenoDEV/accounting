<ol class="breadcrumb">
	<li><a href="<?=BASE_URL;?>/">Home</a></li>
	<li><a href="<?=BASE_URL;?>/ListAccounts">List of Accounts</a></li>
	<li class="active">Create Account History</li>
</ol>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">Account History</h2>
	</div>
	<div class="panel-body">
		<div class="alert alert-success" role="alert">
			<b>New item, Id:</b> <?= $data->getId() ?>
		</div>
	</div>
	<div class="panel-footer"><a href="javascript:history.back()">Back</a></div>
</div>