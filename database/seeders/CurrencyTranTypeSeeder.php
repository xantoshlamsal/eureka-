<?php

namespace Database\Seeders;

use App\Http\Controllers\HelpFunctionsController;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyTranTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mandatoryfields = HelpFunctionsController::getSaveInformation();
//        dd($mandatoryfields);
        $tranTypeNames= [
            1=>"Position a/c GL",
            2=>"Exchange a/c GL",
            3=>"Off Balance Sheet Position a/c GL",
            4=> "Off Balance Sheet Exchange a/c GL",
            5=> "Vault",
            6=> "Head Teller",
            7=> "Teller",
            8=> "In Transit",
            9=> "Trading",
            10=>"Revaluation"
        ];

        foreach ($tranTypeNames as $key=>$value){
            DB::table('currency_tran_type')->insert([
                'DispOrder' => $key,
                'TranTypeCode' => $key,
                'TranTypeName' => $value,
                'TranDate' => $mandatoryfields['TranDate'],
                'TranUserId' => $mandatoryfields['TranUserId']??1,
                'Status' => $mandatoryfields['Status']??5,
                'StatusChangeUserId' => $mandatoryfields['StatusChangeUserId']??1,
                'StatusChangeDate' => $mandatoryfields['StatusChangeDate']
            ]);
        }

    }
}
