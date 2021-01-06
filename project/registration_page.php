<?php // registration_page.php
  require_once 'database_access.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die("Fatal Error");
 /* echo<<< __END
  <h1> Registration Page </h1>
__END;
*/
  if (isset($_POST['user_name'])&&
      isset($_POST['user_password'])&&
      isset($_POST['user_email'])&&
      isset($_POST['user_birthday']))
  {
    $user_name   = get_post($conn, 'user_name');
    $user_password    = get_post($conn, 'user_password');
    $user_email = get_post($conn, 'user_email');
    $user_birthday = get_post($conn, 'user_birthday');
    $big = 0;
    $user_id;
    $query_search  = "SELECT * FROM logindata";
    $result_search = $conn->query($query_search);
    if (!$result_search) die ("Database access failed");
      $rows = $result_search->num_rows;
    for ($j = 0 ; $j < $rows ; ++$j)
  {
    $row = $result_search->fetch_array(MYSQLI_NUM);
    $temp = htmlspecialchars($row[4]);
    if($temp>$big)
      $big=$temp;
  }
  $user_id=$big+1;
  while(strlen($user_id)<6){
    $user_id= '0'.$user_id;
  }
    $query1    = "INSERT INTO logindata VALUES" .
      "('$user_name', '$user_password', '$user_email', '$user_birthday','$user_id');";
    $query2    =  "CREATE TABLE user$user_id(videourl VARCHAR(128),inorder SMALLINT,INDEX(videourl),PRIMARY KEY(inorder))ENGINE InnoDB;";
    $result1   = $conn->query($query1);
    if($result1)$result2   = $conn->query($query2);
    if (!$result1) echo "<script>window.alert('Registration failed -- user_name used');</script>";
    else echo "<script>window.alert('Registration Success');</script>";
}
  $query  = "SELECT * FROM logindata";
  $result = $conn->query($query);
  if (!$result) die ("Database access failed");
  $rows = $result->num_rows;
  $result->close();
  $conn->close();
  function get_post($conn, $var)
  {
    return $conn->real_escape_string($_POST[$var]);
  }
  echo "<script>document.location.href='regispage.html';</script>";
?>