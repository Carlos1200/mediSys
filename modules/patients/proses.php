
<?php
session_start();


require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}

else {
    if ($_GET['act']=='insert') {
        if (isset($_POST['Guardar'])) {
     
            $codigo  = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
            $nombre  = mysqli_real_escape_string($mysqli, trim($_POST['nombre']));
            $tel = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['tel'])));
            $fecha = mysqli_real_escape_string($mysqli, trim($_POST['fecha']));

  
            $query = mysqli_query($mysqli, "INSERT INTO citas(codigo,nombre,tel,fecha) 
                                            VALUES('$codigo','$nombre','$tel','$fecha')")
                                            or die('error '.mysqli_error($mysqli));    

        
            if ($query) {
         
                header("location: ../../main.php?module=patients&alert=1");
            }   
        }   
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['codigo'])) {
        
            $codigo  = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
            $nombre  = mysqli_real_escape_string($mysqli, trim($_POST['nombre']));
            $tel = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['tel'])));
            $fecha = mysqli_real_escape_string($mysqli, trim($_POST['fecha']));

                $query = mysqli_query($mysqli, "UPDATE citas SET  nombre       = '$nombre',
                                                                    tel      = '$tel',
                                                                    fecha      = '$fecha'
                                                              WHERE codigo       = '$codigo'")
                                                or die('error: '.mysqli_error($mysqli));

    
                if ($query) {
                  
                    header("location: ../../main.php?module=patients&alert=2");
                }         
            }
        }
    }

    elseif ($_GET['act']=='delete') {
        if (isset($_GET['id'])) {
            $codigo = $_GET['id'];
      
            $query = mysqli_query($mysqli, "DELETE FROM citas WHERE codigo='$codigo'")
                                            or die('error '.mysqli_error($mysqli));


            if ($query) {
     
                header("location: ../../main.php?module=patients&alert=3");
            }
        }
    }       
}       
?>