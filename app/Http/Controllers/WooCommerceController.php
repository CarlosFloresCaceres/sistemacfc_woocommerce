<?php

namespace App\Http\Controllers;

use Automattic\WooCommerce\Client;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

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

         // Llamada a la API con paginación de WooCommerce
        $products = $this->woocommerce->get('products', ['per_page' => $perPage,
            'page' => $currentPage]);

        // Se Obtiene el total desde la cabecera de WooCommerce
        $total = $this->woocommerce->http->getResponse()->getHeaders()['X-WP-Total'][0] ?? count($products);

        // Convertimos el array a colección y lo metemos en un LengthAwarePaginator
        $productsCollection = collect($products);
        $paginatedProducts = new LengthAwarePaginator(
        $productsCollection,
        $total,
        $perPage,
        $currentPage,
        [
            'path' => $request->url(),
            'query' => $request->query(),
        ]
    );
        return view('woocommerce.productos', [
        'products' => $paginatedProducts]);


        /*$products = $this->woocommerce->get('products', ['per_page' => 8]);
        return view('woocommerce.productos', compact('products'));*/
    }

    public function pedidos( Request $request)
    {
        $perPage = 8;
        $currentPage = $request->input('page', 1);

         // Llamada a la API con paginación de WooCommerce
        $orders = $this->woocommerce->get('orders', ['per_page' => $perPage,
            'page' => $currentPage]);

        // Se Obtiene el total desde la cabecera de WooCommerce
        $total = $this->woocommerce->http->getResponse()->getHeaders()['X-WP-Total'][0] ?? count($orders);

        // Convertimos el array a colección y lo metemos en un LengthAwarePaginator
        $ordersCollection = collect($orders);
        $paginatedOrders = new LengthAwarePaginator(
        $ordersCollection,
        $total,
        $perPage,
        $currentPage,
        [
            'path' => $request->url(),
            'query' => $request->query(),
        ]
    );
        return view('woocommerce.pedidos', [
        'orders' => $paginatedOrders]);

        /*$orders = $this->woocommerce->get('orders', ['per_page' => 10]);
        return view('woocommerce.pedidos', compact('orders'));*/
    }

    public function exportar($tipo)
    {
        if ($tipo === 'productos') {
            $data = $this->woocommerce->get('products');
        } elseif ($tipo === 'pedidos') {
            $data = $this->woocommerce->get('orders');
        } else {
            abort(404);
        }

        return Excel::download(new GenericExport($data), "{$tipo}.xlsx");
    }
}
