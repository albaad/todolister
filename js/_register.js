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



/**/
// fonction de vérification
function auChargement(){
	document.form1.boutonenv.disabled = true;
}

function checkFields(champ)
{
   if(champ.value.length < 2 || champ.value.length > 30)
   {
      surligne(champ, true);
      return false;
   }
   else
   {
      surligne(champ, false);
      return true;
   }
}

function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}


function checkCodePostal(code){
	var valeurN = code.value;
	if (isNaN(valeurN) || valeurN.length!=5) {
		alert("Il faut saisir un nombre entier de 5 caractère !!");
		document.form1.code.value = "";
		document.form1.code.focus();
	} else if(checkFields(document.form1.nom) && checkFields(document.form1.prenom) && checkFields(document.form1.adresse) && checkFields(document.form1.ville)){
	document.form1.boutonenv.disabled = false;
	}
}
