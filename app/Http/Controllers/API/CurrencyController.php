<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HelpFunctionsController;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\CursorPaginationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $currency = Currency::select(['id', 'title' => 'Name'])->get();
        $data = [];
        foreach ($currency as $c) {
            array_push($data,
                [
                    'id' => $c['id'],
                    'text' => $c['Name']
                ]);
        }

        return json_encode([
            "results" => $data
        ]);

//        return json_encode($data, 1);
    }

    public function getGlsFromCurrencyId($currencyId)
    {
        $gls = DB::select(DB::raw(
            'SELECT cgd.* FROM currency c
                    INNER JOIN currency_gl_master cgl on c.id = cgl.CurrencyId
                    inner join currency_gl_detail cgd on cgl.id = cgd.CurrencyGLMasterId
                    where c.id = ' . $currencyId . '
                    order by cgl.EffectDate desc limit 1;'
        ));

        return $gls;

    }

    public function getCurrencyFromCurrencyCode($code)
    {
        return Currency::where('Code', $code)->first();

    }

    public function mapCurrencyToGl(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'gl_id' => 'required|unique:currency_gl_detail,GlId',
            'currency_id' => 'required',
            'tran_type_id' => 'required',
            'currency_master_id' => 'required'
        ]);

        if ($validator->fails()) {
            $response['success'] = false;
            $response['message'] = $validator->messages();
        } else {

            $insert_data = [
                'CurrencyGLMasterId' => $request['currency_master_id'],
                'GlId' => $request['gl_id'],
                'TranTypeId' => $request['tran_type_id'],
                "TranDate" => Carbon::now(),
                "TranUserId" => 1,
                "StatusChangeDate" => Carbon::now(),
                "StatusChangeUserId" => 1,
                "Status" => 1,
            ];
//            return $insert_data;
//            $insert_data = HelpFunctionsController::addMandatoryFields($insert_data);

            $save = DB::table('currency_gl_detail')->insert($insert_data);

            return [
                "success" => true,
                "message" => "Currency Mapped with GL Successfully!",
                "object" => $save
            ];

        }
        return $response;
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Currency::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
