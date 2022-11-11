
<?php
session_start();


require_once "../../config/database.php";

if (empty($_SESSION['username']) && empty($_SESSION['password'])){
    echo "<meta http-equiv='refresh' content='0; url=index.php?alert=1'>";
}

else {
    if ($_GET['act']=='insert') {
        if (isset($_POST['Guardar'])) {

            $query = mysqli_query($mysqli, "SELECT fecha,hora FROM citas ORDER BY codigo DESC")
                                            or die('error: '.mysqli_error($mysqli));
            while ($data = mysqli_fetch_assoc($query)) {     
                if(trim($_POST['fecha']==$data['fecha'])){
                    if(trim($_POST['hora'].":00")==$data['hora']){
                        header("location: ../../main.php?module=form_patients&form=add&alert=1");
                    }
                }
            }                       
     
            $codigo  = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
            $nombre  = mysqli_real_escape_string($mysqli, trim($_POST['nombre']));
            $tel = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['tel'])));
            $fecha = mysqli_real_escape_string($mysqli, trim($_POST['fecha']));
            $hora=mysqli_real_escape_string($mysqli, trim($_POST['hora']));

  
            $query = mysqli_query($mysqli, "INSERT INTO citas(codigo,nombre,tel,fecha,hora) 
                                            VALUES('$codigo','$nombre','$tel','$fecha','$hora')")
                                            or die('error '.mysqli_error($mysqli));    

        
            if ($query) {
         
                header("location: ../../main.php?module=patients&alert=1");
            }   
        }   
    }
    
    elseif ($_GET['act']=='update') {
        if (isset($_POST['Guardar'])) {
            if (isset($_POST['codigo'])) {
            
                $query = mysqli_query($mysqli, "SELECT fecha,hora,codigo FROM citas ORDER BY codigo DESC")
                                            or die('error: '.mysqli_error($mysqli));
                while ($data = mysqli_fetch_assoc($query)) {
                    var_dump($data['codigo'] , $_POST['codigo'],$_POST['fecha'],$data['fecha'],trim($_POST['hora'].":00"),$data['hora']);
                    if($data['codigo'] != $_POST['codigo']){     
                        if(trim($_POST['fecha'])==$data['fecha']){
                            if(trim($_POST['hora'])==$data['hora'] || trim($_POST['hora'].":00")==$data['hora']){
                                header("location: ../../main.php?module=form_patients&form=edit&id=".$_POST['codigo']."&alert=1");
                            }
                        }
                    }
                } 
        
            $codigo  = mysqli_real_escape_string($mysqli, trim($_POST['codigo']));
            $nombre  = mysqli_real_escape_string($mysqli, trim($_POST['nombre']));
            $tel = str_replace('.', '', mysqli_real_escape_string($mysqli, trim($_POST['tel'])));
            $fecha = mysqli_real_escape_string($mysqli, trim($_POST['fecha']));
            $hora=mysqli_real_escape_string($mysqli, trim($_POST['hora']));
                $query = mysqli_query($mysqli, "UPDATE citas SET  nombre       = '$nombre',
                                                                    tel      = '$tel',
                                                                    fecha      = '$fecha',
                                                                    hora      = '$hora'
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