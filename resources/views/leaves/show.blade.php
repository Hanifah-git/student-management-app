@extends('layouts.adminindex')
@section('content')
    <!-- Start Page Content  -->
    <div class="container-fluid">

        <div class="col-md-12">
            <a href="javascript:void(0);" id="btn-back" class="btn btn-secondary btn-sm rounded-0">Back</a>
            <a href="{{ route('leaves.index') }}" class="btn btn-secondary btn-sm rounded-0">Close</a>
        </div>

        <hr />

        <div class="col-md-12">
            <div class="row">

                <div class="col-md-4 col-lg-3 mb-2">
                    <h6>Info</h6>
                    <div class="card border-0 rounded-0 shadow">

                        <div class="card-body">

                            <div class="d-flex flex-column align-items-center mb-3">
                                <div class="h6 mb-1">{{ $leave->title }}</div>
                                <div class="text-muted">
                                    <span>{{ $leave['stage']['name'] }}</span>
                                </div>
                            </div>

                            <div class="mb-3">

                                <div class="row g-0 mb-2">

                                    <div class="col-auto">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <div class="col ps-3">
                                        <div class="row">
                                            <div class="col">
                                                <h6>Tag</h6>
                                            </div>
                                            <div class="col-auto">

                                                {{-- this will link two tags to a single page --}}
                                                {{-- <a href="javascript:void(0);">{{$leave->maptagtonames($users)}}</a> --}}

                                                {{-- this will link each tag to their respective pages --}}
                                                @foreach ($leave->tagpersons($leave->tag) as $id => $name)
                                                    <a href="javascript:void(0);">{{ $name }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="col-md-8 col-lg-9">
                    <h6>Compose</h6>
                    <div class="card border-0 rounded-0 shadow mb-4">
                        <div class="card-body">
                            <div class="accordion">

                                <h3 class="acc-title">New Message</h3>
                                <div class="acc-content">
                                    <div class="col-md-12 py-3">
                                        <form action="" method="POST">
                                            @csrf
                                            <div class="row">
                                                <div class="col-md-6 form-group mb-3">
                                                    <input type="email" name="cmpemail" id="cmpemail"
                                                        class="form-control form-control-sm border-0 rounded-0"
                                                        placeholder="Recipients" value="" readonly />
                                                </div>
                                                <div class="col-md-6 form-group mb-3">
                                                    <input type="text" name="cmpsubject" id="cmpsubject"
                                                        class="form-control form-control-sm border-0 rounded-0"
                                                        placeholder="Subject" value="" />
                                                </div>
                                                <div class="col-md-12 form-group mb-3">
                                                    <textarea name="cmpcontent" id="cmpcontent" class="form-control form-control-sm border-0 rounded-0" rows="3"
                                                        style="resize:none" value=""></textarea>
                                                </div>
                                                <div></div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h6>Class</h6>
                    <div class="card border-0 rounded-0 shadow mb-4">
                        <div class="card-body d-flex flex-wrap gap-3">
                            @foreach ($leave->tagposts($leave->post_id) as $id => $title)
                                <div class="border shadow p-3 enrollboxes">
                                    <a href="{{ route('posts.show', $id) }}">{{ $title }}</a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <h6>Additional Info</h6>
                    <div class="card border-0 rounded-0 shadow mb-4">
                        <ul class="nav">
                            <li class="nav-item">
                                <button type="button" id="autoclick" class="tablinks active"
                                    onclick="gettab(event,'contenttab')">Content</button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="contenttab" class="tab-panel">
                                <p>{!! $leave->content !!}</p>

                                @if (!empty($leavefiles) && $leavefiles->count() > 0)
                                    @foreach ($leavefiles as $leavefile)
                                        <div class="mt-2">
                                            <a href="{{ asset($leavefile->image) }}" data-lightbox="image">
                                                <img src="{{ asset($leavefile->image) }}" alt="{{ $leavefile->id }}"
                                                    width="120" class="border rounded">
                                            </a>
                                        </div>
                                    @endforeach
                                @else
                                    <span>No File</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <h6>Control Session</h6>
                    <div class="card border-0 rounded-0 shadow mb-4">
                        <ul class="nav">
                            <li class="nav-item">
                                <button type="button" id="autoclick" class="tablinks active"
                                    onclick="gettab(event,'authorizationtag')">Authorization</button>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div id="authorizationtag" class="tab-panel">
                                <form action="{{ route('leaves.updatestage',$leave->id) }}" method="POST">

                                    @csrf
                                    @method('PUT')

                                    <div class="row">

                                        <div class="col-md-3 form-group mt-3">

                                            <select name="stage_id" id="stage_id"
                                                class="form-select form-select-sm rounded-0">
                                                @foreach ($stages as $stage)
                                                    <option value="{{ $stage->id }}"
                                                        {{ $leave->stage_id == $stage->id ? 'selected' : '' }}>
                                                        {{ $stage->name }}
                                                    </option>
                                                @endforeach
                                            </select>

                                        </div>

                                        <div class="col-md-3 d-flex justify-content-end">
                                            <button type="submit"
                                                class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                                        </div>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-12">

            </div>
        </div>
        <!-- End Page Content  -->
    @endsection

    @section('css')
        <link href="{{ asset('assets/libs/lightbox2-dev/dist/css/lightbox.min.css') }}" rel="stylesheet"
            type="text/css" />
        <style type="text/css">
            /* Start Accordion */
            .accordion {
                width: 100%;
                max-width: 600px;
                margin: 0 auto;
            }

            .accordion .acc-title {
                background-color: #777;
                color: #fff;
                font-size: 1.2em;

                padding: 15px;
                margin: 0;

                cursor: pointer;
                border: 1px solid #ccc;
                border-radius: 5px;

                user-select: none;
            }

            .accordion .acc-title:hover,
            .accordion .acc-title:focus {
                background-color: steelblue;
                color: #fff;
            }

            .accordion .acc-title::after {
                content: "\2b";
                float: right;
            }

            .accordion .acc-title.active::after {
                content: "-";
            }

            .accordion .acc-content {
                height: 0;
                background-color: #f4f4f4;
                text-indent: 50px;
                text-align: justify;
                font-size: 1em;
                transition: height 0.3s ease;
                padding: 0 15px;
                overflow: hidden;

            }

            /* End Accordion */


            /* Start Tab */

            .nav {
                background-color: #f1f1f1;
                border: 1px solid #ccc;

                display: flex;

                padding: 0;
                margin: 0;
            }

            .nav .nav-item {
                list-style-type: none;
            }

            .nav .tablinks {
                background-color: inherit;
                font-size: 17px;
                border: none;
                outline: none;
                cursor: pointer;

                padding: 14px 16px;
            }

            .nav .tablinks:hover {
                background-color: #ccc;
            }

            .nav .tablinks.active {
                background-color: #ccc;
            }

            .tab-panel {
                border: 1px solid #bbb;
                border-top: none;

                padding: 6px 12px;
                display: none;
            }

            /* End Tab */

            #stage_id:focus {
                outline: none !important;
                box-shadow: none !important;
                border-color: inherit !important;
            }

        </style>
    @endsection

    @section('scripts')
        <script src="{{ asset('assets/libs/lightbox2-dev/dist/css/lightbox.min.css') }}" type="text/javascript"></script>
        <script type="text/javascript">
            // Start Accordion
            const getacctitles = document.getElementsByClassName('acc-title');
            const getacccontents = document.querySelectorAll('.acc-content');


            for (let x = 0; x < getacctitles.length; x++) {

                getacctitles[x].addEventListener('click', function(e) {

                    e.target.classList.toggle('active');
                    const getcontent = this.nextElementSibling;
                    console.log(getcontent);


                    if (this.classList.contains('active')) {
                        // open
                        getcontent.style.height = getcontent.scrollHeight + "px";
                    } else {
                        // close
                        getcontent.style.height = "0";
                    }
                });

                if (getacctitles[x].classList.contains('active')) {
                    getacccontents[x].style.height = getacccontents[x].scrollHeight + 'px';
                }
            }


            // Start Tab

            let gettablinks = document.getElementsByClassName('tablinks'),
                gettabpanels = document.getElementsByClassName('tab-panel');

            let tabpanels = Array.from(gettabpanels);

            function gettab(evn, link) {
                for (let x = 0; x < gettablinks.length; x++) {
                    console.log(x);

                    gettablinks[x].className = gettablinks[x].className.replace(' active', '');
                }

                evn.target.className = "tablinks active";

                tabpanels.forEach(function(tabpanel) {
                    tabpanel.style.display = "none";
                });

                document.getElementById(link).style.display = "block";
            }

            document.getElementById('autoclick').click();
        </script>
    @endsection
