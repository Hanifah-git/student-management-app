@extends('layouts.adminindex')
@section('content')

        <!-- Start Page Content  -->
            <div class="container-fluid">
                <div class="col-md-12">

                    <form action="{{route('leaves.update',$leave->id)}}" method="POST" enctype="multipart/form-data">

                        {{-- Without @csrf or {{ csrf_field() }}, Laravel will reject the form 
                        submission with a 419 Page Expired error.
                        check it out in chatgpt for detail --}}
                        {{-- {{ csrf_field() }} --}}
                        @csrf 
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="image" class="gallery">
                                            @if($leave->image)
                                                <img src="{{asset($leave->image)}}" alt="{{$leave->slug}}" class="img-thumbnail" width="100" height="100"/>
                                            @else
                                                <span>Choose Images</span>
                                            @endif
                                        </label>

                                        <input type="file" name="image" id="image" class="form-control form-control-sm rounded-0" hidden/>
                                    </div>
                                    <div class="col-md-6 form-group mt-3">
                                        <label for="startdate">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" name="startdate" id="startdate" class="form-control form-control-sm rounded-0" value="{{old('startdate',$leave->startdate)}}"/>
                                    </div>
                                    <div class="col-md-6 form-group mt-3">
                                        <label for="enddate">End Date <span class="text-danger">*</span></label>
                                        <input type="date" name="enddate" id="enddate" class="form-control form-control-sm rounded-0" value="{{old('enddate',$leave->enddate)}}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control form-control-sm rounded-0" placeholder="Enter Name" value="{{old('title',$leave->title)}}"/>
                                    </div>

                                    <div class="col-md-6 form-group mt-3">
                                        <label for="post_id">Class <span class="text-danger">*</span></label>
                                        
                                        <select name="post_id" id="post_id" class="form-control form-control-sm rounded-0">
                                            @foreach($posts as $post)
                                                <option value="{{$post['id']}}"
                                                    {{-- showing the set post(when the leave is created) instead of default post  --}}
                                                    @if($post['id'] === $leave['post_id'])
                                                        selected
                                                    @endif
                                                >{{$post['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6 form-group mt-3">
                                        <label for="tag">Tag <span class="text-danger">*</span></label>
                                        <select name="tag" id="tag" class="form-control form-control-sm rounded-0">
                                            <option selected disabled>Choose Authorized Person</option>
                                            @foreach($tags as $tag)
                                                <option value="{{$tag['id']}}">{{$tag['name']}}</option>
                                            @endforeach
                                            @foreach($tags as $tag)
                                                <option value="{{$tag['id']}}"
                                                    {{-- showing the set tag(when the leave is created) instead of default tag  --}}
                                                    @if($tag['id'] === $leave['tag'])
                                                        selected
                                                    @endif
                                                >{{$tag['name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label for="content">Content <span class="text-danger">*</span></label>
                                <textarea type="text" name="content" id="content" class="form-control form-control-sm rounded-0" rows="5" placeholder="If you have something to say, type here...">{{old('content',$leave->content)}}"</textarea>
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

<script type="text/javascript">
    $(document).ready(function(){

    // Start Single Profile Preview

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
                        // output is old photo
                        $(output).html("");
                        $($.parseHTML("<img>")).attr("src",e.target.result).appendTo(output);
                    }
                }
            }
        }

        $("#image").change(function(){
            previewimages(this,"label.gallery");
        });

    // End Single Profile Preview

    });
</script>

@endsection