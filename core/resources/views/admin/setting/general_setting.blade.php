@extends('admin.layouts.app')

@section('panel')
<div class="row">

    <div class="col-lg-12">
        <div class="card">
            <form action="{{ route('admin.setting.update') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <label>Site Title</label>
                            <input type="text" class="form-control" placeholder="Your Company Title" name="sitename" value="{{ $general_setting->sitename }}" />
                        </div>
                        <div class="form-group col-md-4">
                            <label>Currency</label>
                            <input type="text" class="form-control" placeholder="Your Transaction Currency" name="cur_text" value="{{ $general_setting->cur_text }}" />
                        </div>
                        <div class="form-group col-md-4">
                            <label>Currency Symbol</label>
                            <input type="text" class="form-control" placeholder="Your Currency Symbol" name="cur_sym" value="{{ $general_setting->cur_sym }}" />
                        </div>
                        <div class="form-group col">
                            <label>Email Verification</label>
                            <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="ev" @if($general_setting->ev) checked @endif>
                        </div>
                        <div class="form-group col">
                            <label>Email Notification</label>
                            <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="en" @if($general_setting->en) checked @endif>
                        </div>
                        <div class="form-group col">
                            <label>SMS Verification</label>
                            <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="sv" @if($general_setting->sv) checked @endif>
                        </div>
                        <div class="form-group col">
                            <label>SMS Notification</label>
                            <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disable" name="sn" @if($general_setting->sn) checked @endif>
                        </div>

                    </div>

                    <div class="form-row">
                        <div class="form-group col">
                            <label>User Registration</label>
                            <input type="checkbox" data-width="100%" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Enable" data-off="Disabled" name="reg" @if($general_setting->reg) checked @endif>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Active Template</label>
                            <select name="active_template" class="form-control select2">
                                <option value="basic" @if($general_setting->active_template == 'basic') selected @endif>Basic</option>
                                <option value="minimul" @if($general_setting->active_template == 'minimul') selected @endif>Minimul</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label>Alert UI</label>
                            <select name="alert" class="form-control select2">
                                <option value="0" @if($general_setting->alert == 0) selected @endif>No Alert</option>
                                <option value="1" @if($general_setting->alert == 1) selected @endif>iziTOAST</option>
                                <option value="2" @if($general_setting->alert == 2) selected @endif>Toaster</option>
                            </select>
                        </div>

                        <div class="form-group col-md-3">
                            <label>Site Base Color</label>
                            <div class="input-group">
                                <span class="input-group-addon ">
                                    <input type='text' class="form-control colorPicker" value="{{$general_setting->bclr}}"/>
                                </span>
                                <input type="text" class="form-control colorCode" name="bclr" value="{{ $general_setting->bclr }}" />
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <div class="form-row">
                        <div class="form-group col-md-12 text-center">
                            <button type="submit" class="btn btn-block btn-primary mr-2">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script-lib')
<script src="{{ asset('assets/admin/js/spectrum.js') }}"></script>
@endpush

@push('style')
<style>
.sp-replacer {
    padding: 0;
    border: 1px solid rgba(0,0,0,.125);
    border-radius: 5px 0 0 5px;
    border-right: none;
}
.sp-preview {
    width: 100px;
    height: 44px;
    border: 0;
}

.sp-preview-inner {
    width: 110px;
}

.sp-dd{
    display: none;
}

.input-group > .form-control:not(:first-child) {
    border-top-left-radius: 0 !important;
    border-bottom-left-radius: 0 !important;
}
</style>
@endpush

@push('style-lib')
<link rel="stylesheet" href="{{ asset('assets/admin/css/spectrum.css') }}">
@endpush

@push('script')
<script>
    $('.colorPicker').spectrum({
        color: $(this).data('color'),
        change: function (color) {
            $(this).parent().siblings('.colorCode').val(color.toHexString().replace(/^#?/, ''));
        }
    });

    $('.colorCode').on('input', function() {
        var clr = $(this).val();
        $(this).parents('.input-group').find('.colorPicker').spectrum({
            color: clr,
        });
    });
</script>
@endpush
