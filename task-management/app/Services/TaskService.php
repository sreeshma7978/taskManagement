<?php

namespace App\Services;

use App\Jobs\sendEmailJob;
use App\Models\Task;
use App\Models\User;
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
        return $task;
    }
    public function updateTask($id, Request $request)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return false;
        }
        
        // Update the task's assigned user
        $task->update(['assigned_to' => $request->assigned_to]);
        
        // Get the user who is being assigned the task
        $user = User::select('name','email')->where('id',$request->assigned_to)->first();
        
        if ($user) {
            // Dispatch email job with user and updated task data
            sendEmailJob::dispatch($user->email, $user, $task);
        }
        
        return true;}
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
        if ($request->has('id')) 
            $tasks->where('id',$request->id);
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
