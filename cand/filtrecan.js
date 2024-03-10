var from=document.getElementById('form');
var slct=document.getElementById('domaine');
var slct2=document.getElementById('position');
const lastValue1c = localStorage.getItem('lastValue1c');
const lastValue2c = localStorage.getItem('lastValue2c');
if (lastValue1c) {
    slct.value = lastValue1c;
  }
  if(lastValue2c)
slct2.value = lastValue2c;
slct.onchange=function(){
    from.submit();
    localStorage.setItem('lastValue1c', slct.value);
}
slct2.onchange=function(){
    from.submit();
    localStorage.setItem('lastValue2c', slct2.value);
}