@extends('admin.layouts.app')

@section('panel')
<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('admin.frontend.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="key" value="rules">
                <div class="card-body">

                    <div class="row">

                        <div class="col-md-12">

                            <div class="form-group">
                                <label>Rules Content</label>
                                <textarea rows="10" class="form-control nicEdit" placeholder="Rules description" name="body">{{old('body')}}</textarea>
                            </div>
                        </div>
                    </div>

                   
                </div>
                <div class="card-footer">
                    <div class="form-row justify-content-center">
                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-lg btn-block btn-primary mr-2">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
