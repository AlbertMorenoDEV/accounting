<ol class="breadcrumb">
	<li><a href="<?=BASE_URL;?>/">Home</a></li>
	<li><a href="<?=BASE_URL;?>/ListAccounts">List of Accounts</a></li>
	<li class="active">Create Account</li>
</ol>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">Account</h2>
	</div>
	<div class="panel-body">
		<ul class="list-group">
			<li class="list-group-item">
				<h3 class="list-group-item-heading">Id:</h3>
				<p class="list-group-item-text"><?= $data->getId() ?></p>
			</li>
		</ul>
	</div>
	<div class="panel-footer"><a href="javascript:history.back()">Back</a></div>
</div>