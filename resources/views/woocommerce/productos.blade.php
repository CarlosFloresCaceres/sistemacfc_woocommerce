<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Productos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8"> 
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4">              
                <x-exportar_excel href="{{ route('exportar', 'productos') }}">
                 {{ __('Exportar a Excel') }}
                </x-exportar_excel>
           

                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">Imagen</th>
                            <th class="border border-gray-300 px-4 py-2">Nombre</th>
                            <th class="border border-gray-300 px-4 py-2">SKU</th>
                            <th class="border border-gray-300 px-4 py-2">Precio</th>
                            <th class="border border-gray-300 px-4 py-2">Stock</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2 text-center">
                                    <img src="{{ $product->images[0]->src ?? '' }}" width="50" alt="Imagen">
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ $product->name }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $product->sku }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $product->price }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $product->stock_quantity ?: 0 }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
<div class="mt-4">
    {{ $products->links() }}
</div>
            </div>
        </div>
    </div>
</x-app-layout>
