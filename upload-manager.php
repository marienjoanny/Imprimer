<?php
// php info
// phpinfo();
// system ("touch test.txt");
// Canon-PIXMA-MP180-VNC
// echo phpversion();
echo "<a href=http://192.168.1.73:631/jobs/>Gestion des Impressions</a><BR><BR>";
echo "<a href=http://192.168.1.73/imprimer.html>Imprimer Encore</a><BR><BR>";

// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Check if file was uploaded without errors
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0){
        $allowed = array("pdf" => "application/pdf");
        $filename = $_FILES["photo"]["name"];
        $filetype = $_FILES["photo"]["type"];
        $filesize = $_FILES["photo"]["size"];
    
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) die("Erreur: Selectionnez un format de fichier valide.") ;
    
        // Verify file size - 5MB maximum
        $maxsize = 5 * 1024 * 1024 ;
        if($filesize > $maxsize) die("Erreur: La taille de fichier est plus grande que la limite autorisee.") ;
    
        // Check whether file exists before uploading it
        if(file_exists("/tmp/" . $_FILES["photo"]["name"])){
            echo $_FILES["photo"]["name"] . " existe deja. Renommez le et reessayez." ;
        } else{
             move_uploaded_file($_FILES["photo"]["tmp_name"], "/tmp/" . $_FILES["photo"]["name"]) ;
		if(!empty($_POST['debut'])){
			// Print file page debut to fin in command line
			system ("lp -d CANONMP190 -P " . $_POST['debut'] . "-" . $_POST['fin'] . " /tmp/" . $_FILES["photo"]["name"]);
			// echo "lp -d CANONMP190 -P " . $_POST['debut'] . "-" . $_POST['fin'] . " /tmp/" . $_FILES["photo"]["name"];
	 	} else{
			// Print file to test before in command line
			// echo "lp -d CANONMP190 /tmp/" . $_FILES["photo"]["name"];
			system ("lp -d CANONMP190 /tmp/" . $_FILES["photo"]["name"]);
			// echo "no num";
		}
		system ("rm /tmp/" . $_FILES["photo"]["name"]);
                echo "Votre fichier : " . $_FILES["photo"]["name"] . " a ete imprime.";
	}
    } else{
        echo "Error: " . $_FILES["photo"]["error"];
    }
}
?>
