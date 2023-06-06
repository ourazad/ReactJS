<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; 

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
      
       // Return Json Response
       return response()->json([
          'employees' => $employees
       ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $employee = new Employee();

        if($request->hasfile('image'))
        {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
            $employee->image = $imageName;
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
        }

        $employee->name = $request->name;
        $employee->save();

        return response()->json([
            'message' => "Employee successfully created."
        ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Same as edit code
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // employee Detail 
       $employee = Employee::find($id);
       if(!$employee){
         return response()->json([
            'message'=>'Employee Not Found.'
         ],404);
       }
      
       // Return Json Response
       return response()->json([
          'employee' => $employee
       ],200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $employee =  Employee::find($id);

        if($request->hasfile('image'))
        {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
            $employee->image = $imageName;
            Storage::disk('public')->put($imageName, file_get_contents($request->image));
        }

        $employee->name = $request->name;
        $employee->save();

        return response()->json([
            'message' => "Employee successfully updated."
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Detail 
        $employee = Employee::find($id);
        if(!$employee){
          return response()->json([
             'message'=>'employee Not Found.'
          ],404);
        }
      
        // Public storage
        $storage = Storage::disk('public');
      
        // Iamge delete
        if($storage->exists($employee->image))
            $storage->delete($employee->image);
      
        // Delete Product
        $employee->delete();
      
        // Return Json Response
        return response()->json([
            'message' => "employee successfully deleted."
        ],200);
    }
}
