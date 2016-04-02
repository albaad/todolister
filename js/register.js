// Vérification données formulaire coté client

/* Vérifie que le champ n'est pas vide */
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

/* Change le background d'un champ si erreur = true */
function surligne(champ, erreur)
{
   if(erreur)
      champ.style.backgroundColor = "#fba";
   else
      champ.style.backgroundColor = "";
}

/* Vérifie que les mots de passe soient identiques */ 
function pwdCheck(pws2){
	if(document.register.pw2.value == document.register.pw.value){
		surligne(pw2, false);
	} else {
		document.register.pw2.value == "";
		surligne(pw2, true);
	}
}



function checkMail(email){
	
}


function checkDate(dnaiss){


}