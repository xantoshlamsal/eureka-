@extends('dashboard')
@section('content')
    <div class="card">
        <div class="card-header">
            Search GL by Currency
        </div>
        <div class="card-body">
            <form action="{{url('currency-gls')}}" method="post">
                @csrf
                <div class="form-row">
                    <div class="form-group input-group-sm col-sm-4">
                        <label>Effect Date</label>
                        <input type="date" id="calendar-effect-date" name="EffectDate" class="form-control"
                               value="{{$request_values['EffectDate']??old('EffectDate')??date('Y-m-d')}}" required>
                    </div>

                    <div class="form-group input-group-sm col-sm-2">
                        <label>Currency Code</label>
                        <input type="text" class="form-control input-sm" placeholder="Currency Code"
                               name="CurrencyCode" id="currency_code"
                               maxlength="2" value="{{ $request_values['CurrencyCode']??old('CurrencyCode')}}" required>
                    </div>
                    <div class="form-group input-group-sm  col-sm-6">
                        <label>Curency Name</label><br>
                        <select id="currency_name" type="text" class="form-control input-sm" placeholder="Currency name"
                                name="CurrencyId" required>
                            @if(isset($request_values))
                                <option
                                    value="{{$request_values['CurrencyId']}}">{{$request_values['CurrencyName']}}</option>
                            @endif
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-sm btn-primary align-items-bottom">Submit</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
        <div class="card-footer">
            @if(isset($effect_dates))
                This currency has {{count($effect_dates??[])}} effect dates.
                <br>
                <ul id="ul-effect-date" class="list-inline">
                    @foreach($effect_dates as $e)
                        <li id="text-effect-date" class="list-inline-item p-1"
                            style="background: #abb3ba; text-decoration-color: #ffffff"> {{date("Y-m-d", strtotime($e->EffectDate))}}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            List of GL
        </div>
        <div class="card-body">
            @if(isset($request_values))
                <table class="table table-sm text-xs table-hover">
                    <thead>
                    <th>Tran Types</th>
                    <th>GL Code</th>
                    <th>GL Heads</th>
                    <th>Action</th>
                    </thead>
                    <tbody>
                    <?php $col_flag = 0; ?>
                    @foreach($tranTypes as $t)
                        <tr>
                            <td>{{$t->TranTypeCode}} - {{$t->TranTypeName}}</td>
                            @foreach($gls as $g)
                                @if($t->id==$g->TranTypeId)
                                    <?php $col_flag++; ?>
                                    <td>{{$g->GlCode}}</td>
                                    <td>{{$g->GlName}}</td>
                                @endif
                            @endforeach
                            @if($col_flag==0)
                                <td>-</td>
                                <td>-</td>
                            @endif
                            <td>
                                <input type="hidden" id="hidden_tran_type_id" value="{{$t->id}}">
                                {{--                                <input type="hidden" id="hidden_already_mapped" value="{{$t->id}}">--}}
                                <input type="hidden" id="hidden_already_mapped" value="{{($col_flag==0)?0:1}}">
                                <button id="btn_tran_type_gl" type="button" class="btn-xs btn-warning"
                                        data-toggle="modal"
                                        data-target="#exampleModal">
                                    Update
                                </button>
                            </td>
                        </tr>
                        <?php $col_flag = 0; ?>

                    @endforeach
                    </tbody>
                </table>
            @else
                <p>Select Currency to View Details.</p>
            @endif
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Select GL</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{--                    <form action="{{url('currency-gls')}}" method="post">--}}
                    <div class="form-row mb-4">
                        <label>Effect Date</label>
                        <input type="date" id="new_effect_date" class="form-control input-sm" value="{{date('Y-m-d')}}">
                    </div>
                    <div class="form-row">
                        <div class="form-group input-group-sm  col-sm-3">
                            <label>GL Code</label>
                            <input type="text" class="form-control input-sm" placeholder="GL Code"
                                   name="GlCode" id="gl_code">
                        </div>
                        <div class="form-group input-group-sm col-sm-7">
                            <label>GL Name</label><br>
                            <input type="text" id="gl_name_query" class="form-control input-sm"
                                   placeholder="search by name">
                            {{--                                <select id="gl_name" type="text" class="form-control input-sm" placeholder="GL Name name"--}}
                            {{--                                        name="GlName" style="width: 100%">--}}
                            {{--                                </select>--}}
                        </div>
                        <div class="form-group input-group-sm  col-sm-2">
                            <br>
                            <button class="btn-sm btn-warning input-sm" placeholder="GL Code"
                                    id="search_btn">Search
                            </button>
                        </div>
                    </div>

                    {{--                    </form>--}}
                    <table class="table-sm text-xs table-stripped">
                        <thead>
                        <tr>
                            <th>GL Code</th>
                            <th>GL Name</th>
                        </tr>
                        </thead>
                        <tbody id="modal_tbody">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            var currency_id = 0;
            var currency_master_id;
            var gl_id = 0;
            var tran_type_id = 0;
            var user_id = {!! json_encode(\Illuminate\Support\Facades\Auth::id()) !!};
            var already_mapped;
            var effect_date_new;
            var effect_date;


            $(document).on("click", "#btn_tran_type_gl", function () {
                var $row = $(this).closest('tr');
                tran_type_id = $row.find('#hidden_tran_type_id').val();
                already_mapped = $row.find('#hidden_already_mapped').val();
                effect_date=$('#calendar-effect-date').val();
                // currency_master_id = $row.find('#hidden_currency_gl_master_id').val();
                console.log("currency_master" + currency_master_id);
                if (already_mapped == 1) {
                    $('#new_effect_date').closest('label').append(`This Transaction type
                    has already mapped to a gl. Enter new Effect Date to map to another GL`);
                    $('#new_effect_date').prop("disabled", false);
                } else {
                    $('#new_effect_date').prop("disabled", true);
                }
            });

            $(document).on("change", "#new_effect_date", function (){
               effect_date_new=$(this).val();
               console.log(effect_date_new);
            });

            $(document).on("click", "#modal_select_gl_btn", function (event) {
                const $row = $(this).closest('tr');
                gl_id = $row.find('#hidden_gl_id').val();
                // let is_mapped = $(this).siblings('#hidden_already_mapped').val();
                effect_date_new=$('#new_effect_date').val();

                currency_id = $('#currency_name').val();
                console.log("GL: " + gl_id);
                console.log("Currency: " + currency_id);
                console.log("TranType: " + tran_type_id);
                console.log("Currency_Master: " + currency_master_id);
                console.log("user_id: " + user_id);
                console.log("Effect Date: " + effect_date);
                console.log("Effect Date New: " + effect_date_new);
                console.log("Already Mapped: " + already_mapped);

                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "api/currency-map-gl",
                        data: {
                            "currency_id": currency_id,
                            "gl_id": gl_id,
                            "tran_type_id": tran_type_id,
                            "currency_master_id": currency_master_id,
                            "effect_date_new": effect_date_new,
                            "effect_date":effect_date,
                            "user_id": user_id,
                            "already_mapped": already_mapped
                        },
                        success: function (data) {
                            console.log("Return from server");
                            console.log(data);
                            if (data['success']) {
                                console.log(data);
                                alert(data['message']);
                                location.reload();
                            } else {
                                var message = "";
                                $.each(data['message'], function (index, value) {
                                    console.log(value);
                                    message = message + "\n" + value;
                                });
                                    alert(message);
                            }
                        },
                        error: function (error) {
                            console.log(error)
                        }
                    });
            });

            $("#currency_name").select2({
                ajax: {
                    theme: "classic",
                    url: "/api/currency",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                },
                minimumInputLength: 1,
            });


            $('#gl_name_query').on('keypress', function () {
                console.log("Changed");
                $('#modal_rows').remove();

                $.get('/api/gls?q=' + $('#gl_name_query').val(), function (data, status) {
                    $('#modal_rows').remove();
                    console.log(data);
                    $('#gl_code').val(data['GlCode']);
                    if (data != "") {
                        $('#modal_rows').remove();
                        $.each(data, function (index, value) {
                            $('#modal_tbody').append(`<tr id="modal_rows">
                                    <td>${value['GlCode']}</td>
                                    <td>${value['GlName']}</td>
                                       <td class="text-center">
                                      <input type="hidden" id="hidden_gl_id" name="hidden_gl_id" value="${value['id']}">
                                        <button id="modal_select_gl_btn" class="btn-sm xs btn-info"
                                                 type="button">Select</button>
                                                  </td>
           </tr>`);
                        });
                    } else {
                        $('#modal_rows').remove();

                        $('#modal_tbody').append(`<tr id="modal_rows">
                                    <td colspan="3">No Gl Found</td>

           </tr>`);
                    }
                });
            });

            $('#currency_name').on('select2:select', function (e) {
                // let currency;
                // console.log($('#currency_name').val());
                $.get('/api/currency/' + $('#currency_name').val(), function (data, status) {
                    console.log(data);
                    $('#currency_code').val(data['Code']);
                });
            });

            $('#gl_name').on('select2:select', function (e) {
                let currency;
                console.log("Test this");
                $.get('/api/gls/' + $('#gl_name').val(), function (data, status) {
                    console.log(data);
                    $('#gl_code').val(data['GlCode']);
                });
            });


            $('#currency_code').change(function () {
                $('#modal_rows').remove();
                $.get('/api/currency-gl-from-code/' + $('#currency_code').val(), function (data, status) {
                    console.log(data);
                    if (data != []) {
                        console.log(data);
                        if ($('#currency_name').find("option[value='" + data.id + "']").length) {
                            $('#currency_name').val(data.id).trigger('change');
                        } else {
                            // Create a DOM Option and pre-select by default
                            var newOption = new Option(data.Name, data.id, true, true);
                            // Append it to the select
                            $('#currency_name').append(newOption).trigger('change');
                        }
                    } else {
                        alert("Sorry! Currency Code does not exist");
                    }
                });
            });

            $('#gl_code').change(function () {
                $.get('/api/gl-from-gl-code/' + $('#gl_code').val(), function (data, status) {
                    // console.log(data);
                    if (data !== "") {
                        // console.log(data);
                        $('#gl_name_query').val(data['GlName']);
                        $('#modal_tbody').append(`<tr id="modal_rows">
                                    <td>${data['GlCode']}</td>
                                    <td>${data['GlName']}</td>
                                       <td class="text-center">
                                      <input type="hidden" id="hidden_gl_id" value="${data['id']}">
                                        <button id="modal_select_btn" class="btn-sm text-sm btn-info"
                                                 type="button">Select</button>
                                                  </td>
           </tr>`);
                    } else {
                        alert("Sorry! Gl Code does not exist.");
                    }
                });
            });

            $('#ul-effect-date li').click(function () {
                var date = new Date($(this).text().replace(/(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"))
                $('#calendar-effect-date').val(formatDate(date));
                $('#calendar-effect-date').focus();
            });

            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2)
                    month = '0' + month;
                if (day.length < 2)
                    day = '0' + day;

                return [year, month, day].join('-');
            }

        });
    </script>
@endsection

