var exp=document.getElementById('exp');
var btn=document.getElementById('ajt');
var err=document.getElementById('msger');
var sup=document.getElementById('sup');
var form=document.getElementById('formation');
var btn1=document.getElementById('add');
var err1=document.getElementById('msg');
var sup1=document.getElementById('delete');

var i=1;
var j=1;
var tab=[];
var tab1=[];
    btn.onclick=function(e){
        e.preventDefault();
        
        if(i<=5){
            
            tab.push({
                expr: document.getElementsByName('expr[]')[i-1].value,
                dated: document.getElementsByName('dated[]')[i-1].value,
                datef: document.getElementsByName('datef[]')[i-1].value,
                nomen: document.getElementsByName('nomen[]')[i-1].value,
                options: document.getElementsByName('options[]')[i-1].value
            });
        
         i++;
        exp.innerHTML+='<tr><td><input name="expr[]" type="text" placeholder="Enter your experience"></td></td><td><input name="dated[]" type="date"></td><td><input name="datef[]" type="date"></td><td><input name="nomen[]" type="text" placeholder="Enter the company name "></td> <td><select name="options[]" id="options"> <option value="WORK">WORK</option><option value="INTERNSHIP">INTERNSHIP</option> </select></td></tr>'; 
        
    }
        else{
            err.style.display='inline';
        }
         
    for(let j=0;j<tab.length;j++)
    {
    document.getElementsByName('expr[]')[j].value = tab[j].expr;
    document.getElementsByName('dated[]')[j].value = tab[j].dated;
    document.getElementsByName('datef[]')[j].value = tab[j].datef;
    document.getElementsByName('nomen[]')[j].value = tab[j].nomen;
    document.getElementsByName('options[]')[j].value = tab[j].options; } 
        
    }

   
    sup.onclick = function(e) {
        e.preventDefault();
        if (i > 1) {
          exp.removeChild(exp.lastChild);
          tab.pop();
          i--;
          err.style.display = 'none';
        }
        
      }



      btn1.onclick=function(e){
        e.preventDefault();
        if(j<=5){
            tab1.push({
                educ: document.getElementsByName('educ[]')[j-1].value,
                dateS: document.getElementsByName('dateS[]')[j-1].value,
                dateE: document.getElementsByName('dateE[]')[j-1].value,
                nameS: document.getElementsByName('nameS[]')[j-1].value,
                options: document.getElementsByName('optionE[]')[j-1].value
            });
        form.innerHTML+='<tr> <td><input name="educ[]" type="text" placeholder="Enter your degree name"></td><td><input name="dateS[]" type="date"></td><td><input type="date" name="dateE[]"></td> <td><input type="text" name="nameS[]" placeholder="Enter your school name "></td><td><select name="optionE[]" class="optionE"> <option value="deug">DEUST/DEUG</option> <option value="lst">LST/LS</option><option value="master">MASTER</option><option value="cycle">CYCLE</option> <option value="phd">PHD</option><option value="phd">PHD</option> </select></td></tr>'; 
         j++;
    }
        else{
            err1.style.display='inline';
        }
        for(let k=0;k<tab1.length;k++)
        {
            document.getElementsByName('educ[]')[k].value=tab1[k].educ;
            document.getElementsByName('dateS[]')[k].value=tab1[k].dateS;
            document.getElementsByName('dateE[]')[k].value=tab1[k].dateE;
            document.getElementsByName('nameS[]')[k].value=tab1[k].nameS;
            document.getElementsByName('optionE[]')[k].value=tab1[k].options;
             
        }
    }

   
    sup1.onclick = function(e) {
        e.preventDefault();
        if (j > 1) {
          form.removeChild(form.lastChild);
          tab1.pop();
          j--;
          err1.style.display = 'none';
        }
        
      }
    