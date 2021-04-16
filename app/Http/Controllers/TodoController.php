<?php

namespace App\Http\Controllers;

use App\Http\Requests\newTodo;
use App\Http\Requests\updateTodo;
use App\Models\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class TodoController extends Controller
{
    /**
     * lists all the todos in datatable
     * GET - index
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $allTodos = Todo::all();

        return view('todos.list', ['todos' => $allTodos]);
    }

    /**
     * Create new view template
     * GET method
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\View\View
     */
    public function create(Request $request)
    {
        return view('todos.new');
    }

    /**
     * Create
     * POST method
     * @param newTodo $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function createNew(newTodo $request)
    {
        $input = $request->input();
        // use db entity
        if (Todo::create([
            'description' => $input['description'],
            'checked' => isset($input['checked'])
        ])) {
            Session::flash('success', 'Successful Todo added');
        } else {
            Session::flash('error', 'Failed to save new todo');
        }
        return redirect('/');
    }

    /**
     * single edit form
     * GET method
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function editUpdate(Request $request, Todo $todo)
    {
        if (!$todo) {
            Session::flash('error', 'Unknown ID');
            return redirect('/');
        }
        return view('todos.edit', ['todo' => $todo]);
    }

    /**
     * single edit submission
     * POST method - /edit/{todoId}
     * @param \App\Http\Requests\updateTodo $request
     * @param \App\Models\Todo $todo
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application
     */
    public function update(updateTodo $request, Todo $todo)
    {
        $todo->description = $request->input('description');
        $todo->checked = (bool)$request->input('checked');
        if(!$todo->save()) {
            Session::flash('error', 'Failed to update');
        } else {
            Session::flash('success', 'Successful Todo saved');
        }
        return redirect('/edit/' . $todo->id);
    }

    /**
     * single edit submission
     * POST method - /api/update/{id}/{completed}
     *
     * @param Request $request
     * @param Todo $todo  record
     * @param string $checked mark completed
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updateChecked(Request $request, Todo $todo, string $checked)
    {
        $todo->checked = $checked === '1';
        $message['status'] = $checked;
        $message['message'] = ($todo->save() ? 'Saved' : 'Failed to update');
        return response($message)->header('Content-type', 'application/json');
    }

    /**
     * Deletes a todo
     * DELETE method - /api/delete/{id}
     *
     * @param Request $request
     * @param string $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request, Todo $todo)
    {
        $check = $todo->delete();
        $message['status'] = $check ? '1': '0';
        $message['message'] = ($check ? 'Successfully Deleted' : 'Failed to delete');
        return response($message)->header('Content-type', 'application/json');
    }
}
