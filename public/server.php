<?php
  ini_set('display_errors', 1);
?>
<?php
  require "../config.php";
  require "../common.php";
  if(isset($_GET["lat"]) && isset($_GET["lng"]))
  {
  try  {
      $connection = new PDO($dsn, $username, $password, $options);
      $lat = $_GET["lat"];
      $lng = $_GET["lng"];
      $random = rand(10000000, 99999999);
      $distance = 5;
      $sql = "SELECT COUNT(*) AS cnt
FROM ChicagoCrimes C1
WHERE (Primary_Type IN('HOMICIDE', 'BATTERY' ,'ASSAULT' ,'WEAPONS VIOLATION','ARSON' ,'CRIM SEXUAL ASSAULT','KIDKNAPPING','Murder'))
AND (3959 * ACOS (cos(radians(:lat))*COS(radians(C1.Latitude))*cos(radians(C1.Longitude)-radians(:lng))+sin(radians(:lat))*sin(radians(C1.Latitude)))<0.5)";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':lat', $lat);
    $statement->bindParam(':lng', $lng);
    //$statement->bindParam(':distance', $distance, PDO::PARAM_INT);

      $statement->execute();
      $cnt = $statement->fetchColumn();
      echo ($cnt);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
  }
?>
