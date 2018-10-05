/*
 *	This file contains general javascript code
 *	@author: Oguntuberu Nathan O.
 *	@date: 16-07-2018
*/
class System{
    constructor(msgBox)
    {
        this.msgBox = msgBox;
    }
    
    createAjaxObject()
    {
		/*	*/
        var AjaxObject;
        try{
            AjaxObject = new XMLHttpRequest();
        }catch(e){
            try{
                AjaxObject = new ActiveXObject('Msxml2.XMLHTTP');
            }catch(ea){
                try{
                    AjaxObject = new ActiveXObject('Microsoft.XMLHTTP');
                }catch(eb){
                    AjaxObject = false;
                }
            }
        }
        return AjaxObject;
    }
	
    displayFormMessage(msg_body, msg_type)
    {
        /*
         *  This displays a defined message to the screen
        */
        var element = document.getElementById(this.msg_box);
        element.innerHTML = msg_body;
        element.style.display = "block";
        switch(msg_type){
            case 1: //  1 is for a good message
                element.style.backgroundColor = '#3FAF7D';
                break;
            case 2: //  2 is for a process
                element.style.backgroundColor = '#83B2C1';
                break;
            default: // else there is a problem
                element.style.backgroundColor = '#EA9F9F';                
        }
        setTimeout(function(){
            element.style.display = "none";
        }, 2000);
    }
	
    getTimeStamp()
    {
        /*  Returns number of seconds since midnight January 1st, 1970  */
        var milliTime = new Date().getTime().toString();
        milliTime = milliTime.substring(0, (milliTime.length - 3));
        return milliTime;
    }
	
    getHash(value)
    {
        let req = System.createAjaxObject();
        req.open('get', './processes/get-hash.php?val='+value);
        req.send(null);
        
        req.onreadystatechange = function(){
            if(req.readyState === 4)
            {
                return req.responseText;  
            }
        };
    }
    gotoPage(page_uri)
    {
        window.location = page_uri;
    }
}