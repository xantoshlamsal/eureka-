@extends('dashboard')
@section('content')
    <div class="card p-6">
        <form action="{{url('currency')}}" method="post">
            @csrf
            <div class="form-row">
                <div class="form-group input-group-sm col-md-2">
                    <label>Currency Code</label>
                    <input type="text" class="form-control input-sm" placeholder="Currency Code" name="CurrencyCode"
                           maxlength="2" value="{{old('CurrencyCode')}}">
                </div>

                <div class="form-group input-group-sm col-md-5">
                    <label>Currency Name</label>
                    <input type="text" class="form-control" name="CurrencyName" value={{old('CurrencyName')}} >
                </div>
                <div class="form-group input-group-sm  col-md-5">
                    <label>Currency Name Local Language</label>
                    <input type="text" class="form-control" name="NameLoc" value={{old('NameLoc')}}>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group input-group-sm col-md-4">
                    <label>Country Name</label>
                    <select class="form-control" name="country">
                        @foreach($countries as $c)
                            <option value={{$c->id}}>{{$c->name}} {{$c->ThreeCharCode}} </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group input-group-sm col-md-4">
                    <label>Currency Alias</label>
                    <input type="text" class="form-control" name="Alias" maxlength="10" value={{old('Alias')}}>
                </div>
                <div class="form-group input-group-sm col-md-4">
                    <label>Decimal Length</label>
                    <select class="form-control" name="DecimalLength">
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group input-group-sm col-md-3">
                    <label>ISO Code</label>
                    <input type="text" class="form-control" name="IsoCode" maxlength="10" value={{old('IsoCode')}}>
                </div>
                <div class="form-group input-group-sm col-md-3">
                    <label>Rate Quoted Method</label>
                    <select name="RateQuoteMethod" class="form-control">
                        <option value="1">Direct</option>
                        <option value="2">Indirect</option>
                    </select>
                </div>
                <div class="form-group input-group-sm col-md-3">
                    <label>Is Normal Currency?</label>
                    <select name="IsNormalCurrency" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group input-group-sm col-md-3">
                    <label>Is Convertible Currency?</label>
                    <select name="IsConvertibleCurrency" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group input-group-sm col-md-3">
                    <label>Transaction Option</label>
                    <select name="TransactionOption" class="form-control">
                        <option value="0">None</option>
                        <option value="1">Both</option>
                        <option value="2">Buying Only</option>
                        <option value="3">Selling Only</option>
                    </select>
                </div>
                <div class="form-group input-group-sm col-md-3">
                    <label>Is Multiple Deno</label>
                    <select name="IsMultipleDeno" class="form-control">
                        <option value="1">Yes</option>
                        <option value="0">No</option>
                    </select>
                </div>
                <div class="form-group input-group-sm col-md-3">
                    <label>Lower Deno Name</label>
                    <input type="text" class="form-control" name="LowerDenoName" maxlength="100">
                </div>
                <div class="form-group input-group-sm col-md-3">
                    <label>Lower Deno Size</label>
                    <input type="number" class="form-control" name="LowerDenoSize" min="0" max="9999" maxlength="4">
                </div>
            </div>
            <button type="submit" class="btn-sm btn-primary">Save</button>
        </form>

    </div>

@endsection

