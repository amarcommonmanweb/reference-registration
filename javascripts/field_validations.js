/**
 * @author Amar
 */

var error_fields = new Array();


// is not blank
function v0(elem){
	if(elem.value.length == 0){		
		return false;
	}
	return true;	
}

// is alphabetic
function v1(elem){
	var alphaExp = /^[a-zA-Z\s]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		
		return false;
	}	
}

// is numeric
function v2(elem){
	var numericExpression = /^[0-9]+$/;
	if(elem.value.match(numericExpression)){
		return true;
	}else{
		return false;
	}		
}

// is alpha numeric
function v3(elem){
	// NOT allowing dot comma and space also
	//var alphaExp = /^[0-9a-zA-Z\s\.\,]+$/;
	var alphaExp = /^[0-9a-zA-Z\s]+$/;
	if(elem.value.match(alphaExp)){
		return true;
	}else{
		return false;
	}	
}

// is selected  - drop downs and date pickers
function v4(elem){
	if((elem.value == '') || (elem.value == '0') || (elem.value == 0)) {
		return false;
	}else{
		return true;
	}	
}

// is enabled - for any element
function v5(elem){
	if(elem.diabled == true){
		return false;
	}	
	return true;
}

// is email
function v6(elem){	
	var emailExp = /^[a-zA-Z0-9\.\+\_\-]+\@[a-zA-Z0-9\.\-]+\.[a-zA-Z0-9]{2,4}$/;
	if(elem.value.match(emailExp)){		
		return true;
	}else{		
		return false;
	}	
}

//is date
function v7(elem){
	var dateExp = /^(((0[1-9]|[12]\d|3[01])\/(0[13578]|1[02])\/((19|[2-9]\d)\d{2}))|((0[1-9]|[12]\d|30)\/(0[13456789]|1[012])\/((19|[2-9]\d)\d{2}))|((0[1-9]|1\d|2[0-8])\/02\/((19|[2-9]\d)\d{2}))|(29\/02\/((1[6-9]|[2-9]\d)(0[48]|[2468][048]|[13579][26])|((16|[2468][048]|[3579][26])00))))$/;
	if(elem.value.match(dateExp)){
		return true;
	}else{
		return false;
	}	
}

//is radio chosen - 2 elements
function v8(elem1, elem2){	
	if(elem1.checked){
		return true;
	}
	else if(elem2.checked){
		return true;
	}	
	return false;	
} 

// is length
function v9(elem,length)
{
	var val = elem.value;
	if(val.length >= length){
		return true;
	}
	else{
		return false;
	}
}


//is username
function v10(elem){
	
	//allowing dot comma and space also
	var alphaExp = /^[0-9a-zA-Z\.\_]+$/;
	if(elem.value.match(alphaExp) || elem.value == ''){
		return true;
	}else{
		return false;
	}	
}


//is password
function v11(elem){
	
	/*
	 * At least 7 chars
		At least 1 uppercase char (A-Z)
		At least 1 number (0-9)
		At least one special char
	 */
	var alphaExp = /^.*(?=.{7,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9]).*$/;
	if(elem.value.match(alphaExp) || elem.value == ''){
		return true;
	}else{
		return false;
	}	
}


function is_username(elem){
	if(v10(elem) && v9(elem,3)){
		return true;
	}
	else
	{
		return false;
	}
}



//END OF Validations file

