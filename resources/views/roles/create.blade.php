@extends('layouts.adminindex')
@section('content')

        <!-- Start Page Content  -->
            <div class="container-fluid">
                <div class="col-md-12">

                    <form action="{{route('roles.store')}}" method="POST" enctype="multipart/form-data">

                        {{-- Without @csrf or {{ csrf_field() }}, Laravel will reject the form 
                        submission with a 419 Page Expired error.
                        check it out in chatgpt for detail --}}
                        {{ csrf_field() }}
                        {{-- @csrf  --}}

                        <div class="row align-items-end">

                            <div class="col-md-3 form-group">
                                <label for="image">Image <span class="text-danger">*</span></label>
                                @error('image')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <input type="file" name="image" id="image" class="form-control form-control-sm rounded-0"/>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                @error('name')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Enter Role Name"/>
                            </div>

                            <div class="col-md-3 form-group">
                                <label for="status_id">Status</label>
                                @error('status_id')
                                    <span class="text-danger">{{$message}}</span>
                                @enderror
                                <select name="status_id" id="status_id" class="form-control form-control-sm rounded-0">
                                    @foreach($statuses as $status)
                                        <option value="{{$status['id']}}">{{$status['name']}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-3 d-flex gap-2">
                                <a href="{{route('roles.index')}}" class="btn btn-secondary btn-sm rounded-0">Cancel</a>
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