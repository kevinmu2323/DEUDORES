<?php
include 'clases.php';
$name=$_POST['nombre'];
$seleccion=$_POST['seleccion'];
$rutas= config :: ruta();
$fila=[];
$guardar=fopen($rutas,"a");
$tabla = "";
$datofinal="";
$result=0;
$opciones="";
$operacion=$_POST['operacion'];
$monto=[];
$lineanueva=[];
$eliminar=$_POST['eliminar'];
$eliminando = false;
$ultimo_nombre = "";

if (!empty($eliminar)) {
    $archivo1 = fopen($rutas, "r");
    $lineanueva = [];
    $eliminando = false;
    
    while (($lineas = fgetcsv($archivo1, 0, "|")) !== false) {
        if (empty(array_filter($lineas))) continue;
        
        
        if (count($lineas) === 1 && trim($lineas[0]) === $eliminar) {
            $eliminando = true;
            continue;
        }

        
        if ($eliminando) {
            
            if (count($lineas) === 1 && !empty(trim($lineas[0]))) {
                $eliminando = false;
                
                $lineanueva[] = $lineas;
            }
            
            continue;
        } else {
            $lineanueva[] = $lineas;
        }
    }
    fclose($archivo1);
    
    
    $archivo2 = fopen($rutas, "w");
    foreach ($lineanueva as $linea) {
        fputcsv($archivo2, $linea, "|");
    }
    fclose($archivo2);
}

if ($seleccion === "on" && !empty (trim($name)))
{
    if($guardar)
    {
    fwrite($guardar,$name."\n");
    fclose($guardar);
    }

  
}
$guardar=fopen($rutas,"r");
if ($guardar)
{
while(($lineas=fgetcsv($guardar,0,"|"))!==false)
{
$fila[]=$lineas;
}
}
fclose($guardar);
$tabla='<table border="1px">';
foreach($fila as $unaLinea)
{
    if (empty(array_filter($unaLinea))) continue;

    if(!empty($unaLinea[0]))
    {
    $tabla.='<tr>';
        $tabla.=' <td colspan=3 style=text-align:center;font-weight:bold;>'.$unaLinea[0].'</td>';
    $tabla.='</tr>';
    }
   
  if (!empty($unaLinea[1]) && !empty($unaLinea[2]))
  {
    $tabla.='<tr>';
        $tabla.=' <td >'.$unaLinea[1].'</td>';
        $tabla.=' <td >'.$unaLinea[2].'</td>';
        $tabla.='</tr>';
    }
    
}
$delete="";
$tabla.='</table>';
foreach($fila as $unaLinea)
{
 
    if(!empty($unaLinea[0]))
    {
       
        $opciones.='<button value="'.$unaLinea[0].'" name="operacion">'.$unaLinea[0].'</button>';  
        $delete.='<button value="'.$unaLinea[0].'" name="eliminar">'.$unaLinea[0].'</button>'; 
         
    }
    
   if(!empty($unaLinea[0]) && empty ($unaLinea[1]))
   {
    $persona=trim($unaLinea[0]);
   }
  
    if (!empty($unaLinea[1])&& $persona === $operacion)   
    {
        $valor=intval($unaLinea[1]);
     $result+=$valor;
     
    }
   
    
}
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
    <style>
  nav {  
            margin: 10px 0;  
             
        }  
        nav a {  
            margin: 0 15px;  
            color: white;  
            text-decoration: none;  
        }          
body
{  
        font-family: Arial, sans-serif;  
        margin: 0;  
        padding: 0;  
        box-sizing: border-box;  
        background-color:rgb(134, 134, 134);
}  
header 
{  
    background-color: #4CAF50;  
    color: white;  
    padding: 10px 20px;  
    text-align: center;  
    border: 2px solid black;
} 
.container2
{
    width: 90%;
    max-width: 400px;
    margin: auto;
    padding: 3%;
    background-color: rgba(206, 206, 206, 0.53);
    justify-content: center;
}
div
{
    border: 2px solid black;
}
table
{
    background-color: rgb(245, 245, 245);
    color:rgba(0, 0, 0, 0.94);
}

    </style>
</head>
<body>
    <header>  
    <nav>  
        <a href="index.php">Inicio</a>  
        <a href="consulta.php">consultas</a>  
    </nav>  
    </header>  
            <div class="container2">
            <p>Quieres añadir una persona ?</p>
            <form action="consulta.php" method="post">
                <input type="text" name="nombre" id="nombre">
                <input type="radio" name="seleccion" id="seleccion">
                <p>Que Persona Queres ver el total?</p>
                <?php echo $opciones;?>
                <p>Total: <?php echo $result;?></p>
                <p>Ah Que Persona Queres Eliminar?</p>
                 <?php echo $delete;?> <br> <br>
                <input type="submit">
            </form>
            
        </div>
        <div class="container2">
            <?php echo $tabla;?>
            </div>
</body>
</html>