@extends('admin.layouts.app')

@section('panel')


    <div class="row">

        @foreach($plan as $data)
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-header">
                        <h3>{{$data->name}}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <ul class="list-group">
                                    @if($data->fixed_amount == 0)
                                        <li class="list-group-item"><p>Invest Min-Max Amount:
                                                <strong> {{$general->cur_sym}} {{$data->minimum}}
                                                    - {{$general->cur_sym}} {{$data->maximum}}</strong></p></li>
                                    @else
                                        <li class="list-group-item"><p>Fixed Invest Amount:
                                                <strong> {{$general->cur_sym}} {{$data->maximum}}</strong></p></li>
                                    @endif

                                    <li class="list-group-item"><p>Interest :
                                            <strong>{{$data->interest}} @if($data->interest_status == 1)
                                                    % @else {{$general->cur_text}} @endif</strong></p></li>
                                    <li class="list-group-item">Repeat will every {{$data->times}} Hours
                                        After @if($data->lifetime_status == 0) {{$data->repeat_time}} Times @endif</li>

                                    <li class="list-group-item"><p> Capital Back: @if($data->capital_back_status == 1)
                                                <span
                                                    class="badge badge-success">Yes</span> @elseif($data->capital_back_status == 0)
                                                <span class="badge badge-danger">No</span>@endif</p></li>
                                    <li class="list-group-item"><p>Life Time Status: @if($data->lifetime_status == 1)
                                                <span
                                                    class="badge badge-success">Active</span> @elseif($data->lifetime_status == 0)
                                                <span class="badge badge-danger">Inactive</span>@endif</p></li>
                                    <li class="list-group-item"><p>Status: @if($data->status == 1) <span
                                                class="badge badge-success">Active</span> @elseif($data->status == 0)
                                                <span class="badge badge-danger">Disable</span>@endif </p></li>
                                    <li class="list-group-item"><p>Featured: @if($data->featured == 1) <span
                                                class="badge badge-success">Yes</span> @else <span
                                                class="badge badge-danger">No</span>@endif </p></li>
                                </ul>
                            </div>
                        </div>

                        <br>
                        <div class="row">
                            <div class="col-12">
                                <a href="{{route('admin.plan-edit',$data->id)}}"
                                   class="btn btn-primary btn-block">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach

        <div class="col-md-12">
            <div class="card">
                <div class="card-footer py-4">
                    <nav aria-label="...">
                        {{ $plan->links() }}
                    </nav>
                </div>
            </div>

        </div>

    </div>

@endsection

@push('breadcrumb-plugins')

    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal"><i class="fa fa-fw fa-plus"></i>Add New</a>
    <!-- The Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content" style="background-color: transparent">

                <div class="modal-body" >
                    <div class="row">
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-header">
                                    <h3 style="color: black">Investment plan</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{route('admin.plan-create')}}"
                                               class="btn btn-primary btn-block">Go</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col">
                            <div class="card text-center">
                                <div class="card-header">
                                    <h3 style="color: black">Auto-savings plan</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">

                                        </div>
                                    </div>

                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{route('admin.plan-create-saver')}}"
                                               class="btn btn-primary btn-block">Go</a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endpush
