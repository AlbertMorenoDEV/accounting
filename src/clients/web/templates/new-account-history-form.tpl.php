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
		<ul class="list-group">
			<li class="list-group-item">
				<h3 class="list-group-item-heading">Account:</h3>
				<p class="list-group-item-text">
					<a href="ViewAccount?id=<?= $data->getAccount()->getId() ?>"><?= $data->getAccount()->getName() ?></a>
				</p>
			</li>
			<li class="list-group-item">
				<h3 class="list-group-item-heading">Concept:</h3>
				<p class="list-group-item-text"><?= $data->getConcept() ?></p>
			</li>
			<li class="list-group-item">
				<h3 class="list-group-item-heading">Date:</h3>
				<p class="list-group-item-text"><?= $data->getDate()->format('Y-m-d H:i:s') ?></p>
			</li>
			<li class="list-group-item">
				<h3 class="list-group-item-heading">Amount:</h3>
				<p class="list-group-item-text"><?= $data->getAmount() ?></p>
			</li>
		</ul>
	</div>
	<div class="panel-footer"><a href="javascript:history.back()">Back</a></div>
</div>