<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Employee;

/*class CalendarController extends Controller
{
    public function display()
    {
        return view('calendar.display');
    }
}*/



class CalendarController extends Controller
{
    public function display()
    {
        $clients = Client::all();
        $employees = Employee::all();

        return view('calendar.display', compact('clients', 'employees'));
    }
}
 