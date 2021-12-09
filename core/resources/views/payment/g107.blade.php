@extends(activeTemplate().'layouts.master')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card">

                <div class="card-header">Payment Preview</div>


                <div class="card-body">





                <button type="button" class="btn btn-success" id="btn-confirm">Pay Now</button>
                    <form action="{{ route('ipn.g107') }}" method="POST">
                        @csrf
                        <script
                            src="//js.paystack.co/v1/inline.js"
                            data-key="{{ $data->key }}"
                            data-email="{{ $data->email }}"
                            data-amount="{{$data->amount}}"
                            data-currency="{{$data->currency}}"
                            data-ref="{{ $data->ref }}"
                            data-custom-button="btn-confirm"
                        >
                        </script>
                    </form>



                </div>


            </div>



        </div>
    </div>
@endsection

