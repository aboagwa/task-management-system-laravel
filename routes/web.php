<?php

use App\Http\Requests\TaskRequest;
use App\Models\Task;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
// class Task
// {
//     public function __construct
//     (
//     public int $id,
//     public string $title,
//     public string $description,
//     public ?string $long_description,
//     public bool $completed,
//     public string $created_at,
//     public string $updated_at
//     )
//     {

//     }
// }

// $tasks = [
//     new Task
//     (
//     1,
//     'Buy groceries',
//     'Task 1 description',
//     'Task 1 long description',
//     false,
//     '2023-03-01 12:00:00',
//     '2023-03-01 12:00:00'
//     ),
//     new Task
//     (
//     2,
//     'Sell old stuff',
//     'Task 2 description',
//     null,
//     false,
//     '2023-03-02 12:00:00',
//     '2023-03-02 12:00:00'
//     ),
//     new Task
//     (
//     3,
//     'Learn programming',
//     'Task 3 description',
//     'Task 3 long description',
//     true,
//     '2023-03-03 12:00:00',
//     '2023-03-03 12:00:00'
//     ),
//     new Task
//     (
//     4,
//     'Take dogs for a walk',
//     'Task 4 description',
//     null,
//     false,
//     '2023-03-04 12:00:00',
//     '2023-03-04 12:00:00'
//     ),
// ];



// Route::get('/', function () {
//     return 'Main Page'; //view('welcome');
// });

// Route::get('/', function () {
//     return view('index',[ 
//         // 'name' => 'Hassan'
//     ]);
// });


Route:: get('/',function(){
    return redirect()->route('tasks.index');
});
// Route::get('/tasks', function () use($tasks){
//         return view('index',[ 
//             'tasks' => $tasks
//         ]);
//     })-> name('tasks.index');

Route::view('/tasks/create','create')
->name('tasks.create');
Route::get('/tasks', function (){
    return view('index',[ 
        // 'tasks' => \App\Models\Task::all() //it will fetch all tasks
        'tasks' => Task::latest()->paginate(10) //->get() //it will fetch the latest tasks
        // 'tasks' => \App\Models\Task::latest()->where('completed',true)->get() //it will fetch the completed tasks
        // 'tasks' => Task::latest()->where('completed',true)->get() //it will fetch the completed tasks

    ]);
})-> name('tasks.index');


// Route::post('/tasks',function(Request $request){
//     // dd($request->all());

//     $data = $request -> validate([
//         'title' => 'required|max:255',
//         'description' => 'required',
//         'long_description' => 'nullable',
//     ]);

//     $task = new Task;
//     $task->title = $data['title'];
//     $task->description = $data['description'];
//     $task->long_description = $data['long_description'];
//     $task->save(); //insert query
    
//     return redirect()->route('tasks.show',$task->id)
//     ->with('success','Task created successfully'); //flash message 
// })->name('tasks.store');
// Route::post('/tasks',function(TaskRequest $request){
//     dd($request->all());

//     $data = $request -> validated();
//     $task = new Task;
//     $task->title = $data['title'];
//     $task->description = $data['description'];
//     $task->long_description = $data['long_description'];
//     $task->save(); //insert query

//     $task = Task::create($request -> validated());

//     return redirect()->route('tasks.show',$task->id)
//     ->with('success','Task created successfully'); //flash message 
// })->name('tasks.store');


Route::post('/tasks',function(TaskRequest $request){
    $task = Task::create($request -> validated());
    return redirect()->route('tasks.show',$task->id)
    ->with('success','Task created successfully'); //flash message 
})->name('tasks.store');

Route::put('/tasks/{task}',function(Task $task,TaskRequest $request){
    $task->update($request -> validated());
    return redirect()->route('tasks.show',$task->id)
    ->with('success','Task Updated successfully'); //flash message 
})->name('tasks.update');


Route::delete('/tasks/{task}',function(Task $task){

    $task->delete();
    return redirect()->route('tasks.index')
    ->with('success','Task deleted successfully'); //flash message 
})->name('tasks.destroy');


Route::put('tasks/{task}/toggle-complete',function(Task $task){

    $task->toogleCompleted();

    return redirect()->back()->with('success','Task updated successfully'); //flash message 
})->name('tasks.toggle-complete');

// Route::put('/tasks/{id}',function($id,Request $request){
//     // dd($request->all());

//     $data = $request -> validate([
//         'title' => 'required|max:255',
//         'description' => 'required',
//         'long_description' => 'nullable',
//     ]);

// Route::put('/tasks/{task}',function(Task $task,Request $request){
//     // dd($request->all());

//     $data = $request -> validate([
//         'title' => 'required|max:255',
//         'description' => 'required',
//         'long_description' => 'nullable',
//     ]);

//     $task->title = $data['title'];
//     $task->description = $data['description'];
//     $task->long_description = $data['long_description'];
//     $task->save(); //insert query
    
//     return redirect()->route('tasks.show',$task->id)
//     ->with('success','Task Updated successfully'); //flash message 
// })->name('tasks.update');

// Route::put('/tasks/{task}',function(Task $task,TaskRequest $request){
//     dd($request->all());

//     $data = $request -> validated();
//     $task->title = $data['title'];
//     $task->description = $data['description'];
//     $task->long_description = $data['long_description'];
//     $task->save(); //insert query
    
//     $task->update($request -> validated());

//     return redirect()->route('tasks.show',$task->id)
//     ->with('success','Task Updated successfully'); //flash message 
// })->name('tasks.update');

// Route :: get('/tasks/{id}', function($id)
// {

// return 'one single task';
// })-> name('tasks.show');

// Route:: get('/tasks/{id}',function ($id) use($tasks){
//     $task = collect($tasks) -> firstWhere('id',$id);

//     if(!$task){
//         abort(Response::HTTP_NOT_FOUND);
//     }
//     return view('show',['task' => $task]);
// })-> name('tasks.show');;

// Route:: get('/tasks/{id}/edit',function ($id){ 
//     return view('edit',['task' => Task::findOrFail($id)]);
//     //find or findorfail fetch the database by the primary key
// })-> name('tasks.edit');

Route::post('/tasks/{task}/edit',function (Task $task){ 
    return view('edit',[
        'task' => $task //it will fetch the task by id as normal 
]);
    //find or findorfail fetch the database by the primary key
})-> name('tasks.edit');

// Route:: get('/tasks/{id}',function ($id){ 
//     return view('show',['task' => Task::findOrFail($id)]);
//     //find or findorfail fetch the database by the primary key
// })-> name('tasks.show');

Route:: get('/tasks/{task}',function (Task $task){ 
    return view('show',[
        'task' => $task
    ]);
    //find or findorfail fetch the database by the primary key
})-> name('tasks.show');

Route::get('/hello', function () {
    return 'Hello World';
}) ->name('hello');//to name the route 

//Redirect to another route 

Route :: get('/hallo',function(){
    return redirect()-> route('hello');
    // redirect('/hello');
    // redirect ('hello');
});

//to add dynamic routes
Route :: get('/greet/{name}', function($name){
    return 'hello '.$name .'!';
});

//fallback route 
Route:: fallback(function(){
    return 'still got somewhere';
});

// GET to read data and fetch documents
// POST to store new data  and send forms 
// PUT to update or modify an existing data
// DELETE to delete an existing data