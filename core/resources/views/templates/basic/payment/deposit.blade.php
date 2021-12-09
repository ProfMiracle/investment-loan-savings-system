@extends(activeTemplate().'layouts.master')

@section('content')

    <div class="row">
        <div class="col-md-12">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif

            @if(session()->has('danger'))
                <div class="alert alert-danger">
                    {{ session()->get('danger') }}
                </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div>{{$error}}</div>
                @endforeach
            @endif

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Deposit Limit</th>
                    <th scope="col">Charge (Fix + Percent)</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>

                @foreach($gatewayCurrency as $data)
                <tr>
                    <td>{{$data->name}} </td>
                    <td><strong class="text-danger"> {{formatter_money($data->min_amount, $data->method->crypto())}} - {{formatter_money($data->max_amount, $data->method->crypto())}}</strong> <strong>{{$data->baseSymbol()}}</strong></td>

                    <td><strong class="text-danger"> {{formatter_money($data->fixed_charge, $data->method->crypto())}}</strong> <strong>{{$data->baseSymbol()}}    + {{formatter_money($data->percent_charge, $data->method->crypto())}} %</strong></td>

                    <td>
                        <a href="#" data-id="{{$data->id}}" data-currency="{{$data->currency}}" data-method_code="{{$data->method_code}}" class="btn btn-primary deposit" data-toggle="modal" data-target="#exampleModal">
                            Deposit Now
                        </a>

                    </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>




    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('user.deposit.insert')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="currency" class="edit-currency" value="">
                        <input type="hidden" name="method_code" class="edit-method-code" value="">
                        <div class="form-group">
                            <label>Amount</label>
                            <input type="text" class="form-control" name="amount" value="{{old('amount')}}">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Confirm</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop


@section('js')
    <script>

        $(document).ready(function(){
            $('.deposit').on('click', function () {
                var id = $(this).data('id');
                var currency = $(this).data('currency');
                var method_code = $(this).data('method_code');


                $('.edit-currency').val(currency);
                $('.edit-method-code').val(method_code);
            })
        });
    </script>

@stop
