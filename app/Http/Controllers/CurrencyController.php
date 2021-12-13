<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Currency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('currency.index')->with(['currencies' => Currency::all()]);
    }

    public function searchCurrency($q)
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('currency.create')->with(['countries' => Country::all()]);
    }

    public function glmap()
    {
//        return "Hello";
        $tranTypes = DB::table('currency_tran_type')->get();
//        return $tranTypes;
        return view('currency.currencyGLMap')->with(['currencies' => Currency::all(), 'tranTypes' => $tranTypes]);
    }

    public function getGlsFromCurrency(Request $request)
    {
        $request->validate([
            'CurrencyCode' => 'required',
            'CurrencyId' => 'required',
            'EffectDate' => 'required'
        ]);


//        $gls = [];
//        foreach (DB::table('currency_tran_type')->get() as $tr) {
//            $d2 = DB::table('currency_gl_detail')
//                ->where('TranTypeId', '=', $tr->id)
////                ->leftJoin('currency_gl_master', function ($join) {
////                    $join->on('currency_gl_master.CurrencyId','=','currency_gl_detail.CurrencyGlMasterId');
////                })
//                ->select('id', 'CurrencyGLMasterId', 'GlId', 'TranTypeId')
//                ->get();
//            $gls[$tr->TranTypeName] = $d2;
//        }
//
//        return $gls;
//
//        foreach ($gls as $gl){
//
//        }


        $effect_dates = DB::table('currency_gl_master')
            ->where('currencyId', $request['CurrencyId'])
            ->select(['id', 'EffectDate'])
            ->get();

        foreach ($effect_dates as $e) {
            $details = DB::table('currency_gl_detail')
                ->where('CurrencyGlMasterId', '=', $e->id)
                ->select(['id', 'GlId', 'TranTypeId'])
                ->get();
        }


        $d1 = DB::table('currency_gl_master')
            ->where('CurrencyId', $request['CurrencyId'])
            ->where('EffectDate', '<=', $request['EffectDate'])
            ->orderBy('EffectDate', 'DESC')
            ->select('id')
            ->first();

//        return $d1;

        $d2 = DB::table('currency_gl_detail')
            ->where('CurrencyGLMasterId', $d1->id ?? 0)
            ->join('gl', 'currency_gl_detail.GlId', '=', 'gl.Id')
            ->join('currency_tran_type', 'currency_gl_detail.TranTypeId', '=', 'currency_tran_type.Id')
            ->get();

        $currency = Currency::select(['id', 'Name'])->where('id', $request['CurrencyId'])->first();


//        $gls = DB::select(DB::raw(
//            'SELECT cgd.* FROM currency c
//                    INNER JOIN currency_gl_master cgl on c.id = cgl.CurrencyId
//                    inner join currency_gl_detail cgd on cgl.id = cgd.CurrencyGLMasterId
//                    where c.id = '.$request['CurrencyId'].'
//                    order by cgl.EffectDate desc limit 1;'
//        ));

        $requestValues = [
            "CurrencyCode" => $request['CurrencyCode'],
            "CurrencyName" => $currency['Name'],
            "CurrencyId" => $request['CurrencyId'],
            "EffectDate" => $request['EffectDate'],
        ];

//        return [
//            "currency" => $currency,
//            "gls" => $d2
//        ];

//        return $tranTypes;
        return view('currency.currencyGLMap')->with(
//        return
            ['currencies' => Currency::all(),
                'tranTypes' => DB::table('currency_tran_type')->get(),
                'gls' => $d2,
                'currency' => $currency,
                'request_values' => $requestValues,
                'effect_dates' => $effect_dates
            ]);
//        return redirect()->back()->with(['gls'=>$gls, 'old_values'=>$requestValues]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'CurrencyCode' => 'required|unique:currency,Code|max:2',
            'CurrencyName' => 'required|max:50|unique:currency,Name',
            'NameLoc' => 'required|max:50|unique:currency,NameLoc',
            'Alias' => 'required|max:5|unique:currency,Alias',
            'DecimalLength' => 'required|numeric|min:1|max:8',
            'IsoCode' => 'required | max:3',
            'RateQuoteMethod' => 'required',
            'IsNormalCurrency' => 'required',
            'IsConvertibleCurrency' => 'required',
            'TransactionOption' => 'required',
            'IsMultipleDeno' => 'required',
            'LowerDenoName' => 'required|max:25',
            'LowerDenoSize' => 'required|max:4',
        ]);


        $currency = new Currency();
        $currency['Code'] = $request["CurrencyCode"];
        $currency['Name'] = $request["CurrencyName"];
        $currency['NameLoc'] = $request["NameLoc"];
//        $currency['']=$request["country"];
        $currency['Alias'] = $request["Alias"];
        $currency['DecimalLength'] = $request["DecimalLength"];
        $currency['IsoCode'] = $request["IsoCode"];
        $currency['RateQuoteMethod'] = $request["RateQuoteMethod"];
        $currency['IsNormalCurrency'] = $request["IsNormalCurrency"];
        $currency['IsConvertibleCurrency'] = $request["IsConvertibleCurrency"];
        $currency['TranOption'] = $request["TransactionOption"];
        $currency['IsLowerDeno'] = $request["IsMultipleDeno"];
        $currency['LowerDenoName'] = $request["LowerDenoName"];
        $currency['LowerDenoSize'] = $request["LowerDenoSize"];

        //autofilled fields
        $currency['LowerDenoSize'] = $request["LowerDenoSize"];

        $data = HelpFunctionsController::getSaveInformation();
        $currency['TranDate'] = $data['TranDate'];
        $currency['TranUserId'] = $data['TranUserId'];
        $currency['Status'] = $data['Status'];
        $currency['StatusChangeUserId'] = $data['StatusChangeUserId'];
        $currency['StatusChangeDate'] = $data['StatusChangeDate'];
        $currency->save();

        $this->saveCurrencyEffectDate($currency->id, $data);

        return view('currency.index')->with(['currencies' => Currency::all()]);

//        return redirect()->back()->with('Currency Created Successfully and Effect Date entry done successfully');
    }

//    public function test()
//    {
//        return DB::table('currency_gl_master')->insertGetId([
//            'CurrencyId' => 1,
//            'EffectDate' => date('Y-m-d'),
//            'TranDate' => Carbon::now(),
//            'TranUserId' => Auth::id(),
//            'Status' => 1,
//            'StatusChangeUserId' => Auth::id(),
//            'StatusChangeDate' => Carbon::now(),
//        ]);
//    }

    public function saveCurrencyEffectDate($currencyId, $mandatoryFields = [])
    {
        DB::table('currency_gl_master')->insert([
            'CurrencyId' => $currencyId,
            'EffectDate' => date('Y-m-d'),
            'TranDate' => $mandatoryFields['TranDate'],
            'TranUserId' => $mandatoryFields['TranUserId'],
            'Status' => $mandatoryFields['Status'],
            'StatusChangeUserId' => $mandatoryFields['StatusChangeUserId'],
            'StatusChangeDate' => $mandatoryFields['StatusChangeDate'],
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
