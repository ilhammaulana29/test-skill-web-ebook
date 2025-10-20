<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    {{-- ======= Daftar eBook ======= --}}
                    <div id="ebook-table-section">
                        <h3 class="text-lg font-semibold mb-4">📚 Daftar eBook</h3>

                        <div class="overflow-x-auto">
                            @if(session('success'))
                            <div id="flash-message" class="mb-4 p-3 rounded bg-green-100 text-green-800 shadow">
                                {{ session('success') }}
                            </div>
                            @endif
                            <table class="min-w-full border border-gray-200 rounded-lg">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-gray-600 font-medium border-b">No</th>
                                        <th class="px-4 py-2 text-left text-gray-600 font-medium border-b">Nama</th>
                                        <th class="px-4 py-2 text-center text-gray-600 font-medium border-b">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y">
                                    @forelse ($ebooks as $index => $ebook)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-2">{{ $index + 1 }}</td>
                                        <td class="px-4 py-2">{{ $ebook->name }}</td>
                                        <td class="px-4 py-2 text-center flex justify-center gap-2">
                                            <button
                                                class="show-pdf bg-blue-500 text-white px-3 py-1 rounded-md hover:bg-blue-600 transition"
                                                data-url="{{ asset('storage/' . $ebook->file_path) }}">
                                                Lihat
                                            </button>

                                            <form action="{{ route('ebooks.destroy', $ebook->id) }}" method="POST"
                                                class="delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-gray-500">
                                            Belum ada eBook.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- ======= Viewer PDF ======= --}}
                    @include('components.pdf-viewer')

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
    @vite(['resources/js/ebook-viewer.js'])
</x-app-layout>