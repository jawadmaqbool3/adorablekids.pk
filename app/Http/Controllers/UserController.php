<?php

namespace App\Http\Controllers;

use App\Core\Helper;
use App\Exceptions\CustomException;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $thumbWidth;
    private $thumbHeight;
    private $profileDirectory;
    public function __construct()
    {
        $this->thumbWidth = 200;
        $this->thumbHeight = 200;
        $this->profileDirectory = 'assets/media/users/profile/';
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return User::dataTable();
        }
        return view('users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $roles = Role::get();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'co_password' => 'required|min:8',
            'email' => 'required|unique:users,email',
            'name' => 'required|min:3',
            'role' => 'required',
            'status' => 'required',
        ]);
        DB::beginTransaction();
        try {
            if ($request->password != $request->co_password) {
                throw new CustomException('Password mismatch', 'error');
            }
            $role = Role::where('uid', $request->role)->first();
            if (!$role) {
                throw new CustomException('Role does not exist', 'error');
            }
            $image = '';
            if ($request->file('image')) {
                $image = Helper::uploadfile([
                    'file' => $request->file('image'),
                    'path' => $this->profileDirectory,
                    'width' => $this->thumbWidth,
                    'height' => $this->thumbHeight,
                ]);
            }
            $password = Hash::make($request->password);
            $user = User::create([
                'name' => $request->name,
                'password' => $password,
                'email' => $request->email,
                'status' => $request->status,
                'image' => $image
            ]);
            $user->refresh();
            UserRole::create([
                'role_id' => $role->id,
                'user_id' => $user->id
            ]);
            DB::commit();
            return response([
                'success' => true,
                'message' => 'Record Added',
                'redirect' => true,
                'url' => route('users.index'),
            ]);
        } catch (CustomException $e) {
            DB::rollBack();
            return response([
                $e->getLevel() => true,
                'message' => $e->getMessage(),
                'console' => $e->getMessage(),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'error' => true,
                'message' => 'Something went wrong',
                'console' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        return view('users.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|min:3',
            'role' => 'required',
            'status' => 'required',
        ]);
        DB::beginTransaction();
        try {
            if ($request->password && $request->password != $request->co_password) {
                throw new CustomException('Password mismatch', 'error');
            }
            $role = Role::where('uid', $request->role)->first();
            if (!$role) {
                throw new CustomException('Role does not exist', 'error');
            }
            if (User::where('email', $request->email)->where('id', '!=', $user->id)->exists()) {
                throw new CustomException('Email already has been taken', 'error');
            }
            $image = $user->image;
            if ($request->file('image')) {
                if ($user->image) {
                    Helper::deleteExcept([
                        'files' => [$user->image],
                        'exceptions' => [],
                        'path' => $this->profileDirectory
                    ]);
                }
                $image = Helper::uploadfile([
                    'file' => $request->file('image'),
                    'path' => $this->profileDirectory,
                    'width' => $this->thumbWidth,
                    'height' => $this->thumbHeight,
                ]);
            }
            $password = $user->password;
            if ($request->password) {
                $password = Hash::make($request->password);
            }
            User::where('id', $user->id)->update([
                'name' => $request->name,
                'password' => $password,
                'email' => $request->email,
                'status' => $request->status,
                'image' => $image
            ]);
            UserRole::where('user_id', $user->id)->delete();
            UserRole::create([
                'role_id' => $role->id,
                'user_id' => $user->id
            ]);
            DB::commit();
            return response([
                'success' => true,
                'message' => 'Record Updated',
                'redirect' => true,
                'url' => route('users.index'),
            ]);
        } catch (CustomException $e) {
            DB::rollBack();
            return response([
                $e->getLevel() => true,
                'message' => $e->getMessage(),
                'console' => $e->getMessage(),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'error' => true,
                'message' => 'Something went wrong',
                'console' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        Helper::deleteExcept([
            'files' => [$user->image],
            'exceptions' => [],
            'path' => $this->profileDirectory
        ]);
        $user->delete();
        return response([
            'success' => true,
            'message' => 'Record Deleted',
            'table_reload' => true,
        ]);
    }


    public function customerRegistrationForm()
    {
        return view('user.registration_form');
    }

    public function customerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'cell_no' => 'required|max:10|min:8',
            'email' => 'required|max:20|min:7',
            'password' => 'required|confirmed|min:8|max:15',
        ]);
        DB::beginTransaction();
        try {

            $role = Role::where('name', 'customer')->first();
            if (!$role) {
                throw new CustomException('Role does not exist', 'error');
            }
            if (User::where('email', $request->email)->exists()) {
                throw new CustomException('Email already has been taken', 'error');
            }
            $image  = '';
            if ($request->file('image')) {
                $image = Helper::uploadfile([
                    'file' => $request->file('image'),
                    'path' => $this->profileDirectory,
                    'width' => $this->thumbWidth,
                    'height' => $this->thumbHeight,
                ]);
            }
            if ($request->password) {
                $password = Hash::make($request->password);
            }
            $user = User::create([
                'name' => $request->name,
                'password' => $password,
                'email' => $request->email,
                'status' => 'active',
                'image' => $image
            ]);
            $user->refresh();
            UserRole::create([
                'role_id' => $role->id,
                'user_id' => $user->id
            ]);
            DB::commit();
            auth()->loginUsingId($user->uid);
            return response([
                'success' => true,
                'message' => 'Email confirmation link is sent to you. Please confirm to continue',
                'redirect' => true,
                'url' => route('dashboard'),
            ]);
        } catch (CustomException $e) {
            DB::rollBack();
            return response([
                $e->getLevel() => true,
                'message' => $e->getMessage(),
                'console' => $e->getMessage(),
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return response([
                'error' => true,
                'message' => 'Something went wrong',
                'console' => $e->getMessage(),
            ]);
        }
    }
}
