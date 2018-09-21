<?php

namespace App\Http\Controllers;

use Auth;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

  public function __construct()
  {
    $this->middleware('auth');
  }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::where(['user_id' => Auth::user()->id])->get();
        return response()->json([
          'tasks' => $tasks,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'name'        => 'required|max:255',
        'description' => 'required'
        ]);

        $task = Task::create([
          'name'        => request('name'),
          'description' => request('description'),
          'user_id'     => Auth::user()->id
        ]);

        return response()->json([
          'task'    => $task,
          'message' => 'Tarea creada exitosamente!'
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
      $this->validate($request, [
        'name'        => 'required|max:255',
        'description' => 'required',
      ]);

      $task->update($request->all());

      return response()->json([
        'message' => 'Tarea actualizada exitosamente!'
      ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
      $task->delete();

      return response()->json([
        'message' => 'Tarea eliminada exitosamente!'
      ]);
    }
}
