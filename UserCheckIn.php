<?php
if (isset($_GET['submit'])) {
    require_once'count_user_checkin.php';
    // kalo start-date atau end-date kosong, ganti dengan tanggal hari ini
    $start = date('Y-m-d', strtotime($_GET['start-date'] ?: 'today'));
    $end = date('Y-m-d', strtotime($_GET['end-date'] ?: 'today'));
    echo count_user_checkin_between($_GET['username'], $start, $end);
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" type="text/css" href="css/usercheckin.css">
  <title>Check In</title>
</head>
<body>
  <div class="mainFrame">
    <?php include'header.php';?>
    <main>
      <section>
      <form action="UserCheckIn.php">
        <table>
          <td>
<p>User :  . 
</td>
<td><select name="username">
        <?php
            require'connectDB.php';
            $sql = "SELECT * FROM user WHERE NOT username='' ORDER BY id ASC";
            $result = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($result, $sql)) {
                echo '<p class="error">SQL Error</p>';
            }
            else{
              mysqli_stmt_execute($result);
                $resultl = mysqli_stmt_get_result($result);
              if (mysqli_num_rows($resultl) > 0){
                  while ($row = mysqli_fetch_assoc($resultl)){
          ?>
                  <option value="<?=$row['username']?>"><?=$row['username']?></option>
        <?php
                }   
            }
          }
        ?>
</td>
</table>
</select></p>
<p>Tanggal Awal:<input type="date" name="start-date"></p>
<p>Tanggal Akhir:<input type="date" name="end-date"></p>
<input type="submit" name="submit" value="Submit">

</form>

        <?php } ?>
      </section>
    </main>
  </div>
</body>
</html>
