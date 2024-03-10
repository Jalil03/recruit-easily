var not=document.getElementById('dropdown');
var msgs=document.getElementById('dp');
var cli=false;
not.onclick=function(){
   if(!cli){
    msgs.style.display="block"; 
    cli=true;
   }
   else{
    msgs.style.display="none"; 
    cli=false;
   }
}