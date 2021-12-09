@extends('admin.layouts.app')

@section('panel')



    <div class="row">

        @foreach($interest as $data)
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">

                                <ul class="list-group">
                                    <li class="list-group-item" style="font-weight: bold">Name: {{$data->name}}</li>
                                    <li class="list-group-item">Time:  {{$data->days}} Days</li>
                                </ul>

                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <a href="#editModal{{$data->id}}" data-toggle="modal" class="btn btn-primary btn-block">Edit</a>
                            </div>

                            <div class="col-6">
                                <a href="#delModal{{$data->id}}" data-toggle="modal" class="btn btn-danger btn-block">Delete</a>
                            </div>

                        </div>
                    </div>
                </div>

            </div>

            <div id="delModal{{$data->id}}" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Confirm Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form role="form" action="" method="post">
                            @csrf
                            <div class="modal-body">
                                <strong class="text-dark">Are you sure to delete this?</strong>
                            </div>
                            <input type="hidden" name="id" value="{{$data->id}}">
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <input type="submit" name="delete" class="btn btn-danger" value="Delete">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="editModal{{$data->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="myModalLabel"> Edit Time</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                        </div>
                        <form id="frmProducts" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="form-group">
                                    <strong>Time Name: </strong>
                                    <input type="text" class="form-control" value="{{$data->name}}"  name="name"  required>
                                </div>
                                <input type="hidden" name="id" value="{{$data->id}}">
                                <div class="form-group">
                                    <strong>Time in Days</strong>
                                    <div class="input-group">
                                        <input type="number" class="form-control"  name="time" value="{{$data->days}}"  required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Days</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <strong>Interest: </strong>
                                    <div class="input-group">
                                        <input type="number" class="form-control" value="{{$data->interest}}"  name="interest"  required>
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">%</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                                <input type="submit" name="update" class="btn btn-primary bold uppercase" value="Update">
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        @endforeach

    </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel"> Add New Interest</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                </div>
                <form id="frmProducts" method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <strong>Time Name: </strong>
                            <input type="text" class="form-control"  name="name"  required>
                        </div>

                        <div class="form-group">
                            <strong>Time in Days</strong>
                            <div class="input-group">
                                <input type="number" class="form-control"  name="time"  required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Days</div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <strong>Interest: </strong>
                            <div class="input-group">
                                <input type="number" class="form-control" value=""  name="interest"  required>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">%</div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                        <input type="submit" name="save" class="btn btn-primary bold uppercase" value="Save">
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection

@push('breadcrumb-plugins')
    <button type="button" data-target="#myModal" data-toggle="modal" class="btn btn-success"><i class="fa fa-fw fa-plus"></i>Add New</button>
@endpush
