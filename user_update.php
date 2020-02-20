<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

// Verify where we are from, user.php or  user_update_action.php.
if (!isset($_POST["update_fail"])) { // from user.php
  // Fetch the record to be updated.
  $q_clientid = $_GET["clientid"];

  // the sql string
  $sql = "select clientid, fname, lname, password, adminflag, studentflag from myclient where clientid = '$q_clientid'";
  echo($sql);

  $result_array = execute_sql_in_oracle ($sql);
  $result = $result_array["flag"];
  $cursor = $result_array["cursor"];
  echo($sql);

  if ($result == false){
    display_oracle_error_message($cursor);
    die("Query Failed.");
  }

  $values = oci_fetch_array ($cursor);
  oci_free_statement($cursor);

  $clientid = $values[0];
  $fname = $values[1];
  $lname = $values[2];
  $password = $values[3];
  $adminflag = $values[4];
  $studentflag = $values[5];


}
else { // from user_update_action.php
  // Obtain values of the record to be updated directly.
  $clientid = $_POST["clientid"];
  $fname = $_POST["fname"];
  $lname = $_POST["lname"];
  $password = $_POST["password"];
  $adminflag = $_POST["adminflag"];
  $studentflag = $_POST["studentflag"];
}

// Display the record to be updated.
echo("
  <form method=\"post\" action=\"user_update_action.php?sessionid=$sessionid\">
  Id (Read-only): <input type=\"text\" readonly value = \"$clientid\" size=\"10\" maxlength=\"10\" name=\"clientid\"> <br />
  Firstname (Required): <input type=\"text\" value = \"$fname\" size=\"20\" maxlength=\"30\" name=\"fname\">  <br />
  Lastname (Required): <input type=\"text\" value = \"$lname\" size=\"20\" maxlength=\"30\" name=\"lname\">  <br />
  Password: <input type=\"text\" value = \"$password\" size=\"10\" maxlength=\"12\" name=\"password\">  <br />
  Admin: <input type=\"text\" value = \"$adminflag\" size=\"1\" maxlength=\"1\" name=\"adminflag\">  <br />
  Student: <input type=\"text\" value = \"$studentflag\" size=\"1\" maxlength=\"1\" name=\"studentflag\">  <br />
  <input type=\"submit\" value=\"Update\">
  <input type=\"reset\" value=\"Reset to Original Value\">
  </form>

  <form method=\"post\" action=\"user.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>
  ");
?>
