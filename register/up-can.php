<?php
include('database.php');
include('../cand/util.php');
init_php_session();

if (isset($_FILES['file']) && isset($_POST['submit']))
{
    // pour extraire les differents informations sur notre fichier
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    // Emplacement temporaire du fichier
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];
    // Extraction de l'extension
    $fileExt= explode('.', $fileName );
    // JPG->jpg end pour recuperer la derniere partie de nom du fichier
    $fileActualExt = strtolower(end($fileExt));
    // on va commencer de faire des tests sur les differents informations associees au fichier
    $allowed = array('jpg','jpeg','png');
    if(in_array($fileActualExt, $allowed)) {
        if($fileError === 0) {
            // verification sur la tailee du fichier 
            if($fileSize < 1000000) {
                $fileNameNew = uniqid('',true).".".$fileActualExt ;
                $fileDestination ='upload1/'.$fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                
                // modification de la requête SQL pour insérer le nom de fichier
                try {
                    $sql=$conn->prepare('UPDATE candidat SET photo = :upic WHERE id_candidat = :id');
                    $sql->bindParam(':upic',$fileNameNew);
                    $sql->bindParam(':id', $_SESSION['id']);
                    $sql->execute();
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            } else{
                $message= "your file is too big!";
            }
        
         }
         else{  $message="There was an error uploading your file!";}
        }
        else{
            $message="You cannot upload files of this type";
        }
      
  //on envoie l'utilisateur vers la page register-cand-comp.php si tout va correctement
   if ($message !='')  {echo $message;} 

   else{ header('Location:register-cand-comp.php');}
  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../stylecandidat.css">
    
    <title>Document</title>
    
</head>
<body>
<nav id="navb" class="navbar navbar-expand-lg " >
        <div class="container ">
        <a class="navbar-brand" href="../index.php"><img  class="logo" src="../images/logoW.jpg" height="60px" width="100px" alt="link" class="img"></a>
   </div> 
	</nav>
   
   <div class="container">
  
    <div class="  col">
    <form action="up-can.php" method="post" enctype="multipart/form-data">
   
    <label for="nom_du_fichier">
        <img id="previewImage" src="../image.png" alt="Upload Image">
    </label>

    
    <input type="file" name="file" id="nom_du_fichier" accept="image/*" style="display: none;">
    
    
    <input type="submit" name="submit" class="btn" value="Upload">
</form>
   <a href="register-cand-comp.php"> <button class="btn">Skip>></button></a>
    </div>
   
    </div>
    <script>
    
    document.getElementById('nom_du_fichier').addEventListener('change', function(event) {
        var input = event.target;
        var reader = new FileReader();

        reader.onload = function(){
            var img = document.getElementById('previewImage');
            img.src = reader.result;
            var MAX_WIDTH = 356; 
            var MAX_HEIGHT = 356; 
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');

            var originalImage = new Image();
            originalImage.src = reader.result;

            originalImage.onload = function() {
                var width = originalImage.width;
                var height = originalImage.height;

                if (width > MAX_WIDTH) {
                    height *= MAX_WIDTH / width;
                    width = MAX_WIDTH;
                }

                if (height > MAX_HEIGHT) {
                    width *= MAX_HEIGHT / height;
                    height = MAX_HEIGHT;
                }

                canvas.width = width;
                canvas.height = height;

                ctx.drawImage(originalImage, 0, 0, width, height);
                img.src = canvas.toDataURL('image/jpeg');
            };
        };

        reader.readAsDataURL(input.files[0]);
    });
</script>
    
</body>
</html>

