<?php

namespace App\Http\Controllers;

use App\Helpers\ApiFormatter;

use App\Models\User;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Exception;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->search_name;
        $limit = $request->limit;
        $users = User::where('name', 'LIKE', '%'.$search.'%')->limit($limit)->get();

        if ($users) {
            return ApiFormatter::createApi(200, 'success', $users);
        } else {
            return ApiFormatter::createApi(400, 'failed');
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $getData = User::where('id', $user->id)->first();

            if ($getData) {
                return ApiFormatter::createApi(200, 'success', $getData);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function createToken() 
    {
        return csrf_token();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $userDetail = User::where('id', $id)->first();

            if ($userDetail) {
                return ApiFormatter::createApi(200, 'success', $userDetail);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::findOrFail($id);

            $user->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $updateUser = User::where('id', $user->id)->first();

            if ($updateUser) {
                return ApiFormatter::createApi(200, 'success', $updateUser);
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $users = User::findOrFail($id);
            $process = $users->delete();
    
            if ($process) {
                return ApiFormatter::createApi(200, 'success');
            } else {
                return ApiFormatter::createApi(400, 'failed');
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function trash()
    {
        try {
            $users = User::onlyTrashed()->get();
            if ($users) {
                return ApiFormatter::createApi(200, 'success', $users);
            } else {
                return ApiFormatter::createApi(400, 'failed');  
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }

    public function destroyPermanent(string $id)
    {
        try {
            $users = User::onlyTrashed()->where('id', $id);
            $process = $users->forceDelete();
            if ($process) {
                return ApiFormatter::createApi(200, 'success');
            } else {
                return ApiFormatter::createApi(400, 'failed');  
            }
        } catch (Exception $error) {
            return ApiFormatter::createApi(400, 'failed');
        }
    }
}
