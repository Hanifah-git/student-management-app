@extends('layouts.adminindex')
@section('content')

        <!-- Start Page Content  -->
            <div class="container-fluid">

                <div class="col-md-12">
                    <a href="javascript:void(0);" id="btn-back" class="btn btn-secondary btn-sm rounded-0">Back</a>
                    <a href="{{route('leaves.index')}}" class="btn btn-secondary btn-sm rounded-0">Close</a>
                </div>

                <hr/>

                <div class="col-md-12">
                    <div class="row">

                        <div class="col-md-4 col-lg-3 mb-2">
                            <h6>Info</h6>
                            <div class="card border-0 rounded-0 shadow">

                                <div class="card-body">
                                
                                    <div class="d-flex flex-column align-items-center mb-3">
                                        <div class="h6 mb-1">{{$leave->title}}</div>
                                        <div class="text-muted">
                                            <span>{{$leave["stage"]["name"]}}</span>
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
                                                       @foreach($leave->tagpersons($leave->tag) as $id=>$name)
                                                           <a href="javascript:void(0);">{{$name}}</a>
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
                                                            <input type="email" name="cmpemail" id="cmpemail" class="form-control form-control-sm border-0 rounded-0" placeholder="Recipients" value="" readonly />
                                                        </div>
                                                        <div class="col-md-6 form-group mb-3">
                                                            <input type="text" name="cmpsubject" id="cmpsubject" class="form-control form-control-sm border-0 rounded-0" placeholder="Subject" value="" />
                                                        </div>
                                                        <div class="col-md-12 form-group mb-3">
                                                            <textarea name="cmpcontent" id="cmpcontent" class="form-control form-control-sm border-0 rounded-0" rows="3" style="resize:none"  value=""></textarea>
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
                                    @foreach($leave->tagposts($leave->post_id) as $id=>$title)
                                        <div class="border shadow p-3 enrollboxes">
                                            <a href="{{route('posts.show',$id)}}">{{$title}}</a>
                                        </div>
                                    @endforeach
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
<style type="text/css">
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

.accordion .acc-title:hover,.accordion .acc-title:focus {
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


</style>
@endsection

@section('scripts')

<script type="text/javascript">

// Start Accordion
const getacctitles = document.getElementsByClassName('acc-title');
const getacccontents = document.querySelectorAll('.acc-content');


for(let x = 0;x < getacctitles.length;x++){

    getacctitles[x].addEventListener('click',function(e){
        
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

    if(getacctitles[x].classList.contains('active')){
        getacccontents[x].style.height = getacccontents[x].scrollHeight + 'px';
    }
}
</script>

@endsection