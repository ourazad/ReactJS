<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage; 

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
      
       // Return Json Response
       return response()->json([
          'customers' => $customers
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

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $customer = new Customer();

        if($request->hasfile('image'))
        {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
            $customer->image = $imageName;

            Storage::disk('public')->put($imageName, file_get_contents($request->image));
            // $name = $request->file('image')->getClientOriginalName();
            // $customer->image = $name;
            // $path = $request->file('image')->storeAs('public/images/customer', $name);
            // $customer->image = $path;
        }

        $customer->name = $request->name;
        $customer->save();

        return response()->json([
            'message' => "Product successfully created."
        ],200);
        
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       // Product Detail 
       $customer = Customer::find($id);
       if(!$customer){
         return response()->json([
            'message'=>'customer Not Found.'
         ],404);
       }
      
       // Return Json Response
       return response()->json([
          'customer' => $customer
       ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required',
        ]);

        $customer = Customer::find($id);

        if($request->hasfile('image'))
        {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);
            $imageName = Str::random(32).".".$request->image->getClientOriginalExtension();
            $customer->image = $imageName;

            Storage::disk('public')->put($imageName, file_get_contents($request->image));
            // $name = $request->file('image')->getClientOriginalName();
            // $customer->image = $name;
            // $path = $request->file('image')->storeAs('public/images/customer', $name);
            // $customer->image = $path;
        }

        $customer->name = $request->name;
        $customer->save();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Detail 
        $customer = Customer::find($id);
        if(!$customer){
          return response()->json([
             'message'=>'Product Not Found.'
          ],404);
        }
      
        // Public storage
        $storage = Storage::disk('public');
      
        // Iamge delete
        if($storage->exists($customer->image))
            $storage->delete($customer->image);
      
        // Delete Product
        $customer->delete();
      
        // Return Json Response
        return response()->json([
            'message' => "Product successfully deleted."
        ],200);
    }

    // new image delete

    public function deleteImage($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            
            if (!empty($customer->image)) {
                // Delete the old image file
                Storage::delete($customer->image);
                
                // Clear the image field in the customer record
                $customer->image = null;
                $customer->save();
            }
            
            return response()->json(['message' => 'Customer image deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete customer image'], 500);
        }
    }

}