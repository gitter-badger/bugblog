@extends('layouts.app')

@push('css')
<link href="/css/plug/select2/select2.min.css" rel="stylesheet" />
@endpush

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            @include('layouts.nav')
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4">Atricles</div>
                        <div class="col-md-1 col-md-offset-7">
                            <button type="button" class="btn btn-primary btn-xs " data-toggle="modal" data-url="/admin/article" data-method="post" data-target="#articleModal"> + 添加 </button>
                        </div>
                    </div>
                  
                </div>
<!--                 <div class="dataTables_wrapper form-inline dt-bootstrap no-footer"> -->
                <!-- Table -->
                <div class="panel-body table-responsive">
                    <table class="table table-hover table-bordered" id="articles-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>标题</th>
                                <th>简要</th>
                                <th>创建时间</th>
                                <th>更新时间</th>
                                <th>操作</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
@include('admin.article.modal')
@endsection


@push('scripts')
<script>
$(function() {

    var table = $('#articles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{!! url('/admin/article/datas') !!}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'title', name: 'title'},
            { data: 'review', name: 'review' },
            // { data: 'content', name: 'content' },
            { data: 'created_at', name: 'created_at' },
            { data: 'updated_at', name: 'updated_at' },
            { data: 'id', name: 'edit', render: function(data, type, full, meta) {
                return '<a href="javascript:;" class="btn btn-primary btn-xs edit" data-url="/admin/article/'+data+'" data-method="put" data-toggle="modal" data-target="#articleModal">Edit</a>\
                <a href="javascript:;" class="btn btn-warning btn-xs" data-url="'+data+'">Top</a>\
                <a href="javascript:;" data-placement="top" class="btn btn-danger btn-xs" data-trigger="focus" data-toggle="popover" >Delete</a>';
            }, orderable: false, searchable: false }
        ]
    });

    table.on( 'draw', function () {
        $('[data-toggle="popover"]').popover({
            title: "请选择操作",
            html: 'true',
            content: '<button type="button" class="btn btn-success btn-xs delete">确定</button>\
            <button type="button" class="btn btn-danger btn-xs">取消</button>'
        });

        // 点击编辑
        $('#articles-table').on('click', 'a.edit', function () {
            var id = table.row( $(this).closest('tr') ).data().id
            var url = '/admin/article/' + id;
            var ue = UE.getEditor('content');
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    // console.log(data);
                    $('#title').val(data.title);
                    $('#review').val(data.review);
                    ue.setContent(data.content);
                }
            })
        });
        // 点击删除
        $('#articles-table').on( 'click', 'button.delete', function () {
            var id = table.row( $(this).closest('tr') ).data().id
            // console.log(id)
            var url = '/admin/article/' + id;
            $.ajax({
                url: url,
                type: 'DELETE',
                success: function() {
                    table.ajax.reload( null, false );
                }
            })
        });
    });

    
});
</script>
@endpush