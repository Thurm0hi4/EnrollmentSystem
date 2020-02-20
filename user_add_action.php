<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

// Suppress PHP auto warnings.
ini_set( "display_errors", 0);

// Get the values of the record to be inserted.
$clientid = trim($_POST["clientid"]);
if ($clientid == "") $clientid = "NULL";

$fname = $_POST["fname"];
$lname = $_POST["lname"];
$password = $_POST["password"];
$adminflag = $_POST["adminflag"];
$studentflag = $_POST["studentflag"];

// Form the insertion sql string and run it.
$sql = "insert into myclient values ('$clientid', '$fname', '$lname', '$password', to_number('$adminflag'), to_number('$studentflag'))";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Insertion Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i>

  <form method=\"post\" action=\"user_add?sessionid=$sessionid\">

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

// Record inserted.  Go back.
Header("Location:user.php?sessionid=$sessionid");
?>