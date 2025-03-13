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

    public function generateExercise(Request $request): View
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
            $resultOperation = round(
                $this->calculate($number_one, $number_two, $operation),
                2
            );
            $exercises[] = $this->handleCreateExercises(
                index: $i,
                operation: $operation,
                number_one: $number_one,
                number_two: $number_two,
                resultOperation: $resultOperation
            );
        }

        $request->session()->put('exercises', $exercises);
        return view('operations', ["exercises" => $exercises]);
    }

    public function printExercises(Request $request)
    {
        $this->checkExercisesSession();
        $exercises = $request->session()->get('exercises');

        return view('print', ["exercises" => $exercises]);
    }

    public function exportExercises(Request $request)
    {
        // echo "exportar os exercicios";
        $this->checkExercisesSession();

        $exercises = session()->get('exercises');
        $fileName = 'exercises_' . env('APP_NAME') . '_' . date('YmdH\is') . '.txt';

        $content = "Exercises \n" . str_repeat("- ", 20) . "\n";

        foreach ($exercises as $exercise) {
            $content .= "(" . $exercise['exercise_number'] . ')- ' . $exercise['exercise'] . "\n";
        }

        $content .= "\n";
        $content .= "Solutions\n" . str_repeat("- ", 20) . "\n";

        foreach ($exercises as $exercise) {
            $content .= "(" . $exercise['exercise_number'] . ')- ' . $exercise['exercise'] . $exercise['result'] . "\n";
        }

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
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

    private function handleCreateExercises($index, $number_one, $number_two, $operation, $resultOperation): array
    {
        $exercise = [
            'exercise_number' => str_pad($index + 1, 2, "0", STR_PAD_LEFT),
            'number_one' => $number_one,
            'number_two' => $number_two,
            'operation' => $operation,
            'exercise' => $number_one . ' ' . $this->handleOperationStrigs($operation) . ' ' . $number_two . ' = ',
            'exercise_resolve' => $number_one . ' ' . $this->handleOperationStrigs($operation) . ' ' . $number_two . ' = ' . $resultOperation,
            'result' => $resultOperation,
        ];

        return $exercise;
    }

    private function checkExercisesSession()
    {
        if (!session()->has('exercises')) {
            return redirect()->route('home');
        }
    }

}

