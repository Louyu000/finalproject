<?php // login_page.php
  require_once 'database_access.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");
  echo "<h1>Log In</h1>";
  if (isset($_POST['user_name'])&&
      isset($_POST['user_password']))
  {
    $user_name   = get_post($conn, 'user_name');
    $user_password    = get_post($conn, 'user_password');
    $query  = "SELECT * FROM logindata";
    $result = $conn->query($query);
    if (!$result) die ("Database access failed");
      $rows = $result->num_rows;
    $success_login = FALSE;
    for ($j = 0 ; $j < $rows ; ++$j)
  {
    $row = $result->fetch_array(MYSQLI_NUM);

    $r0 = htmlspecialchars($row[0]);
    $r1 = htmlspecialchars($row[1]);
    if($user_name==$r0 && $user_password==$r1)
      $success_login=TRUE;
  }
  if($success_login==TRUE){
      echo "<script>window.alert('Log in success')</script>";
  }
  else{
    echo "<script>window.alert('Wrong user_name or password')</script>";
  }
  $result->close();
}

  echo <<<_END
    <form action="login_page.php" method="post"><pre>
      user_name     <input type="text" name="user_name">
      user_password <input type="text" name="user_password">
  <br><input type="submit" value="Log In">
    </pre></form>
_END;
  $conn->close();
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
  
?>