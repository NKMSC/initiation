// var form=document.forms[0];
e=document.getElementById("error");
function err(id,msg){
	var n=document.getElementById('e-'+id);
	if(!n) e.innerHTML+='<div id="e-'+id+'"" onclick="go(\''+id+'\');" class="error-tip">'+msg+'</div>';
}

function rmv_err(id){
	var n=document.getElementById('e-'+id);
	if(n) e.removeChild(n);
}

function V(s){
	if(s!='gender'){
		return document.getElementById(s).value;
	}else{

	}

}
function isNull( s ){ 
	if ( s == ""|s==null ) return true; 
	var r =/"^[ ]+$"/; 
	return r.test(s); 
} 

function go(id){
	rmv_err(id);
	document.getElementById(id).focus();
}

function checkid( id ){   
	var r = /^[0-9]{4,}[x|x]?$/; 
	if( r.test(id))
	{
		rmv_err('id');
		return true;
	}else{
		err('id','请填写正确的学号！(学号我们仅作为核实身份用!)');
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
		err('phone','请填写,你的国内11位手机号!(方便我们短信通知你)');
		return false;
	}
}
function checkemail(e) { 
	var r= /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/; 
	if(r.test(e)){
		rmv_err('email');
		return true;
	}else{
		err('email',"请填写正确的邮箱！(详细信息我们会发送邮件给你)");
		return false;
	}
}
function checkdept1(d){
	if(isNull(d))
	{
		err('dept1','请选择你希望加入的部门！');
		return false;
	}else{
		var d2=document.getElementById('dept2');
		for (var i = d2.options.length - 1; i >= 0; i--) {
			var o=d2.options[i];
			if(o.value==d){
				o.disabled=true;
			}else if(!isNull(o.value)) {
				o.disabled=false;
				o.selected=true;
			}
		};
		rmv_err('dept1');
		return true;
	}
}
function checkform(f){
	var id=V('id');
	var name=V('name');
	//var	gender=V('gender');
	var college=V('college');
	alert(id+name+gender+college);
	return false;
};