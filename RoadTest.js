// IMP: can issue js statments in console tab of Chrome F12
//console.log(variable)
function showHideControls()
{ 
    let currentVisibility;

    if(document.getElementById("f_IncidentCheckbox").checked)
        currentVisibility = "hidden";
    else
        currentVisibility = "visible";
    document.getElementById("hidden").style.visibility = currentVisibility;
}
function Validate()
{
    
    var LicensePlate, DateStamp, Speed;
    var isValid = true;
    //make save button start off disabled
    LicensePlate = document.getElementById("f_LicensePlate").value;
    DateStamp = new Date(document.getElementById("f_DateStamp").value);
    Speed = document.getElementById("f_Speed").value;
    ValidDate = new Date("2000-04-15");

    if (LicensePlate.trim() == "")
    {
        document.getElementById("licenseError").innerHTML = "Invalid license plate";
        isValid = false;
    }
    else
        document.getElementById("licenseError").innerHTML = "";


    if (document.getElementById("f_DangerStatus").value == "Critical" && Speed >= 50)
    {
        document.getElementById("speedError").innerHTML = "Too Fast";
        isValid = false;
    }
    else 
        document.getElementById("speedError").innerHTML = "";

    if (DateStamp <= ValidDate)
    {
        document.getElementById("dateError").innerHTML = "Invalid Date";
        isValid = false;
    }
    else 
        document.getElementById("dateError").innerHTML = "";
    
    document.getElementById("saveButton").disabled = (!isValid);
}
 