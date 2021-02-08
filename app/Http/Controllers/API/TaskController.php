<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    
    public function index()
    {
        $data=Task::all();
        if (is_null($data)) {
            return response()->json([
                'success'=>false,
                'msg'=>'Task List',
                'data'=>null,
            ]);
        }
        return response()->json([
            'success'=>true,
            'msg'=>'Task List',
            'data'=>$data,
        ]);
    } public function taskWithProject($id){
        $data=Task::with('project')->find($id);
        return response()->json([
            'success'=>true,
            'msg'=>'Task with Project',
            'data'=>$data,
        ]);
    }
    public function store()
    {
        $validator = Validator::make(Request::all(), [
            'name'            => 'required|string',
            'description'            => 'required|string',
            'project'            => 'required',
        ]);
       
        if ($validator->fails()) {
            return response([
                        'error'=>$validator->errors()
                    ], 400);
        }
        $task=new Task();
        $task->name=Request::get('name');
        $task->description=Request::get('description');
        $task->status=Request::get('status');
        $task->project_id=Request::get('project');
        $task->save();
        return response()->json([
            'success'=>true,
            'msg'=>'Item created.',
            'data'=>$task,
        ]);
    }public function edit(Task $item)
    {
        
        return response()->json([
            'success'=>true,
            'msg'=>'Item ',
            'data'=>$item
        ]);
    }
    public function update(Task $item)
    {
       
        // $validator = Validator::make($formdata, [
        //     'name'            => 'required|string',
        //     'description'            => 'required|string',
        //     'project'            => 'required',
        // ]);
       $validator=Validator::make(Request::all(), [
           'name'=>['required','string'],
           'description'=>['required','string'],
           'project'=>['required',Rule::exists('projects','id')],
       ]);
        if ($validator->fails()) {
            return response([
                        'error'=>$validator->errors()
                    ], 400);
        }
        // $item->update([
        //     'name'=>Request::get('name'),
        //     'description'=>Request::get('description'),
        //     'status'=>Request::get('status'),
        //     'project_id'=>Request::get('project'),
        // ]);
        $item->name=Request::get('name');
        $item->description=Request::get('description');
        $item->status=Request::get('status');
        $item->project_id=Request::get('project');
        $item->update();
        return response()->json([
            'success'=>true,
            'msg'=>'Item updated.',
            'data'=>$item,
        ]);
    }
    public function destroy(Task $item)
    {
        $item->delete();
        return response()->json([
            'success'=>true,
            'msg'=>'Item deleted.',
            
        ]);
    }
}
