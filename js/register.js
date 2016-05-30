/* Client-side form data verification */

/* Verifies field is not empty */
function checkFields(champ)
{
   if(champ.value.length == 0)
   {
   	  champ.value = "";
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

/* Changes field background if erreur = true */
function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

/* Verifies passwords match */
function pwdCheck(pws2){
	if(document.register.pw2.value == document.register.pw.value){
		surligne(pw2, false);
	} else {
		document.register.pw2.value == "";
		surligne(pw2, true);
	}
}

/* Verfies email format */
function checkMail(email){

}
