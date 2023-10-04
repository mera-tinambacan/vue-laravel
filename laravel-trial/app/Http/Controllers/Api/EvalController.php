<?php

namespace App\Http\Controllers\Api;

use App\Models\Employee;
use App\Models\Evaluation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class EvalController extends Controller
{
    public function indexEval()
    {
        $evals = Evaluation::all();
        if($evals->count()>0){

            return response()->json([
                'status' => 200,
                'evals' => $evals
            ], 200);
        }else{

            return response()->json([
                'status' => 404,
                'message' => 'No records found!'
            ], 404);
        }

        
    }

    public function storeEval(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'evalPeriod' => 'required|string|max:191',
            'workLoc' => 'required|string|max:191',
            'project' => 'required|string|max:191', // Add a project field to the validation
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'errors' => $validator->errors()
            ], 422);
        } else {
            // Fetch employee names with the same project
            $project = $request->project;
            $employeeNames = Employee::where('project', $project)->pluck('name')->toArray();

            // Create multiple eval records for each employee with the same project
            foreach ($employeeNames as $employeeName) {
                Evaluation::create([
                    'evalPeriod' => $request->evalPeriod,
                    'workLoc' => $request->workLoc,
                    'projectMembers' => $employeeName, // Assign the employee name to projectMembers
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => "Eval records created Successfully"
            ], 200);
        }
    }
}
