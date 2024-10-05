<?php

namespace Modules\ShoppingCart\Http\Controllers;

use Modules\Products\Entities\Product;
use Modules\Products\Entities\ProductSize;
use Modules\Products\Entities\ProductColor;
use Modules\Settings\Entities\PaymentSetting;
use Modules\Products\Entities\ProductInventory;
use Modules\Settings\Entities\ShippingSettings;

class CartController extends HelperController
{
    public function index()
    {
        // check item stock
        $items = cart()->getContent();
        $deletedItemsHtml = "";
        foreach ($items as $item) {
            $rowArr = explode('_',$item->id);
            $inventoryId = null;
            if (count($rowArr) > 1){
                $inventoryId =$rowArr[1];
            }
            $product = Product::find($item->associatedModel->id);
            if (!$product || !$product->inStock() || $product->getStockQuantity($inventoryId) < $item->quantity){
                $deletedItemsHtml = "<p>برخی از آیتم های سبد خرید شما به دلیل تغییر در موجودی آنها، از سبد خرید شما حذف شدند.</p>";
                $deletedItemsHtml .= "<span>محصولات حذف شده: </span>";
                $deletedItemsHtml .= '<a class="m-2 d-inline-block fw-bold text-decoration-none" href="'.route('product.show',$item->associatedModel).'">"'.$item->associatedModel->title.'"</a>';
                cart()->remove($item->id);
            }
        }
        if (!empty($deletedItemsHtml)){
            session()->flash('warning', $deletedItemsHtml);
        }

        $items = cart()->getContent();
        $totalQuantity = cart()->getTotalQuantity();
        $totalDiscount = 0;
        foreach ($items as $item) {
            $rowArr = explode('_',$item->id);
            $inventoryId = null;
            if (count($rowArr) > 1){
                $inventoryId =$rowArr[1];
            }
            $totalDiscount += $item->associatedModel->getDiscountedPrice($inventoryId) * $item->quantity;
        }

        $shippingSettings = ShippingSettings::first();

        // محاسبه وزن کل بر اساس برنج
        $totalWeight = 0;
        foreach ($items as $cartItem) {

            // جداسازی محصولات غیر برنج
            $categories = $cartItem->associatedModel->categories->pluck('id')->toArray();
            if(in_array(443, $categories)) {
                continue;
            }

            $totalItemWeight = intval($cartItem->associatedModel->weight) * $cartItem->quantity / 1000;
            $totalWeight += $totalItemWeight;
        }
       
        return view('shoppingcart::cart', compact('items', 'totalQuantity', 'totalDiscount', 'shippingSettings', 'totalWeight'));
    }

    public function increase()
    {
        if (request()->ajax()) {
            $productId = request('id');
            $rowId = explode('_',$productId);
            $inventoryId = null;
            if (count($rowId) > 1){
                $inventoryId =$rowId[1];
            }

            $product = Product::find($productId);
            if (!$product) {
                return response(array(
                    'status' => 'product_not_found'
                ));
            }

            $item = cart()->get($productId);

            $totalQuantity = $product->getStockQuantity($inventoryId);
            $quantity = $item->quantity;

            $cartTotalDiscount = 0;
            foreach (cart()->getContent() as $i) {
                if ($i->id == $item->id) {
                    $cartTotalDiscount += $i->associatedModel->getDiscountedPrice($inventoryId) * ($i->quantity + 1);
                } else {
                    $cartTotalDiscount += $i->associatedModel->getDiscountedPrice($inventoryId) * $i->quantity;
                }
            }
            $itemTotalDiscount = $item->associatedModel->getDiscountedPrice($inventoryId) * ($item->quantity + 1);

            if ($quantity < $totalQuantity) {
                cart()->update($productId, array('quantity' => 1));

                $isLast = 0;
                if (($totalQuantity - $quantity) == 1) {
                    $isLast = 1;
                }

                // محاسبه وزن کل بر اساس برنج
                $totalWeight = 0;
                $items = cart()->getContent();
                foreach ($items as $cartItem) {

                    // جداسازی محصولات غیر برنج
                    $categories = $cartItem->associatedModel->categories->pluck('id')->toArray();
                    if(in_array(443, $categories)) {
                        continue;
                    }

                    $totalItemWeight = intval($cartItem->associatedModel->weight) * $cartItem->quantity / 1000;
                    $totalWeight += $totalItemWeight;
                }

                // محاسبه مبلغ کل بدون تخفیف
                $totalDiscount = 0;
                foreach (cart()->getContent() as $item) {
                    $rowArr = explode('_',$item->id);
                    $inventoryId = null;
                    if (count($rowArr) > 1){
                        $inventoryId =$rowArr[1];
                    }
                    $totalDiscount += $item->associatedModel->getDiscountedPrice($inventoryId) * $item->quantity;
                }
                $totalPriceWithoutDiscount = cart()->getSubTotalWithoutConditions() + $totalDiscount;

                $item = cart()->get($productId);
                $priceSum = $item->getPriceSum();
                $cartTotal = cart()->getSubTotalWithoutConditions();
                $result = array(
                    'status' => 'success',
                    'quantity' => $item->quantity,
                    'item_price_sum' => $priceSum,
                    'cart_total_quantity' => cart()->getTotalQuantity(),
                    'cart_total' => $totalPriceWithoutDiscount,
                    'is_max_quantity' => $isLast,
                    'cart_total_discount' => $cartTotalDiscount,
                    'item_total_discount' => $itemTotalDiscount,
                    'total_weight' => $totalWeight,
                    'price_to_pay' => number_format(cart()->getTotal())
                );
                return response($result);
            } else {
                return response(array(
                    'status' => 'max_quantity'
                ));
            }
        }
        return response(array('status' => 'unauthorized'));
    }

    public function decrease()
    {
        if (request()->ajax()) {
            $rowId = request('id');
            $item = cart()->get($rowId);
            $quantity = $item->quantity;
            $rowArr = explode('_',$rowId);
            $inventoryId = null;
            if (count($rowArr) > 1){
                $inventoryId =$rowArr[1];
            }

            $cartTotalDiscount = 0;
            foreach (cart()->getContent() as $i) {
                if ($i->id == $item->id) {
                    $cartTotalDiscount += $i->associatedModel->getDiscountedPrice($inventoryId) * ($i->quantity - 1);
                } else {
                    $cartTotalDiscount += $i->associatedModel->getDiscountedPrice($inventoryId) * $i->quantity;
                }
            }
            $itemTotalDiscount = $item->associatedModel->getDiscountedPrice($inventoryId) * ($item->quantity - 1);

            if ($quantity > 1) {
                cart()->update($rowId, array('quantity' => -1));
                $item = cart()->get($rowId);
                $priceSum = $item->getPriceSum();
                $cartTotal = cart()->getSubTotalWithoutConditions();
                if (cart()->getTotalQuantity() == 0) {
                    cart()->clear();
                    cart()->clearCartConditions();
                    session()->remove('coupon');
                }

                // محاسبه وزن کل بر اساس برنج
                $totalWeight = 0;
                $items = cart()->getContent();
                foreach ($items as $cartItem) {

                    // جداسازی محصولات غیر برنج
                    $categories = $cartItem->associatedModel->categories->pluck('id')->toArray();
                    if(in_array(443, $categories)) {
                        continue;
                    }

                    $totalItemWeight = intval($cartItem->associatedModel->weight) * $cartItem->quantity / 1000;
                    $totalWeight += $totalItemWeight;
                }

                // محاسبه مبلغ کل بدون تخفیف
                $totalDiscount = 0;
                foreach (cart()->getContent() as $item) {
                    $rowArr = explode('_',$item->id);
                    $inventoryId = null;
                    if (count($rowArr) > 1){
                        $inventoryId =$rowArr[1];
                    }
                    $totalDiscount += $item->associatedModel->getDiscountedPrice($inventoryId) * $item->quantity;
                }
                $totalPriceWithoutDiscount = cart()->getSubTotalWithoutConditions() + $totalDiscount;

                $result = array(
                    'status' => 'success',
                    'quantity' => $item->quantity,
                    'item_price_sum' => $priceSum,
                    'cart_total_quantity' => cart()->getTotalQuantity(),
                    'cart_total' => $totalPriceWithoutDiscount,
                    'cart_total_discount' => $cartTotalDiscount,
                    'item_total_discount' => $itemTotalDiscount,
                    'total_weight' => $totalWeight,
                    'price_to_pay' => number_format(cart()->getTotal())
                );
                return response($result);
            } else {
                return response(array(
                    'status' => 'min_quantity'
                ));
            }
        }
        return response(array('status' => 'unauthorized'));
    }

    public function delete()
    {
        if (request()->ajax()) {
            $rowId = request('id');
            $item = cart()->get($rowId);
            $rowArr = explode('_',$rowId);
            $inventoryId = null;
            if (count($rowArr) > 1){
                $inventoryId =$rowArr[1];
            }

            $cartTotalDiscount = 0;
            foreach (cart()->getContent() as $i) {
                $cartTotalDiscount += $i->associatedModel->getDiscountedPrice($inventoryId) * $i->quantity;
            }
            $cartTotalDiscount = $cartTotalDiscount - ($item->associatedModel->getDiscountedPrice($inventoryId) * $item->quantity);

            if (cart()->remove($rowId)) {
                $cartTotal = cart()->getSubTotalWithoutConditions();
                $cartQuantity = cart()->getContent()->count();
                $cartTotalQuantity = cart()->getTotalQuantity();

                $this->checkCartConditions();

                if ($cartTotalQuantity == 0) {
                    cart()->clear();
                    cart()->clearCartConditions();
                }

                $result = array(
                    'status' => 'success',
                    'cart_quantity' => $cartQuantity,
                    'cart_total_quantity' => $cartTotalQuantity,
                    'cart_total' => $cartTotal,
                    'cart_total_discount' => $cartTotalDiscount,
                );
            } else {
                $result = array('status' => 'error');
            }
            return response($result);
        }
        return array('status' => 'error');
    }

    public function add()
    {
        if (request()->ajax()) {
            try {
                $productId = request('product_id');
                $colorId = request('color_id');
                $sizeId = request('size_id');
                $inventoryId = null;

                // get selected inventory
                if ($colorId && !$sizeId) {
                    $inventory = ProductInventory::where('product_id',$productId)
                        ->where('color_id',$colorId)->first();
                }else if (!$colorId && $sizeId) {
                    $inventory = ProductInventory::where('product_id',$productId)
                        ->where('size_id',$sizeId)->first();
                }else if($colorId && $sizeId) {
                    $inventory = ProductInventory::where('product_id',$productId)
                        ->where('size_id',$sizeId)
                        ->where('color_id',$colorId)
                        ->first();
                }


                $product = Product::find($productId);
                // check product
                if (!$product) {
                    return response(array('status' => 'product_not_found'));
                }

                // check inventory
                $rowId = $productId;
                $attributes = [];
                if (isset($inventory)){
                    $inventoryId = $inventory->id;
                    $rowId = $productId .'_'. $inventoryId;
                    $color = ProductColor::find($colorId);
                    $size = ProductSize::find($sizeId);
                    $attributes = array(
                        'inventory_id' => $inventory->id,
                        'color' => $color,
                        'size' => $size
                    );
                }

                $quantityToAdd = 1;
                if (request()->has('quantity') && request('quantity') != null && request('quantity') != '' && request('quantity') != 'NaN'){
                    $quantityToAdd = intval(request('quantity'));
                }

                // check quantity to add
                if ($quantityToAdd > $product->getStockQuantity($inventoryId)){
                    $msg = "شما مجاز به خرید این تعداد از محصول نیستید.";
                    if ($inventoryId) $msg = "موجودی کالا با ویژگی های انتخاب شده به اتمام رسیده.";
                    return response(array(
                        'status' => 'low_quantity',
                        'msg' => $msg
                    ));
                }

                // check stock
                $item = cart()->get($rowId);
                $itemQuantity = 0;
                if ($item) {
                    $itemQuantity += $item->quantity;
                }

                if ($product->getStockQuantity($inventoryId) < (1 + $itemQuantity)) {
                    return response(array('status' => 'out_of_stock'));
                } else {
                    cart()->add(array(
                        'id' => $rowId,
                        'name' => $product->title,
                        'price' => $product->getFinalPrice($inventoryId),
                        'quantity' => $quantityToAdd,
                        'attributes' => $attributes,
                        'associatedModel' => $product
                    ));
                    $cartTotal = cart()->getTotal();
                    $cartQuantity = cart()->getContent()->count();
                    $cartTotalQuantity = cart()->getTotalQuantity();
                    $result = array(
                        'status' => 'success',
                        'cart_quantity' => $cartQuantity,
                        'cart_total_quantity' => $cartTotalQuantity,
                        'cart_total' => $cartTotal,
                        'product' => $product,
                    );
                    return response($result);
                }
            } catch (\Exception $e) {
                return $e;
            }
        }
        return response(array('status' => 'unauthorized'));
    }
}
