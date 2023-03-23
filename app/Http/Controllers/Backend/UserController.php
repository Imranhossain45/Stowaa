<?php

namespace App\Http\Controllers\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeUsers = User::where('status', 'publish')->paginate(20);
        $draftUsers = User::where('status', 'draft')->paginate(20);
        $trashUsers = User::onlyTrashed()->orderBy('id', 'desc')->paginate(20);
        return view('backend.user.index', compact('activeUsers', 'draftUsers', 'trashUsers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::whereNotIn('name', ['super-admin'])->get();
        return view('backend.user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photo = $request->file('photo');
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
            'phone' => 'nullable',
            'photo' => 'nullable|mimes:png,jpg,jpeg|max:2000',
        ]);
        if ($photo) {
            $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->save(public_path('storage/user/' . $photoName));
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'email' => $request->phone,
            'photo' => $photoName,
            'password' => Hash::make($request->password),
            'email_verified_at' => Carbon::now(),
        ]);
        $user->assignRole($request->role);
        return back()->with('success','User Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
