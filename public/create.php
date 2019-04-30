
<?php
  ini_set('display_errors', 1);
?>

<?php
  require "../config.php";
  require "../common.php";

  if (isset($_POST['submit'])) {
    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'])) die();
    try  {
      $connection = new PDO($dsn, $username, $password, $options);

      $random = rand(10000000, 99999999);

      $arrest = "False";
      if ($_POST['Arrest'] == "Yes") {
        $arrest = "True";
      }

      $domestic = "False";
      if ($_POST['Domestic'] == "Yes") {
        $domestic = "True";
      }


      $new_crime = array(
        "ID"                    => $random,
        "Date"                  => $_POST['Date'],
        "Block"                 => $_POST['Block'],
        "Primary_Type"          => $_POST['Primary_Type'],
        "Description"           => $_POST['Description'],
        "Location_Description"  => $_POST['Location_Description'],
        "Arrest"                => $arrest,
        "Domestic"              => $domestic,
        "Year"                  => date("Y"),
        "Updated_On"            => date('Y-m-d H:i:s', time())
      );

      $sql = sprintf(
        "INSERT INTO %s (%s) values (%s)",
        "ChicagoCrimes",
        implode(", ", array_keys($new_crime)),
        ":" . implode(", :", array_keys($new_crime))
      );

      $statement = $connection->prepare($sql);
      $statement->execute($new_crime);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
  }
?>

<?php require "templates/header.php"; ?>

  <?php if (isset($_POST['submit']) && $statement) : ?>
    <blockquote> Crime # <?php echo escape($random); ?> successfully added.</blockquote>
  <?php endif; ?>

  <div class = "form" >
    <h2 style = "margin-top:0;">Add a Crime</h2>

    <form method="post">

      <input name =  "csrf" type = "hidden" value = "<?php echo escape($_SESSION['csrf']); ?>" >

      <label for="Date">Date and Time</label>
      <input type="datetime-local" name="Date" id="Date">

      <label for="Block">Address Block</label>
      <input type="text" name="Block" id="Block">

      <label for="Primary_Type">Crime Type</label>
      <input type="text" name="Primary_Type" id="Primary_Type">

      <label for="Description">Description</label>
      <input type="text" name="Description" id="Description">

      <label for="Location_Description">Location Description (Apartment, Street, etc.)</label>
      <input type="text" name="Location_Description" id="Location_Description">

      <label for="Arrest"> Was an Arrest Made? </label>
      <input name = "Arrest" type = "radio" value = "Yes"/> Yes <br>
      <input name = "Arrest" type = "radio" value = "No"/> No <br>

      <label for="Domestic"> Was the Crime Domestic? </label>
      <input name = "Domestic" type = "radio" value = "Yes"/> Yes <br>
      <input name = "Domestic" type = "radio" value = "No"/> No <br>

      <input type="submit" name="submit" value="Submit">
    </form>

    <a class = "getstarted" href="index.php">Back to home</a>
  </div>
<?php require "templates/footer.php"; ?>
