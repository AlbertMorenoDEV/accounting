<ol class="breadcrumb">
	<li><a href="<?=BASE_URL;?>/">Home</a></li>
	<li><a href="<?=BASE_URL;?>/ListAccounts">List of Accounts</a></li>
	<li><a href="<?=BASE_URL;?>/ListAccountsHistories">List of Accounts histories</a></li>
	<li class="active">New Account history</li>
</ol>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">Account history</h2>
	</div>
	<div class="panel-body">
		<form action="<?=BASE_URL;?>/CreateAccountHistory">
			<ul class="list-group">
				<li class="list-group-item">
					<h3 class="list-group-item-heading">Account:</h3>
					<p class="list-group-item-text">
						<a href="ViewAccount?id=<?= $data->getId() ?>"><?= $data->getName() ?></a>
					</p>
				</li>
				<li class="list-group-item">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1">@</span>
						<input type="text" class="form-control" placeholder="Concept" aria-describedby="basic-addon1" name="concept" value="">
					</div>
				</li>
				<li class="list-group-item">
					<div class="input-group">
						<span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
						<input type="text" class="form-control" placeholder="Date" aria-describedby="basic-addon1" name="date" value="<?=date("m/d/Y");?>">
					</div>
				</li>
				<li class="list-group-item">
					<div class="input-group">
						<span class="input-group-addon">&euro;</span>
						<input type="text" class="form-control" aria-label="Amount" name="amount" value="0">
					</div>
				</li>
				<li class="list-group-item">
					<button type="submit" class="btn btn-success">Save</button>
				</li>
			</ul>
			<input type="hidden" name="accountId" value="<?= $data->getId() ?>"/>
		</form>
	</div>
	<div class="panel-footer"><a href="javascript:history.back()">Back</a></div>
</div>
<script>
	$(function() {
		$( "input[name=date]" ).datepicker();
	});
</script>