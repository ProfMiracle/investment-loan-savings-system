@extends('admin.layouts.app')

@section('panel')


    <div class="row">
        <div class="col-md-12">
            <div class="card">


                <div class="card-body">

                    <form method="post" class="form-horizontal" action="{{route('admin.plan-store-saver')}}">
                        @csrf

                        <div class="form-body">

                            <div class="form-row">

                                <div class="form-group col-md-3">
                                    <strong>Return /Interest</strong>
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="interest" value="{{$plan->interest??''}}" required>
                                        <div class="input-group-append" style="height: 45px">
                                            <div class="input-group-text">
                                                <select name="interest_status" class="form-control" style="height: 35px !important;">
                                                    <option value="%">%</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group offman col-md-3">
                                    <strong>Minimum Amount</strong>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="minimum" value="{{$plan->min??''}}">
                                        <div class="input-group-append">
                                            <div class="input-group-text">{{$general->cur_sym}}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group offman col-md-3" >
                                    <strong>Maximum Amount</strong>
                                    <div class="input-group">
                                        <input type="text" class="form-control"  name="maximum" value="{{$plan->max??''}}">
                                        <div class="input-group-append">
                                            <div class="input-group-text">{{$general->cur_sym}}</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="form-row">
                                <div class="form-group col">
                                    <strong>Interval</strong>
                                    <select multiple class="form-control" name="interval[]" required>
                                        @foreach($time as $data)
                                            <option value="{{$data->time}}">{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col">
                                    <strong>Duration</strong>
                                    <select multiple class="form-control" name="duration[]" required>
                                        @foreach($time as $data)
                                            <option value="{{$data->time}}">{{$data->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-md-12">

                            <button type="submit" class="btn btn-primary btn-block">Update</button>

                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>


@endsection

@push('breadcrumb-plugins')
    <a href="{{route('admin.plan-setting')}}"  class="btn btn-success"><i class="fa fa-fw fa-eye"></i>Plan List</a>
@endpush

@push('script')
    <script>
        $(document).ready(function () {


            $('#amount').on('change', function () {
                var isCheck = $(this).prop('checked');
                if (isCheck == false)
                {
                    $('.offman').css('display', 'block');
                    $('.onman').css('display', 'none');
                }else {
                    $('.offman').css('display', 'none');
                    $('.onman').css('display', 'block');
                }
            });

            $('#lifetime').on('change', function () {
                var isCheck = $(this).prop('checked');
                if (isCheck == true)
                {
                    $('.return').css('display', 'block');

                }else {

                    $('.return').css('display', 'none');

                }
            });

        })
    </script>
@endpush
