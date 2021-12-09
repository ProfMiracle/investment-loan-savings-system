@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <div class="col-lg-12">
            <div class="card">

                <div class="table-responsive table-responsive-xl">
                    <table class="table align-items-center table-light">
                        <thead>
                        <tr>
                            <th scope="col">Request Date</th>
                            <th scope="col">Loan Code</th>
                            <th scope="col">Username</th>
                            <th scope="col">Duration</th>
                            <th scope="col">Amount Requested</th>
                            <th scope="col">Amount Approved</th>
                            <th scope="col">Payback Amount</th>
                            <th scope="col">Payback Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse( $loans as $loan )
                            {{--@if(!$loan->gateway) @endif--}}
                            <tr>
                                <td>{{ show_datetime($loan->request_date) }}</td>
                                <td class="font-weight-bold text-uppercase">{{ $loan->loan_id }}</td>
                                <td>{{\Illuminate\Support\Facades\Auth::user($loan->user_id)->username
                                    }}</td>
                                @if($loan->request_duration > 21)
                                    @if($loan->request_duration == 28)
                                        <td>{{ 'One month' }}</td>
                                    @elseif($loan->request_duration == 56)
                                        <td>{{ 'Two months' }}</td>
                                    @elseif($loan->request_duration == 84)
                                        <td>{{ 'Three months' }}</td>
                                    @elseif($loan->request_duration == 112)
                                        <td>{{ 'Four months' }}</td>
                                    @elseif($loan->request_duration == 140)
                                        <td>{{ 'Five months' }}</td>
                                    @elseif($loan->request_duration == 168)
                                        <td>{{ 'Six months' }}</td>
                                    @endif
                                @else
                                    <td>{{ $loan->request_duration.' Days' }}</td>
                                @endif
                                <td class="text-primary">NGN {{ formatter_money($loan->request_amount) }}</td>
                                <td class="text-primary">NGN {{ formatter_money($loan->approved_amount) }}</td>
                                <td class="text-primary">NGN {{ formatter_money($loan->payback_amount) }}</td>
                                <td>{{ show_datetime($loan->payback_date) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                {{--<div class="card-footer py-4">
                    <nav aria-label="...">
                        {{ $loans->links() }}
                    </nav>
                </div>--}}
            </div>
        </div>
    </div>


    {{-- APPROVE MODAL --}}
    <div id="approveModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve Deposit Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.deposit.approve') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>Are you sure to <span class="font-weight-bold">approve</span> <span class="font-weight-bold withdraw-amount text-success"></span> deposit of <span class="font-weight-bold withdraw-user"></span>?</p>
                        <p class="withdraw-detail"></p>

                        <span class="withdraw-proveImg"></span>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Approve</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- REJECT MODAL --}}
    <div id="rejectModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Deposit Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.deposit.reject') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal-body">
                        <p>Are you sure to <span class="font-weight-bold">reject</span> <span class="font-weight-bold withdraw-amount text-success"></span> deposit of <span class="font-weight-bold withdraw-user"></span>?</p>

                        <p class="withdraw-detail"></p>
                        <span class="withdraw-proveImg"></span>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Reject</button>
                        <button type="button" class="btn btn-dark" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $('.approveBtn').on('click', function() {
            var modal = $('#approveModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-user').text($(this).data('username'));

            modal.find('.withdraw-proveImg').html($(this).data('prove_img'));

            var details =  Object.entries($(this).data('detail'));
            var list = [];
            details.map( function(item,i) {
                list[i] = ` <li class="list-group-item">${item[0]} : ${item[1]}</li>`
            });
            modal.find('.withdraw-detail').html(list);

            modal.modal('show');
        });

        $('.rejectBtn').on('click', function() {
            var modal = $('#rejectModal');
            modal.find('input[name=id]').val($(this).data('id'));
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-user').text($(this).data('username'));
            modal.find('.withdraw-proveImg').html($(this).data('prove_img'));

            var details =  Object.entries($(this).data('detail'));
            var list = [];
            details.map( function(item,i) {
                list[i] = ` <li class="list-group-item">${item[0]} : ${item[1]}</li>`
            });
            modal.find('.withdraw-detail').html(list);


            modal.modal('show');
        });
    </script>
@endpush

@push('breadcrumb-plugins')
    @if(request()->routeIs('admin.users.deposits'))
        <form action="" method="GET" class="form-inline">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="Deposit code" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @else
        <form action="{{ route('admin.deposit.search', $scope ?? str_replace('admin.deposit.', '', request()->route()->getName())) }}" method="GET" class="form-inline">
            <div class="input-group has_append">
                <input type="text" name="search" class="form-control" placeholder="Deposit code/Username" value="{{ $search ?? '' }}">
                <div class="input-group-append">
                    <button class="btn btn-success" type="submit"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    @endif
@endpush
