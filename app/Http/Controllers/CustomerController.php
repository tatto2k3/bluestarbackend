<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    function addCustomer(Request $request){
        $customer = new Customer;
        $customer->c_id = $request->input('C_ID');
        $customer->num_id = $request->input('NUM_ID');
        $customer->fullname = $request->input('FULLNAME');
        $customer->point = $request->input('POINT');
        $customer->mail = $request->input('MAIL');
        $customer->save();

        return $customer;
    }

    function getCustomers()
    {
        $customers = Customer::all();
         return response()->json($customers);
    }
    function updateCustomer(Request $request){
        
        try {
        // Validate the request data as needed
            $request->validate([
                'C_ID' => 'required',
                'FULLNAME' => 'required',
                'MAIL' => 'required|email',
                'POINT' => 'required',
                'NUM_ID' => 'required',
            ]);

            // Find the customer by cId
            $customer = Customer::where('C_ID', $request->input('C_ID'))->first();

            if (!$customer) {
                return response()->json(['error' => 'Customer not found'], 404);
            }

            // Update customer data
            $customer->FULLNAME = $request->input('FULLNAME');
            $customer->MAIL = $request->input('MAIL');
            $customer->POINT = $request->input('POINT');
            $customer->NUM_ID = $request->input('NUM_ID');
            $customer->save();

            return response()->json(['message' => 'Customer updated successfully'], 200);
        } catch (\Exception $e) {
            // Handle exceptions
            return response()->json(($e->getMessage()), 500);
        }
    }


    function getCustomerDetails(Request $request)
    {
        $selectedCustomers = $request->input('cIds');

        // Chuyển chuỗi cIds thành mảng
        $selectedCustomerIds = explode(',', $selectedCustomers);

        // Lấy chi tiết của các khách hàng được chọn
        $customerDetails = Customer::whereIn('C_ID', $selectedCustomerIds)->get();

        return response()->json($customerDetails);
    }

    function deleteCustomer($cId)
    {
        try {
            // Tìm khách hàng dựa trên C_ID
            $customer = Customer::where('C_ID', $cId)->first();

            if (!$customer) {
                return response()->json(['error' => 'Customer not found'], 404);
            }

            // Xóa khách hàng
            $customer->delete();

            return response()->json(['message' => 'Customer deleted successfully'], 200);
        } catch (\Exception $e) {
            // Xử lý lỗi
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    function searchCustomers(Request $request)
    {
        try {
            $searchKeyword = $request->input('searchKeyword');

            if (empty($searchKeyword)) {
                return response()->json(['error' => 'Invalid search keyword'], 400);
            }

            // Search customers by name containing the provided keyword
            $searchResults = Customer::where('FULLNAME', 'like', '%' . $searchKeyword . '%')
                ->orWhere('NUM_ID', 'like', '%' . $searchKeyword . '%')
                ->orWhere('C_ID', 'like', '%' . $searchKeyword . '%')
                ->get();

            return response()->json($searchResults);
        } catch (\Exception $ex) {
            return response()->json(['error' => 'Internal server error: ' . $ex->getMessage()], 500);
        }
    }



}
