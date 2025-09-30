@extends('layouts.adminindex')
@section('content')

        <!-- Start Page Content  -->
            <div class="container-fluid">

                <div class="col-md-12">
                    <a href="{{route('leaves.create')}}" class="btn btn-primary btn-sm rounded-0">Create Leave</a>
                </div>

                <hr/>

                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-2 mb-2">
                            <a href="javascript:void(0);" id="bulkdelete-btn" class="btn btn-danger btn-sm rounded-0">Bulk Delete</a>
                        </div>

                        <div class="col-md-10">
                            <form action="" method="">
                        
                                <div class="row justify-content-end">

                                    <div class="col-md-6 col-sm-6 mb-2 d-flex">
                                        <div class="input-group"></div>
                                        <input type="text" name="filtername" id="filtername" class="form-control form-control-sm rounded-0" placeholder="Search..."/>
                                        <button type="submit" id="search-btn" class="btn btn-secondary btn-sm"><i class="fas fa-search"></i></button>
                                    </div>

                                        
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-12">
                    <table id="mytable" class="table table-sm table-hover border">
                        <thead>
                            <tr>
                                <th>
                                <input type="checkbox" name="selectalls" id="selectalls" class="form-check-input selectalls"/>
                                </th>
                                <th>No</th>
                                <th>Title</th>
                                <th>Tag</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>By</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($leaves as $idx=>$leave)
                            <tr>
                                <td>
                                    <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$leave->id}}"/>
                                </td>
                                <td>{{++$idx}}</td>
                                <td>
                                    <a href="{{route('leaves.show',$leave->id)}}">
                                        {{Str::limit($leave->title,20)}}
                                    </a>
                                </td>
                                <td>
                                    @php
                                        $tagids = $leave->tag ?? [];
                                        $tagnames = collect($tagids)->map(function($id) use ($users){
                                            return $users[$id] ?? 'Unknown';
                                        });
                                    @endphp

                                    {{$tagnames->join(', ')}}
                                </td>
                                <td>{{$leave->startdate}}</td>
                                <td>{{$leave->enddate}}</td>
                                <td>{{$leave['stage']['name']}}</td>   
                                <td>{{$leave['user']['name']}}</td>
                                <td>{{$leave->created_at->format('d M Y')}}</td>
                                <td>{{$leave->updated_at->format('d M Y h:m:s')}}</td>
                                <td>

                                    <a href="{{route('leaves.edit',$leave->id)}}" class="text-info"><i class="fas fa-pen"></i></a>
                                    

                                    <form action="{{ route('leaves.destroy', $leave->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-link text-danger p-0 ms-2" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        <!-- End Page Content  -->

@endsection
       
@section('styles')
@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function(){
        
    })
</script>

@endsection

 

 