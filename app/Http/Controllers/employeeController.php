<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateemployeeRequest;
use App\Http\Requests\UpdateemployeeRequest;
use App\Repositories\employeeRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Practice;
use Illuminate\Http\Request;
use App\Models\Employee;
use Flash;
use Response;

class employeeController extends AppBaseController
{
    /** @var employeeRepository $employeeRepository*/
    private $employeeRepository;

    public function __construct(employeeRepository $employeeRepo)
    {
        $this->employeeRepository = $employeeRepo;
    }

    /**
     * Display a listing of the employee.
     *
     * @param Request $request
     *
     * @return Response
     */
<<<<<<< HEAD

    public function index()
    {
=======
    public function index(Request $request)
    {
        // If AJAX/JSON request, return all employees as JSON
        if ($request->get('format') === 'json') {
            return response()->json(\App\Models\Employee::all());
        }

>>>>>>> dc1fe35a028bf085efa8052c3232ecfddf877891
        $user = auth()->user();
        $employee = \App\Models\Employee::where('userid', $user->id)->first();

        if (!$employee) {
            return redirect()->route('login')->with('error', 'Only employees can view this page.');
        }

        $employees = \App\Models\Employee::where('practice_id', $employee->practice_id)->get();

        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return Response
     */
    public function create()
    {
        $practices = Practice::all(); // Fetch all practices from the database

        return view('employees.create')->with([
            'practices' => $practices, // ✅ Pass practices to the view
        ]);
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param CreateemployeeRequest $request
     *
     * @return Response
     */

    public function new($userid)
    {
        $practices = \App\Models\Practice::all();
        
        $practice_id = $practices->first()->id;
        
        return view('employees.new')->with([ 
            'practices' => $practices, 
            'userid' => $userid 
        ]);
    }
    /**
     * Store a newly created client in storage.
     *
     * @param CreateclientRequest $request
     *
     * @return Response
     */
    public function store(CreateemployeeRequest $request)
    {
        $input = $request->all();

        $employee = $this->employeeRepository->create($input);

        Flash::success('Employee saved successfully.');

        return redirect()->route('employee.new', ['userid' => $employee->id])
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified employee.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            Flash::error('Employee not found');

            return redirect(route('employees.index'));
        }

        return view('employees.show')->with('employee', $employee);
    }

    /**
     * Show the form for editing the specified employee.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            Flash::error('Employee not found');
            return redirect(route('employees.index'));
        }

        $practices = Practice::all(); // Fetch all practices for dropdown

        return view('employees.edit', compact('employee', 'practices'));
    }


    /**
     * Update the specified employee in storage.
     *
     * @param int $id
     * @param UpdateemployeeRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateemployeeRequest $request)
    {
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            Flash::error('Employee not found');

            return redirect(route('employees.index'));
        }

        $employee = $this->employeeRepository->update($request->all(), $id);

        Flash::success('Employee updated successfully.');

        return redirect(route('employees.index'));
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $employee = $this->employeeRepository->find($id);

        if (empty($employee)) {
            Flash::error('Employee not found');

            return redirect(route('employees.index'));
        }

        $this->employeeRepository->delete($id);

        Flash::success('Employee deleted successfully.');

        return redirect(route('employees.index'));
    }
    /**
     * Store a newly created client in storage.
     *
     * @param CreateclientRequest $request
     *
     * @return Response
     */
    public function searchEmployees(Request $request)
    {
        $query = $request->query('query');

        if (!$query) {
            return response()->json([]); // Return empty array if no query
        }

        $employees = \App\Models\Employee::where('emp_first_name', 'LIKE', "%{$query}%")
                        ->orWhere('emp_surname', 'LIKE', "%{$query}%")
                        ->orderBy('emp_first_name', 'asc')
                        ->get(['id', 'emp_first_name', 'emp_surname', 'role']);

        return response()->json($employees);
    }
    public function practice()
    {
        return $this->belongsTo(\App\Models\Practice::class);
    }
}
