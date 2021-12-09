@extends(activeTemplate() .'layouts.user')

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


                                        <form  action="{{route('user.ticket.store')}}" role="form" method="post" enctype="multipart/form-data" id="recaptchaForm">
                                            @csrf
                                            <div class="row ">
                                                <div class="form-group col-md-6">
                                                    <label for="name">@lang('Name')</label>
                                                    <input type="text"  name="name" value="{{$user->firstname . ' '.$user->lastname}}" class="form-control form-control-lg" placeholder="@lang('Enter Name')" required readonly>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="email">@lang('Email address')</label>
                                                    <input type="email"  name="email" value="{{$user->email}}" class="form-control form-control-lg" placeholder="@lang('Enter your Email')" required readonly>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-12">
                                                    <label for="website">@lang('Subject')</label>
                                                    <input type="text" name="subject" value="{{old('subject')}}" class="form-control form-control-lg" placeholder="@lang('Subject')" >
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="form-group col-md-6">
                                                    <label for="department">@lang('Department')</label>
                                                    <select class="form-control form-control-lg required" name="department" required>
                                                        @foreach($topics as $topic)
                                                            <option value="{{$topic->id}}">{{$topic->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label for="priority">@lang('Priority')</label>
                                                    <select class="form-control form-control-lg required" name="priority" required>
                                                        <option value="medium">@lang('Medium')</option>
                                                        <option value="high">@lang('High')</option>
                                                        <option value="low">@lang('Low')</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12 form-group">
                                                    <label for="inputMessage">@lang('Message')</label>
                                                    <textarea name="message" id="inputMessage" rows="12" class="form-control">{{old('message')}}</textarea>
                                                </div>
                                            </div>

                                            <div class="row form-group">
                                                <div class="col-sm-12">
                                                    <label for="inputAttachments">@lang('Attachments')</label>
                                                </div>
                                                <div class="col-sm-9 file-upload">
                                                    <input type="file" name="attachments[]" id="inputAttachments" class="form-control form-control-lg" />
                                                    <div id="fileUploadsContainer"></div>
                                                </div>



                                                <div class="col-sm-3">
                                                    <button type="button" class="btn btn-custom" onclick="extraTicketAttachment()">
                                                        <i class="fa fa-plus"></i> @lang('Add More')
                                                    </button>
                                                </div>
                                                <div class="col-sm-12 ticket-attachments-message text-muted">
                                                    @lang("Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx")
                                                </div>
                                            </div>

                                            <div class="row form-group justify-content-center">
                                                <div class="col-md-6">
                                                    <button class="btn custom-button bg-3  text-center mt-3" type="submit" id="recaptcha" ><i class="fa fa-paper-plane"></i>&nbsp;@lang('Submit Now')</button>
                                                </div>


                                                <div class="col-md-6">
                                                    <button class=" btn btn-danger mt-3" type="button" onclick="formReset()">&nbsp;@lang('Cancel')</button>
                                                </div>
                                            </div>
                                        </form>


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


    @if($plugins[2]->status == 1)
        <script src="//code.jquery.com/jquery-3.4.1.min.js"></script>
        @php echo recaptcha() @endphp
    @endif
@endsection


@section('load-js')
@stop


@section('script')
    <script>
        function extraTicketAttachment() {
            $("#fileUploadsContainer").append('<input type="file" name="attachments[]" class="form-control form-control-lg mt-2" required />')
        }
        function formReset() {
            window.location.href = "{{url()->current()}}"
        }
    </script>
@endsection
