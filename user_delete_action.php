<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);


ini_set( "display_errors", 0);


$clientid = $_POST["clientid"];

// Form the sql string and execute it.
$sql = "delete from myclient where clientid = '$clientid'";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  // Error handling interface.
  echo "<B>Deletion Failed.</B> <BR />";

  display_oracle_error_message($cursor);

  die("<i>

  <form method=\"post\" action=\"user.php?sessionid=$sessionid\">
  Read the error message, and then try again:
  <input type=\"submit\" value=\"Go Back\">
  </form>

  </i>
  ");
}

// Record deleted.  Go back.
Header("Location:user.php?sessionid=$sessionid");
?>
