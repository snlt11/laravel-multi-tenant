<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Validator;

class TenantController extends Controller
{
    /**
     * List all tenants with their domains
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tenants = Tenant::with('domains')->get();
        
        return response()->json([
            'tenants' => $tenants
        ]);
    }
    
    /**
     * Create a new tenant with domain
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|string|max:255|unique:tenants,id',
            'domain' => 'required|string|max:255|unique:domains,domain',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tenant = Tenant::create(['id' => $request->id]);
        
        $domain = $tenant->domains()->create([
            'domain' => $request->domain
        ]);

        return response()->json([
            'message' => 'Tenant created successfully',
            'tenant' => $tenant,
            'domain' => $domain
        ], 201);
    }
}
