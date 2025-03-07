<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserActivityService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    protected $useractivityService;

    public function __construct(UserRepositoryInterface $userService, UserActivityService $useractivityService)
    {
        $this->userService = $userService;
        $this->useractivityService = $useractivityService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = $this->userService->getFilteredUsers($search);
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:Admin,Staff Gudang,Manajer Gudang',
        ]);

        $this->userService->create($validated);

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Menambahkan akun pengguna baru';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = $this->userService->findById($id);
        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:Admin,Staff Gudang,Manajer Gudang',
        ]);

        $this->userService->update($id, $validated);

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Memperbarui akun pengguna';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->userService->delete($id);

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Menghapus akun sebuah pengguna';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}