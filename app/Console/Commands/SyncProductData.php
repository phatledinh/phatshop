<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class SyncProductData extends Command
{
    protected $signature = 'products:sync-data';
    protected $description = 'Sync sold in products with order_items';

    public function handle()
    {
        // Đặt lại sold về 0
        Product::query()->update(['sold' => 0]);

        // Tính tổng quantity từ order_items
        $soldQuantities = OrderItem::query()
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.status', ['paid', 'completed'])
            ->groupBy('order_items.product_id')
            ->select('order_items.product_id', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->get();

        // Cập nhật sold
        foreach ($soldQuantities as $item) {
            Product::where('id', $item->product_id)
                ->update(['sold' => $item->total_sold]);
        }

        // Kiểm tra stock âm
        $negativeStocks = Product::where('stock', '<', 0)->get();
        foreach ($negativeStocks as $product) {
            $this->error("Sản phẩm ID: {$product->id} ({$product->product_name}) có stock âm: {$product->stock}");
        }

        $this->info('Đồng bộ hoàn tất.');
    }
}
