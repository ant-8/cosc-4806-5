<?php require_once 'app/views/templates/header.php' ?>
<main role="main" class="container">
  <div class="page-header" id="banner">
    <div class="row">
      <div class="col-lg-12">
        <h1>Update Reminder</h1>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-sm-auto">
      <form method="post" action="/reminders/update/<?= $data['reminder']['id'] ?>">
        <fieldset>
          <div class="form-group">
            <label for="subject">Reminder Subject</label>
            <input type="text" class="form-control" id="subject" name="subject" value="<?= htmlspecialchars($data['reminder']['subject']) ?>" required>
          </div>
          <br>
          <button type="submit" class="btn btn-primary">Update Reminder</button>
        </fieldset>
      </form>
    </div>
  </div>
</main>
<?php require_once 'app/views/templates/footer.php' ?>