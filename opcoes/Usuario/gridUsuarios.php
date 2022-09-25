<?php

 require_once 'cardUsuarios.php';

function generateGrid($listUsuarios){
  $grid = "";

  foreach ($listUsuarios as $indice => $usuario) {

  //  $grid = $grid . "<div class='container-fluid '> \n";
      $grid = $grid . createCard($usuario);
  //  $grid = $grid . "</div> \n";

  }
  $grid = $grid . "</tbody>\n";
  $grid = $grid . "</table>\n";
    return $grid;
}

function generateGridAtividades($listUsuarios){
  $grid = "";
    $i = 1;

  foreach ($listUsuarios as $indice => $usuario) {

  //  $grid = $grid . "<div class='container-fluid '> \n";
      $grid = $grid . createCardAtividade($usuario, $i);
  //  $grid = $grid . "</div> \n";
    $i++;
  }
  $grid = $grid . "</tbody>\n";
  $grid = $grid . "</table>\n";
    return $grid;
}

 ?>
