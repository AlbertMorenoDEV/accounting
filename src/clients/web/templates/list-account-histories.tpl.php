<ol class="breadcrumb">
	<li><a href="<?=BASE_URL;?>/">Home</a></li>
	<li><a href="<?=BASE_URL;?>/ListAccounts">List of Accounts</a></li>
	<li class="active">List of Account histories</li>
</ol>
<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">List of Account histories</h2>
	</div>
	<div class="panel-body">
		<table class="table">
			<tr>
				<th>Date</th>
				<th>Concept</th>
				<th>Amount</th>
				<!-- <th> </th> -->
			</tr>
			<?php foreach ($data as $accountHistory) { ?>
				<tr>
					<td><?= $accountHistory->getDate()->format('Y-m-d H:i:s') ?></td>
					<td><a href="ViewAccountHistory?id=<?= $accountHistory->getId() ?>"><?= $accountHistory->getConcept() ?></a></td>
					<td><?= $accountHistory->getAmount() ?></td>
					<!-- <td>
						<a href="ConfigureAccountHistory?id=<?= $accountHistory->getId() ?>">
							<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
						</a>
					</td> -->
				</tr>
			<?php } ?>
		</table>
	</div>
</div>