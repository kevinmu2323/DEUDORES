<?php
class Guardar 
{
    public  function guardar1 ($datos ,$ruta)
    {
        $guardar=fopen($ruta,"a");
        if($guardar)
        {
            fwrite($guardar,$datos );
            fclose($guardar);
            $result="Informacion Guardada";
        }
            else
            {
                $result="No Se Guardo La Informacion";
            }
            return $result;
    }
}
class config

{
public static function ruta  ()
{
    return'archivos/nombres.csv';
}


}




?>