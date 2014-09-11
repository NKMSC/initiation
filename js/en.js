//for english
e=document.getElementById("error");
var s=document.getElementsByTagName('select');
for (var i = 0; i < s.length; i++) {
	s[i].style.background="#222";
	s[i].style.color="#444";
	s[i].onclick=function(){
		// this.style.background="rgb(56,46,44,0.8)";
		this.style.color="#58FE50";
		o=this.options;
		for (var i = o.length - 1; i >= 0; i--) {
			if(!o[i].disabled){
				o[i].style.color=o[i].selected?'#FFF':'green';

			}else{
				o[i].color="#444";
			}
		};
	}
	s[i].onfocus=function(){
		this.style.background="#d0ecfd";
		this.style.color="green";
	}

};

function nc(s){
	s.style.color="white";
	s.style.background="#222";
}

function err(id,msg){
	var n=document.getElementById('e-'+id);
	if(!n) e.innerHTML+='<div id="e-'+id+'" onclick="go(\''+id+'\');" class="error-tip">'+msg+'</div>';
}

function rmv_err(id){
	if(id){
		var n=document.getElementById('e-'+id);
		if(n) e.removeChild(n);
	}else{
		e.innerHTML='';
	}
}
function go(id){
	rmv_err();
	document.getElementById(id).focus();
}

function V(s){
	return document.getElementById(s).value;
}

function isNull( s ){ 
	if ( s == ""|s==null ) return true; 
	var r =/"^[ ]+$"/; 
	return r.test(s); 
} 

function select(s,v){
	var o=s.options;
	for (var i = o.length - 1; i >= 0; i--) {
		if(o[i].value==v)
		{
			o[i].selected=true;
			o[i].style.color="#FFF";
			s.style.color="#FFF";			
			return true;
		}
	}
}

function checkid( id ){   
	var r = /^[0-9]{4,}[x|x]?$/; 
	if( r.test(id))
	{
		var auto=arguments[1]?arguments[1]:true;
		if(auto){
			var g=document.getElementById('grade');
			switch(id.substr(0,2)){
				case '11'://11级大四
				select(g,'大四');
				break;

				case '12'://大三
				select(g,'大三');
				break;
				case '13':select(g,'大二');
				break;
				case '14':select(g,'大一');
				break;
			}
		}
		rmv_err('id');
		return true;
	}else{
		err('id','Please fill in the student ID for verification');
		return false;
	}
}
function checkname( n ){
	var r = /^((([\u4E00-\uFA29]|[\uE7C7-\uE7F3]){2,8})|[A-Za-z]{3,50})$/;   
	if(r.test(n)){
		rmv_err('name');
		return true;
	}else{
		err('name',"Please fill in your name. It is better to use your Chinese Name ！");
		return false;
	}
}
function checkgender(){

	var R=document.getElementsByName('gender');
	for (var i =R.length - 1; i >=0; i--) {
		if(R[i].checked)
		{
			rmv_err('gender');
			return true;
		}
	};
	err('gender','check your gender!')
	return false;
}

function checkcollege(c){
	if(isNull(c))
	{
		err('college','Please select your college, if your college is not in this form please select “Other College”, and note in comment！');
		return false;
	}else{
		rmv_err('college');
		return true;
	}
}

function checkgrade(g){
	if(isNull(g))
	{
		err('grade','Please select your grade! if you are not a student, please select " “Others",and Note in Comment！');
		return false;
	}else{
		rmv_err('grade');
		return true;
	}
}
function checkphone(p){
	var r =/^1[3458]{1}\d{9}$/; 
	if(r.test(p))
	{
		rmv_err('phone');
		return true;
	}else{
		err('phone','Please write your phone number(11-digit) in China !(we will send important notice by SMS)');
		return false;
	}
}
function checkemail(e) { 
	var r= /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/; 
	if(r.test(e)){
		rmv_err('email');
		return true;
	}else{
		err('email',"Please write your email address correctly! ( we will tell you the progress and details via email. )");
		return false;
	}
}
function checkdept1(d){
	if(isNull(d))
	{
		err('dept1','Please select the department  that you most wish to jion. (PS: Technology Department will have the written test)');
		return false;
	}else{
		var d2=document.getElementById('dept2');
		var no=d2.options[0];
		no.disabled=false;
		no.text="No";
		no.value="无";
		for (var i = d2.options.length - 1; i >= 1; i--) {
			var o=d2.options[i];
			if(o.value==d){
				o.disabled=true;
				d2.style.color="#FFF";
			}else{
				o.disabled=false;
				o.selected=true;
			}
		};
		rmv_err('dept1');
		return true;
	}
}
function checkform(){
	var isok=true;
	
	var id=V('id');
	isok&=checkid(id,false);
	
	var name=V('name');
	isok&=checkname(name);

	isok&=checkgender();

	var college=V('college');
	isok&=checkcollege(college);

	var grade=V('grade');
	isok&=checkgrade(grade);

	var phone=V('phone');
	isok&=checkphone(phone);

	var email=V('email');
	isok&=checkemail(email);

	var dept1=V('dept1');
	isok&=checkdept1(dept1);

	return Boolean(isok);
};