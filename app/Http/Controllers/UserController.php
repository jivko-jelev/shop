<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function ajax(Request $request)
    {
        $users        = User::select(['id', 'name', 'first_name', 'last_name', 'email', 'created_at', 'sex']);
        $recordsTotal = User::all()->count();

        $ajaxGridColumnNames = [
            0 => 'name',
            1 => 'first_name',
            2 => 'last_name',
            3 => 'sex',
            4 => 'email',
            5 => 'created_at',
        ];

        $users->whereLikeIf('name', $request->get('name'))
              ->whereLikeIf('first_name', $request->get('first_name'))
              ->whereLikeIf('last_name', $request->get('last_name'))
              ->whereIf('sex', $request->get('sex'))
              ->whereLikeIf('email', $request->get('email'))
              ->whereLikeIf('created_at', $request->get('created_at'));

        $recordsFiltered = $users->count();

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

        foreach ($users as $user) {
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
        return view('admin.users.users', ['title' => 'Потребители']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Throwable
     */
    public function edit(User $user)
    {
        return view('admin.users.modal.user', ['user' => $user])->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User                     $user
     * @param \Illuminate\Http\Request $request
     * @param UserRequest              $userRequest
     * @return void
     */
    public function update(User $user, Request $request, UserRequest $userRequest)
    {
        $user->name  = $request->get('name');
        $user->email = $request->get('email');

        if ($request->get('password')) {
            $user->password = bcrypt($request->get('name'));
        }

        $user->first_name = $request->get('first_name') ?? null;
        $user->last_name  = $request->get('last_name') ?? null;
        $user->sex        = $request->get('sex') ?? null;

        $user->save();

        if ($request->ajax()) {
            return response()->json(['message'=> 'Потребителят: <strong>' . $user->name . '</strong><br>' .
                                    'Име: <strong>' . $user->full_name . '</strong>' .
                                    '<br> беше успешно редактиран.']);
        }

        return redirect()->back()->with('message', 'Потребителят беше успешно редактиран.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
    }
}
