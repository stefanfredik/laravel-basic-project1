<?php


namespace App\Helpers;

use App\Models\Notification;
use App\Models\User;


class NotificationHelper
{
    public static function send($userId, $type, $title, $message, $link = null)
    {
        return Notification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'message' => $message,
            'link' => $link,
            'read' => false
        ]);
    }


    public function lowStockAlert($productId, $productName)
    {
        $adminUsers = User::where('is_admin', true)->get();


        foreach ($adminUsers as $user) {
            self::send(
                $user->id,
                'low_stock',
                'Stok Produk Rendah',
                "Produk '{$productName}' memiliki stok rendah dan perlu diisi ulang.",
                route('products.edit', $productId)
            );
        }
    }
}
