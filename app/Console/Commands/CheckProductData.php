<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class CheckProductData extends Command
{
    protected $signature = 'products:check-data';
    protected $description = 'Check stock and sold against order_items';

    public function handle()
    {
        $products = Product::select('id', 'product_name', 'stock', 'sold')->get();

        foreach ($products as $product) {
            $actualSold = OrderItem::query()
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('order_items.product_id', $product->id)
                ->whereIn('orders.status', ['paid', 'completed'])
                ->sum('order_items.quantity');

            if ($product->sold != $actualSold) {
                $this->warn("Sản phẩm ID: {$product->id} ({$product->product_name})");
                $this->warn("sold: {$product->sold}, Thực tế từ order_items: {$actualSold}");
            }

            // Kiểm tra stock (giả sử bạn có initial_stock hoặc cần kiểm tra stock âm)
            if ($product->stock < 0) {
                $this->error("Sản phẩm ID: {$product->id} ({$product->product_name}) có stock âm: {$product->stock}");
            }
        }

        $this->info('Kiểm tra hoàn tất.');
    }
}
