<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class MainController extends Controller
{
    public function home(Request $request): View
    {
        return view(view: 'home');
    }

    public function generateExercise(Request $request)
    {
        $request->validate([
            'check_sum' => 'required_without_all:check_subtraction,check_multiplication,check_division',
            'check_subtraction' => 'required_without_all:check_sum,check_multiplication,check_division',
            'check_multiplication' => 'required_without_all:check_sum,check_subtraction,check_division',
            'check_division' => 'required_without_all:check_sum,check_subtraction,check_multiplication',
            'number_one' => 'required|integer|min:0|max:999|lt:number_two',
            'number_two' => 'required|integer|min:0|max:999',
            'number_exercises' => 'required|integer|min:5|max:50',
        ]);

        $operations = [];
        if ($request->check_sum)
            $operations[] = 'sum';
        if ($request->check_subtraction)
            $operations[] = 'subtraction';
        if ($request->check_multiplication)
            $operations[] = 'multiplication';
        if ($request->check_division)
            $operations[] = 'division';

        $min = $request->number_one;
        $max = $request->number_two;
        $number_exercises = $request->number_exercises;

        $exercises = [];
        for ($i = 0; $i < $number_exercises; $i++) {
            $number_one = rand($min, $max);
            $number_two = rand($min, $max);
            $operation = $operations[array_rand($operations)];
            $exercises[] = [
                'exercise_number' => $i + 1,
                'number_one' => $number_one,
                'number_two' => $number_two,
                'operation' => $operation,
                'exercise' => $number_one . ' ' . $this->handleOperationStrigs($operation) . ' ' . $number_two . ' = ',
                'result' => $this->calculate($number_one, $number_two, $operation),
            ];
        }

        dd($exercises);
    }

    private function handleOperationStrigs(string $operation)
    {
        switch ($operation) {
            case 'sum':
                return '+';
            case 'subtraction':
                return '-';
            case 'multiplication':
                return 'x';
            case 'division':
                return ':';
            default:
                return '';
        }
    }

    private function calculate($number_one, $number_two, $operation)
    {
        switch ($operation) {
            case 'sum':
                return $number_one + $number_two;
            case 'subtraction':
                return $number_one - $number_two;
            case 'multiplication':
                return $number_one * $number_two;
            case 'division':
                if ($number_two == 0) {
                    return 0;
                }

                return $number_one / $number_two;
            default:
                return 0;
        }
    }

    public function printExercises(Request $request)
    {
        echo "imprimir os exercicios";
    }

    public function exportExercises(Request $request)
    {
        echo "exportar os exercicios";
    }
}

