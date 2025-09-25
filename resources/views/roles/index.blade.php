@extends('layouts.adminindex')
@section('content')

        <!-- Start Page Content  -->
            <div class="container-fluid">

                <div class="col-md-12">
                    <a href="{{route('roles.create')}}" class="btn btn-primary btn-sm rounded-0">Create Role</a>
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
                                <th>Name</th>
                                <th>Status</th>
                                <th>By</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $idx=>$role)
                            <tr>
                                <td>
                                    <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$role->id}}"/>
                                </td>
                                <td>{{++$idx}}</td>
                                <td>
                                    <a href="{{route('roles.show',$role->id)}}">
                                        <img src="{{asset($role->image)}}" class="rounded-circle m-1" width="20" height="20"/>
                                    </a>
                                    {{$role->name}}
                                </td>
                                <td>{{$role['status']['name']}}</td>   
                                <td>{{$role['user']['name']}}</td>
                                <td>{{$role->created_at->format('d M Y')}}</td>
                                <td>{{$role->updated_at->format('d M Y h:m:s')}}</td>
                                <td>

                                    <a href="{{route('roles.edit',$role->id)}}" class="text-info"><i class="fas fa-pen"></i></a>
                                    <a href="javascript:void(0);" class="text-danger ms-2 delete-btn" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a>
                                
                                    <form id="formdelete-{{$idx}}" action="{{route('roles.destroy',$role->id)}}" method="POST">
                                        @csrf
                                        @method('DELETE')
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
        // Single Delete
        $('.delete-btn').click(function(){
            const getidx = $(this).data('idx');
            // console.log(getidx);

            if(confirm(`Are you sure you want to delete role ${getidx}?`)){
                $('#formdelete-'+getidx).submit();
                return true;
            }else{
                return false;
            }
        });
        // Single Delete

        
        // Bulk Delete
        //   If #selectalls is checked → all .singlechecks become checked.
        //   If #selectalls is unchecked → all .singlechecks become unchecked.
        $('#selectalls').click(function(){
            // $('.singlechecks').prop('checked',true);
            $('.singlechecks').prop('checked',$(this).prop('checked'));
        });
        // Bulk Delete
    })
</script>

@endsection

 