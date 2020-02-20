<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);


// Here we can generate the content of the welcome page
echo("<h1 align=\"center\"><font face=\"Times New Roman\" color\"#000080\">Student Menu is under construction</font></h1> <br />");

echo("<br />");
echo("Click <A HREF = \"logout_action.php?sessionid=$sessionid\">here</A> to Logout.");
?>
