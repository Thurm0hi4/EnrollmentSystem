<?
include "utility_functions.php";

$sessionid =$_GET["sessionid"];
verify_session($sessionid);


// Here we can generate the content of the welcome page
echo("<h1 align=\"center\"><font face=\"Times New Roman\" color=\"#000080\">Administrator Menu</font></h1> <br />");
echo("<h3>");
echo("<UL>
  <LI><A HREF=\"user.php?sessionid=$sessionid\">Users</A></LI>
  </UL>");
echo("<UL>
  <LI><A HREF=\"stuwelcome.php?sessionid=$sessionid\">Student Site</A></LI>
  </UL>");
echo("</h3>");
echo("<br />");
echo("<br />");
echo("Click <A HREF = \"logout_action.php?sessionid=$sessionid\">here</A> to Logout.");
?>
