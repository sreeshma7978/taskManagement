Task Management System

This project is a simple Laravel-based API for managing tasks, implementing core concepts such as authentication, queues, jobs, middleware, and task scheduling.


Features

   User Registration and Authentication with Laravel Sanctum
  
  Task Management: Create, Assign, Mark as Completed, and List tasks
  
   Queue & Job: Sends notification emails asynchronously when tasks are assigned
  
  Custom Middleware: Logs request execution time
  
   Scheduled Command: Automatically marks overdue tasks as expired


Prerequisites

  PHP 8.3+

  Laravel 12+

  Composer

   MySQL



  Installation

Follow these steps to get the application up and running on your local machine.

Step 1: Clone the repository

git clone https://github.com/sreeshma7978/taskManagement.git

cd task-management

Step 2: Install dependencies

Run the following command to install all required dependencies via Composer:

composer install

Step 3: Set up the environment file

Create a .env file by copying the example:
cp .env.example .env
Step 4: Configure the database

Edit the .env file to configure your database connection. For example:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=

Step 5: Generate application key

Run the following command to generate a new application key:

php artisan key:generate

Step 6: Migrate the database

Run the migrations to set up the database schema:

php artisan migrate

Step 7: Set up Queue (Database Driver)

Ensure you have the database driver configured in .env:

QUEUE_CONNECTION=database


Step 9: Set up Mail Configuration

Configure your .env file for email notifications (e.g., using SMTP):

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@taskmanager.com
MAIL_FROM_NAME="${APP_NAME}"

Step 10: Run the Application

Start the development server:

php artisan serve

API Endpoints
Authentication Endpoints

Register a new user


  POST /api/register

  Request body:

{
  "name": "John Doe",
  "email": "johndoe@example.com",
  "password": "secret",
  "password_confirmation":"secret"
}



Login a user

   POST /api/login

  Request body:

{
  "email": "johndoe@example.com",
  "password": "secret"
}

Response:

{
  "token": "apiToken"
}

Logout a user

  POST /api/logout

  Headers:

  Authorization: Bearer {token}

  Description: Logs out the authenticated user by invalidating the API token.

  ResponTask Schedulerse:

{
  "message": "Successfully logged out"
}


Task Management Endpoints
Create a new task

   POST /api/tasks

  Request body:

{
  "title": "Task Title",
  "description": "Task description",
  "assigned_to":"1",//user id
  "due_date": "2025-03-16 12:00:00"
}

Assign a task to a user

   PUT /api/tasks/{id}/assign

  Request body:

   {
          "assigned_to": 2
      }

Mark a task as completed

   PUT /api/tasks/{id}/complete

List all tasks with filters

  GET /api/tasks?status=pending&assigned_to=2

  Task Scheduler

The scheduler runs every hour and marks overdue tasks as "expired."

Queue and Job

When a task is assigned to a user, a notification email is sent asynchronously via Laravel's queue system.

Middleware

A custom middleware logs request execution time in storage/logs/laravel.log.
Conclusion

This Laravel-based Task Management API provides a simple yet comprehensive example of how to implement modern features like authentication, queues, middleware, and task scheduling. It demonstrates best practices in Laravel application architecture and can be further extended with additional features such as user roles, comments, etc.
