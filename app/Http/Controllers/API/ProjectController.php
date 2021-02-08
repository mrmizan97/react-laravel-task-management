<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $data=Project::withCount('tasks')->latest()->get();
        if (is_null($data)) {
            return response()->json([
                'success'=>false,
                'msg'=>'Project List',
                'data'=>null,
            ]);
        }
        return response()->json([
            'success'=>true,
            'msg'=>'Project List',
            'data'=>$data,
        ]);
    }
    public function projecWithTask($id)
    {
        $data=Project::with('tasks')->find($id);
        return response()->json([
            'success'=>true,
            'msg'=>'Project with task',
            'data'=>$data,
        ]);
    }
    public function store()
    {
        $validator = Validator::make(Request::all(), [
            'name'            => 'required|string',
            'description'            => 'required|string',
            // 'user'            => 'required',
        ]);
       
        if ($validator->fails()) {
            return response([
                        'error'=>$validator->errors()
                    ], 400);
        }
        $project=new Project();
        $project->name=Request::get('name');
        $project->description=Request::get('description');
        // $project->status=Request::get('status');
        $project->status=0;
        $project->user_id=Request::get('user');
        $project->save();
        return response()->json([
            'success'=>true,
            'msg'=>'Project created.',
            'data'=>$project,
        ]);
    }
    public function edit( $id)
    {
        $item=Project::find($id);
        return response()->json([
            'success'=>true,
            'msg'=>'Project deleted.',
            'data'=>$item
        ]);
    }
    public function update( $id)
    {
        
        $validator=Validator::make(Request::all(), [
            'name'=>['required','string'],
            'description'=>['required','string'],
            'user'=>['required',Rule::exists('users','id')],
        ]);
        if ($validator->fails()) {
            return response([
                        'error'=>$validator->errors()
                    ], 400);
        }
        $project=Project::find($id);
        $project->name=Request::get('name');
        $project->description=Request::get('description');
        $project->status=Request::get('status');
        $project->user_id=Request::get('user');
        $project->save();
        return response()->json([
            'success'=>true,
            'msg'=>'Project updated.',
            'data'=>$project,
        ]);
    }
    public function destroy(Project $item)
    {
        $item->delete();
        return response()->json([
            'success'=>true,
            'msg'=>'Project deleted.',
            
        ]);
    }
}
