email=document.getElementsByTagName('email');
for (var i = 0;	i < email.length;	i++) {
	email[i].innerHTML=email[i].innerHTML.replace('AT', '&#64;').replace('DOT', '&#46;');
};
var p = location.search.substr(1);
if(p){msg=decodeURI(p);
	if(msg){
		document.getElementById("info").innerHTML="<span>"+msg+"</span>";
	}
}