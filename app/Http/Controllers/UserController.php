<?php

namespace App\Http\Controllers;

use App\Core\Helper;
use App\Exceptions\CustomException;
use App\Mail\ForgotPassword;
use App\Mail\UserRegistered;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\HttpException;

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
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('user.registration_form');
    }

    public function customerStore(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'cell_no' => 'required|max:10|min:8',
            'email' => 'required|max:30|min:7',
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
            Mail::to($user)->send(new UserRegistered($user));
            return response([
                'success' => true,
                'message' => 'Email confirmation link is sent to your email address. Please confirm to continue',
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

    public function logout(Request $request)
    {
        auth()->logout();
        return response([
            'success' => true,
            'reload' => true,
        ]);
    }



    public function loginForm()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('user.login');
    }



    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (auth()->attempt($credentials)) {
            if (auth()->user()->email_verified_at == null) {
                auth()->logout();
                return response([
                    'warning' => true,
                    'message' => "Your account is not confirmed, please check your email and confirm your account",
                ]);
            }
            return response([
                'success' => true,
                'reload' => true,
            ]);
        } else {
            return response([
                'warning' => true,
                'message' => 'Credentials doesn\'t match any account. try forget password to recover your password',
            ]);
        }
    }

    public function customerForgotPasswordForm()
    {
        if (auth()->check()) {
            return redirect()->route('dashboard');
        }
        return view('user.forget_password');
    }


    public function user(User $user)
    {
        if (!$user || $user->email_verified_at) {
            throw new HttpException(403);
        } else {
            $now = Carbon::now()->format('Y-m-d H:i:s');
            $user->email_verified_at = $now;
            $user->save();
            auth()->loginUsingId($user->id);
            return redirect()->route('dashboard');
        }
    }

    public function confirm(User $user)
    {
        if ($user->email_verified_at == null) {
            auth()->loginUsingId($user->uid);
            $user->email_verified_at = Carbon::now()->format('Y-m-d H:i:s');
            $user->save();
            return redirect()->route('dashboard');
        } else {
            throw new HttpException(498);
        }
    }


    public function resetPasswordForm($token)
    {
        $user  = User::where('remember_token', $token)->first();
        if ($user) {
            return view('user.reset_password', compact('user'));
        } else {
            throw new HttpException(498);
        }
    }

    public function resetPassword($token, Request $request)
    {
        $user = User::where('remember_token', $token)->first();
        if ($user) {
            $request->validate([
                'password' => 'required|confirmed|min:8|max:15',
            ]);
            $user->password = Hash::make($request->password);
            $user->remember_token = null;
            $user->save();
            return response([
                'success' => true,
                'message' => 'Password Updated, try to login using new password',
                'redirect' => true,
                'url' => route('login.form')
            ]);
        } else {
            return response([
                'warning' => true,
                'message' => 'Reset password link is expired, try again with new page.',
            ]);
        }
        return redirect()->route('dashboard');
    }

    public function forgotPassword(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = rand(1000000, 9999999);
            $user->remember_token = $user->id . $token;
            $user->save();
            Mail::to($user)->send(new ForgotPassword($user));
            return response([
                'success' => true,
                'message' => 'Email is sent to your email address. Please confirm to continue',
                'redirect' => true,
                'url' => route('dashboard'),
            ]);
        } else {
            return response([
                'warning' => true,
                'message' => 'Unable to find your account. Check your email or register with a new account.',
            ]);
        }
    }
}
