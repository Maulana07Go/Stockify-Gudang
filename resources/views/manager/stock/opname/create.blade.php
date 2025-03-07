@extends('layouts.manager')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6 mt-6">
    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Buat Stok Opname</h2>

    <form action="{{ route('manager.stock.opname.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Pilih Produk -->
        <div>
            <label for="product_id" class="block text-gray-600 font-medium">Pilih Produk</label>
            <select name="product_id" id="product_id" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
                <option value="" selected disabled>-- Pilih Produk --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Stok Awal (Otomatis) -->
        <div>
            <label for="initial_stock" class="block text-gray-600 font-medium">Stok Awal</label>
            <input type="number" id="initial_stock" name="initial_stock" class="w-full mt-1 p-2 border rounded-lg bg-gray-100 text-gray-500" readonly>
        </div>

        <!-- Stok Akhir -->
        <div>
            <label for="final_stock" class="block text-gray-600 font-medium">Stok Akhir</label>
            <input type="number" id="final_stock" name="final_stock" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
        </div>

        <!-- Catatan -->
        <div>
            <label for="notes" class="block text-gray-600 font-medium">Catatan</label>
            <textarea id="notes" name="notes" class="w-full mt-1 p-2 border rounded-lg focus:ring-2 focus:ring-blue-400 focus:outline-none" rows="3"></textarea>
        </div>

        <!-- Tombol Submit -->
        <div class="flex justify-end space-x-2">
            <a href="{{ route('manager.stock.opname.index') }}" class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Simpan Stok Opname</button>
        </div>
    </form>
</div>

<!-- Script untuk Mengisi Stok Awal -->
<script>
    document.getElementById("product_id").addEventListener("change", function () {
        var productId = this.value;
        var products = @json($products); // Ambil data produk dalam JSON

        var selectedProduct = products.find(p => p.id == productId);
        if (selectedProduct) {
            document.getElementById("initial_stock").value = selectedProduct.stock;
        } else {
            document.getElementById("initial_stock").value = "";
        }
    });
</script>
@endsection