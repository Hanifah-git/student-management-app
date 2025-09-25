@extends('layouts.adminindex')
@section('content')

        <!-- Start Page Content  -->
            <div class="container-fluid">
                <div class="col-md-12">

                    <form action="{{route('paymenttypes.store')}}" method="POST">

                        {{-- Without @csrf or {{ csrf_field() }}, Laravel will reject the form 
                        submission with a 419 Page Expired error.
                        check it out in chatgpt for detail --}}
                        {{ csrf_field() }}
                        {{-- @csrf  --}}

                        <div class="row align-items-end">

                            <div class="col-md-6 form-group">
                                <label for="name">Name <span class="text-danger">*</span></label>
                                @error('name')
                                <span class="text-danger">{{$message}}</span>
                                @enderror
                                <input type="text" name="name" id="name" class="form-control form-control-sm rounded-0" placeholder="Enter Payment Type"/>
                            </div>

                            <div class="col-md-4 form-group">
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

                            <div class="col-md-2 d-flex gap-2">
                                <button type="reset" class="btn btn-secondary btn-sm rounded-0">Cancel</button>
                                <button type="submit" class="btn btn-primary btn-sm rounded-0 ms-3">Submit</button>
                            </div>
                        </div>
                    </form>
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
                        @foreach($paymenttypes as $idx=>$paymenttype)
                            <tr>
                                <td>
                                    <input type="checkbox" name="singlechecks" class="form-check-input singlechecks" value="{{$paymenttype->id}}"/>
                                </td>
                                <td>{{++$idx}}</td>
                                <td>{{$paymenttype->name}}</td>
                                <td>{{$paymenttype['status']['name']}}</td>   
                                <td>{{$paymenttype['user']['name']}}</td>
                                <td>{{$paymenttype->created_at->format('d M Y')}}</td>
                                <td>{{$paymenttype->updated_at->format('d M Y h:m:s')}}</td>
                                <td>
                                    <a href="javascript:void(0);" class="text-info"><i class="fas fa-pen"></i></a>
                                    <a href="javascript:void(0);" class="text-danger ms-2 delete-btn" data-idx="{{$idx}}"><i class="fas fa-trash-alt"></i></a>
                                
                                    <form id="formdelete-{{$idx}}" action="{{route('paymenttypes.destroy',$paymenttype->id)}}" method="POST">
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

            if(confirm(`Are you sure you want to delete payment type ${getidx}?`)){
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

 