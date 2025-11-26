<x-app-layout>
    <style> * { font-family: 'Poppins', sans-serif; } </style>

    <div class="py-12 bg-slate-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold text-slate-800 mb-6">Pesanan Masuk</h1>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-slate-100">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-slate-500">
                        <thead class="text-xs text-slate-700 uppercase bg-slate-50 border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Produk</th>
                                <th class="px-6 py-4">Pembeli</th>
                                <th class="px-6 py-4">Total</th>
                                <th class="px-6 py-4">Status Saat Ini</th>
                                <th class="px-6 py-4">Ubah Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orderItems as $item)
                                <tr class="bg-white border-b border-slate-50 hover:bg-slate-50">
                                    <td class="px-6 py-4 font-medium text-slate-900 flex items-center gap-3">
                                        <div class="w-10 h-10 rounded bg-slate-100 overflow-hidden">
                                            @if($item->product->image)
                                                <img src="{{ asset('storage/' . $item->product->image) }}" class="w-full h-full object-cover">
                                            @endif
                                        </div>
                                        {{ $item->product->name }}
                                        <br>
                                        <span class="text-xs text-slate-400">x{{ $item->quantity }}</span>
                                    </td>
                                    <td class="px-6 py-4">{{ $item->order->user->name }}</td>
                                    <td class="px-6 py-4 font-bold text-indigo-600">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                                    
                                    <!-- Status Badge -->
                                    <td class="px-6 py-4">
                                        @php
                                            $status = $item->order->status;
                                            $color = match($status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'processing' => 'bg-blue-100 text-blue-800',
                                                'shipped' => 'bg-purple-100 text-purple-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="px-2 py-1 rounded text-xs font-bold {{ $color }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>

                                    <!-- Form Update Status -->
                                    <td class="px-6 py-4">
                                        <form action="{{ route('seller.orders.update', $item->id) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="text-xs border-slate-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                                <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="processing" {{ $status == 'processing' ? 'selected' : '' }}>Proses</option>
                                                <option value="shipped" {{ $status == 'shipped' ? 'selected' : '' }}>Kirim</option>
                                                <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>Selesai</option>
                                                <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Batal</option>
                                            </select>
                                            <button type="submit" class="bg-indigo-600 text-white px-3 py-1 rounded-lg text-xs font-bold hover:bg-indigo-700">
                                                Update
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-slate-500">Belum ada pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div class="mt-4">
                {{ $orderItems->links() }}
            </div>
        </div>
    </div>
</x-app-layout>