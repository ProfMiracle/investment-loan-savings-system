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
                <form action="{{ route('admin.frontend.homeContent.update', $post->id) }}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">

                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Title </label>
                                    <input type="text" class="form-control " placeholder="Write Title" name="title"
                                           value="{{@$post->value->title }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-4">


                            <div class="col-md-4">
                                <label>Image </label><br>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
                                         data-trigger="fileinput">
                                        <img style="width: 200px"
                                             src="{{asset('assets/images/frontend/'.@$post->value->image)}}" alt="...">

                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i
                                                            class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i
                                                            class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="image" accept="image/*">
                                                </span>
                                        <a href="#" class="btn btn-danger fileinput-exists bold uppercase"
                                           data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                </div>
                                @if ($errors->has('image'))
                                    <div class="error">{{ $errors->first('image') }}</div>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <label>Coin Image </label><br>
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"
                                         data-trigger="fileinput">
                                        <img style="width: 200px"
                                             src="{{asset('assets/images/frontend/'.@$post->value->coin_image)}}" alt="...">

                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail"
                                         style="max-width: 200px; max-height: 150px"></div>
                                    <div>
                                                <span class="btn btn-info btn-file">
                                                    <span class="fileinput-new bold uppercase"><i
                                                            class="fa fa-file-image-o"></i> Select image</span>
                                                    <span class="fileinput-exists bold uppercase"><i
                                                            class="fa fa-edit"></i> Change</span>
                                                    <input type="file" name="coin_image" accept="image/*">
                                                </span>
                                        <a href="#" class="btn btn-danger fileinput-exists bold uppercase"
                                           data-dismiss="fileinput"><i class="fa fa-trash"></i> Remove</a>
                                    </div>
                                </div>
                                @if ($errors->has('coin_image'))
                                    <div class="error">{{ $errors->first('coin_image') }}</div>
                                @endif
                            </div>
                        </div>



                        <div class="form-row mt-4">

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Plan  Title </label>
                                    <input type="text" class="form-control " placeholder="Write Title"
                                           name="plan_title" value="{{@$post->value->plan_title }}"/>
                                </div>
                                <div class="form-group">
                                    <label>Plan  Sub Title </label>
                                    <input type="text" class="form-control " placeholder="Write Title"
                                           name="plan_sub_title" value="{{@$post->value->plan_sub_title }}"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Invest Title </label>
                                    <input type="text" class="form-control " placeholder="Write Title"
                                           name="invest_title" value="{{@$post->value->invest_title }}"/>
                                </div>
                                <div class="form-group">
                                    <label>Invest Sub Title </label>
                                    <input type="text" class="form-control " placeholder="Write Title"
                                           name="invest_sub_title" value="{{@$post->value->invest_sub_title }}"/>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Profit Calculator Title </label>
                                    <input type="text" class="form-control " placeholder="Write Title"
                                           name="profit_title" value="{{@$post->value->profit_title }}"/>
                                </div>
                                <div class="form-group">
                                    <label>Profit Calculator  Sub Title </label>
                                    <input type="text" class="form-control " placeholder="Write Title"
                                           name="profit_sub_title" value="{{@$post->value->profit_sub_title }}"/>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Latest Transaction  Title </label>
                                    <input type="text" class="form-control " placeholder="Write Title"
                                           name="trx_title" value="{{@$post->value->trx_title }}"/>
                                </div>
                                <div class="form-group">
                                    <label>Latest Transaction   Sub Title </label>
                                    <input type="text" class="form-control " placeholder="Write Title"
                                           name="trx_sub_title" value="{{@$post->value->trx_sub_title }}"/>
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
