/**
 * @author dreake
 */

 var xhr = createXHR();
 var url = 'system/translate.php';
 var debug = 1;
 
  // Auto focus text input
 document.getElementById('text').focus();
 // Set languages from cookies
 setLangsFromCookies();
 
 
 function createXHR(){
 	try{
		xhr = new XMLHttpRequest();
	} catch(e) {
		var versions = new Array("MSXML2.XMLHTTP.6.0", "MSXML2.XMLHTTP.5.0", "MSXML2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP", "Microsoft.XMLHTTP");
		var l = versions.length;
		for(var i=0; i<l && !xhr; i++){
			try{
				xhr = new ActiveXObject(versions[i]);
			} catch(e) {
				displayError('Error while creating XMLHttpObcject [createXHR()] ' + e.toString());
			}
		}
	}
	
	return xhr;
 }
 
 
 function process() {
 	if(xhr) {
		try{
			var data = getData();
			
			if(!data) return;
			
			
			xhr.open('POST', url, true);
			xhr.onreadystatechange = handleRequestStateChange;
			xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
			xhr.setRequestHeader('Content-length', data.length);
			xhr.setRequestHeader('Connection', 'close');
			xhr.send(data);
		} catch(e) {
			displayError('Error while connecting to server. [process()] ' + e.toString());
		}
	}
 }

 
 function handleRequestStateChange() { 
 	if (xhr.readyState == 4 && xhr.status == 200) {
		try {
			handleServerResponse();
		} catch (e) {
			displayError('Error while reading data [handleRequestStateChange()] ' + e.toString());
		}
	}
 }
 
 
 function handleServerResponse() {
	var result = document.getElementById('result');
	result.style.display = 'block';
	result.innerHTML = xhr.responseText;
	
 }
 
 
 function displayError(error) {
 	var msg = 'Wystąpił błąd. Spróbuj ponownie za 1 minutę. ';
	if(debug && error != undefined)
		msg += error;
		
	alert(msg)
 }

 
 function getData()	{
 	var text = document.getElementById('text').value;
 	var langFrom = document.getElementById('langFrom').value;
 	var langTo = document.getElementById('langTo').value;
	
	if(!text) return;
	
	if(langFrom != langTo)
		return 'text='+text+'&langFrom='+langFrom+'&langTo='+langTo
 }
 
 
 function stopForm(e){
 	if (e.stopPropagation) e.stopPropagation();
    else e.cancelBubble = true;

    if (e.preventDefault) e.preventDefault();
    else e.returnValue = false;
 }
 
 
 function replaceL(){
 	var langFrom = document.getElementById('langFrom');
	var langBuffor = langFrom.value;
 	var langTo = document.getElementById('langTo');
	langFrom.value = langTo.value;
	langTo.value = langBuffor;
	
	setCookie('langFrom', langFrom.value, 30);
	setCookie('langTo', langTo.value, 30);
 }
 
 
 function setCookie(name, value, expireDays) { 
 	var exp = new Date();     //set new date object
	
	exp.setTime(exp.getTime() + (1000 * 60 * 60 * 24 * expireDays)); 	
	
	document.cookie = name + "=" + escape(value) + "; path=/" + "; expires=" + exp.toGMTString();
 }
 
 function getCookie (name) {
    var dc = document.cookie;
    var cname = name + "=";

    if (dc.length > 0) {
      begin = dc.indexOf(cname);
      	if (begin != -1) {
	        begin += cname.length;
	        end = dc.indexOf(";", begin);
	        if (end == -1) end = dc.length;
			
	        return unescape(dc.substring(begin, end));
    	}
	}
    return null;
 }
 
 function setLangsFromCookies() {
 	var langFrom = document.getElementById('langFrom');
 	var langTo = document.getElementById('langTo');
	
	langFrom.value == getCookie('langFrom') ? null : langFrom.value = getCookie('langFrom')
	langTo.value == getCookie('langTo') ? null : langTo.value = getCookie('langTo')
 }
