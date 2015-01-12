<ol class="breadcrumb">
	<li><a href="<?=BASE_URL;?>/">Home</a></li>
	<li><a href="<?=BASE_URL;?>/ListAccounts">List of Accounts</a></li>
	<li class="active">Modify Account Form</li>
</ol>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">Account</h2>
	</div>
	<div class="panel-body">
		<form action="<?=BASE_URL;?>/ModifyAccount">
			<ul class="list-group">
				<li class="list-group-item">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">@</span>
						<input type="text" class="form-control" placeholder="Name" aria-describedby="basic-addon1" name="name" value="<?= $data->getName() ?>">
					</div>
				</li>
				<li class="list-group-item">
					<button type="submit" class="btn btn-success">Save</button>
				</li>
			</ul>
			
			<input type="hidden" name="uuid" value="<?= $data->getId() ?>"/>
		</form>
	</div>
	<div class="panel-footer"><a href="javascript:history.back()">Back</a></div>
</div>