<?php

use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Output\ConsoleOutput;



class Utilidades
{
  /**
   * Trae el valor de app_id usando el id de un rol.
   */
  public function tomarRolApp($idRol)
  {
    $rolApp = DB::select("SELECT r.app_id from roles as r where r.id = ? limit 1;", [$idRol]);
    if (!empty($rolApp)) {
      return $rolApp[0]->app_id;
    } else {
      return 0;
    }
  }

  //trae el valor del id de la campana usando el id del rol de un usuario
  public function tomaridCampana($idRol)
  {
    $rolApp = DB::select("SELECT r.campeigns_id from roles as r where r.id = ? limit 1;", [$idRol]);
    if (!empty($rolApp)) {
      return $rolApp[0]->campeigns_id;
    } else {
      return 0;
    }
  }

  //funcion que trae el id del formulario
  public function tomaridFormulario($idCampana)
  {
    $idForm = DB::select("SELECT c.id_formulario from campeigns as c where c.id = ?;", [$idCampana]);
    if (!empty($idForm)) {
      return $idForm[0]->id_formulario;
    } else {
      return 0;
    }
  }

  //solo selecciona rol alfa usando el id de una campana en especifico
  public function tomarIdRolMenor($idCampana)
  {
    $rolApp = DB::select("SELECT r.id from roles as r where r.campeigns_id = ? and r.app_id = 3 limit 1;", [$idCampana]);
    if (!empty($rolApp)) {
      return $rolApp[0]->id;
    } else {
      return 0;
    }
  }

  public function tomarIdRolMenorBeta($idCampana)
  {
    $rolApp = DB::select("SELECT r.id from roles as r where r.campeigns_id = ? and r.app_id = 4 limit 1;", [$idCampana]);
    if (!empty($rolApp)) {
      return $rolApp[0]->id;
    } else {
      return 0;
    }
  }

  public function imprimir($variable){
    $output = new ConsoleOutput();
    $output->writeln($variable);
  }
}
