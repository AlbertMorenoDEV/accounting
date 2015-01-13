<ol class="breadcrumb">
	<li><a href="<?=BASE_URL;?>/">Home</a></li>
	<li class="active">List of Accounts</li>
</ol>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">List of Accounts</h2>
	</div>
	<div class="panel-body">
		<table class="table">
			<tr>
				<th>Name</th>
				<th>Balance</th>
				<th> </th>
				<th> </th>
				<th> </th>
			</tr>
			<?php foreach ($data as $account) { ?>
				<tr>
					<td><a href="ViewAccount?id=<?= $account->getId() ?>"><?= $account->getName() ?></a></td>
					<td><?= $account->getTotal() ?></td>
					<td>
						<a href="ListAccountHistories?id_account=<?= $account->getId() ?>">
							<span class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
						</a>
					</td>
					<td>
						<a href="ModifyAccountForm?id=<?= $account->getId() ?>">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						</a>
					</td>
					<td>
						<a href="CreateAccountHistoryForm?id=<?= $account->getId() ?>">
							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						</a>
					</td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>