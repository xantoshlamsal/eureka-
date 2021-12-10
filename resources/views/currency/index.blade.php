@extends('dashboard')
@section('content')
    <div class="card">
        <div class="card-header">
            List of Currencies
        </div>
        <div class="card-body">
            <table class="table text-xs table-striped">
                <thead>
                <tr>
                    <th>SN</th>
                    <th>Code</th>
                    <th>Currency Name</th>
                    <th>Currency Name Loc</th>
                    <th>Alias</th>
                    <th>Rate Quote Method</th>
                    <th>Decimal Length</th>
                    <th>Normal Currency?</th>
                    <th>Convertible Currency?</th>
                    <th>Tran. Option</th>
                    <th>ISO Code</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($currencies as $c)
                    <tr>
                        <td>{{$c->id}}</td>
                        <td>{{$c->Code}}</td>
                        <td>{{$c->Name}}</td>
                        <td>{{$c->NameLoc}}</td>
                        <td>{{$c->Alias}}</td>
                        <td>{{($c->RateQuoteMethod==1)?'Direct':'Indirect'}}</td>
                        <td>{{$c->DecimalLength}}</td>
                        <td>{{($c->IsNormalCurrency==1)?'Yes':'No'}}</td>
                        <td>{{($c->IsConvertibleCurrency==1)?'Yes':'No'}}</td>
                        <td>{{\App\Http\Controllers\HelpFunctionsController::getTransactionOptionTerm($c->TranOption)}}</td>
                        <td>{{$c->IsoCode}}</td>
                        <td>{{$c->Status}}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
