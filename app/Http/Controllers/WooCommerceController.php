<?php

namespace App\Http\Controllers;

use Automattic\WooCommerce\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;
use Illuminate\Pagination\LengthAwarePaginator;

class WooCommerceController extends Controller
{
    private $woocommerce;

    public function __construct()
    {
        $this->woocommerce = new Client(
            env('WOOCOMMERCE_STORE_URL'),
            env('WOOCOMMERCE_CONSUMER_KEY'),
            env('WOOCOMMERCE_CONSUMER_SECRET'),
            [
                'version' => 'wc/v3',
                'query_string_auth' => true,
                'verify_ssl' => false,
            ]
        );
    }

    public function productos(Request $request)
    {
        $perPage = 8;
        $currentPage = $request->input('page', 1);

        $products = $this->woocommerce->get('products', [
            'per_page' => $perPage,
            'page' => $currentPage
        ]);

        $total = $this->woocommerce->http->getResponse()->getHeaders()['X-WP-Total'][0] ?? count($products);

        $paginatedProducts = new LengthAwarePaginator(
            collect($products),
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('woocommerce.productos', [
            'products' => $paginatedProducts
        ]);
    }

    public function pedidos(Request $request)
    {
        $perPage = 8;
        $currentPage = $request->input('page', 1);

        // Fecha de hace 30 días en formato ISO 8601
        $date30DaysAgo = now()->subDays(30)->toIso8601String();

        $orders = $this->woocommerce->get('orders', [
            'per_page' => $perPage,
            'page' => $currentPage,
            'after' => $date30DaysAgo
        ]);

        $total = $this->woocommerce->http->getResponse()->getHeaders()['X-WP-Total'][0] ?? count($orders);

        $paginatedOrders = new LengthAwarePaginator(
            collect($orders),
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ]
        );

        return view('woocommerce.pedidos', [
            'orders' => $paginatedOrders
        ]);
    }

    public function exportar($tipo)
    {
        if ($tipo === 'productos') {
            $data = $this->woocommerce->get('products');
        } elseif ($tipo === 'pedidos') {
            // Exporta solo pedidos de últimos 30 días
            $date30DaysAgo = now()->subDays(30)->toIso8601String();
            $data = $this->woocommerce->get('orders', [
                'after' => $date30DaysAgo
            ]);
        } else {
            abort(404);
        }

        return Excel::download(new GenericExport($data), "{$tipo}.xlsx");
    }
}
