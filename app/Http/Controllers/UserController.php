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
        $users           = User::select(['id', 'name', 'first_name', 'last_name', 'email', 'created_at', 'sex']);
        $recordsTotal    = User::all()->count();
        $recordsFiltered = $recordsTotal;

        $ajaxGridColumnNames = [
            0 => 'name',
            1 => 'first_name',
            2 => 'last_name',
            3 => 'sex',
            4 => 'email',
            5 => 'created_at',
        ];


        $users->when($request->get('search')['value'], function ($query) use ($request) {
            $query->where(function ($query) use ($request) {
                $query->where('first_name', 'like', "%{$request->get('search')['value']}%")
                      ->orWhere('last_name', 'like', "%{$request->get('search')['value']}%")
                      ->orWhere('name', 'like', "%{$request->get('search')['value']}%")
                      ->orWhere('sex', 'like', "%{$request->get('search')['value']}%")
                      ->orWhere('email', 'like', "%{$request->get('search')['value']}%");
            });
        });

        $orderState = $request->get('order');
        foreach ($orderState as $singleOrderState) {
            $users->orderBy($ajaxGridColumnNames[$singleOrderState['column']], $singleOrderState['dir']);
        }

        $users->skip($request->input('start'))->take($request->input('length'));

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
            return response()->json('{"message": "Потребителят: <strong>' .
                                    $user->name .
                                    '</strong><br>' .
                                    'Име: <strong>' . $user->full_name . '</strong>' .
                                    '<br> беше успешно редактиран."}');
        }

        return redirect()->back()->with('message', 'Потребителят беше успешно редактиран.');
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
