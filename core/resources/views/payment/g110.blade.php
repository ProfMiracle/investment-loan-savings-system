@extends(activeTemplate().'layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Payment Preview</div>
                <div class="card-body">

                    <form action="{{$data->url}}" method="{{$data->method}}">
                        <script src="{{$data->checkout_js}}"
                                @foreach($data->val as $key=>$value)
                                data-{{$key}}="{{$value}}"
                                @endforeach >

                        </script>

                        <input type="hidden" custom="{{$data->custom}}" name="hidden">

                        </form>


                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

@stop
