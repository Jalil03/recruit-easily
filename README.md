# job-portal

I . Dossier Register: 
   Ce dossier contient les formulaires d'inscription pour les candidats et le recruteurs ( le processus d'inscription est sur plusieurs pages)
         
II . Dossier cand:
    Ce dossier contient:
       la page où on affiche les offres: Offers.php
       la page où on affiche les candidats: 
       le profile (candidat ou recruteur) 
       
    
/////////////////////////////////////////////////////////////////////////////////////////////////////////////



Dans register :

-> addrec + register-rec : utiliser lorsqu'un recrueur veut faire le sign up , cad(entrer pour la premiere fois)  

-> adduser , register-cand : utiliser lorsque le candidat veut faire le sign up , cad (entrer pour la premiere fois)

-> addcom pour calculer le score

-> database : contient les infos de la base de donnes 

-> form-candidat : contient si le user au debut veut etre un rec ou candidat 

-> register-cand : signup du candidat

-> register-rec : signup du  recruteur 

-> register-cand-com : les donnes quu'on va donnes au candidats pour choisir ses competences et ses experiences et education  

-> successful : la page qu'on affiche au candidat pour le redirecter vers dashboard (le recrutteur n'a pas cette page )

-> up-can / up-rec : les pages qui apparaissent au candidat/rec apres qu'il font le sign in et on demande les photos



/////////////////////////////////////////////////////////////////////////////////////////////////////////////



outside register : 


-> index.js : scroll to top button 

-> index.php : la page d'acceuil 

et les diff styles utiliser dans tout le programme 



//////////////////////////////////////////////////////////////////////////////////////////////////


Dans candidat:


dashboard : c'est la dashboard de tout le system , le coeur de l'application ou le candidat et le recruteur vont passer la majoriter de leurs temps , ici on a un code php pour afficher un contenue ou candidat et un contenue ou rec 

dans la nav bar on a une partie avec php qui direge le user vers sa page concerner en se basant sur le type user de la base de donne , les pages offres et profiles sont des pages afficher au deux (on va les redireger lorsqu'ils seront la) 




dans dashboard si on click sur offres on va aller a la page offres et on va voir tout les offres (soit 1 or 2 )

si on check une offre on va partir a info_offre 

pour le recrutteur veut checker son offre on va le montrer la page ou il peut modifier son offre 


-> form_update_offre : va montrer la pages ou on peut modifier les offres 

-> form_update_cand : si le cand veut faire un update on va inclure le updatec qui va verifier le mail et le pasword lors de la mise a jour de ce dernier

-> form_update_rec : elle va afficher la page ou le rec peut modifier son compte 

-> info_offre : si on click su offre on va afficher les elements qui convenable a chaque user 

-> info cand : afficher les infos du candidat  , chaque user a ces proprietes 

-> une page de login  : login.php

-> offres.php : lorsqu'on click sur le button offre si on est sur dashboard ou profile , en va afficher a chaque user les proprietes qu'il peut faire , il sonts expliquer bien avec les // dans le code 

-> postulation.php : insere dans la bdd chaque postulant et son offre 

-> profilec.php : le profile du candidat enligne 

->profilerec.php : le profile du recrutteur enligne

-> read.php : ou le candidat peut lire les messages (contient bien sure le fetch des olds messages )

->send.php : ou le recruteur peut envoyer les messages (ofc on a seulement des inserts )

