<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{


    public function register(Request $request)
    {
        
        $user = new Account;

        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->name = $request->input('name');
        $user->position = 'Khách hàng';
        $user->save();

        $customer = new Customer;
        $customer->c_id = generateRandomString(3);
        $customer->fullname = $request->input('name');
        $customer->mail = $request->input('email');
        $customer->save();



        return response()->json(['message' => 'Đăng ký thành công', 'redirect' => '/'], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $user = Auth::user(); 

        if ($user->position === 'Nhân viên') {
            return response()->json(['message' => 'Đăng nhập thành công', 'redirect' => '/KhachHang'], 200);
        } elseif ($user->position === 'Khách hàng') {
            return response()->json(['message' => 'Đăng nhập thành công', 'redirect' => '/'], 200);
        } else {
            return response()->json(['message' => 'Đăng nhập thành công', 'redirect' => '/']);
        }
    }

    return response()->json(['message' => 'Thông tin đăng nhập không hợp lệ'], 401);
    }
    function getAccountDetails(Request $request)
    {
        $selectedAccounts = $request->input('email');

        // Chuyển chuỗi cIds thành mảng
        $selectedAccountIds = explode(',', $selectedAccounts);

        // Lấy chi tiết của các khách hàng được chọn
        $AccountDetails = Account::whereIn('email', $selectedAccountIds)->get();

        return response()->json($AccountDetails);
    }
    function updateAccount(Request $request){
        
        try {
        // Validate the request data as needed
            $request->validate([
                'email' => 'required',
            ]);

            // Find the Luggage by cId
            $Account = Account::where('email', $request->input('email'))->first();

            if (!$Account) {
                return response()->json(['error' => 'Account not found'], 404);
            }

            // Update Luggage data
            $Account->name = $request->input('name');
            $Account->save();

            return response()->json(['message' => 'Account updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(($e->getMessage()), 500);
        }
    }
    function getPoints(Request $request){
        try {
            $email = $request->input('email');
            $selectedAccountIds = explode(',', $email);
            $count = Ticket::whereIn('Mail', $selectedAccountIds)->count();
            return response()->json($count);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    
}
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
}