<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

// Suppress PHP auto warning.
ini_set( "display_errors", 0);

// Obtain information for the record to be updated.
$clientid = $_POST["clientid"];
$fname = $_POST["fname"];
$lname = $_POST["lname"];
$password = $_POST["password"];
$adminflag = $_POST["adminflag"];
$studentflag = $_POST["studentflag"];


// Form the sql string and execute it.
$sql = "update myclient set fname = '$fname', lname = '$lname', password = '$password', adminflag = to_number('$adminflag'), studentflag = to_number('$studentflag') where clientid = '$clientid'";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Update Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i>

  <form method=\"post\" action=\"user_update?sessionid=$sessionid\">

  <input type=\"hidden\" value = \"1\" name=\"update_fail\">
  <input type=\"hidden\" value = \"$clientid\" name=\"clientid\">
  <input type=\"hidden\" value = \"$fname\" name=\"fname\">
  <input type=\"hidden\" value = \"$lname\" name=\"lname\">
  <input type=\"hidden\" value = \"$password\" name=\"password\">
  <input type=\"hidden\" value = \"$adminflag\" name=\"adminflag\">
  <input type=\"hidden\" value = \"$studentflag\" name=\"studentflag\">

  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

// Record updated.  Go back.
Header("Location:user.php?sessionid=$sessionid");
?>
