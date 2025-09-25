@extends('layouts.adminindex')
@section('content')

    <!-- Start Page Content  -->
    <div class="container-fluid">
        <div class="col-md-12">

            <form action="{{ route('leaves.update', $leave->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="images" class="gallery">
                                    @if($leave->image)
                                        <div class="mt-2">
                                            <img src="{{ asset('uploads/'.$leave->image) }}" alt="Preview" width="120" class="border rounded">
                                        </div>
                                    @else
                                        <span>Choose Images</span>
                                    @endif
                                </label>

                                <input type="file" name="images[]" id="images" class="form-control form-control-sm rounded-0" multiple hidden/>
                                
                            </div>

                            <div class="col-md-6 form-group mt-3">
                                <label for="startdate">Start Date <span class="text-danger">*</span></label>
                                @error('startdate')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <input type="date" name="startdate" id="startdate" 
                                    class="form-control form-control-sm rounded-0" 
                                    value="{{ old('startdate', $leave->startdate) }}"/>
                            </div>

                            <div class="col-md-6 form-group mt-3">
                                <label for="enddate">End Date <span class="text-danger">*</span></label>
                                @error('enddate')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <input type="date" name="enddate" id="enddate" 
                                    class="form-control form-control-sm rounded-0" 
                                    value="{{ old('enddate', $leave->enddate) }}"/>
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
                                <input type="text" name="title" id="title" 
                                    class="form-control form-control-sm rounded-0" 
                                    placeholder="Enter Title" 
                                    value="{{ old('title', $leave->title) }}"/>
                            </div>

                            <div class="col-md-6 form-group mt-3">
                                <label for="post_id">Class <span class="text-danger">*</span></label>
                                @error('post_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <select name="post_id[]" id="post_id" class="form-control form-control-sm rounded-0" multiple="multiple">
                                    @foreach($posts as $id=>$title)
                                        <option value="{{ $id }}" 
                                        {{-- “If the current option’s ID exists in the old input or in the leave’s saved data, then select this option by default.” --}}
                                            {{ collect(old('post_id', $leave->post_id ?? []))->contains($id) ? 'selected' : '' }}>
                                            {{ $title }}
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
                                            {{ collect(old('tag', $leave->tag ?? []))->contains($tag->id) ? 'selected' : '' }}>
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
                        <textarea type="text" name="content" id="content" 
                            class="form-control form-control-sm rounded-0" rows="5" 
                            placeholder="If you have something to say, type here...">{{ old('content', $leave->content) }}</textarea>
                    </div>

                    <div class="col-md-12 d-flex justify-content-start">
                        <a href="{{route('leaves.index')}}" class="btn btn-secondary btn-sm rounded-0">Cancel</a>
                        <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3">Update</button>
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

    
    <link href="{{ asset('assets/libs/select2-develop/dist/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/summernote-0/summernote-lite.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>

<script src="{{ asset('assets/libs/select2-develop/dist/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/libs/summernote-0/summernote-lite.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('assets/libs/flatpickr/flatpickr.min.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    $(document).ready(function(){

        // Start Multi Profile Preview

        let previewimages = function(input,output){
            // console.log(input,output);

            if(input.files){

                let totalfiles = input.files.length;
                // console.log(totalfiles);

                if(totalfiles > 0){
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

    });
</script>
@endsection
