<?php

namespace App\Http\Controllers\API\Task;

use App\Http\Controllers\Controller;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    protected $taskService;

    // Inject the TaskService into the controller
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * Add a new task.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addTask(Request $request)
    {
        
         // Validate input 
         $validator = validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description'=>'nullable',
            'assigned_to' => 'required|exists:users,id', // Ensure the assigned user exists
            'due_date' => 'nullable|date', // Optional due date
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        // Call the addTask method from the service
          $task = $this->taskService->createTask($request);

        // Return the response
        if ($task) {
            return response()->json([
                'status' => true,
                'message' => 'Task added successfully',
                'data' => $task
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to add task'
        ], 400);
    }
    public function assignTask($id,Request $request)
    {

          // Validate the assigned user
          $validator = validator::make($request->all(), [
            'assigned_to' => 'required|exists:users,id', // Ensure the user exists
        ], [
            'assigned_to.required' => 'The assigned user is required.',
            'assigned_to.exists' => 'The selected user does not exist.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }


        $task = $this->taskService->updateTask($id,$request);

        // Return the response
        if ($task) {
            return response()->json([
                'status' => true,
                'message' => 'Task updated successfully',
                'data' => $task
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to update task or task not found'
        ], 400);
    }
    public function markAsComplete($id)
    {
        $task = $this->taskService->completeTask($id);

        // Return the response
        if ($task) {
            return response()->json([
                'status' => true,
                'message' => 'Task completed successfully',
                'data' => $task
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to update task'
        ], 400);
    }
    public function getAllTasks(Request $request)
    {
        $task = $this->taskService->getAllTasks($request);

        // Return the response
        if ($task) {
            return response()->json([
                'status' => true,
                'message' => 'Details Fetch successfully',
                'data' => $task
            ], 201);
        }

        return response()->json([
            'status' => false,
            'message' => 'Failed to get details'
        ], 400);
    }
}
