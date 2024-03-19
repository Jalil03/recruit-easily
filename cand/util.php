<?php
/*
  Dans ce fichier on va définir un ensemble de fonction pour les réutiliser après dans d'autres fichiers ¡) 
  Il va donc contenir plusieur fonctions à réutiliser
*/
include('database.php');
// fonction pour créer une session
function init_php_session() : bool
{
    if(!session_id())
    {
        session_start();//initialisation de la session
        session_regenerate_id();//on regènere session id
        return true;
    }
    return false; 
}
// fonction pour arrêter une session
function clean_php_session() : void
{
    session_start();
    session_unset();
    session_destroy();
}
// fonction pour vérfie si l'utilisateur est connecté
function is_logged() : bool 
{
    if(isset($_SESSION['email']) && !empty($_SESSION['email']))
        return true;
    return false;
}
// fonction pour vérifier le type d'utilisateur
function is_recruteur() : bool
{
    if(is_logged())
       if(isset($_SESSION['type_user']) && $_SESSION['type_user']==1)
           return true;
    return false;
}
function is_recruteur1($type_user) : bool
{
    if(is_logged())
       if(isset($_SESSION['type_user']) && $_SESSION['type_user']==1)
           return true;
    return false;
}

// fonction qui permet de vérifier si une offre est active ou non , on lui renvoie $act qui est le champ is_active de la base de données 

function active($act):bool{
  if($act==0) return true;
  else return false;
}

//fonction qui va nous permettre de vérifier si l'offre est publiée par le recruteur ou non

//Cette fonction vérifie si une offre spécifique ($id1) a été publiée par un recruteur spécifique ($id2). Si les deux identifiants correspondent, cela signifie que l'offre a été publiée par ce recruteur, donc la fonction renvoie true. Sinon, elle renvoie false.

function verifier($id1,$id2):bool{
    if($id1==$id2)
    return true;
    else 
    return false;
}

// fonction qui vérifie si le candidat a postulé ou non à l'offre s'il a postulé on bloque le bouton "postuler" sinon il est disponible
function postuler($id1,$id2):bool{
   global $PDO;
   $rq=$PDO->prepare('select * from postule where id_candidat=? and id_offre=?');
   $rq->execute(array($id1,$id2));
   if($rq->rowCount()!=0) return true;
   else return false;
}

//Cette fonction vérifie si un candidat a postulé à une offre spécifique ($id2) en vérifiant s'il existe une entrée dans la table 'postule' associant l'identifiant du candidat ($id1) à l'identifiant de l'offre ($id2). Si une entrée correspondante est trouvée, cela signifie que le candidat a déjà postulé, donc la fonction renvoie true. Sinon, elle renvoie false


?>
