<?php
  ini_set('display_errors', 1);
?>

<?php include "templates/header.php"; ?>

<?php
  $src = "";
  $msg = "";
  if (isset($_POST['submit'])) {
    sleep(5);
    $year = $_POST['year'];
    $crime = $_POST['crime'];
    $count = 0;

    if ($crime == "Arson") {
      $src = "assets/arson.png";
      if ($year == "2017") {
        $count = 510.658;
      } else if ($year == "2018") {
        $count = 371.157;
      } else if ($year == "2019") {
        $count = 39.918;
      }
    } else if ($crime == "Robbery") {
      $src = "assets/robbery.png";
      if ($year == "2017") {
        $count = 18662.463;
      } else if ($year == "2018") {
        $count = 31009.424;
      } else if ($year == "2019") {
        $count = 50448.976;
      }
    } else if ($crime == "Homicide") {
      $src = "assets/homocide.png";
      if ($year == "2017") {
        $count = 1265.775;
      } else if ($year == "2018") {
        $count = 2052.336;
      } else if ($year == "2019") {
        $count = 3189.456;
      }
    } else if ($crime == "Narcotics") {
      $src = "assets/narcotics.png";
      if ($year == "2017") {
        $count = 14704.579;
      } else if ($year == "2018") {
        $count = 19712.124;
      } else if ($year == "2019") {
        $count = 26373.752;
      }
    } else if ($crime == "Kidnapping") {
      $src = "assets/kidnapping.png";
      if ($year == "2017") {
        $count = 147.193;
      } else if ($year == "2018") {
        $count = 174.174;
      } else if ($year == "2019") {
        $count = 208.423;
      }
    }
    $msg = "Number of " . $crime . " crimes expected in " . $year . ": " . $count;
  }
?>

<div class = "graph">
  <h2 style = "margin-top:0;">Predict Crimes</h2>

  <form method="post">
    <p> Which year do you want to predict?
      <br>
      <select id = "year" name="year">
        <option value="">Select...</option>
        <option value="2017">2017</option>
        <option value="2018">2018</option>
        <option value="2019">2019</option>
      </select>
    </p>

    <p> Which crime do you want to predict?
      <br>
      <select id = "crime" name="crime">
        <option value="">Select...</option>
        <option value="Arson">Arson</option>
        <option value="Robbery">Robbery</option>
        <option value="Homicide">Homicide</option>
        <option value="Narcotics">Narcotics</option>
        <option value="Kidnapping">Kidnapping</option>
      </select>
    </p>

    <input type="submit" name="submit" value="View Results">
  </form> <br>
  <img src = "<?php echo $src?>"/> <br> <br>
    <h1> <?php echo $msg?> </h1>
  <a class = "getstarted" href="index.php">Back to home</a>
</div>
