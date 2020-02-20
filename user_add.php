<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);

//Heading
echo("<h1 align=\"center\"><font face=\"Times New Roman\" color=\"#000080\">Manage Users</font></h1> <br />");

// Generate the query section
echo("
  <form method=\"post\" action=\"user.php?sessionid=$sessionid\">
  Firstname: <input type=\"text\" size=\"20\" maxlength=\"30\" name=\"q_fname\">
  Lastname: <input type=\"text\" size=\"20\" maxlength=\"30\" name=\"q_lname\">
  <BR />
");

echo("
  </select>
  <input type=\"submit\" value=\"Search\">
  </form>

  <form method=\"post\" action=\"stuwelcome.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go to Student Site\">
  </form>

  <form method=\"post\" action=\"adminwelcome.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Go Back\">
  </form>

  <form method=\"post\" action=\"user_add.php?sessionid=$sessionid\">
  <input type=\"submit\" value=\"Add A New User\">
  </form>

");

// Interpret the query requirements
$q_fname = $_POST["q_fname"];
$q_lname = $_POST["q_lname"];

$whereClause = "";

if (isset($q_fname) and $q_fname != "") {
  $whereClause .= "fname like '%$q_fname%'";
}
else if (isset($q_lname) and $q_lname != "") {
  $whereClause .= "lname like '%$q_lname%'";
}
else if((isset($q_fname) and $q_fname != "") and (isset($q_lname) and $q_lname != "")) {
  $whereClause .= "fname like $q_fname and lname like $q_lname";
}


// Form the query statement and run it.
if ($whereClause == ""){
  $sql = "select clientid, fname, lname, adminflag, studentflag
    from myclient order by lname";
}
else {
  $sql = "select clientid, fname, lname, adminflag, studentflag
    from myclient where $whereClause order by lname";
}
//echo($sql);

$result_array = execute_sql_in_oracle ($sql);
$result = $result_array["flag"];
$cursor = $result_array["cursor"];

if ($result == false){
  display_oracle_error_message($cursor);
  die("Client Query Failed.");
}

// Display the query results
echo "<table border=1>";
echo "<tr> <th>Id</th> <th>Firstname</th> <th>Lastname</th> <th>Admin Flag</th> <th>Student Flag</th> <th>Update</th> <th>Delete</th></tr>";

// Fetch the result from the cursor one by one
while ($values = oci_fetch_array ($cursor)){
  $clientid = $values[0];
  $fname = $values[1];
  $lname = $values[2];
  $adminflag = $values[3];
  $studentflag = $values[4];
  echo("<tr>" .
    "<td>$clientid</td> <td>$fname</td> <td>$lname</td> <td>$adminflag</td> <td>$studentflag</td>".
    " <td> <A HREF=\"user_update.php?sessionid=$sessionid&clientid=$clientid\">Update</A> </td> ".
    " <td> <A HREF=\"user_delete.php?sessionid=$sessionid&clientid=$clientid\">Delete</A> </td> ".
    "</tr>");
}
oci_free_statement($cursor);

echo "</table>";

?>
