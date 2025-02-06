<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Validation\Rule;


class CustomerController extends Controller
{
    // Get Customer List with Search, Pagination, and Filtering
    public function index(Request $request)
    {
        $query = Customer::query();

        // Search by text
        if ($request->has('search_text')) {
            $query->where(function ($q) use ($request) {
                $q->where('firstname', 'LIKE', '%' . $request->search_text . '%')
                    ->orWhere('lastname', 'LIKE', '%' . $request->search_text . '%')
                    ->orWhere('email', 'LIKE', '%' . $request->search_text . '%');
            });
        }

        // Filter by date range
        if ($request->has('date_range')) {
            $today = now();
            switch ($request->date_range) {
                case '7_days':
                    $query->where('created_at', '>=', $today->copy()->subDays(7));
                    break;
                case '30_days':
                    $query->where('created_at', '>=', $today->copy()->subDays(30));
                    break;
                case '3_months':
                    $query->where('created_at', '>=', $today->copy()->subMonths(3));
                    break;
                case 'custom_range':
                    // You can handle custom range logic here
                    break;
            }
        }

        // Filter by status
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        // Pagination
        $pageSize = $request->input('page_size', 10);
        $customers = $query->paginate($pageSize);

        return response()->json($customers)->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    // Create a New Customer
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'telephone' => 'required|string|unique:customers',
            'bvn' => 'required|string|unique:customers',
            'dob' => 'required|date',
            'residential_address' => 'required|string',
            'state' => 'required|string',
            'bankcode' => 'required|string',
            'accountnumber' => 'required|string|unique:customers',
            'company_id' => 'required|string',
            'email' => 'required|email|unique:customers',
            'city' => 'required|string',
            'country' => 'required|string',
            'id_card' => 'nullable|string',
            'voters_card' => 'nullable|string',
            'drivers_licence' => 'nullable|string',
        ]);

        $customer = Customer::create($validatedData);

        return response()->json($customer, 201);
    }

    // Update Customer Details
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validatedData = $request->validate([
            'firstname' => 'sometimes|required|string|max:255',
            'lastname' => 'sometimes|required|string|max:255',
            'telephone' => ['sometimes', 'required', Rule::unique('customers')->ignore($customer->id)],
            'bvn' => ['sometimes', 'required', Rule::unique('customers')->ignore($customer->id)],
            'dob' => 'sometimes|required|date',
            'residential_address' => 'sometimes|required|string',
            'state' => 'sometimes|required|string',
            'bankcode' => 'sometimes|required|string',
            'accountnumber' => ['sometimes', 'required', Rule::unique('customers')->ignore($customer->id)],
            'company_id' => 'sometimes|required|string',
            'email' => ['sometimes', 'required', 'email', Rule::unique('customers')->ignore($customer->id)],
            'city' => 'sometimes|required|string',
            'country' => 'sometimes|required|string',
            'id_card' => 'nullable|string',
            'voters_card' => 'nullable|string',
            'drivers_licence' => 'nullable|string',
        ]);

        $customer->update($validatedData);

        return response()->json($customer);
    }
}
