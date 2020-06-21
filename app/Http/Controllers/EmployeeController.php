<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Http\Resources\EmployeeCollection;
use App\Http\Resources\Employee as EmployeeResource;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return EmployeeCollection
     */
    public function index()
    {
        return new EmployeeCollection(Employee::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //I like to keep this function for others programmers to see the difference between "create" and "store"
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:employees',
            'gender' => 'required|in:male,female',
            'job' => 'max:255',
        ]);

        $employee = Employee::create($request->all());

        return (new EmployeeResource($employee))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return EmployeeResource
     */
    public function show($id)
    {
        return new EmployeeResource(Employee::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     */
    public function edit($id)
    {
        //I like to keep this function for others programmers to see the difference between "edit" and "update"
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return EmployeeResource
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|max:255',
            'gender' => 'required|in:male,female',
            'job' => 'max:255',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->name = $request->get('name');
        $employee->email = $request->get('email');
        $employee->gender = $request->get('gender');
        $employee->job = $request->get('job');

        $employee->save();

        return new EmployeeResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();

        return response()->json(null, 204);
    }
}
