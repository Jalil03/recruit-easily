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



// explication code 

//Lorsque l'utilisateur interagit avec la première liste déroulante et sélectionne une option, cette valeur est stockée localement sous la clé 'lastValue1c' à l'aide de localStorage.setItem('lastValue1c', slct.value). Ensuite, lorsqu'il recharge la page ou revient à cette page ultérieurement, le code vérifie s'il existe une valeur précédemment enregistrée pour lastValue1c dans le stockage local, et s'il en trouve une, il l'applique comme la valeur actuelle de la première liste déroulante. Cela garantit que la dernière sélection de l'utilisateur est restaurée, offrant ainsi une meilleure expérience utilisateur.

// bref ce code permet de mémoriser les sélections précédentes dans les menus déroulants et de les restaurer lorsque la page est rechargée, tout en envoyant automatiquement le formulaire à chaque fois qu'une nouvelle sélection est effectuée. Cela offre une meilleure expérience utilisateur en préservant les choix précédents et en soumettant automatiquement les sélections mises à jour.