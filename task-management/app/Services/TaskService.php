<?php

namespace App\Services;

use App\Jobs\sendEmailJob;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskService
{
    
    public function createTask(Request $request)
    {
       
        // Create the task
        $task = Task::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'assigned_to' => $request['assigned_to'],
            'due_date' => $request['due_date'],
            'created_by' => $request->user()->id,
            'updated_by' => $request->user()->id

        ]);
        return 3;
        return $task;
    }
    public function updateTask($id,Request $request)
    {
       
        // Update the task's assigned user
        $update =Task::where('id', $id)->first()?->update(['assigned_to' => $request->assigned_to]);
        $email = "sreeshma7978@gmail.com";
        sendEmailJob::dispatch($email);


        return $update;
    }
    public function completeTask($id)
    {
        $update =Task::where('id', $id)->first()?->update(['status' => 'completed']);
        return $update;
    }
    public function getAllTasks($request)
    {
        $user = $request->user();
         $tasks = Task::select('id','title','description','due_date','status');
         $tasks =$tasks->where(function($query) use ($user) {
            $query->where('created_by', $user->id)
                  ->orWhere('assigned_to', $user->id);
        });

        if ($request->has('status')) 
            $tasks->where('status',$request->status);
        if ($request->has('title')) 
            $tasks->where('title',$request->title);
        if ($request->has('due_date')) 
            $tasks->where('due_date',$request->due_date);
        if ($request->has('assigned_to')) 
            $tasks->where('assigned_to',$request->assigned_to);
         $tasks = $tasks->get();
         return $tasks;
    }
}
