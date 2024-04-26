<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Resources\TaskResource;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Models\Task;
use Auth;
class TaskController extends Controller
{

    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       return TaskResource::collection(
        Task::where('user_id',Auth::user()->id)->get()
       );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        
        $request->validated($request->all());
        $task = Task::create([
            'user_id'=>Auth::user()->id,
            'name'=>$request->name,
            'description'=>$request->description,
            'priority'=>$request->priority
        ]);

        return new TaskResource($task);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return ($this->isNotAuthorized($task)) ? $this->isNotAuthorized($task):new TaskResource($task);;

        
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
       
        if ($this->isNotAuthorized($task)) {
            return ($this->isNotAuthorized($task)) ;
        }
 
        $task->name = (!empty($request->name))?$request->name:$task->name;
        $task->description = (!empty($request->description))?$request->description:$task->description;
        $task->priority = (!empty($request->priority) && (in_array($request->priority,['low','medium','high'])))?$request->priority:$task->priority;
        $task->save();
        // $task->update([
            
        //     'name'=>$request->name,
        //     'description'=>$request->description,
        //     'priority'=>$request->priority
        // ]);

        return new TaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task )
    {
        if ($this->isNotAuthorized($task)) {
            return ($this->isNotAuthorized($task)) ;
        }

         $task->delete();
           return  $this->success('','deleted',200);
    }

    private function isNotAuthorized(Task $task){
      
        if(Auth::user()->id !== $task->user_id  ){
            return $this->error('','you have no power here!',403);
        }
    }
}
