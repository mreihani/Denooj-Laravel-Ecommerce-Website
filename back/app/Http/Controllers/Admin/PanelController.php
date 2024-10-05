<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use CyrildeWit\EloquentViewable\Support\Period;
use Hekmatinasser\Verta\Verta;
use Illuminate\Support\Carbon;
use Modules\Blog\Entities\Post;
use Modules\Comments\Entities\Comment;
use Modules\Orders\Entities\Order;
use Modules\Products\Entities\Category;
use Modules\Products\Entities\Product;
use Modules\Questions\Entities\Question;
use Modules\Users\Entities\User;


class PanelController extends Controller
{
    public function dashboard(){

        $latestOrders = Order::latest()->take(4)->get();
        $ordersCount = Order::all()->count();
        $saleCount = Order::where('is_paid',true)->get()->count();

        // total sale
        $totalSale = Order::where('is_paid',true)->sum('paid_price');

        // total month sale
        $totalMonthSale = Order::where('is_paid',true)->where('created_at', '>=', Carbon::now()->subDays(30))->sum('paid_price');

        // total week sale
        $totalWeekSale = Order::where('is_paid',true)->where('created_at', '>=', Carbon::now()->subDays(7))->sum('paid_price');

        // visits
        $productVisitCount = views(Product::class)->period(Period::pastMonths(1))->count();
        $postVisitCount = views(Post::class)->period(Period::pastMonths(1))->count();
        $categoryVisitCount = views(Category::class)->period(Period::pastMonths(1))->count();

        // active users
        $activeUsers = User::orderByDesc('last_active_at')->take(8)->get();

        // total users count
        $usersCount = User::all()->count();

        // comments
        $comments = Comment::latest()->take(5)->get();

        // questions
        $questions = Question::where('parent_id',null)->latest()->take(5)->get();

        // most visited products
        $mostVisitedProducts = Product::orderByViews('asc',Period::pastMonths(1))->take(8)->get();


        // get chart data
        $monthsList = [];
        $chartSalePrice = [];
        $chartSaleCount = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = Verta::today()->startMonth()->subMonth($i);
            $date = Carbon::now()->subMonths($i);
            $sale = Order::where('is_paid',true)->where('created_at', '<=', $date);
            array_push($monthsList, $month->format('%B %Y'));
            array_push($chartSalePrice, $sale->sum('paid_price'));
            array_push($chartSaleCount, $sale->count());
        }
        $chartData = json_encode([
            'labels' => $monthsList,
            'sale_price' => $chartSalePrice,
            'sale_count' => $chartSaleCount
        ]);

        return view('admin.views.dashboard',compact([
            'comments',
            'mostVisitedProducts',
            'questions',
            'activeUsers',
            'usersCount',
            'ordersCount',
            'saleCount',
            'totalSale',
            'totalMonthSale',
            'totalWeekSale',
            'productVisitCount',
            'postVisitCount',
            'categoryVisitCount',
            'chartData',
            'latestOrders'
        ]));
    }

    public function icons(){
        return view('admin.views.icons');
    }

    public function getUserInfo(){
        $user = User::find(request('user_id'));
        if ($user) {
            return response([
                'data' => $user,
                'status' => 'success'
            ]);
        }
        return response([
            'status' => 'error'
        ]);
    }

    public function changelog(){
        return view('admin.views.changelog');
    }

}
