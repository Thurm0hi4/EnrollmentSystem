<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);


$q_clientid = $_GET["clientid"];


// Fetech the record to be deleted and display it
$sql = "select clientid, fname, lname, password, adminflag, studentflag from myclient where clientid = '$q_clientid'";
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

if (!($values = oci_fetch_array ($cursor))) {
  // Record already deleted by a separate session.  Go back.
  Header("Location:user.php?sessionid=$sessionid");
}
oci_free_statement($cursor);

$clientid = $values[0];
$fname = $values[1];
$lname = $values[2];
$password = $values[3];
$adminflag = $values[4];
$studentflag = $values[5];

// Display the record to be deleted.
echo("
  <form method=\"post\" action=\"user_delete_action.php?sessionid=$sessionid\">
  Id (Read-only): <input type=\"text\" readonly value = \"$clientid\" size=\"10\" maxlength=\"10\" name=\"clientid\"> <br />
  Firstname: <input type=\"text\" disabled value = \"$fname\" size=\"20\" maxlength=\"30\" name=\"fname\">  <br />
  Lastname: <input type=\"text\" disabled value = \"$lname\" size=\"20\" maxlength=\"30\" name=\"lname\">  <br />
  Password: <input type=\"text\" disabled value = \"$password\" size=\"10\" maxlength=\"12\" name=\"password\">  <br />
  Administrator: <input type=\"text\" disabled value = \"$adminflag\" size=\"1\" maxlength=\"1\" name=\"adminflag\">  <br />
  Student: <input type=\"text\" disabled value = \"$studentflag\" size=\"1\" maxlength=\"1\" name=\"studentflag\">  <br />
  <input type=\"submit\" value=\"Delete\">
  </form>

  <form method=\"post\" action=\"user.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");

?>
