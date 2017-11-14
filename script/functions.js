function trim(b){
	var i=0;
	while(b.charAt(i)==" ")
	{
	i++;
	}
	b=b.substring(i,b.length);
	len=b.length-1;
	while(b.charAt(len)==" "){
	len--;
	}
	b=b.substring(0,len+1);
	return b;

}


//For Selecting/ deselecting check boxed
   function selectDeselect(field, isCheck) {
	   var boxes = document.getElementsByName(field);
	   var boxes_checked = anyChecked();
   
	   if(isCheck){
		   if(document.getElementsByName(isCheck)[0].checked) setChecks(true);
		   else setChecks(false);			
	   }else{
		   if(!boxes_checked) setChecks(true);
		   else setChecks(false);
	   }
   
	   function setChecks( setting ) {
		   for( var i=0; i < boxes.length; i++ ) {
			   boxes[ i ].checked = setting;
		   }
	   }
	   function anyChecked() {
		   for( var i=0; i < boxes.length; i++ ) {
			   if( boxes[i].checked == true) {
				   return (true);
			   } 
		   }
		   return (false);
	   }
   }

   //To check wheather user have selected box or not
   function anyChecked(field) {
	   var boxes = document.getElementsByName(field);
	   for( var i=0; i < boxes.length; i++ ) {
		   if( boxes[i].checked == true) {
			   return (true);
		   } 
	   }
	   return (false);
   }

   function checkSelection(field, name) {
	   ifAnyChecked(document.getElementsByName(field), name)
   }

   function ifAnyChecked(obj, name) {
	   var count = 0;
	   for( var i=0; i < obj.length; i++ ) {
		   if( obj[i].checked == false) {
			   count++;
		   } 
	   }

	   if(count > 0){
		   if(document.getElementById(name).checked){
			   document.getElementById(name).checked = false;
		   }
	   }
	   else {
		 document.getElementById(name).checked = true;
	   }
   }

function checkAll(frmObject){ 



	for(i=1; i<frmObject.chkRecordId.length; i++)

	{

		frmObject.chkRecordId[i].checked = frmObject.chkRecordId[0].checked;

	}

}
//For checking Null values
function isNull(aStr) {
	var index;		
	for (index=0; index < aStr.length; index++)
		if (aStr.charAt(index) != ' ')
			return false;
	return true;
}


function isAllSelect(frmObject){

	var flgChk = 0;

	for(i=1; i<frmObject.chkRecordId.length; i++)

	{

		if(frmObject.chkRecordId[i].checked == false)

		{

			flgChk = 1;

			break;

		}

	}

	if(flgChk == 1){

		frmObject.chkRecordId[0].checked = false;

	}else{

		frmObject.chkRecordId[0].checked = true;

	}

}

function isValidAddress(s){
	return isCharsInBag (s, "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-,'");
}
  
 function setStatus(strAction,strSection,frmObject) {
	if(changeStatus(strAction,strSection,frmObject)){
		frmObject.hidAllId.value = varAllId;
		frmObject.submit();
	}else{
		frmObject.hidAct.value = "";
	}
}

function changeStatus(strAction,strSection,frmObject){
	frmObject.hidAct.value = strAction;
	strAction = strAction.toLowerCase()
	varMsg = "Do you really want to "+ strAction + " the selected item(s)?";
	if(isAnySelect(frmObject)){
		if(confirm(varMsg)){	
			return true;	
		}else{
            return false;
        }
	}else{
		alert("Please select at least one item(s) to " + strSection + ".");
		return false;
	}
    return false;
}

var varAllId;
var isNS = (navigator.appName=="Netscape")?1:0; //verify for netscape/mozilla
function isAnySelect(frmObject){	
	varAllId = "";	
	for(i=1; i<frmObject.chkRecordId.length; i++)
	{   	
		if(frmObject.chkRecordId[i].checked == true) {
			if(varAllId == "") {				
				varAllId = frmObject.chkRecordId[i].value;
			}
			else {
				varAllId += "," + frmObject.chkRecordId[i].value;
			}				
		}	
	}
	
	if(varAllId == ""){
		return false;
	}else{
		return true;
	}
}

function confirmStatus(act) {
	if(!confirm("Are you sure you want to "+act+" the selected record?")) {
		return false;
	}
	else {
		return true;
	}
}

function redirectBrowser(url) {
	window.location.href = url;
	return false;

}

