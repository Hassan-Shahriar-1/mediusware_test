@extends('layouts.app')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Products</h1>
    </div>


    <div class="card">
        <form action="/filter" method="get" class="card-header">
            <div class="form-row justify-content-between">
                <div class="col-md-2">
                    <input type="text" name="title" id="title" placeholder="Product Title" class="form-control">
                </div>
                <div class="col-md-2">
                    <select name="variant" id="variant" class="form-control">
                        
                        
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Price Range</span>
                        </div>
                        <input type="text" name="price_from" aria-label="First name" id="low" placeholder="From" class="form-control">
                        <input type="text" name="price_to" aria-label="Last name" id="high" placeholder="To" class="form-control">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="date" name="date" placeholder="Date" class="form-control">
                </div>
                <div class="col-md-1">
                    <button type="submit" onclick="filter()" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>

        <div class="card-body">
            <div class="table-response">
                <table class="table">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                        <?php $sl=0;?>
                    @foreach ($data as $key=>$val )
                        @php $sl++;@endphp
                    
                    <tr>
                        <td>{{$sl}}</td>
                        <td>{{$val['title']}} <br> Created at : {{$val['created_at']}}</td>
                        <td>{{$val['description']}}</td>
                        <td>
                            <dl class="row mb-0" style="height: 80px; overflow: hidden" id="variant">
                                @foreach ($val['grp'] as $pkey=>$pval )
                                
                                    
                                
                                <dt class="col-sm-3 pb-0">
                                    {{$pval['name']}}
                                </dt>
                              
                                <dd class="col-sm-9">
                                    <dl class="row mb-0">                                       
                                        <dt class="col-sm-4 pb-0">Price : {{ $pval['price'] }}</dt>
                                        <dd class="col-sm-8 pb-0">InStock : {{ $pval['stock'] }}</dd>
                                        @endforeach
                                    </dl>
                                </dd>
                            </dl>
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('product.edit', $val['id']) }}" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                        
                    </tbody>

                </table>
            </div>

        </div>

        <div class="card-footer">
            <div class="row justify-content-between">
                <div class="col-md-6">
                    <p>Showing {{ $data->firstItem('vendor.pagination.bootstrap-4') }} to {{ $data->lastItem('vendor.pagination.bootstrap-4') }}
                        of total {{$data->total('vendor.pagination.bootstrap-4')}} entries
                        </p>
                    
                </div>
                <div class="col-md-3">
                    {{$data->links('vendor.pagination.bootstrap-4')}}
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
@endsection
<script>
var data={!!json_encode($data->toArray())!!}
function filter(){
    var title=$('#title').val();
    console.log(search=data.filter(function(title){
 
</script>