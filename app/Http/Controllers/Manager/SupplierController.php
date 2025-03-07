<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Services\SupplierService;
use App\Services\UserActivityService;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    protected $supplierService;
    protected $useractivityService;

    public function __construct(SupplierService $supplierService, UserActivityService $useractivityService)
    {
        $this->supplierService = $supplierService;
        $this->useractivityService = $useractivityService;
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $suppliers = $this->supplierService->getFilteredSuppliers($search);

        return view('manager.supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('manager.supplier.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email',
        ]);

        $this->supplierService->createSupplier($data);

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Menambahkan supplier baru';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('manager.supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $supplier = $this->supplierService->getSupplierById($id);
        return view('manager.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email',
        ]);

        $this->supplierService->updateSupplier($id, $data);

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Memperbarui data supplier';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('manager.supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $this->supplierService->deleteSupplier($id);

        $validatedData['user_id'] = auth()->id();
        $validatedData['activity'] = 'Menghapus sebuah supplier';
        $validatedData['date'] = now();

        $this->useractivityService->createUserActivity($validatedData);

        return redirect()->route('manager.supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }
}