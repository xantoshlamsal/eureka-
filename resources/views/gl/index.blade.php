@extends('dashboard')
@section('content')


    <div class="continer p-6">

        <div class="card">
            <div class="card-header">
                Create new GL
            </div>
            <div class="card-body">
                <form action="{{url('gl')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="form-group input-group-sm col-sm-3">
                            <label>GL Code</label>
                            <input type="number" class="form-control input-sm" name="GlCode"
                                   value="{{old('GlCode')}}" min="1" maxlength="99999" required>
                        </div>
                        <div class="form-group input-group-sm col-sm-7">
                            <label>Gl Name</label>
                            <input type="text" class="form-control input-sm" placeholder="GL Name" name="GlName"
                                   value="{{old('GlName')}}" required>
                        </div>
                        <div class="form-group input-group-sm col-sm-2">
                            <br>
                            <button type="submit" class="btn-sm btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-6">
            <dic class="card-header">
                List of Available GL
            </dic>
            <div class="card-body">
                <table class="table table-xs table-stripped text-sm">
                    <thead>
                    <tr>
                        <th>SN</th>
                        <th>GLName</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Last Status Changed By</th>
                        <th>Created At</th>
                        <th>Last Update At</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($gls as $gl)
                        <tr>
                            <td>{{$gl->id}}</td>
                            <td>{{$gl->GlName}}</td>
                            <td>{{$gl->StatusTerm}}</td>
                            <td>{{$gl->TranUser}}</td>
                            <td>{{$gl->StatusChangeUser}}</td>
                            <td>{{$gl->TranDate}}</td>
                            <td>{{$gl->StatusChangeDate}}</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>

    </div>
@endsection
