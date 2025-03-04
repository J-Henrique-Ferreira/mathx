<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    public function home(Request $request): View{
        return view(view: 'home');
    }

    public function generateExercise(Request $request){
        echo "apresentar os ecercicios";
    }

    public function printExercises(Request $request){
        echo "imprimir os exercicios";
    }

    public function exportExercises(Request $request){
        echo "exportar os exercicios";
    }
}

