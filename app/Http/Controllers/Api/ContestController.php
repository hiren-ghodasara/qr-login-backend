<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contest;
use App\Models\ContestType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContestController extends Controller
{
    public function listAllContest(Request $request)
    {
        //sleep(3);
        //print_r($request->get('sort'));
        DB::enableQueryLog();
        $query = Contest::with(['contestsType', 'user']);
        if ($request->get('price')) {
            $query->whereBetween('joining_fee', $request->get('price'));
        }
        if ($request->get('contests_type')) {
            $query->whereIn('type', $request->get('contests_type'));
        }
        if ($request->get('organizer')) {
            $query->whereIn('created_by', $request->get('organizer'));
        }
        $query = $query->where('execution_date', '>', Carbon::now());
        if ($request->get('sort')) {
            $sortCol = $request->get('sort')['key'];
            if ($sortCol == "joined_user") {
                $sortCol = DB::raw("joined_user * 100 / max_user");
            }
            $query = $query->orderBy($sortCol, $request->get('sort')['by']);
        }

        $data = $query->paginate($request->get('per_page'));
        //lq(1);
        return response($data);
    }

    public function setSideBarFilter(Request $request)
    {
        $filterResult = array();
        $query = DB::table('contests');
        $query->select(DB::raw("MAX(joining_fee) as maxPrice , MIN(joining_fee) as minPrice"));
        $result = $query->get();
        if ($result && $result[0]) {
            $filterResult['price'] = ["min" => $result[0]->minPrice, "max" => $result[0]->maxPrice];
        }
        $contests_type = ContestType::all();
        if ($contests_type) {
            $filterResult['contests_type'] = $contests_type;
        }
        $user = Contest::select('created_by', DB::raw('1 as visibility'), DB::raw('count(*) as total'))->with(['user' => function ($query) {
            $query->select('id', 'first_name', 'last_name');
        }])->where('execution_date', '>', Carbon::now())->groupBy('created_by')->get();
        if ($user) {
            $filterResult['organizer'] = $user;
        }
        return response($filterResult);
    }

    public function TestCreate(Request $request)
    {
        $faker = \Faker\Factory::create();
        $sourceDir = storage_path('app/public/contest_default');
        $targetDir = storage_path('app/public/contest_photo');
        $path = $faker->file($sourceDir, $targetDir, false);
        $filterResult = Contest::create(
            [
                'name' => $faker->safeColorName,
                'photo' => "storage/contest_photo/{$path}",
                'description' => $faker->paragraph(rand(3, 30)),
                'created_by' => \Auth::guard('api')->check() ? \Auth::guard('api')->user()->id : 3,
                'type' => 1,
                'joining_fee' => $faker->numberBetween(10, 100),
                'max_user' => $faker->numberBetween(40, 50),
                'joined_user' => $faker->numberBetween(1, 40),
                'execution_date' => Carbon::parse($request->get('execution_date'))->addMinute(10),
            ]
        );
        return response($filterResult);
    }
}
