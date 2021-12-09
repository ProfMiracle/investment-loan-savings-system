@extends('admin.layouts.app')

@section('panel')
    <div class="row">

        <?php
        function user($user_id)
        {
            return \Illuminate\Support\Facades\DB::select("SELECT * FROM users WHERE id = ?", [$user_id])[0];
        }
        ?>
        <div class="col-lg-12">
            <div class="card">

                <div class="table-responsive table-responsive-xl">
                    <table class="table align-items-center table-light">
                        <thead>
                        @if($type === 'autosave')
                            <tr>
                            <th scope="col">Username</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">End Date</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Debit Frequency</th>
                            <th scope="col">Debit Time</th>
                            <th scope="col">Action</th>
                        </tr>
                        @endif
                        @if($type === 'vaultsave')
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Amount</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Action</th>
                            </tr>
                        @endif
                        @if($type === 'targetsave')
                            <tr>
                                <th scope="col">Username</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Target</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Debit Frequency</th>
                                <th scope="col">Debit Time</th>
                                <th scope="col">Action</th>
                            </tr>
                        @endif
                        </thead>
                        <tbody>
                        @if($type === 'autosave')
                            @forelse( $savings as $saving )
                                <tr>
                                    <td>{{ user($saving->user_id)->username }}</td>
                                    <td>{{ $saving->start }}</td>
                                    <td>{{ $saving->end }}</td>
                                    <td class="text-primary">NGN{{ formatter_money($saving->amount) }}</td>
                                    <td>{{ $saving->how }}</td>
                                    <td>{{ $saving->when }}</td>
                                    <td>
                                        {{--<button class="btn btn-success approveBtn" data-detail="{{$loan->request_reason}}" data-id="{{ $loan->loan_id }}" data-amount="NGN {{ formatter_money($loan->request_amount)}}" data-username="{{ user($loan->user_id)->username }}" data-amount-noformat="{{$loan->request_amount}}"><i class="fa fa-fw fa-check"></i></button>--}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                                </tr>
                            @endforelse
                        @endif
                        @if($type === 'vaultsave')
                            @forelse( $savings as $saving )
                                {{--@if(!$loan->gateway) @endif--}}
                                <tr>
                                    <td>{{ user($saving->user_id)->username }}</td>
                                    <td class="text-primary">NGN{{ formatter_money($saving->amount) }}</td>
                                    <td>{{ $saving->end }}</td>
                                    <td>
                                        {{--<button class="btn btn-success approveBtn" data-detail="{{$loan->request_reason}}" data-id="{{ $loan->loan_id }}" data-amount="NGN {{ formatter_money($loan->request_amount)}}" data-username="{{ user($loan->user_id)->username }}" data-amount-noformat="{{$loan->request_amount}}"><i class="fa fa-fw fa-check"></i></button>--}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                                </tr>
                            @endforelse
                        @endif
                        @if($type === 'targetsave')
                            @forelse( $savings as $saving )
                                <tr>
                                    <td>{{ user($saving->user_id)->username }}</td>
                                    <td>{{ $saving->start }}</td>
                                    <td>{{ $saving->end }}</td>
                                    <td class="text-primary">NGN{{ formatter_money($saving->target) }}</td>
                                    <td class="text-primary">NGN{{ formatter_money($saving->amount) }}</td>
                                    <td>{{ $saving->how }}</td>
                                    <td>{{ $saving->when }}</td>
                                    <td>
                                        {{--<button class="btn btn-success approveBtn" data-detail="{{$loan->request_reason}}" data-id="{{ $loan->loan_id }}" data-amount="NGN {{ formatter_money($loan->request_amount)}}" data-username="{{ user($loan->user_id)->username }}" data-amount-noformat="{{$loan->request_amount}}"><i class="fa fa-fw fa-check"></i></button>--}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-muted text-center" colspan="100%">{{ $empty_message }}</td>
                                </tr>
                            @endforelse
                        @endif
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
                <form action="" method="POST">
                    @csrf
                    <input type="hidden" name="loan_id">
                    <div class="modal-body">
                        <p>Are you sure to <span class="font-weight-bold">approve</span> <span class="font-weight-bold withdraw-amount text-success"></span> loan request of <span class="font-weight-bold withdraw-user"></span>?</p>
                        <p class="withdraw-detail"></p>
                        <div class="form-group">
                            <input type="number" name="approved_amount" value="" class="form-control form-control-sm" id="approved_amount">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn btn-primary" name="approved" value="Approved">
                        <input type="submit" class="btn btn-primary" name="reject" value="Reject">
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
            modal.find('input[name=loan_id]').val($(this).data('id'));
            modal.find('input[name=approved_amount]').val($(this).data('amount-noformat'));
            modal.find('.withdraw-amount').text($(this).data('amount'));
            modal.find('.withdraw-user').text($(this).data('username'));

            var details =  Object.entries($(this).data('detail'));

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
