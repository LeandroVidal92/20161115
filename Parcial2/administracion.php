<?phpsession_start();if(isset($_SESSION["user"])){$user = $_SESSION["user"];//var_dump($user);}else{$user=null;}//require_once("verificar_sesion.php");require_once("Clases/Usuario.php");$queMuestro = isset($_POST['queMuestro']) ? $_POST['queMuestro'] : NULL;switch ($queMuestro) {    case 'CerrarSesion':     $_SESSION['user']['mail']=null;//Para destruir una variable global pongo un null    $_SESSION['user']['nombre']=null;    $_SESSION['user']['perfil']=null;    break;        case "ENUNCIADO":                require_once("enunciado.php");                break;        case "MOSTRAR_GRILLA": if($user['perfil']!=NULL && $user['perfil']!='invitado')          {            $ArrayUsuarios=Usuario::TraerTodosLosUsuarios();                                        ?>                            <table class="table" style="background-color: #3f51b5;">                            <thead>                        <tr>                            <th><h3>Nombre</h3></th><th><h3>Email</h3></th>                            <th><h3>password</h3></th><th><h3>perfil</h3></th>                            </th><th><h3>Modificar</h3></th>                            </th><th><h3>Borrar</h3></th>                         </tr>                                    <?php                                foreach ($ArrayUsuarios as $Usuario )                                 {                                    $vec = array();                                    $vec["id"]=$Usuario->id;                                    $vec["nombre"] = $Usuario->nombre;                                    $vec["mail"]=$Usuario->email;                                    $vec["password"]=$Usuario->password;                                     $vec["perfil"]=$Usuario->perfil;                                    $vec= json_encode($vec);                                    echo " <tr>                                                <td><h4>$Usuario->nombre</h4></td>                                                <td><h4>$Usuario->email</h4></td>                                                <td><h4>$Usuario->password</h4></td>                                                <td><h4>$Usuario->perfil</h4></td>                                                <td><a class='btn btn-info animated ' onclick='EditarUsuario($vec)'> Modificar </a></td>                                                <td><a class='btn btn-info animated '   onclick='EliminarUsuario($vec)'> Borrar </a></td>                                                                                            </tr>   ";                                }        ?>                            </thead></table><?php    }       else        {            if($user['perfil']==null )            {                echo"NO ESTA LOGUEADO";            }            else            {                echo "no posee los permisos suficientes siendo ".$user['perfil'];            }        }                     break;    case "FORM"://MUESTRA FORM ALTA-MODIFICACION USUARIO        $usuario = isset($_POST["usuario"]) ? json_decode(json_encode($_POST["usuario"])) : NULL;        if($user['perfil']!='usuario' && $user['perfil']!=NULL && $user['perfil']!='invitado')                    require_once("form.php");        else        {            if($user['perfil']==null )            {                echo"NO ESTA LOGUEADO";            }            else            {                echo "no posee los permisos suficientes siendo ".$user['perfil'];            }        }        break;    case "ALTA_USUARIO":        $user=$_POST['usuario'];        $obj = new Usuario();        $obj->nombre=$user['nombre'];        $obj->email=$user['email'];        $obj->password=$user['password'];        $obj->perfil=$user['perfil'];        $obj->Exito = TRUE;        $obj->Mensaje = "mensaje";        echo json_encode($obj);        usuario::Agregar($obj);                //implementar...                break;    case "MODIFICAR_USUARIO":              $user=$_POST['usuario'];      echo json_encode($user);        $obj = new Usuario();        $obj->id=$user['id'];        $obj->nombre=$user['nombre'];        $obj->email=$user['email'];        $obj->password=$user['password'];        $obj->perfil=$user['perfil'];        $obj->Exito = TRUE;        $obj->Mensaje = "mensaje";        echo json_encode($obj);        usuario::Modificar($obj);        //implementar...                break;            case "ELIMINAR_USUARIO":        $user=$_POST['usuario'];        $obj = new Usuario();        $obj->Exito = TRUE;        $obj->Mensaje = "";        usuario::Borrar($user['id']);        //implementar...        echo json_encode($obj);        break;    case "LOGOUT":        //$_SESSION['user']['mail']=null;//Para destruir una variable global pongo un null        //$_SESSION['user']['nombre']=null;        //$_SESSION['user']['perfil']=null;        break;    default:        echo ":(";}?>