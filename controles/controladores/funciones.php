<?php

function limpiar($variable)
{
    $dato = trim(htmlspecialchars(stripcslashes($variable)));
    return $dato;
}

?>