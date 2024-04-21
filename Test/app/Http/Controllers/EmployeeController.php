<?php

namespace App\Http\Controllers;
use App\Models\Employee; 
use Illuminate\Validation\Validator;
use Illuminate\Validation\ValidationException;


use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    
    public function index()
    {
        $employees = Employee::all();
        return view('index', compact('employees'));
    }

   
    public function store(Request $request)
{
    try {
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:employees',
            'phone' => 'required|digits:10|unique:employees',
            'department' => 'required',
            'hobbies' => 'required',
        ]);
        // return  $request->all();


        $employee = new Employee;
        $employee->name = $validatedData['name'];
        $employee->email = $validatedData['email'];
        $employee->phone = $validatedData['phone'];
        $employee->department = $validatedData['department'];
        $employee->hobbies = implode(', ', $validatedData['hobbies']); 

        $employee->save();

        return response()->json(['success' => true, 'message' => 'Employee added successfully']);
    } catch (ValidationException $e) {
        $errors = $e->validator->errors()->toArray();
        return response()->json(['success' => false, 'errors' => $errors], 422);
    }
}

///edit  functionality start///

public function edit($id)
{
    $employee = Employee::find($id);
    return response()->json($employee);
}

//update functionality start////


public function update(Request $request, $id)
{
   // return $request->all(); 
    try {
    $employee = Employee::find($id);
    // return $request->all();
    
    if (!$employee) {
        return response()->json(['error' => 'Employee not found'], 404);
    }
    $employee->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'department' => $request->department,
        'hobbies' =>  $request->hobbies
    ]);

    return response()->json(['success' => 'Employee updated successfully']);
} catch (\Exception $e) {
    return response()->json(['error' => $e->getMessage()], 500);
}

}

//delete functionality startings//////

// public function destroy($id)
// {
//     $employee = Employee::find($id);

//     if (!$employee) {
//         return response()->json(['error' => 'Employee not found'], 404);
//     }

//     $employee->delete();

//     return response()->json(['success' => 'Employee deleted successfully']);
// }

public function destroyMultiple(Request $request)
{
    $employeeIds = $request->input('employeeIds');
    
    Employee::whereIn('id', $employeeIds)->delete();

    return response()->json(['message' => 'Employees deleted successfully']);
}




}
