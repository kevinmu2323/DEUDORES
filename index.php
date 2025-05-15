<?php

include 'clases.php';


    $ruta= config :: ruta();
    $resultado="";  
    $guardar=new Guardar();
    $agregado = false;
    $selecionado=$_POST['seleccionados']??"";
    $valor=$_POST['valor'];
    $mensaje=$_POST['mensaje'];
    $agregar_a_esta = false;
    $archivo=fopen($ruta,"r");
$archivo = fopen($ruta, "r");
if ($archivo) {
    while (($lineas = fgetcsv($archivo, 0, "|")) !== false) {
        if (empty(array_filter($lineas))) {
            continue;
        }

        
        if (count($lineas) === 1 && !str_contains($lineas[0], '|')) {
            if ($agregar_a_esta && !$agregado && !empty($valor) && !empty($mensaje)) {
                $datofinal .= "|$valor|$mensaje|\n";
                $agregado = true;
            }

            $encabezado = trim($lineas[0]);
            $datofinal .= $encabezado . "\n";
            $agregar_a_esta = ($selecionado === $encabezado);
            continue;
        }

        $datofinal .= implode("|", $lineas) . "\n";
    }

    if ($agregar_a_esta && !$agregado && !empty($valor) && !empty($mensaje)) {
        $datofinal .= "|$valor|$mensaje|\n";
        $agregado = true;
    }

    fclose($archivo);

    if (!empty(trim($datofinal))) {
        file_put_contents($ruta, $datofinal, LOCK_EX);
        $resultado = "Guardado exitosamente";
    }
}



    $fila = [];
    $ruta = config::ruta();
    $botones = "";
    $guardar=fopen($ruta,"r");
    if ($guardar)
    {
    while(($lineas=fgetcsv($guardar,0,"|"))!==false)
    {
    $fila[]=$lineas;
    }
    }   
    foreach($fila as $unaLinea)
    {
        $nombre=trim($unaLinea[0]??'');
        if (!empty($nombre)) 
        {
        $nombre = trim($unaLinea[0]);
        $botones .= '<label><input type="radio" name="seleccionados" value="'.$nombre.'">'.$nombre.'</label><br>';
        }
    }
?>
<!DOCTYPE html>  
<html lang="es">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Deudores</title>  
    <style>  
        body {  
            font-family: Arial, sans-serif;  
            margin: 0;  
            padding: 0;  
            box-sizing: border-box;  
            background-color:rgb(134, 134, 134);
        }  
        header {  
            background-color: #4CAF50;  
            color: white;  
            padding: 10px 20px;  
            text-align: center;  
            border: 2px solid black;
        }  
        nav {  
            margin: 10px 0;  
        }  
        nav a {  
            margin: 0 15px;  
            color: white;  
            text-decoration: none;  
        } 
        div
{
    border: 2px solid black;
} 
        .container, .container2 {
    width: 90%;
    max-width: 400px;
    margin: auto;
    padding: 3%;
    background-color: rgba(206, 206, 206, 0.53);
}

        
        p
        {
            margin-left:-4%;
            background-color:#FFF; 
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

<div class="container">  
<form  action="index.php" method="post"> 
<?php echo $botones ?>
<p>Deuda</p>
<input type="number" id="valor" name="valor" placeholder="$"><br>
<p>Informacion</p>
<input type="text" id="mensaje" name="mensaje"><br>
<input type="submit">
<td><?php echo $resultado; ?></td>
</form>
</div >  
</body>  
</html>  