
e=document.getElementById("error");

var s=document.getElementsByTagName('select');
for (var i = 0; i < s.length; i++) {
	s[i].style.background="#222";
	s[i].style.color="#444";
	s[i].onchange=function(){
		this.style.color="#FFF";
	}
	s[i].onclick=function(){
		o=this.options;
		for (var i = o.length - 1; i >= 0; i--) {
			if(!o[i].disabled){
				o[i].style.color=o[i].selected?'#FFF':'green';

			}else{
				o[i].color="#444";
			}
		};
	}
};

function err(id,msg){
	var n=document.getElementById('e-'+id);
	if(!n) e.innerHTML+='<div id="e-'+id+'"" onclick="go(\''+id+'\');" class="error-tip">'+msg+'</div>';
}

function rmv_err(id){
	var n=document.getElementById('e-'+id);
	if(n) e.removeChild(n);
}
function go(id){
	rmv_err(id);
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
		err('id','请填写正确的学号！(学号我们仅作为核实身份用^_^)');
		return false;
	}
}
function checkname( n ){
	var r = /^([\u4E00-\uFA29]|[\uE7C7-\uE7F3]){2,10}$/;   
	if(r.test(n)){
		rmv_err('name');
		return true;
	}else{
		err('name',"请输填写你的中文姓名！");
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
	err('gender','性别二选一!')
	return false;
}

function checkcollege(c){
	if(isNull(c))
	{
		err('college','请选择学院,如果列表中没有你所在的学院请选择“其他”，并在备注中说明！');
		return false;
	}else{
		rmv_err('college');
		return true;
	}
}

function checkgrade(g){
	if(isNull(g))
	{
		err('grade','请选择你本学期所在的年级,如果你不是南开大学的学生，请选择“其他”并在备注中说明！');
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
		err('phone','请填写,你的国内11位手机号!(方便我们短信通知你^_^)');
		return false;
	}
}
function checkemail(e) { 
	var r= /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/; 
	if(r.test(e)){
		rmv_err('email');
		return true;
	}else{
		err('email',"请填写正确的邮箱！(详细信息我们会发送邮件给你^_^)");
		return false;
	}
}
function checkdept1(d){
	if(isNull(d))
	{
		err('dept1','请选择你希望加入的部门！(技术部会有笔试(^▽^))');
		return false;
	}else{
		var d2=document.getElementById('dept2');
		for (var i = d2.options.length - 1; i >= 0; i--) {
			var o=d2.options[i];
			if(o.value==d){
				o.disabled=true;
			}else{
				o.disabled=false;
				if(!isNull(o.value)){
					o.selected=true;
			}else{//把备选选项变成不选择
				o.text='不选择';
			}
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
