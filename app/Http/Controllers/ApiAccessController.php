<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiAccess;

class ApiAccessController extends Controller
{
    public function index()
    {
        $data = ApiAccess::get();
        return view('admin.apiAccess.index', compact('data'));
    }
    public function create()
    {
        return view('admin.apiAccess.create');
    }
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        $apiAccess = new ApiAccess();
        $apiAccess->name = $validatedData['name'];
        $apiAccess->username = $validatedData['username'];
        $apiAccess->password = $validatedData['password'];

        $apiAccess->save();


        return redirect()->back()->with('status', 'User added successfully!');
    }

    public function updateStatus($id)
    {
        $user = ApiAccess::find($id);

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }

        $user->status = request()->input('status');

        $user->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
    public function destroy($id)
    {
        $apiAccess = ApiAccess::find($id);

        if (!$apiAccess) {
            return redirect()->back()->with('status', 'User Not Found!');
        }

        $apiAccess->delete();

        return redirect()->back()->with('status', 'User Deleted successfully!');
    }
}
