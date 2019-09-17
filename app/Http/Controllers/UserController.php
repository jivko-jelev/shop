<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function ajax(Request $request)
    {
        $users = User::select(['name', 'first_name', 'last_name', 'sex', 'email', 'id']);

        $recordsTotal    = User::all()->count();
        $recordsFiltered = $recordsTotal;

        $ajaxGridColumnNames = [
            0 => 'name',
            1 => 'first_name',
            2 => 'last_name',
            3 => 'sex',
            4 => 'email',
        ];

        $orderState = $request->get('order');
        foreach ($orderState as $singleOrderState) {
            $users->orderBy($ajaxGridColumnNames[$singleOrderState['column']], $singleOrderState['dir']);
        }

        if ($request->input('start') > 0) {
            $users->skip($request->input('start'));
        }
        if ($request->input('length') > 0) {
            $users->take($request->input('length'));
        }

        $users = $users->get();

        foreach ($users as $key => $user) {
            $user->actions = view('admin.users.layouts.users-actions')->with('user', $user)->render();
        }

        return response()->json([
            'data'            => $users,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', ['title' => __('Потребител: :0', [$user->name]), 'user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest              $user
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function update(Request $request, UserRequest $user)
    {
        return redirect()->back()->with('message', 'ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
