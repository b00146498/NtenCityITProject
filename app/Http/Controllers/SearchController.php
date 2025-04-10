<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Employee;
use App\Models\StandardExercises;


class SearchController extends Controller
{
    public function global(Request $request)
    {
        $query = $request->input('q');

        $clients = Client::where('first_name', 'like', "%{$query}%")
                        ->orWhere('surname', 'like', "%{$query}%")
                        ->get();

        $employees = Employee::where('emp_first_name', 'like', "%{$query}%")
                            ->orWhere('emp_surname', 'like', "%{$query}%")
                            ->get();

        $exercises = StandardExercises::where('exercise_name', 'like', "%{$query}%")->get();

        return view('results', compact('query', 'clients', 'employees', 'exercises'));
    }
}


