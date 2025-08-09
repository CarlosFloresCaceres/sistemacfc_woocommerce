<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pedidos') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
               <x-exportar_excel href="{{ route('exportar', 'pedidos') }}">
                 {{ __('Exportar a Excel') }}
                </x-exportar_excel>

                <table class="table-auto w-full border-collapse border border-gray-300">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border border-gray-300 px-4 py-2">Cliente</th>
                            <th class="border border-gray-300 px-4 py-2">Fecha</th>
                            <th class="border border-gray-300 px-4 py-2">Productos</th>
                            <th class="border border-gray-300 px-4 py-2">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $order->billing->first_name ?:  $order->shipping->first_name}} {{ $order->billing->last_name ?: $order->shipping->last_name}}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ \Carbon\Carbon::parse($order->date_created)->format('d/m/Y') }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <ul class="list-disc pl-5">
                                        @foreach($order->line_items as $item)
                                            <li>{{ $item->name }} (x{{ $item->quantity }})</li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ ucfirst($order->status) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
    {{ $orders->links() }}
</div>

            </div>
        </div>
    </div>
</x-app-layout>
