	 	function createXMLHttpRequest() {
			var xmlhttp = false;
			if (window.XMLHttpRequest) {
				xmlhttp = new XMLHttpRequest();
			} else if(window.ActiveXObject) {
				try {
					xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
				} catch (e) {
					try {
						xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
					} catch (e) {
					xmlhttp = false;
					}
				}
			}
		return xmlhttp;
		}
function request(url,cadre) {
	var XHR = null;

	if(window.XMLHttpRequest) // Firefox
		XHR = new XMLHttpRequest();
	else if(window.ActiveXObject) // Internet Explorer
		XHR = new ActiveXObject("Microsoft.XMLHTTP");
	else { 
		alert("Votre navigateur ne supporte pas les objets XMLHTTPRequest...");
		return;
	}
	XHR.open("GET",url, true);

	XHR.onreadystatechange = function attente() {

	if(XHR.readyState == 4)     {

	document.getElementById(cadre).innerHTML = XHR.responseText;
   }
	}
	XHR.send(null);		
	return;
}

			function appelPHP(){
			var xhr = createXMLHttpRequest();
			xhr.open('GET', '../captcha/refresh.php', true);
			xhr.onreadystatechange = function (aEvt) {
				if (xhr.readyState == 4) {
					if(xhr.status == 200){
						document.getElementById('resultatAppel').innerHTML = xhr.responseText;
					}else{
						dump("Error loading page\n");
					}
				}
			}
			xhr.send(null);
		}
		
		
			
			
			 var divPrecedent=document.getElementById('NomCompte');
			
			function visibilite(thingId)
			{
				var targetElement;
				targetElement = document.getElementById(thingId) ;
				if (targetElement.style.display == "none")
				{
				targetElement.style.display = "" ;
				} else {
				targetElement.style.display = "none" ;
				}
			}
			
			function testEchap(e){
			var keynum;
			if(window.event) // IE
			  {
			  keynum = e.keyCode;
			  }
			else if(e.which) // Netscape/Firefox/Opera
			  {
			  keynum = e.which;
			  }
			//alert(keynum);
				if (keynum == 27) {
					document.getElementById("FormulaireConnexion").style.display = "none";
					document.getElementById("FormulaireInscription").style.display = "none";
					//window.location.reload();
				}
			}		// ]] -->
			
			function connexion_ajax(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../connexion/connexion.php";
				var login = document.getElementById("login_c").value;
				var password = document.getElementById("password").value;
				var checkbox = 1;
					var vars = "login="+login+"&password="+password;
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("message_connexion").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("message_connexion").innerHTML = '<div class="alert alert-info"> Connexion en cours</div>';
			}	


				function afficheId(baliseId) 
				  {
				  if (document.getElementById && document.getElementById(baliseId) != null) 
					{
					document.getElementById(baliseId).style.visibility='visible';
					document.getElementById(baliseId).style.display='block';
					}
				  }
				
				function cacheId(baliseId) 
				  {
				  if (document.getElementById && document.getElementById(baliseId) != null) 
					{
					document.getElementById(baliseId).style.visibility='hidden';
					document.getElementById(baliseId).style.display='none';
					}
				  }
				
				cacheId('contenu'); 


			function sendSupport(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../support/envois-support.php";
				
				var pseudo = document.getElementById("pseudo").value;
				
				var message = document.getElementById("message").value;
				var objet = document.getElementById("objet").value;
				
				var mail = document.getElementById("mail").value;
				var captcha = document.getElementById("captcha").value;
				
					var vars = "pseudo="+pseudo+"&message="+message+"&objet="+objet+"&mail="+mail+"&captcha="+captcha;
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("message_Support").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("message_Support").innerHTML = '<div class="alert alert-info"> Envois en cours...</div>';
			}	
			function voirItem(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../boutique/buy_object.php";
				var itemId = document.getElementById("itemId").value;
					var vars = "itemId="+itemId;
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("itemShow").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("itemShow").innerHTML = '<div class="alert alert-info"> Chargement</div>';
			}	
			
			function creationCommentaire(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../traitements/commentaires.php";
				var texte = document.getElementById("texte").value;
				var id_news = document.getElementById("id_news").value;
				
					var vars = "texte="+texte+"&id_news="+id_news;
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("creationCommentaire").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("creationCommentaire").innerHTML = '<div class="alert alert-info"> En cours de création.</div>';
			}	
			
			function addFriends(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../recherche/addFriends.php";
				var id = document.getElementById("id").value;
				
					var vars = "id="+id;
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("messageFriends").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("messageFriends").innerHTML = '<div class="alert alert-info"> En cours d\'ajout.</div>';
			}	
			
			function creationMessage(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../traitements/message.php";
				var message_texte = document.getElementById("message_texte").value;
				var message_id = document.getElementById("message_id").value;
				
					var vars = "message_texte="+message_texte+"&message_id="+message_id;
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("creationMessage").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("creationMessage").innerHTML = '<div class="alert alert-info"> En cours de création.</div>';
			}	
			
			function envoiMessage(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../traitements/createMessage.php";
				var message_texte = document.getElementById("message_texte").value;
				var titre = document.getElementById("titre").value;
				var destinataire = document.getElementById("destinataire").value;
				
					var vars = "message_texte="+message_texte+"&destinataire="+destinataire+"&titre="+titre;
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("envoiMessage").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("envoiMessage").innerHTML = '<div class="alert alert-info"> En cours de création.</div>';
			}	
			

			function creationCompte(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../connexion/creation-compte.php";
				
				var pseudo = document.getElementById("pseudo").value;
				
				var mdp = document.getElementById("mdp").value;
				var mdp_verif = document.getElementById("mdp_verif").value;
				
				var mail = document.getElementById("mail").value;
				var mail_verif = document.getElementById("mail_verif").value;
				var reponse = document.getElementById("reponse").value;
				
					var vars = "pseudo="+pseudo+"&mdp="+mdp+"&mdp_verif="+mdp_verif+"&mail="+mail+"&mail_verif="+mail_verif+"&reponse="+reponse;
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("message_Inscription").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("message_Inscription").innerHTML = '<div class="alert alert-info"> Enregistrement en cours</div>';
			}	

			function rechercher_joueur(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../recherche/traitement_AJAX.php";
				var inputSearch = document.getElementById("inputSearch").value;
					var vars = "&inputSearch="+inputSearch;
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("message_joueur").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("message_joueur").innerHTML = '<div class="alert alert-info"> Connexion en cours</div>';
			}	

			function vote_recompense(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../voter/traitement_AJAX.php";
				var inputSearch = document.getElementById("inputSearch").value;
					var vars = "&inputSearch="+inputSearch;
				
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("message_vote").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("message_vote").innerHTML = '<div class="alert alert-info"> Veuillez patienter</div>';
			}	

function ajax_out(){
    // Create our XMLHttpRequest object
    var hr = new XMLHttpRequest();
    // Create some variables we need to send to our PHP file
    var url = "../voter/confirmation-traitement.php";
    var fn = document.getElementById("out").value;
    var vars = "out="+fn;
    hr.open("POST", url, true);
    // Set content type header information for sending url encoded variables in the request
    hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    // Access the onreadystatechange event for the XMLHttpRequest object
    hr.onreadystatechange = function() {
	    if(hr.readyState == 4 && hr.status == 200) {
		    var return_data = hr.responseText;
			document.getElementById("status").innerHTML = return_data;
	    }
    }
    // Send the data to PHP now... and wait for response to update the status div
    hr.send(vars); // Actually execute the request
    document.getElementById("status").innerHTML = '<div class="alert alert-info"> Traitement en cours</div>';
}



			
			function achat_ajax(){
				// Create our XMLHttpRequest object
				var hr = new XMLHttpRequest();
				// Create some variables we need to send to our PHP file
				var url = "../payment/achat.php";
				var id = document.getElementById("id").value;
				var serveur = document.getElementById("serveur").value;
				var vars = "id="+id+"&serveur="+serveur;
				hr.open("POST", url, true);
				hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
				hr.onreadystatechange = function() {
					if(hr.readyState == 4 && hr.status == 200) {
						var return_data = hr.responseText;
						document.getElementById("message_id").innerHTML = return_data;
					}
				}
				hr.send(vars); // Actually execute the request
				document.getElementById("message_id").innerHTML = '<div class="alert alert-info"> Achat en cours</div>';
			}	
			
			function change_onglet(name)
			{
				document.getElementById('onglet_'+anc_onglet).className = 'onglet_0 onglet';
				document.getElementById('onglet_'+name).className = 'onglet_1 onglet';
				document.getElementById('contenu_onglet_'+anc_onglet).style.display = 'none';
				document.getElementById('contenu_onglet_'+name).style.display = 'block';
				anc_onglet = name;
			}
			function cinemamode() 
			{
			
			var div = document.getElementById("blackcinema");
			
				if(div.style.display == "none") 
				{
					div.style.display = "block";
				} 
				else 
				{
					div.style.display = "none";
				}
			}
			
function evalPwd(s)
{
	var cmpx = 0;
	
	if (s.length >= 6)
	{
		cmpx++;
		
		if (s.search("[A-Z]") != -1)
		{
			cmpx++;
		}
		
		if (s.search("[0-9]") != -1)
		{
			cmpx++;
		}
		
		if (s.length >= 8 || s.search("[\x20-\x2F\x3A-\x40\x5B-\x60\x7B-\x7E]") != -1)
		{
			cmpx++;
		}
	}
	
	if (cmpx == 0)
	{
		document.getElementById("weak").className = "nrm";
		document.getElementById("medium").className = "nrm";
		document.getElementById("strong").className = "nrm";
	}
	else if (cmpx == 1)
	{
		document.getElementById("weak").className = "red";
		document.getElementById("medium").className = "nrm";
		document.getElementById("strong").className = "nrm";
	}
	else if (cmpx == 2)
	{
		document.getElementById("weak").className = "yellow";
		document.getElementById("medium").className = "yellow";
		document.getElementById("strong").className = "nrm";
	}
	else
	{
		document.getElementById("weak").className = "green";
		document.getElementById("medium").className = "green";
		document.getElementById("strong").className = "green";
	}
} 
function Afficher_Block(thingId)
{
	var targetElement;
	targetElement = document.getElementById(thingId) ;
	if (targetElement.style.display == "none")
	{
	targetElement.style.display = "" ;
	} else {
	targetElement.style.display = "none" ;
	}
}

var counter = 25;
var intervalId = null;
function action()
{
  clearInterval(intervalId);
  document.getElementById("bip").innerHTML = '<input type="hidden" name="out" id="out" value="completed"><button type="submit" onClick="javascript:ajax_out();" class="btn btn-default"/>Continuer</button><div id="status"></div>';	
}
function bip()
{
  document.getElementById("bip").innerHTML = '<div class="alert alert-info"><i>Vérification du vote en cours ...</i></div>';
  counter--;
}
function start()
{
  intervalId = setInterval(bip, 1000);
  setTimeout(action, 25000);
}

window.setTimeout(function() 
{
    $("#divSmallBoxes").fadeTo(1000, 0).slideUp(1000, function()
    {
        $(this).remove(); 
    });
}, 5000);


function messageSupport(){
	// Create our XMLHttpRequest object
	var hr = new XMLHttpRequest();
	// Create some variables we need to send to our PHP file
	var url = "../traitements/reponse_ticket.php";
	var message = document.getElementById("message").value;
	
	var vars = "message="+message;
	
	hr.open("POST", url, true);
	hr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	hr.onreadystatechange = function() {
		if(hr.readyState == 4 && hr.status == 200) {
			var return_data = hr.responseText;
			document.getElementById("messageSupport").innerHTML = return_data;
		}
	}
	hr.send(vars); // Actually execute the request
	document.getElementById("messageSupport").innerHTML = '<div class="alert alert-info"> Chargement</div>';
}	