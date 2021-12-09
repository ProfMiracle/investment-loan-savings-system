@extends('admin.layouts.app')

@push('style-lib')
    <link href="{{ asset('assets/admin/css/bootstrap-fileinput.css') }}" rel="stylesheet">
@endpush
@push('script')
    <script src="{{ asset('assets/admin/js/bootstrap-fileinput.js') }}"></script>
@endpush
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <form action="{{ route('admin.frontend.homeContent.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title </label>
                                    <input type="text" class="form-control " placeholder="Write Title" name="title" value="{{@$post->value->title }}" />
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Details </label>
                                    <textarea name="details" class="form-control nicEdit" placeholder="Write content" cols="30" rows="10">{{ @$post->value->details }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label>Image </label><br>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                        <img style="width: 200px" src="{{asset('assets/images/frontend/'.@$post->value->image)}}" alt="...">

                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" accept="image/*" >
                                                </span>
                                        <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                    <div class="error">{{ $errors->first('image') }}</div>
                                @endif

                            </div>

                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label>Featured Investment Title </label>
                                            <input type="text" class="form-control " placeholder="Write Title" name="featured_title" value="{{@$post->value->featured_title }}" />
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label >User Can See Featured</label>
                                            <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="can_see_featured" @if(@$post->value->can_see_featured) checked @endif>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-8">
                                        <label>Site  Information Title </label>
                                        <input type="text" class="form-control " placeholder="Write Title" name="site_information" value="{{@$post->value->site_information }}" />
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label >Can See Information</label>
                                        <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="can_see_info" @if(@$post->value->can_see_info) checked @endif>
                                    </div>

                                </div>
                            </div>


                            <div class="col-md-4">
                                <label>Statics Image </label><br>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                        <img style="width: 200px;filter: contrast(200%) !important;background: #bcbbbd;" src="{{asset('assets/images/frontend/'.@$post->value->dragon)}}" alt="..." >

                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="dragon" accept="image/*" >
                                                </span>
                                        <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                </div>
                                @if ($errors->has('dragon'))
                                    <div class="error">{{ $errors->first('dragon') }}</div>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                        <div class="form-group col-md-8">
                                            <label>Transaction Title </label>
                                            <input type="text" class="form-control " placeholder="Write Title" name="transaction_title" value="{{@$post->value->transaction_title }}" />
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label >Can See Transaction</label>
                                            <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="can_see_trx" @if(@$post->value->can_see_trx) checked @endif>
                                        </div>
                                </div>

                            </div>



                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group ">
                                            <label>Map Image </label><br>
                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;" data-trigger="fileinput">
                                                    <img style="width: 200px;filter: contrast(200%) !important;background: #bcbbbd;" src="{{asset('assets/images/frontend/'.@$post->value->map)}}" alt="..." >

                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px"></div>
                                                <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="map" accept="image/*" >
                                                </span>
                                                    <a href="#" class="btn btn-danger fileinput-exists bold uppercase" data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                                </div>
                                            </div>
                                            @if ($errors->has('map'))
                                                <div class="error">{{ $errors->first('map') }}</div>
                                            @endif

                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group ">
                                            <label >Can See Map</label>
                                            <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="can_see_map" @if(@$post->value->can_see_map) checked @endif>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-4">
                                        <label >Can See We Accept</label>
                                        <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="we_accept" @if(@$post->value->we_accept) checked @endif>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label >Can See Subscription Form</label>
                                        <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="subscription_form" @if(@$post->value->subscription_form) checked @endif>
                                    </div>

                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-row justify-content-center">
                            <div class="form-group col-md-12">
                                <button type="submit" class="btn btn-block btn-primary mr-2">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
