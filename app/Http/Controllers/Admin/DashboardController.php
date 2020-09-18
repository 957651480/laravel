<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\ApiController;
use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DashboardController extends ApiController
{

    public function panelGroup(Request $request)
    {
        $panelGroup = [
            'newVisitis' => [
                'expectedData' => [100, 120, 161, 134, 105, 160, 165],
                'actualData' => [120, 82, 91, 154, 162, 140, 145]
            ],
            'messages' => [
                'expectedData' => [200, 192, 120, 144, 160, 130, 140],
                'actualData' => [180, 160, 151, 106, 145, 150, 130]
            ],
            'purchases' => [
                'expectedData' => [80, 100, 121, 104, 105, 90, 100],
                'actualData' => [120, 90, 100, 138, 142, 130, 130]
            ],
            'shoppings' => [
                'expectedData' => [130, 140, 141, 142, 145, 150, 160],
                'actualData' => [120, 82, 91, 154, 162, 140, 130]
            ]
        ];
    }

    public static function weekdayUser()
    {
        $query = User::query();
        $query->whereHas('indents', function (Builder $query) {
            $query->where('type', 'openid');
        });
        $now = time();
        $sevenDay = strtotime('-7 day', $now);
        $list = $query->where('created_at', '>=', $sevenDay)
            ->where('created_at', '=<', $now)
            ->groupBy(DB::raw('FROM_UNIXTIME(created_at,\'%Y-%m-%d\')'))
            ->list();
        return $list;
    }
}