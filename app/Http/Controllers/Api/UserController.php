<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * GET
     */
    public function index()
    {
        $data = User::paginate(5);
        return response()->json($data);
    }

    /**
     * POST
     */
    public function store(Request $request)
    {
        # validando
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:255',
        ]);

        # criando
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        # retornando
        return response()->json($user, 201);
    }

    /**
     * GET/{user}
     */
    public function show(User $user)
    {
        return response()->json($user);
    }

    /**
     * PUT
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,' . $user->id,
            'password' => 'required|string|min:6|max:255',
        ]);

        $data = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($data);
    }

    /**
     * DELETE
     */
    public function destroy(User $user)
    {
        DB::beginTransaction();
        try {
            $user->delete();
            DB::commit();
            return response()->json(null, 204);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Erro ao deletar usuário'], 500);
        }
    }
}
