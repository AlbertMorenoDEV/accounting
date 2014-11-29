<h2>List of Accounts</h2>
<table>
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