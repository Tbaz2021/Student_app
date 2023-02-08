<?php

namespace App\Http\Controllers;

use App\Models\Student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    //
    public function index()
    {


        return view('student.index');
    }


    public function store(Request $request)
    {

        $validate = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'phone' => 'required|max:191',
            'course' => 'required|max:191',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' =>$validate->messages(),
            ]);

        }else{


          Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'course' => $request->course,
          ]);

            return response()->json([
                'status' => 200,
                'message' => 'Student Added Successfully',
            ]);
        }
    }



    public function display(){

        $students = Student::latest()->get();
        return response()->json([

            'students' => $students,
        ]);
    }


    public function edit($id){

        $students = Student::find($id);

        if ($students) {
            return response()->json([
                'status' =>200,
                'student' => $students,
            ]);

        }else{
            return response()->json([
                'status' =>404,
                'message' => 'Student not Found',
            ]);

        }

    }

    public function update(Request $request, $id)
    {
        $validate = Validator::make($request->all(),[
            'name' => 'required|max:191',
            'email' => 'required|max:191',
            'phone' => 'required|max:191',
            'course' => 'required|max:191',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 400,
                'errors' =>$validate->messages(),
            ]);

        }else{


            $students = Student::find($id);
            if ($students) {
                $students->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'course' => $request->course,
                  ]);

                    return response()->json([
                        'status' => 200,
                        'message' => 'Student Updated Successfully',
                    ]);

            }else{
                return response()->json([
                    'status' =>404,
                    'message' => 'Student not Found',
                ]);

            }


        }


    }



    public function destroy($id)
    {

       $students = Student::find($id);
       if ($students) {

        $students->delete();
        return response()->json([
            'status' =>200,
            'message' => 'Student Deleted Successful',
        ]);

    }else{
        return response()->json([
            'status' =>404,
            'message' => 'Student not Found',
        ]);

    }


    }
}
