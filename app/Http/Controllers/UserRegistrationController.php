<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\UserRepositoryInterface;
use App\Models\User;

class UserRegistrationController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUserByEmail(Request $request)
    {
        $email = $request->email;
        if (!$email) {
            return response()->json([
                'error' => [
                    'code' => 404,
                    'message' => "User not found!",
                ]
            ], 404);
        }

        $user = User::where(['email' => $email])->first();

        if (!$user) {
            return response()->json([
                'error' => [
                    'code' => 404,
                    'message' => "User not found!!",
                ]
            ], 404);
        }

        return response()->json($user, 200);
    }

    public function registration(Request $request)
    {
        $this->validate($request, [
            'first_name'        => 'required',
            'last_name'        => 'required',
            'email'             => 'required|email',
            // 'father_name'       => 'required',
            // 'mather_name'       => 'required',
            'date_of_birth'     => 'required',
            'nid'               => 'required',
            'password'          => 'required',
            'mobile'            => 'required',
            // 'blood_group'       => 'required',
            // 'marital_status'    => 'required',
            'gender'            => 'required',
            // 'address'           => 'required',
        ]);

        try {
            DB::beginTransaction();
            $user = $this->userRepository->registerUser($request);
            DB::commit();
            if (!empty($user)) {
                $this->eventUpdateAppointment($user);
            }
            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'data' => $user
            ], 200);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ], 400);
        }
    }

    public function registaredUserList()
    {
    }

    public function eventUpdateAppointment(User $user)
    {
        $data = new \stdClass();
        $data->id = $user->id;
        $data->first_name = $user->first_name;
        $data->last_name = $user->last_name;
        $data->email = $user->email;
        $data->date_of_birth = $user->date_of_birth;
        $data->mobile = $user->mobile;
        $data->gender = $user->gender;

        try {
            event(new UserCreated($data));
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
