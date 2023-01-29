<?php
// http://localhost/RoadTestCapstoneTheShell/RoadTest.php
require_once("RoadTestInclude.php");
require_once("clsCreateRoadTestTable.php");
// main
date_default_timezone_set ('America/Toronto');
$mysqlObj; 
$TableName = "RoadTests"; 
writeHeaders("Road Test","Driverless Car", "topdiv");
if (isset($_POST['f_CreateTable']))
  createTableForm($mysqlObj,$TableName);
else
	if (isset($_POST['f_Save'])) saveRecordtoTableForm($mysqlObj,$TableName) ;
      else if (isset($_POST['f_AddRecord'])) addRecordForm($mysqlObj,$TableName) ;	   
        else if (isset($_POST['f_DisplayData'])) displayDataForm ($mysqlObj,$TableName);
		  else if (isset($_POST['f_Validate'])) validateForm($mysqlObj,$TableName);
		    else if (isset($_POST['f_ModifyRecord'])) modifyRecordForm($mysqlObj,$TableName) ;	
			else if (isset($_POST['f_FindExistingRecord'])) displayExistingRecordForm($mysqlObj,$TableName) ;	
		       else if (isset($_POST['f_WriteChangedRecordToTable'])) writeChangedRecordToTable($mysqlObj,$TableName) ;	
		          else displayMainForm();
if (isset($mysqlObj)) $mysqlObj->close();
echo "</div><div class=\"bottomdiv\">";
DisplayContactInfo(); 
echo "</div>";
echo "</body>\n";
echo "</html>\n";

function displayMainForm()
{
   echo "<form action=? method=post>";
   displayLabel("Welcome to my awesome program.");
   displayButton("f_CreateTable", "Create Table", "", "Create Tables");
   displayButton("f_AddRecord", "Add Record", "", "Add Record");
   displayButton("f_ModifyRecord", "Modify Record", "", "Modify Record");
   displayButton("f_DisplayData", "Display Data", "", "Display Data");
  	echo "</form>"; 
} // end displayMainForm

function createTableForm(&$mysqlObj,$TableName)
{
	echo "<form action=? method=post>"; 
	echo "<h2>Create Table Form</h2>";
	// type = button tells the browser not to refresh/reload the page
	echo "<div id=\"buttonDiv\">";
	displayButton("f_Main","Home","", "Home");
	echo "</div>";
	$createTable = new clsCreateRoadTestTable();
	$createTable->createTheTable($mysqlObj, $TableName);
	echo "</form>"; 
	
}
function validateForm(&$mysqlObj,$TableName)
{
	// this runs when they hit the validate button
	echo "here";
	addRecordForm($mysqlObj,$TableName);
	echo "</form>";
}

function addRecordForm(&$mysqlObj,$TableName)
{
    echo "<form action=? method=post>";
	echo "<h2>Road Test Data</h2>";
	// type = button tells the browser not to refresh/reload the page
	echo "<div class = \"flexBox\">";
	echo "<div class = \"leftBox\">";
		echo "<div id=\"buttonDiv\">";
		echo "<button type = \"button\" onclick = \"Validate()\" id=\"f_Validate\" name=\"f_Validate\">Validate</button>";
		echo "<button name = \"f_Save\" id = \"saveButton\" type = \"submit\" disabled>Save</button>";
		displayButton("f_Main","Home","", "Home");
		echo "</div>";
	echo "</div>";
	echo "<div class = \"rightBox\">";
		echo "<div class = \"datapair\">";
		echo "<div class=\"formLabel\">";
		displayLabel("License Plate");
		echo "</div>";
		$defaultValue = "woof";
		echo "<div class=\"formLabel\">";
		echo "<input type = text name = \"f_LicensePlate\" id = \"f_LicensePlate\" Size = 5 value = \"$defaultValue\">";  
		displayLabel("", "licenseError");
		echo "</div>";
		echo "<div class = \"datapair\">";
		echo "<div class=\"formLabel\">";
		displayLabel("Date Stamp");
		echo "</div>";
		$defaultValue= date('Y-m-d');
		echo "<div class=\"formLabel\">";
		echo "<input type = date name = \"f_DateStamp\" id = \"f_DateStamp\" Size = 10 value = \"$defaultValue\" >";  
		displayLabel("", "dateError");
		echo "</div>";
		echo "</div>";
		
		echo "<div class = \"datapair\">";
		echo "<div class=\"formLabel\">";
		displayLabel("Time Stamp");
		echo "</div>";
		echo "<div class=\"formLabel\">";
		displayTextbox ("time", "f_TimeStamp", 10, date('h:i')); 
		echo "</div></div>";
		
		echo "<div class = \"datapair\">";
		echo "<div class=\"formLabel\">";
		displayLabel("Number of Passengers");
		echo "</div>";
		echo "<div class=\"formLabel\">";
		displayTextbox ("number", "f_Passengers", 0, "3"); 
		echo "</div>";
		echo "</div>";
		echo "<div class = \"datapair\">";
		echo "<div class=\"formLabel\">";
		displayLabel("Incident free?");
		echo "</div>";
		echo "<input type=checkbox id=\"f_IncidentCheckbox\" name=\"f_IncidentCheckbox\" onclick = \"showHideControls()\">";
		echo "</div>";
		
		echo "<div id = \"hidden\"";
			echo "<div class = \"datapair\" >"; 
				echo "<div class=\"formLabel\">";
				displayLabel("Danger Status", "f_DangerStatusLabel");
			echo "</div>";
			$defaultValue = "Medium";
				echo "<div class=\"formLabel\">";
				echo "<select name=\"f_DangerStatus\" id =\"f_DangerStatus\" size=\"4\">"; 
				echo "<option selected id = \"Low\" value=\"Low\">Low</option>";
				echo "<option id = \"Medium\" value=\"Medium\">Medium</option>";
				echo "<option id = \"High\" value=\"High\">High</option>";
				echo "<option id = \"Critical\" value=\"Critical\">Critical</option> ";
		echo "</select></div>";
		echo "<div class = \"datapair\">";
			echo "<div class=\"formLabel\">";
			displayLabel("Speed (km/h)", "f_SpeedLabel");
		echo "</div>";
		$defaultValue = 100;
		echo "<div class=\"formLabel\">";
			echo "<input type = text name = \"f_Speed\" id = \"f_Speed\" Size = 5 value = \"$defaultValue\">";  
			displayLabel("", "speedError");
		echo "</div>";
		echo "</div>";
	echo "</div>";
	echo "</div>";
 	echo "</div>";
} //end addRecordForm  

function saveRecordtoTableForm(&$mysqlObj,$TableName) 
{ 
	echo "<form action=? method=post>";
	echo "<h2>Save Record to Table Form</h2>";
	// type = button tells the browser not to refresh/reload the page
	echo "<div id=\"buttonDiv\">";
	displayButton("f_Main","Home","", "Home");
	echo "</div>";
    $passengers = $_POST['f_Passengers'];
	$baseCost = 5000;
	$honarariumPerPassenger = 100;
	$cost = $baseCost + $honarariumPerPassenger * $passengers;
	$licensePlate = $_POST['f_LicensePlate']; 
	// dateTimeStamp is a datetime field but when it goes 
	// through bind it has to be a string, so build a string
	$dateTimeStamp = $_POST['f_DateStamp'] . " " .  $_POST['f_TimeStamp'];
	$passengers = $_POST['f_Passengers'];
	// isset avoids warning.  
	if (isset($_POST['f_IncidentCheckbox']))
	   $incident =  true;
	else
		$incident = false; 
	switch ($_POST['f_DangerStatus'])
	{
		case "Low":
			$dangerStatus = "L";
			break;
		case "Medium":
			$dangerStatus = "M";
			break;
		case "High":
			$dangerStatus = "H";
			break;
		case "Critical":
			$dangerStatus = "C";
			break;
	}
	$speed =$_POST['f_Speed'];
	$mysqlObj = CreateConnectionObject();
	$addRecord = "Insert Into $TableName Values (?, ?, ?, ?, ?, ?, ?)";
	try{
		$stmt = $mysqlObj->prepare($addRecord);  	 
		$stmt->bind_param("ssiisdd", $licensePlate, $dateTimeStamp, 
						$passengers, $incident,$dangerStatus, $speed, $cost); 
		$success = $stmt->execute();
		if ($success)
		echo "Record successfully added to " . $TableName;
	}
	catch (exception $e)
    {
       echo "Unable to add record to " . $TableName . ". No two license plates can have the same name."; 
	}
	echo "</form>"; 
   	$stmt->close();
 } 
function displayDataForm (&$mysqlObj,$TableName)
{
	echo "<form action=? method=post>";
	echo "<h2>Display Data Form</h2>";
	// type = button tells the browser not to refresh/reload the page
	echo "<div id=\"buttonDiv\">";
	displayButton("f_Main","Home","", "Home");
	echo "</div>";
	$mysqlObj = createConnectionObject(); 
	$query = "Select licensePlate, dateTimeStamp, nbrPassengers, incidentFree, 
	          dangerStatus, speed, cost from ";
    $query .= "$TableName Order by dangerStatus desc";
	$stmt = $mysqlObj->prepare($query);
	$stmt->bind_result($licensePlate, $dateTimeStamp, $nbrPassengers, $incidentFree, 
					   $dangerStatus, $speed, $cost);
	$stmt->execute();
	echo "<table border = \"1\"><th>License Plate</th><th>Date/Time Stamp</th>
	      <th># Passengers</th><th>Incident Free</th><th>Danger Status</th><th>Cost</th>";
	while ($stmt->fetch())
	{
		$dateTimeStamp = str_replace(" ", " at ", $dateTimeStamp);
		echo "<tr><td>$licensePlate</td><td>$dateTimeStamp</td>
	          <td>$nbrPassengers</td>";
		if ($incidentFree)
			echo "<td>Yes</td>";
		else
			echo "<td>No</td>";
		switch ($dangerStatus)
		{
			case "L":
				$dangerStatus = "Low";
				break;
			case "M":
				$dangerStatus = "Medium";
				break;
			case "H":
				$dangerStatus = "High";
				break;
			case "C":
				$dangerStatus = "Critical";
				break;
		}
		echo "<td>$dangerStatus</td><td>$cost</td></tr>";
	}
	echo "</table>";
	$stmt->close(); 
	echo "</form>";  
} // end displayDataform
function modifyRecordForm(&$mysqlObj,$TableName)
{
	echo "<form action=? method=post>";
	echo "<h2>Modify Record Form</h2>";
 	// type = button tells the browser not to refresh/reload the page
	echo "<div id=\"buttonDiv\">";
	displayButton("f_FindExistingRecord","Find Existing Record","", "Find Existing Record");
	echo "</div>";
 	displayLabel("License Plate");
    echo "<input type = text name = \"f_LicensePlate\">";
}
function displayExistingRecordForm(&$mysqlObj,$TableName)
{
	echo "<form action=? method=post>";
	$licensePlate = $_POST['f_LicensePlate'];
	$mysqlObj = createConnectionObject(); 
	echo "<h2>Road Test Data</h2>";
	// type = button tells the browser not to refresh/reload the page
	$query = "Select licensePlate, dateTimeStamp, nbrPassengers, incidentFree, 
	          dangerStatus, speed, cost from " . $TableName . " where licensePlate = '$licensePlate'" ;
	$stmt = $mysqlObj->prepare($query);
	$stmt->bind_result($licensePlate, $dateTimeStamp, $nbrPassengers, $incidentFree, 
						$dangerStatus, $speed, $cost);
	$stmt->execute();

	///
	
	while ($stmt->fetch())
	{
		switch ($dangerStatus)
		{
			case "L":
				$dangerStatus = "Low";
				break;
			case "M":
				$dangerStatus = "Medium";
				break;
			case "H":
				$dangerStatus = "High";
				break;
			case "C":
				$dangerStatus = "Critical";
				break;
		}
	}

	if($stmt->num_rows > 0)
	{
	echo "<div id=\"buttonDiv\">";
	echo "<button name = \"f_WriteChangedRecordToTable\" id = \"f_WriteChangedRecordToTable\">Write Changed Record</button>";
	displayButton("f_Main","Home","", "Home");
	echo "</div>";
	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("License Plate");
	echo "</div>";
    //$defaultValue = $licensePlate;
	echo "<div class=\"formLabel\">";
    echo "<input type = text name = \"f_LicensePlate\" id = \"f_LicensePlate\" Size = 5 value = \"$licensePlate\" readonly>";  
	echo "</div>";
	
	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("Date Stamp");
	echo "</div>";
    //$defaultValue= $dateTimeStamp;
	echo "<div class=\"formLabel\">";
	echo "<input type = date name = \"f_DateStamp\" id = \"f_DateStamp\" Size = 10 value = $dateTimeStamp >";  
	echo "</div>";
	echo "</div>";
	
	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("Time Stamp");
	echo "</div>";
	echo "<div class=\"formLabel\">";
	displayTextbox ("time", "f_TimeStamp", 10, date('H:i',strtotime($dateTimeStamp))); 
	echo "</div></div>";
	
	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("Number of Passengers");
	echo "</div>";

	echo "<div class=\"formLabel\">";
	displayTextbox ("number", "f_Passengers", 0, $nbrPassengers); 
	echo "</div>";
    echo "</div>";
	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("Incident free?");
	echo "</div>";
	if($incidentFree == true)
    	echo "<input type=checkbox id=\"f_IncidentCheckbox\" name=\"f_IncidentCheckbox\" checked>";
	else
	echo "<input type=checkbox id=\"f_IncidentCheckbox\" name=\"f_IncidentCheckbox\">";
 	echo "</div>";
	
    echo "<div class = \"datapair\" >"; 
	echo "<div class=\"formLabel\">";
	displayLabel("Danger Status", "f_DangerStatusLabel");
	echo "</div>";
	$defaultValue = "Medium";
	echo "<div class=\"formLabel\">";
	echo "<select name=\"f_DangerStatus\" id =\"f_DangerStatus\" size=\"4\">";
	switch ($dangerStatus)
		{
			case "Low":
				$LowSelect = "selected";
				break;
			case "Medium":
				$MedSelect = "selected";
				break;
			case "High":
				$HiSelect = "selected";
				break;
			case "Critical":
				$CriSelect = "selected";
				break;
		}
 	echo "<option $LowSelect id = \"Low\" value=\"Low\">Low</option>";
	echo "<option $MedSelect id = \"Medium\" value=\"Medium\">Medium</option>";
	echo "<option $HiSelect id = \"High\" value=\"High\">High</option>";
	echo "<option $CriSelect id = \"Critical\" value=\"Critical\">Critical</option> ";
	echo "</select></div></div>";

	echo "<div class = \"datapair\">";
	echo "<div class=\"formLabel\">";
	displayLabel("Speed (km/h)", "f_SpeedLabel");
	echo "</div>";
    
	echo "<div class=\"formLabel\">";
	echo "<input type = text name = \"f_Speed\" id = \"f_Speed\" Size = 5 value = \"$speed\">";  
 	echo "</div>";
 	echo "</div>";
	}
	else
	{
		echo "<div id=\"buttonDiv\">";
		displayButton("f_Main","Home","", "Home");
		echo "</div>";
		echo "No such Lisence Plate!";
	}
}

function writeChangedRecordToTable(&$mysqlObj,$TableName) 
{
	echo "<form action=? method=post>";
	echo "<h2>Change Confirmation</h2>";

    $passengers = $_POST['f_Passengers'];
	$baseCost = 5000;
	$honarariumPerPassenger = 100;
	$cost = $baseCost + $honarariumPerPassenger * $passengers;
	$licensePlate = $_POST['f_LicensePlate']; 
	// dateTimeStamp is a datetime field but when it goes 
	// through bind it has to be a string, so build a string
	$dateTimeStamp = $_POST['f_DateStamp'] . " " .  $_POST['f_TimeStamp'];
	$passengers = $_POST['f_Passengers'];
	// isset avoids warning.  
	if (isset($_POST['f_IncidentCheckbox']))
	   $incident =  true;
	else
		$incident = false; 
	switch ($_POST['f_DangerStatus'])
	{
		case "Low":
			$dangerStatus = "L";
			break;
		case "Medium":
			$dangerStatus = "M";
			break;
		case "High":
			$dangerStatus = "H";
			break;
		case "Critical":
			$dangerStatus = "C";
			break;
	}
	$speed =$_POST['f_Speed'];
	$mysqlObj = CreateConnectionObject();
	$updateRecord = "Update $TableName Set dateTimeStamp = ?, nbrpassengers = ?, incidentFree = ?,
	dangerStatus = ?, speed = ?, cost = ? where licensePlate = '$licensePlate'" ;
	try{
		$stmt = $mysqlObj->prepare($updateRecord);  	 
		$stmt->bind_param("siisdd", $dateTimeStamp, $passengers, $incident,$dangerStatus, $speed, $cost); 
		$success = $stmt->execute();
		if ($success)
			echo "Record successfully modified " . $TableName;
	}
	catch (exception $e)
    {
       echo "Unable to modify the record.";
	   echo $e;
	}
	$stmt->close();
   	
	displayButton("f_Main","Home","", "Home");
	echo "</form>"; 
}
?>