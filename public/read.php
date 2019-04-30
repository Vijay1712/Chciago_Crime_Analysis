<?php
  ini_set('display_errors', 1);
?>


<?php
  require "../config.php";
  require "../common.php";

  if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
      die();
    }

    $searchParam = $_POST['formType'];

    if ($searchParam == "") {
      echo "Search Parameter must be set!";
      die();
    }


    try {
      $connection = new PDO($dsn, $username, $password, $options);
      $sql = "";
      if ($searchParam == "Type") {
        $sql = "SELECT *
              FROM ChicagoCrimes
              WHERE Primary_Type LIKE concat('%', :search, '%')
              LIMIT 250";
      } else if ($searchParam == "ID") {
        $sql = "SELECT *
                FROM ChicagoCrimes
                WHERE ID = :search";
      } else if ($searchParam == "Description") {
        $sql = "SELECT *
                FROM ChicagoCrimes
                WHERE Description LIKE concat('%', :search, '%')
                LIMIT 250";
      } else if ($searchParam == "Price") {
        $sql = "SELECT * FROM (SELECT *
                FROM ChicagoCrimes
                NATURAL JOIN HousingPrices) AS T
                WHERE houseMedian <= :search
                LIMIT 250";
      }

  $search = $_POST['search'];
  $statement = $connection->prepare($sql);
  $statement->bindParam(':search', $search, PDO::PARAM_STR);
  $statement->execute();

  $result = $statement->fetchAll();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }

  }

?>

<?php include "templates/header.php"; ?>

<?php
if (isset($_POST['submit'])) {
  if ($result && $statement->rowCount() > 0) { ?>
    <div class = "table">
      <h2 style="margin-top:0;">Results</h2>

      <table class = "center-table">
        <thead>
          <tr>
            <th>Date</th>
            <th>Block</th>
            <th>Primary Type</th>
            <th>Description</th>
            <th>Location Description</th>
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
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <?php } else { ?>
      <blockquote>No results found for <?php echo escape($_POST['search']); ?>.</blockquote>
    <?php }
} ?>
    <div class = "form">
      <h2 style = "margin-top:0;">Find crime based on details</h2>

      <form method="post">
        <input name="csrf" type="hidden" value="<?php echo escape($_SESSION['csrf']); ?>">
        <p> What do you want to search by?
          <br>

          <select id = "formType" name="formType">
            <option value="">Select...</option>
            <option value="ID">ID</option>
            <option value="Description">Description</option>
            <option value="Type">Type</option>
            <option value="Price">Median Housing Price (Less than)</option>
          </select>

        </p>
      	<label for="search">Search</label>
      	<input type="text" id="search" name="search"> <br> <br>
      	<input type="submit" name="submit" value="View Results">
      </form> <br>
      <a class = "getstarted" href="index.php">Back to home</a>
    </div>
    <?php require "templates/footer.php"; ?>
