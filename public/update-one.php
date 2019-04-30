<?php
require "../config.php";
require "../common.php";
if (isset($_POST['submit'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $user =[
      "ID"                    => $_POST['ID'],
      "Date"                  => $_POST['Date'],
      "Block"                 => $_POST['Block'],
      "Primary_Type"          => $_POST['Primary_Type'],
      "Description"           => $_POST['Description'],
      "Location_Description"  => $_POST['Location_Description'],
    ];

    $sql = "UPDATE ChicagoCrimes
            SET
              Date = :Date,
              Block = :Block,
              Primary_Type = :Primary_Type,
              Description = :Description,
              Location_Description = :Location_Description
            WHERE ID = :ID";

  $statement = $connection->prepare($sql);
  $statement->execute($user);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}

if (isset($_GET['ID'])) {
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_GET['ID'];
    $sql = "SELECT ID, Date, Block, Primary_Type, Description, Location_Description FROM ChicagoCrimes WHERE ID = :ID";
    $statement = $connection->prepare($sql);
    $statement->bindValue(':ID', $id);
    $statement->execute();

    $user = $statement->fetch(PDO::FETCH_ASSOC);
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
} else {
    echo "Something went wrong!";
    exit;
}
?>

<?php require "templates/header.php"; ?>


  <div class = "form">
    <?php if (isset($_POST['submit']) && $statement) : ?>
      <?php echo escape($_POST['firstname']); ?> Crime successfully updated.
    <?php endif; ?>
    <h2 style = "margin-top:0;">Edit a Crime</h2>

    <form method="post">
        <?php foreach ($user as $key => $value) : ?>
          <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
          <input type="text" name="<?php echo $key; ?>" id="<?php echo $key; ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ? 'readonly' : null); ?>>
        <?php endforeach; ?>
        <br>
        <input type="submit" name="submit" value="Submit">
    </form>

    <a class = "getstarted" href="index.php">Back to home</a>
  </div>
<?php require "templates/footer.php"; ?>
