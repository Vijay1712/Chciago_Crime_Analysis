<?php
  ini_set('display_errors', 1);
?>

<?php
  require "../config.php";
  require "../common.php";

  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT * FROM ChicagoCrimes
            LIMIT 250";

    $statement = $connection->prepare($sql);
    $statement->execute();

    $result = $statement->fetchAll();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
 ?>

 <?php require "templates/header.php"; ?>

<div class = "table">
  <h2 style="margin-top:0;">Update Crimes</h2>

  <table class = "center-table">
    <thead>
      <tr>
        <th>Date</th>
        <th>Block</th>
        <th>Primary Type</th>
        <th>Description</th>
        <th>Location</th>
      </tr>
    </thead>

    <tbody>
      <?php foreach ($result as $row) : ?>
        <tr>
          <td><?php echo escape($row["Date"]); ?></td>
          <td><?php echo escape($row["Block"]); ?></td>
          <td><?php echo escape($row["Primary_Type"]); ?></td>
          <td><?php echo escape($row["Description"]); ?></td>
          <td><?php echo escape($row["Location_Description"]); ?></td>
          <td><a href="update-one.php?ID=<?php echo escape($row["ID"]); ?>">Edit</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>

  </table>

  <a class = "getstarted" href="index.php">Back to home</a>
</div>
<?php require "templates/footer.php"; ?>
