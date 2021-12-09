<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HelpFunctionsController extends Controller
{
    public static function getSaveInformation(): array
    {
        return [
            "TranDate" => Carbon::now(),
            "TranUserId" => Auth::id(),
            "StatusChangeDate" => Carbon::now(),
            "StatusChangeUserId" => Auth::id(),
            "Status" => 1
        ];
    }

    public static function addMandatoryFields($object=[]): array
    {
            $object["TranDate"] = Carbon::now();
            $object["TranUserId"] = Auth::id();
            $object["StatusChangeDate"] = Carbon::now();
            $object["StatusChangeUserId"] = Auth::id();
            $object["Status"] = 1;
            return $object;
    }
    public static function getStatusTerm($code)
    {
        $statuses = [
            0 => 'Draft',
            1 => 'New',
            2=> 'Under Approval',
            3=> 'Review During Under Approval',
            4=> 'Rejected During Under Approval',
            5=> 'Approved',
            6=> 'On Queue',
            7=> 'Closed',
        ];

        return $statuses[$code];
    }

    public static function getUserNameFromId($id){
        $username=User::select(['name'])->where('id',$id)->first();
        return $username['name'];
    }
}
