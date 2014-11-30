<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">List of Accounts</h2>
	</div>
	<div class="panel-body">
		<table class="table">
			<tr>
				<th>id</th>
				<th>Name</th>
				<th>Creation date</th>
			</tr>
			<?php foreach ($data as $account) { ?>
				<tr>
					<td><a href="ViewAccount?id=<?= $account->getId() ?>"><?= $account->getId() ?></a></td>
					<td><?= $account->getName() ?></td>
					<td><?= $account->getCreationDate() ?></td>
				</tr>
			<?php } ?>
		</table>
	</div>
</div>