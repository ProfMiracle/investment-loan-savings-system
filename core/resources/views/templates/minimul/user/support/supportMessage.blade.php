@extends(activeTemplate() .'layouts.user')

@section('style')
    <link rel="stylesheet" href="{{asset('assets/admin/css/simplemde.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/admin/css/ticket.css')}}">
    <style>
        .subscribe-block {
            display: none
        }

        .editor-statusbar {
            display: none;
        }

        .accordion .card::before {
            content: none !important;
            color: #fff;
            display: inline-block;
            box-shadow: none;
            background: transparent !important;
            font-size: 12px;
            position: absolute;
            width: 30px;
            height: 30px;
            border-radius: 100%;
            text-align: center;
            line-height: 30px;
            top: 15px;
            left: 10px;
        }

        .card-body {
            border-radius: 20px;
        }

    </style>
@stop
@section('content')

    @include(activeTemplate().'partials.breadcrumb')
    <!-- ========User-Panel-Section Starte Here ========-->
    <section class="user-panel-section padding-bottom padding-top">
        <div class="container user-panel-container">
            <div class=" user-panel-tab">
                <div class="row">
                    @include(activeTemplate().'partials.sidebar')

                    <div class="col-lg-9" id="myvideo">
                        <div class="user-panel-header mb-60-80">
                            <div class="left d-sm-block d-none">
                                <h6 class="title">{{__($page_title)}}</h6>
                            </div>
                            <ul class="right">
                                <li>
                                    <a href="#0" id="fullScreen"><i class="flaticon-ui-2"></i></a>
                                    <a href="#0" id="exitScreen"><i class="flaticon-ui-1"></i></a>
                                </li>

                                <li>
                                    <a href="{{route('user.ticket') }}" class="btn btn-custom float-right" data-toggle="tooltip" data-placement="top" title="@lang('My Support Ticket')">
                                        <i class="fa fa-eye"></i> @lang('See All')
                                    </a>
                                </li>
                                <li>
                                    <a href="#0" class="log-out d-lg-none">
                                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                                            <span class="navbar-toggler-icon"></span>

                                            <i class="fas fa-bars" style="color:#fff; font-size:28px;"></i>
                                        </button>
                                    </a>
                                </li>
                            </ul>
                        </div>


                        <div class="tab-area fullscreen-width">
                            <div class="tab-item active">
                                <div class="row mb-60-80">
                                    <div class="col-md-12 mb-30">


                                        <div class="card">


                                            <div class=" user-panel-header text-white">
                                                <div class="left">
                                                    <h6 class="title">@lang('Subject'): {{ $my_ticket->subject }}</h6>
                                                </div>


                                                <ul class="right">
                                                    <li>
                                                        @if($my_ticket->status == 0)
                                                            <span class="badge badge-primary "> @lang('Open') </span>
                                                        @elseif($my_ticket->status == 1)
                                                            <span class="badge badge-success "> @lang('Answered') </span>
                                                        @elseif($my_ticket->status == 2)
                                                            <span class="badge badge-info"> @lang('Customer Replied') </span>
                                                        @elseif($my_ticket->status == 3)
                                                            <span class="badge badge-danger "> @lang('Closed') </span>
                                                        @endif
                                                    </li>
                                                </ul>

                                            </div>

                                            <div class="card-body">


                                                <div class="accordion" id="accordionExample">

                                                    <div class="card">
                                                        <div class="card-header card-header-bg" id="headingThree">
                                                            <h2 class="my-1 ">
                                                                <a class="btn btn-link collapsed float-left "
                                                                   href="javascript:void(0)" data-toggle="collapse"
                                                                   data-target="#collapseThree" aria-expanded="false"
                                                                   aria-controls="collapseThree">
                                                                    <i class="fa fa-pencil"></i> @lang('Reply')
                                                                </a>


                                                                <a class="btn btn-link collapsed float-right accor"
                                                                   href="javascript:void(0)" data-toggle="collapse"
                                                                   data-target="#collapseThree" aria-expanded="false"
                                                                   aria-controls="collapseThree">
                                                                    <i class="fa fa-plus"></i>
                                                                </a>

                                                            </h2>
                                                        </div>
                                                        <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                                             data-parent="#accordionExample">

                                                            <div class="card-body">
                                                                @if($my_ticket->status != 4)
                                                                    <form method="post"
                                                                          action="{{ route('user.message.store', $my_ticket->id) }}"
                                                                          enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                            <textarea name="message"
                                                                                      class="form-control form-control-lg"
                                                                                      id="inputMessage"
                                                                                      placeholder="@lang('Your Reply') ..."
                                                                                      rows="4" cols="10"></textarea>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class=" col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="inputAttachments">@lang('Attachments')</label>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-9">
                                                                                        <div class="form-group">
                                                                                            <input type="file"
                                                                                                   name="attachments[]"
                                                                                                   id="inputAttachments"
                                                                                                   class="form-control"/>
                                                                                            <div
                                                                                                id="fileUploadsContainer"></div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-3">
                                                                                        <div class="form-group">
                                                                                            <a href="javascript:void(0)"
                                                                                               class="btn btn-danger btn-round"
                                                                                               onclick="extraTicketAttachment()">
                                                                                                <i class="fa fa-plus"></i> @lang('Add More')
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12 ">
                                                                                        <div
                                                                                            class="form-group ticket-attachments-message text-muted">
                                                                                            @lang("Allowed File Extensions: .jpg, .jpeg, .png, .pdf")
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="row">
                                                                                    <div class="col-md-3">
                                                                                        <button type="submit"
                                                                                                class="btn btn-success custom-success"
                                                                                                name="replayTicket" value="1">
                                                                                            <i class="fa fa-paper-plane"></i> @lang('Send')
                                                                                        </button>
                                                                                    </div>

                                                                                    <div class="col-md-3">
                                                                                        <button type="button"
                                                                                                class="btn btn-danger custom-danger delete_button"
                                                                                                data-toggle="modal"
                                                                                                data-target="#DelModal">
                                                                                            <i class="fa fa-times"></i> @lang('Close')
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                @endif

                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-12 product-service md-margin-bottom-30">
                                                        <ol class="commentlist noborder nomargin  clearfix">
                                                            @foreach($messages as $message)
                                                                @if($message->type == 1)
                                                                    <div class="row">
                                                                        <div class="col-md-10 offset-md-2">
                                                                            <li class="comment even thread-even depth-1"
                                                                                id="li-comment-1">
                                                                                <div id="comment-1"
                                                                                     class="comment-wrap clearfix">
                                                                                    <div class="comment-meta">
                                                                                        <div class="comment-author vcard">
                                                                <span class="comment-avatar clearfix">
                                                                    <img alt=""
                                                                         src="{{get_image(config('constants.user.profile.path') .'/'. Auth::user()->image) }}"
                                                                         class="avatar avatar-60 photo avatar-default"
                                                                         width="60" height="60"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="comment-content clearfix">
                                                                                        <div
                                                                                            class="comment-author">{{ $message->ticket->user->name }}
                                                                                            <span>{{ date('d F, Y - h:i A', strtotime($message->created_at)) }}</span>
                                                                                        </div>
                                                                                        <p>{{ $message->message }}</p>

                                                                                        @if($message->attachments()->count() > 0)
                                                                                            <div class="mt-2">
                                                                                                @foreach($message->attachments as $k=>$image)
                                                                                                    <a href="{{route('user.ticket.download',encrypt($image->id))}}"
                                                                                                       class="ml-4"><i
                                                                                                            class="fa fa-file-text-o"></i> {{++$k}} @lang('File Download')
                                                                                                    </a>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endif
                                                                                        <div class="row">
                                                                                            <div class="col-md-1">
                                                                                                <button data-id="{{$message->id}}"
                                                                                                        type="button"
                                                                                                        data-toggle="modal"
                                                                                                        data-target="#DelMessage"
                                                                                                        class="btn btn-danger btn-sm float-right mt-2 delete-message">
                                                                                                    <i class="fa fa-trash"></i></button>
                                                                                            </div>
                                                                                        </div>


                                                                                    </div>
                                                                                    <div class="clear"></div>
                                                                                </div>
                                                                            </li>
                                                                        </div>
                                                                    </div>
                                                                @elseif($message->type == 2)
                                                                    <div class="row">
                                                                        <div class="col-md-10">
                                                                            <li class="comment even thread-even depth-1"
                                                                                id="li-comment-1">
                                                                                <div id="comment-1"
                                                                                     class="comment-wrap clearfix">
                                                                                    <div class="comment-meta">
                                                                                        <div class="comment-author vcard">
                                                                <span class="comment-avatar clearfix">
                                                                    <img alt=""
                                                                         src="{{ get_image(config('constants.logoIcon.path') .'/logo.png') }}"
                                                                         class="avatar avatar-60 photo avatar-default"
                                                                         width="60" height="60"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="comment-content clearfix">
                                                                                        <div class="comment-author">
                                                                                            @lang('Admin')
                                                                                            <span>{{date('d F, Y - h:i A',strtotime($message->created_at)) }}</span>
                                                                                        </div>
                                                                                        <p>{{ $message->message }}</p>

                                                                                        @if($message->attachments()->count() > 0)
                                                                                            <div class="mt-2">
                                                                                                @foreach($message->attachments as $image)
                                                                                                    <a href="{{route('user.ticket.download',encrypt($image->id))}}"
                                                                                                       class="ml-4 btn btn-sm btn-success">
                                                                                                        <i class="fa fa-download"></i></a>
                                                                                                @endforeach
                                                                                            </div>
                                                                                        @endif
                                                                                    </div>
                                                                                    <div class="clear"></div>
                                                                                </div>
                                                                            </li>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        </ol>
                                                    </div>

                                                </div>


                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ========User-Panel-Section Ends Here ========-->



    <div class="modal fade" id="DelModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="post" action="{{ route('user.message.store', $my_ticket->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <strong class="modal-title"><i class='fa fa-exclamation-triangle'></i> @lang('Confirmation')!</strong>

                        <button type="button" class="close btn btn-sm" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <strong>@lang('Are you sure you want to Close This Support Ticket')?</strong>
                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-success btn-lg custom-btn-background" name="replayTicket"
                                value="2"><i class="fa fa-check"></i> @lang("Confirm")
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i>
                            @lang('Close')
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>


    <div class="modal fade" id="DelMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
         aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form method="post" action="{{ route('user.ticket.delete')}}">
                    @csrf
                    <div class="modal-header">

                        <strong class="modal-title" id="myModalLabel"><i
                                class='fa fa-exclamation-triangle'></i><strong> @lang("Confirmation!")</strong>
                        </strong>

                        <a href="javascript:void(0)" data-dismiss="modal" aria-hidden="true">X</a>
                    </div>
                    <div class="modal-body">
                        <strong>@lang("Are you sure to delete this?")</strong>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="message_id" class="message_id">
                        <button type="submit" class="btn btn-primary "><i class="fa fa-check"></i> @lang("Confirm")
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i>
                            @lang("Close")
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>



@endsection


@section('load-js')
@stop


@section('script')

    <script src="{{asset('assets/admin/js/simplemde.min.js')}}"></script>
    <script>
        var simplemde = new SimpleMDE({element: document.getElementById("inputMessage")});

        $(document).ready(function () {
            $('.card-body').scrollTop($('.card-body')[0].scrollHeight);
            $('.delete-message').on('click', function (e) {
                $('.message_id').val($(this).data('id'));
            })

        });

        function extraTicketAttachment() {
            $("#fileUploadsContainer").append('<input type="file" name="attachments[]" class="form-control mt-1" required />')
        }
    </script>
@endsection
