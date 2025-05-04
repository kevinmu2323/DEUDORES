<?php
include 'clases.php';
$ruta= congif::ruta();
$buscar=$_POST['buscar'];
$buscar=strtoupper($buscar);
$resultado="";
$total=0;
$eliminar=$_POST['eliminar'];
$eliminar=strtoupper($eliminar);
$lineanueva=[];

$archivo=fopen($ruta,"r");
while(($lineas=fgetcsv($archivo,0,"|"))!== false)
{  

    if($lineas[1]===$buscar)
    {
       $resultado.="<tr> <td>{$lineas[0]}</td>
                <td>{$lineas[1]}</td>
                <td> $ {$lineas[2]}</td>
                <td>{$lineas[3]}</td>
                </tr>"; 
                $total+= (float) $lineas[2];
    }
    
    
}
fclose($archivo);
$archivo=fopen($ruta,"r");
while(($lineas=fgetcsv($archivo,0,"|"))!== false)
{  

    if($lineas[1]!=$eliminar)
    {
       $lineanueva[]=$lineas;
    }
    
    
}
fclose($archivo);

$archivo=fopen($ruta,"w");
foreach($lineanueva as $lineas)
{
    fputcsv($archivo,$lineas,"|");
}
fclose($archivo);


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
        <a href="index.html">Inicio</a>  
        <a href="consulta.php">consultas</a>  
    </nav>  
    </header>  
            <div class="container2">
            <table border="2" >
                <form action="consulta.php" method="post">
                <input type="text" id="buscar" name="buscar" placeholder="buscar"> <input type="submit">
                </form>
            <tr><td>id</td><td>Nombre</td><td>Deuda</td><td>informacion</td></tr>
        <?php   
        $archivo=fopen($ruta,"r");
        while(($lineas=fgetcsv($archivo,0,"|"))!== false)
        {  
            echo"<tr> <td>{$lineas[0]}</td>
                <td>{$lineas[1]}</td>
                <td> $ {$lineas[2]}</td>
                <td>{$lineas[3]}</td>
                </tr>";   
        }
?>
<form action="consulta.php" method="post">
                <input type="text" id="eliminar" name="eliminar" placeholder="ELIMINAR"> <input type="submit">
                </form>
        </table>
        <table><tr><?php  echo $resultado;?></tr></table>
        <p><?php  echo $total;?></p>
        </div>
     
</body>
</html>