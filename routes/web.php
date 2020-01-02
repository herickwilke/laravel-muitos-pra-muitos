<?php

use App\Projeto;
use App\Desenvolvedor;
use App\Alocacao;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/desenvolvedor_projetos', function () {
    $desenvolvedores = Desenvolvedor::with('projetos')->get();

    foreach($desenvolvedores as $d){
        echo "<p>Nome do Desenvolvedor: " . $d->nome . "</p>";
        echo "<p>Cargo: " . $d->cargo . "</p>";
        if (count($d->projetos) > 0){
            echo "Projetos: <br>";
            echo "<ul>";
            foreach($d->projetos as $p) {
                echo "<li>";
                echo "Nome: " . $p->nome . " | ";
                echo "Horas totais: " . $p->estimativa_horas . " | ";
                echo "Horas semanais: " . $p->pivot->horas_semanais;
                echo "</li>";
            }
            echo "</ul>";
        }

        echo "<hr>";
    }
    //return $desenvolvedores->toJson();
});

Route::get('/projeto_desenvolvedores', function () {
    $projetos = Projeto::with('desenvolvedores')->get();

    foreach($projetos as $p){
        echo "<p>Nome do Projeto: " . $p->nome . "</p>";
        echo "<p>Estimativa: " . $p->estimativa_horas . "</p>";

        if (count($p->desenvolvedores) > 0){
            echo "Desenvolvedores: <br>";
            echo "<ul>";
            foreach($p->desenvolvedores as $d) {
                echo "<li>";
                echo "Nome: " . $d->nome . " | ";
                echo "Cargo: " . $d->cargo . " | ";
                echo "Horas semanais: " . $d->pivot->horas_semanais;
                echo "</li>";
            }
            echo "</ul>";
        }

        echo "<hr>";
    }
   // return $projetos->toJson();
});

Route::get('/alocar', function () {

    $proj = Projeto::find(4);
    if(isset($proj)) {
        //$proj->desenvolvedores()->attach(1, ['horas_semanais' => 50]);
        $proj->desenvolvedores()->attach([
            1 => ['horas_semanais' => 76],
            2 => ['horas_semanais' => 38],
            3 => ['horas_semanais' => 75],
        ]);
    }
});

Route::get('/desalocar', function () {

    $proj = Projeto::find(4);
    if(isset($proj)) {
        //$proj->desenvolvedores()->attach(1, ['horas_semanais' => 50]);
        $proj->desenvolvedores()->detach([1,2,3]);
    }
});

