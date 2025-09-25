@extends('layouts.adminindex')
@section('content')

{{-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}

        <!-- Start Page Content  -->
            <div class="container-fluid">
                <div class="col-md-12">

                    <form action="{{route('leaves.store')}}" method="POST" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">


                                    <div class="col-md-12 form-group mb-3">

                                        <label for="images" class="gallery" id="gallery">
                                            <span>Choose Images</span>
                                        </label>


                                        <input type="file" name="images" id="images" class="form-control form-control-sm rounded-0" multiple hidden/>
                                

                                    </div>


                                    <div class="col-md-6 form-group mt-3">
                                        <label for="startdate">Start Date <span class="text-danger">*</span></label>
                                        @error('startdate')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <input type="date" name="startdate" id="startdate" class="form-control form-control-sm rounded-0" value="{{old('startdate')}}"/>
                                    </div>
                                    <div class="col-md-6 form-group mt-3">
                                        <label for="enddate">End Date <span class="text-danger">*</span></label>
                                        @error('enddate')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <input type="date" name="enddate" id="enddate" class="form-control form-control-sm rounded-0" value="{{old('enddate')}}"/>
                                    </div>

                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        @error('title')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <input type="text" name="title" id="title" class="form-control form-control-sm rounded-0" placeholder="Enter Title" value="{{old('title')}}"/>
                                    </div>

                                    <div class="col-md-6 form-group mt-3">
                                        <label for="post_id">Class <span class="text-danger">*</span></label>
                                        @error('post_id')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <select name="post_id[]" id="post_id" class="form-control form-control-sm rounded-0" multiple="multiple">
                                            @foreach($posts as $id=>$title)
                                                <option value="{{$id}}" 
                                                   {{ collect(old('post_id'))->contains($id) ? 'selected' : '' }}>
                                                   {{$title}}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('post_id.*')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 form-group mt-3">
                                        <label for="tag">Tag <span class="text-danger">*</span></label>
                                        @error('tag')
                                            <span class="text-danger">{{$message}}</span>
                                        @enderror
                                        <select name="tag[]" id="tag" class="form-control form-control-sm rounded-0" multiple="multiple">
                                            @foreach($tags as $tag)
                                                <option value="{{ $tag->id }}" 
                                                    {{ collect(old('tag'))->contains($tag->id) ? 'selected' : '' }}>
                                                    {{ $tag->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('tag.*')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>
                                
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label for="content">Content <span class="text-danger">*</span></label>
                                <textarea type="text" name="content" id="content" class="form-control form-control-sm rounded-0" rows="5" placeholder="If you have something to say, type here...">{{old('content')}}</textarea>
                            </div>

                            <div class="col-md-12 d-flex justify-content-start">
                                <a href="{{route('leaves.index')}}" class="btn btn-secondary btn-sm rounded-0">Cancel</a>
                                <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>

                <hr/>
            </div>
        <!-- End Page Content  -->

@endsection
       
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.css" rel="stylesheet">
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />

    <style type="text/css">

        .gallery {
            width: 100%;
            background-color: #eee;
            color: #aaa;

            text-align: center;
            padding: 10px;
        }

        .gallery.removetext span {
            display: none;
        }

        .gallery img {
            width: 100px;
            height: 100px;
            border: 2px dashed #aaa;
            border-radius: 10px;
            object-fit: cover;

            padding: 5px;
            margin: 0 5px;
        }

    </style>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
    <script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}" type="text/javascript"></script>


<script type="text/javascript">

    $(document).ready(function(){
 
        // Start Multi Profile Preview

        let previewimages = function(input,output){
            console.log(input,output);

            if(input.files){

                let totalfiles = input.files.length;
                console.log(totalfiles);

                if(totalfiles > 0){
                    // $(output).html(""); 
                    $(output).addClass('removetext');
                }else{
                    $(output).removeClass('removetext');
                }

                // image
                for(let x=0; x < totalfiles; x++){
                    // console.log(x);
                   
                    let filereader = new FileReader();
                    filereader.readAsDataURL(input.files[x]);

                    filereader.onload = function(e){
                        $($.parseHTML("<img>")).attr("src",e.target.result).appendTo(output);
                    }
                }
            }
        }

        $("#images").change(function(){
            previewimages(this,"label.gallery");
        });

    // End Multi Profile Preview

    
        $('#post_id').select2({
            placeholder:"Choose class"
        });

        $('#tag').select2({
            placeholder:"Choose authorized person"
        });

        $('#content').summernote({
            placeholder:"Say Something...",
            height: 120,
            toolbar: [
                ['font',['bold','underline','clear']],
                ['color',['color']],
                ['para',['ul','ol','paragraph']],
                ['insert',['link']],
            ]
        });

        $("#startdate,#enddate").flatpickr({
            dateFormat: "Y-m-d",
            minDate: "today",
            maxDate: new Date().fp_incr(30)
        });

    });
</script>
@endsection