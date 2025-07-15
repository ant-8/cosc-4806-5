<?php require_once 'app/views/templates/header.php' ?>
<main role="main" class="container">
	<div class="page-header" id="banner">
		<div class="row">
			<div class="col-lg-12">
				<h1>Create a New Reminder</h1>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-sm-auto">
			<form method="post" action="/reminders/create">
				<fieldset>
					<div class="form-group">
						<label for="subject">Subject</label>
						<input required type="text" class="form-control" id="subject" name="subject">
					</div>
					<br>
					<button type="submit" class="btn btn-primary">Create Reminder</button>
				</fieldset>
			</form>
		</div>
	</div>
</main>
<?php require_once 'app/views/templates/footer.php' ?>