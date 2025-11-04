<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FirstCrudApi;
use Illuminate\Support\Facades\Validator;

class FirstCrudApiController extends Controller
{
    // 📥 CREATE
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:first_crud_apis,email',
            'phone' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }

        $data = FirstCrudApi::create($request->only('name', 'email', 'phone'));
        return response()->json(['status' => 'success', 'message' => 'Data inserted successfully', 'data' => $data], 201);
    }

    // 📋 READ
    public function index()
    {
        $data = FirstCrudApi::latest()->get();
        return response()->json(['status' => 'success', 'data' => $data], 200);
    }

    // ✏️ UPDATE
    public function update(Request $request, $id)
    {
        $data = FirstCrudApi::find($id);
        if (!$data) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:first_crud_apis,email,' . $id,
            'phone' => 'required|string|max:15',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()], 422);
        }

        $data->update($request->only('name', 'email', 'phone'));
        return response()->json(['status' => 'success', 'message' => 'Data updated successfully', 'data' => $data], 200);
    }

    // ❌ DELETE
    public function destroy($id)
    {
        $data = FirstCrudApi::find($id);
        if (!$data) {
            return response()->json(['status' => 'error', 'message' => 'Record not found'], 404);
        }

        $data->delete();
        return response()->json(['status' => 'success', 'message' => 'Record deleted successfully'], 200);
    }
}
