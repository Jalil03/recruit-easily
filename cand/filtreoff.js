var from=document.getElementById('form');
var slct=document.getElementById('domaine');
var slct2=document.getElementById('ville');
var slct3=document.getElementById('type_offre');
const lastValue1r = localStorage.getItem('lastValue1r');
const lastValue2r = localStorage.getItem('lastValue2r');
const lastValue3r = localStorage.getItem('lastValue3r');

if (lastValue1r) 
slct.value = lastValue1r;
if(lastValue2r)
slct2.value = lastValue2r;
if(lastValue3r)
slct3.value = lastValue3r;
slct.onchange=function(){
   
    from.submit();
    localStorage.setItem('lastValue1r', slct.value);
}
slct2.onchange=function(){
    from.submit();
    localStorage.setItem('lastValue2r', slct2.value);
}
slct3.onchange=function(){
    from.submit();
    localStorage.setItem('lastValue3r', slct3.value);
}

// meme logique que filtercan , mais la diff est que ce code est destinee au recruteur 

