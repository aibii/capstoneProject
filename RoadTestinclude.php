<?php
function WriteHeaders($Heading="Welcome",$TitleBar="MySite", $topdiv="")
{
  echo " 
    <!doctype html>
	<html lang = \"en\">
	<head>
		<meta charset = \"UTF-8\">
		<title>$TitleBar</title>\n
		<link rel =\"stylesheet\" type = \"text/css\" href=\"RoadTest.css\"/>
		<script type=\"text/javascript\" src =\"RoadTest.js\"></script>
	</head>
	<body>\n";
	echo "<div id=\"topParentDiv\">";
	echo "<div class=$topdiv><h1>$Heading - Kian Petroskie, Xavier Corneau</h1>\n
	</div></div>";
}
function DisplayLabel($prompt, $id1="")
{
  if ($id1 == "")
  	echo "<label>" . $prompt . "  " . "</label>";
  else
	echo "<label id = \"$id1\">" . $prompt . "  " . "</label>";
}
function DisplayTextbox($boxType, $Name, $Size, $Value=0)
{ 
  echo "<input type = $boxType name = \"$Name\" Size = $Size value = \"$Value\">";  
}
function DisplayImage($Filename, $Alt, $Height="400", $Width="400")
{
	echo "<img src=$Filename alt=$Alt height = $Height width = $Width>"; 
}
function DisplayButton($Name, $Text, $Filename="", $Alt="",$enabled="enabled")
{
	if ($Filename == "") 
	  echo "<button id=\"$Name\" name = \"$Name\" $enabled>$Text</button>";
	else
	{
	  echo "<button id=\"$Name\" name = \"$Name\" $enabled>"; 
	  DisplayImage($Filename,$Alt,35,85);
	  echo "</button>";
	}
}
function DisplayContactInfo()
{
  echo "<footer>Questions? Comments? You're out of luck.</footer>";
}
function WriteFooters()
{
  DisplayContactInfo(); 
  echo "</body>\n";
  echo "</html>\n";
}
function CreateConnectionObject()
{
	$fh = fopen('auth.txt','r');
	$Host =  trim(fgets($fh));
	$UserName = trim(fgets($fh));
	$Password = trim(fgets($fh));
	$Database = trim(fgets($fh));
	$Port = trim(fgets($fh)); 
	fclose($fh);
	$mysqlObj = new mysqli($Host, $UserName, $Password,$Database,$Port);
	// if the connection and authentication were successful, the error number is 0
	if ($mysqlObj->connect_errno != 0) 
	{
		echo "<p>Connection failed. Unable to open database $Database. 
		     Error: " . $mysqlObj->connect_error . "</p>";
		// stop executing the php script
		exit;
	}
	return ($mysqlObj);
}
?>