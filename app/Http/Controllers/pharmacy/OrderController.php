<?php

namespace App\Http\Controllers\pharmacy;

use App\Enum\OrderEnum;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Notifications\UserOrderNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function getAll()
    {
        $orders = Auth::user()->pharmacyOrders()->get();
        return view('pharmacy.dashboard.testing-orders', compact('orders'));
    }

    public function getOrder($id)
    {
      $order = Auth::user()->pharmacyOrders()->where('id', $id)->first();
      return view('0-testing.order', compact('order'));
    }

    public function orderRefusal($id)
    {
        $order = Order::find($id);

        if ($order)
        {
            $order->update(['status' => OrderEnum::REFUSAL_ORDER]);

            // send and save notification in DB
            $user  = User::find($order->user_id);
            $data  = [
              'pharmacy' => Auth::user(),
              'order'    => $order,
              'message'  => 'عذراً لا يتوفر لدينا طلبك'
            ];
            Notification::send($user, new UserOrderNotification($data));

            return back()->with('status', 'لقد تم رفض الطلب');
        }

        return back()->with('status', 'هُناك خطأ، يُرجى التأكد من صحة رقم الطلب');
    }
}
