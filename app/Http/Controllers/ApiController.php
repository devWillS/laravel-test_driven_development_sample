<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Services\CustomerService;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function getCustomers(CustomerService $customerService): \Illuminate\Http\JsonResponse
    {
        return response()->json($customerService->getCustomers());
    }

    public function postCustomers(Request $request, CustomerService $customerService)
    {
        $this->validate($request, ['name' => 'required']);

        $customerService->addCustomer($request->json('name'));
    }

    public function getCustomer()
    {
    }

    public function putCustomer()
    {
    }

    public function deleteCustomer()
    {
    }

    public function getReports()
    {
    }

    public function postReports(Request $request)
    {
    }

    public function getReport()
    {
    }

    public function putReport()
    {
    }

    public function deleteReport()
    {
    }
}
