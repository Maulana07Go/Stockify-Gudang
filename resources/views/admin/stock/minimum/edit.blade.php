@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Edit Stok Minimum</h2>

    <div class="bg-white shadow-lg rounded-lg p-6">
        <form action="{{ route('admin.stock.minimum.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="reorder_point" class="block font-semibold">Reorder Point</label>
                <input type="number" id="reorder_point" name="reorder_point" value="{{ old('reorder_point', $product->reorder_point) }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label for="average_usage" class="block font-semibold">Average Usage</label>
                <input type="number" id="average_usage" name="average_usage" value="{{ old('average_usage', $product->average_usage) }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label for="average_lead_time" class="block font-semibold">Average Lead Time</label>
                <input type="number" id="average_lead_time" name="average_lead_time" value="{{ old('average_lead_time', $product->average_lead_time) }}" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label for="minimum_stock" class="block font-semibold">Stok Minimum</label>
                <input type="number" id="minimum_stock" name="minimum_stock" value="{{ old('minimum_stock', $product->minimum_stock) }}" class="w-full border p-2 rounded bg-gray-200" readonly>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan Perubahan
            </button>
        </form>
        <div class="mt-6">
            <a href="{{ route('admin.stock.minimum.index') }}" class="inline-block px-4 py-2 text-white bg-gray-600 rounded-lg hover:bg-gray-700 transition duration-200">
                Kembali
            </a>
        </div>
    </div>
</div>

<script>
    function calculateMinimumStock() {
        let reorderPoint = parseFloat(document.getElementById('reorder_point').value) || 0;
        let averageUsage = parseFloat(document.getElementById('average_usage').value) || 0;
        let averageLeadTime = parseFloat(document.getElementById('average_lead_time').value) || 0;

        let minimumStock = reorderPoint - (averageUsage * averageLeadTime);
        document.getElementById('minimum_stock').value = Math.max(0, minimumStock);
    }

    document.getElementById('reorder_point').addEventListener('input', calculateMinimumStock);
    document.getElementById('average_usage').addEventListener('input', calculateMinimumStock);
    document.getElementById('average_lead_time').addEventListener('input', calculateMinimumStock);
</script>

@endsection