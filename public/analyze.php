<?php include "templates/header.php"; ?>

<?php
  $src = "";
  if (isset($_POST['submit'])) {
    sleep(3);
    $formType = $_POST['formType'];
    if ($formType == "Years") {
      $src = "assets/years.png";
    } else if ($formType == "Months") {
      $src = "assets/months.png";
    } else if ($formType == "Days") {
      $src = "assets/days.png";
    } else if ($formType == "Hours") {
      $src = "assets/hours.png";
    } else if ($formType == 'Types of Crimes') {
      $src = "assets/types.png";
    }
  }
?>

<div class = "graph">
  <h2 style = "margin-top:0;">Analyze Crimes</h2>

  <form method="post">
    <p> What do you want to analyze crimes by?
      <br>

      <select id = "formType" name="formType">
        <option value="">Select...</option>
        <option value="Years">Years</option>
        <option value="Months">Months</option>
        <option value="Days">Days</option>
        <option value="Hours">Hours</option>
        <option value="Types of Crimes">Types of Crimes</option>
      </select>

    </p>
    <input type="submit" name="submit" value="View Results">
  </form> <br>
  <img src = "<?php echo $src?>"/> <br> <br>
  <a class = "getstarted" href="index.php">Back to home</a>
</div>
