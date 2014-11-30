<div class="panel panel-default">
	<div class="panel-heading">
		<h2 class="panel-title">Account</h2>
	</div>
	<div class="panel-body">
		<h2>Account</h2>
		<h3>Id:</h3>
		<p><?= $data->getId() ?></p>
		<h3>Name:</h3>
		<p><?= $data->getName() ?></p>
		<h3>Creation date:</h3>
		<p><?= $data->getCreationDate() ?></p>
	</div>
	<div class="panel-footer"><a href="javascript:history.back()">Back</a></div>
</div>