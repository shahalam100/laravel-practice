<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserDetail;
use \Illuminate\Http\UploadedFile;

class UserDetailController extends Controller
{
    public function index(){
        $users = UserDetail::all();
        return view('index', compact('users'));
    }

    public function create(){
        return view('create');
    }

    public function store(Request $request){


        // $allData = $request->all();

        // echo '<pre>';
        // print_r($allData); 
        // print_r($request->file('docs')); 
        // echo '</pre>';
        // die();

        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female,other',
            'email' => 'required|email|max:255|unique:user_details,email',
            'password' => 'required|string|min:8|confirmed',
            'skills' => 'required|array|min:1',
            'skills.*' => 'required|string|distinct|max:255',
            'docs' => 'required|mimes:pdf,jpeg,png,jpg,gif|max:10240',  //10mb
            'phone' => 'required|string|max:10',
            'country' => 'required|in:India,USA,UK,Canada,Australia'

        ],[
            'docs.mimes' => 'Only PDF, JPEG, PNG, JPG, and GIF files are allowed..',
        ]);

        $skills = implode(',', $request->skills);
        //Handle File Upload..
        $fileName = null;
        if($request->hasFile('docs')){
            $file = $request->file('docs');
            $fileName = $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);
        }

        // Insert Data
        UserDetail::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'gender'     => $request->gender,
            'email'      => $request->email,
            'password'   => bcrypt($request->password), // Securely hashes the password [2]
            'skills'     =>  $skills,
            'docs'       => $fileName,                 // Assumes $fileName is processed beforehand
            'phone'      => $request->phone,
            'country'    => $request->country,
        ]);

        // Redirect with flash message
        return redirect()->route('users.index')->with('success', 'User Added Successfully');

    }

    public function edit($id)
    {
        $user = UserDetail::findOrFail($id);
        return view('edit', compact('user'));
    }

    public function update(Request $request, $id){

        $user = UserDetail::findOrFail($id);

        //Validation
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'email' => 'required|email|unique:user_details,email,' . $id,
            'phone' => 'required',
            'country' => 'required'
        ]);

        //File Upload (optional)
        if ($request->hasFile('docs')) {
            $file = $request->file('docs');
            $fileName = $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $fileName);

            $user->docs = $fileName;
        }

        //Skills
        $skills = $request->skills ? implode(',', $request->skills) : null;

        //Update Data
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'gender' => $request->gender,
            'email' => $request->email,
            'skills' => $skills,
            'phone' => $request->phone,
            'country' => $request->country,
        ]);

        //Update password only if entered
        if ($request->password) {
            $user->update([
                'password' => bcrypt($request->password)
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User Updated Successfully');
    }

}
