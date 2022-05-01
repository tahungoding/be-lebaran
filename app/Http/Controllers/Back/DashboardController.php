<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Web;
use App\Models\Pos;
use App\Models\User;
use App\Models\PosGatur;
use App\Models\Kemacetan;
use App\Models\Kecelakaan;
use Illuminate\Support\Facades\Auth;
use Analytics;
use GuzzleHttp\Client;
use Spatie\Analytics\Period;



class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['web'] = Web::all();
        $data['pos'] = Pos::count();
        $data['pos_gatur'] = PosGatur::count();
        $data['user'] = User::count();
        $data['kemacetan'] = Kemacetan::when(Auth::user()->role == 'pos', function ($query) {
            $query->where('pos_id', Auth::user()->pos_id);
        })->count();
        $data['kecelakaan'] = Kecelakaan::when(Auth::user()->role == 'pos', function ($query) {
            $query->where('pos_id', Auth::user()->pos_id);
        })->count();
        $days = 0;
        // $analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days($days));
        $data['analyticsData'] = Analytics::performQuery(
            Period::days(0),
            'ga:pageviews',
            [
                'metrics' => 'ga:visitors',
                'dimensions' => 'ga:date',
                'filters' => 'ga:pagePath==/Init page view'
            ]
            
        );
        
        $data['visitor'] = $data['analyticsData']->totalsForAllResults['ga:visitors'];
       

        // $client = new Client(); //GuzzleHttp\Client
        // $url = "https://api.countapi.xyz/update/lebaran.sumedangkab.go.id/visitor?amount=1";


        // $response = $client->request('GET', $url, [
        //     'verify'  => false,
        // ]);

        // $responseBody = json_decode($response->getBody());
        // $data['visitor'] = $responseBody;

        // $data['analyticsData'] = Analytics::fetchVisitorsAndPageViews(Period::days(7));
        // dd($data['analyticsData']);
        return view('back.dashboard.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
