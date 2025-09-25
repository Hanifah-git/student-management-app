 @extends('layouts.adminindex')
@section('content')

        <!-- Start Page Content  -->
            <div class="container-fluid">
                <div class="col-md-12">

                    <form action="{{route('leaves.store')}}" method="POST" enctype="multipart/form-data">

                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="image">Image</label>
                                        <input type="file" name="image" id="image" class="form-control form-control-sm rounded-0"/>
                                    </div>
                                    <div class="col-md-6 form-group mt-3">
                                        <label for="startdate">Start Date <span class="text-danger">*</span></label>
                                        <input type="date" name="startdate" id="startdate" class="form-control form-control-sm rounded-0" value="{{old('startdate','$gettoday')}}"/>
                                    </div>
                                    <div class="col-md-6 form-group mt-3">
                                        <label for="enddate">End Date <span class="text-danger">*</span></label>
                                        <input type="date" name="enddate" id="enddate" class="form-control form-control-sm rounded-0" value="{{old('startdate','$gettoday')}}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-md-12 form-group">
                                        <label for="title">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control form-control-sm rounded-0" placeholder="Enter Name"/>
                                    </div>

                                    <div class="col-md-6 form-group mt-3">
                                        <label for="post_id">Class <span class="text-danger">*</span></label>
                                        <select name="post_id" id="post_id" class="form-control form-control-sm rounded-0">
                                            <option selected disabled>Choose Class</option>
                                            @foreach($posts as $post)
                                                <option value="{{$post['id']}}">{{$post['title']}}</option>
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
                                        </select>
                                    </div>

                                </div>
                                
                            </div>

                            <div class="col-md-12 form-group mb-3">
                                <label for="content">Content <span class="text-danger">*</span></label>
                                <textarea type="text" name="content" id="content" class="form-control form-control-sm rounded-0" rows="5" placeholder="If you have something to say, type here..."></textarea>
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
       
@section('styles')
@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function(){
        
    });
</script>

@endsection