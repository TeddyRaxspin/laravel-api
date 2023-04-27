<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    public function index(){

        $students = Student::all();

        if($students -> count() > 0) {
            return response()->json([
                'status' => 200,
                'students' => $students
            ],200);
        } else{
            return response()-> json([
                'status' => 404,
                'message' => 'No Records Found!'
            ], 404);
        }


    }


    //Create a record
    public function store(Request $request){
        //validate input
        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        //check validation status
        if ($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else{
            $student = Student::create([
                'name' => $request->name,
                'course' => $request->course,
                'email' => $request->email,
                'phone' => $request->phone
            ]);

            //create record upon successful validation
                if ($student){
                    return response()->json([
                        'status' => 200,
                        'message' => 'Record Created Successfully!'
                    ],200);
                }else{
                    return response()->json([
                        'status' => 500,
                        'message' => 'Oops! Something Went Wrong'
                    ],500);
                }
        }
    }

    //Query One Record
    public function show ($id){

        $student = Student::find($id);

        if ($student){

            return response()->json([
                'status' => 200,
                'student' => $student
            ],200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Student Found With Such A Record!'
            ],404);
        }
    }


    //Edit A Record
    public function edit($id){

        $student = Student::find($id);

        if ($student){

            return response()->json([
                'status' => 200,
                'student' => $student
            ],200);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Student Found With Such Record!'
            ],404);
        }
    }


    //Update A Record

    public function update(Request $request, int $id){

        $validator = Validator::make( $request->all(),[
            'name' => 'required|string|max:191',
            'course' => 'required|string|max:191',
            'email' => 'required|email|max:191',
            'phone' => 'required|digits:10',
        ]);

        //check validation status
        if ($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ], 422);
        } else{

            $student = Student::find($id);

            //update record upon successful validation
            if ($student){

                $student -> update([
                    'name' => $request->name,
                    'course' => $request->course,
                    'email' => $request->email,
                    'phone' => $request->phone
                ]);

                return response()->json([
                    'status' => 200,
                    'message' => 'Record Updated Successfully!'
                ],200);

            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'No Student Found With Such Record!'
                ],404);
            }
        }


    }

    // Delete A Record

    public function destroy($id){

        $student = Student::find($id);

        if($student){

            $student-> delete();

            return response()->json([
                'status' => 200,
                'message' => 'Record Deleted Successfully!'
            ]);

        }else{
            return response()->json([
                'status' => 404,
                'message' => 'No Student Found With Such Record!'
            ],404);
        }

    }
}
