/* *****************************************************************************
* Title: Angie Stropp
* URL: http://www.angiestropp.com
***************************************************************************** */

/* console.log(); writes to the firebug console. */

/* ============================= AJAX FUNCTIONS ============================= */
// =============================================================================
// Function: saveChange
// Description: AJAX call to save any changes made by the user.
// Notes: 
// @param: identifier - level - record id (example 1-1)
// @return: 
// =============================================================================
function saveChange(identifier){
  // get required values
  var a = identifier.split('-');
  var level = a[0];
  var id = a[1];
  var checked = (document.getElementById(identifier).checked === true) ? '1' : '0';
  // execute request
  $.ajax({
    url: 'save-changes.php',
    data: 'id='+id+'&level='+level+'&checked='+checked,
    type: 'POST',
    success: function(textStatus){refreshHierarchy();},
    error: function(jqXHR,textStatus,errorThrown){ alert(errorThrown);}
  });
}

// =============================================================================
// Function: refreshHierarchy
// Description: 3) AJAX call to display the hierarchy after any modifications.
// Notes: Update the anatomical-hierarchy section without reloading the page.
// @param: 
// @return: 
// =============================================================================
function refreshHierarchy(){
  // get the xmlhttp object
  var xmlhttp = getXmlhttp();
  // data is ready to load
  xmlhttp.onreadystatechange = function(){
    if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
      document.getElementById('anatomical-hierarchy').innerHTML = xmlhttp.responseText;
    }
  };
  // execute request
  xmlhttp.open('GET','hierarchy.php',true);
  xmlhttp.send(null);
}

// =============================================================================
// Function: getXmlhttp
// Description: Create XMLHttpRequest object.
// Notes: 
// @param: 
// @return: XMLHttpRequest object.
// =============================================================================
function getXmlhttp(){
  if(window.XMLHttpRequest){
    // code for IE7+, Firefox, Chrome, Opera, Safari
    var xmlhttp = new XMLHttpRequest();
  }else{
    // code for IE6, IE5
    var xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
  }
  return xmlhttp;
}