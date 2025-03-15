<!-- resources/views/emails/tasks/assigned.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background-color: #f8f9fa; padding: 20px; border: 1px solid #ddd; border-radius: 5px;">
        <h2>New Task Assigned</h2>
        
        <p>Hi {{ $user->name }},</p>
        
        <p>A new task has been assigned to you:</p>
        
        <div style="background-color: white; padding: 15px; margin: 15px 0; border-radius: 4px; border: 1px solid #eee;">
            <p><strong>Title:</strong> {{ $task->title }}</p>
            <p><strong>Description:</strong> {{ $task->description }}</p>
            <p><strong>Due Date:</strong> {{ $task->due_date }}</p>
        </div>
        
        <p>You can view this task by <a href="{{ url('/tasks/'.$task->id) }}">clicking here</a>.</p>
        
        <p>Thank you,<br>{{ config('app.name') }} Team</p>
    </div>
   
</body>
</html>