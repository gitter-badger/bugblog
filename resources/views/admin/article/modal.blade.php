
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">文章</h4>
			</div>
			<form action="/admin/article" method="post" id="myform">
				<div class="modal-body">
					
					<div class="form-group">
						<label for="title">标题</label>
						<input type="text" class="form-control" name="title" id="title" placeholder="Title">
						<span id="helpBlock" class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
					</div>

					<div class="form-group">
					    <!-- <label for="cats">分类</label> -->
					    <input type="text" class="form-control" name="cat_id" id="cats" placeholder="Title">
					    <span id="helpBlock" class="help-block">选择分类.</span>
				    </div>

				    <div class="form-group">
					    <label for="review">简要</label>
					    <textarea class="form-control" rows="3" name="review" id="review" placeholder="Review..."></textarea>
					    <span id="helpBlock" class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
				    </div>
				    
				    <div class="form-group">
					    <label for="content">内容</label>
					    <textarea id="content" name="content" rows="15" cols="80" style="width: 100%"></textarea>
					    <span id="helpBlock" class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
				    </div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save changes</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@push('scripts')
<!-- 配置文件 -->
<script type="text/javascript" src="/js/admin/plug/ueditor/ueditor.config.js"></script>
<!-- 编辑器源码文件 -->
<script type="text/javascript" src="/js/admin/plug/ueditor/ueditor.all.js"></script>
<!-- validate -->
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<!-- select2 -->
<script src="/js/admin/plug/select2/select2.full.min.js"></script>
<!-- 实例化编辑器 -->
<script type="text/javascript">
$(function() {
    var ue = UE.getEditor('content');

    $('#modal').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var action = button.data('url') // Extract info from data-* attributes
		var method = button.data('method') // Extract info from data-* attributes

		var modal = $(this)
		if (method == 'put') {
			// modal.find('form').append('<input type="hidden" name="_method" value="put" />')
		}
		modal.find('form').attr('action', action)
		modal.find('form').attr('method', method)
	})

    // 隐藏modal
	$('#modal').on('hidden.bs.modal', function(){
	    $(this).find('form')[0].reset();
	    ue.setContent("");
	    validator.resetForm();
	    $('.form-group').removeClass('has-error has-feedback');
	});

	// select2
	$("#cats").select2({
		placeholder: {
			// id: "-1",
			placeholder: "Select an option"
		}
	});
    
    var validator = $("#myform").submit(function(){
        ue.sync();
    }).validate({
    	errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: '',
		rules: {
			title: "required",
			review: "required",
			content: "required"
		},
		messages: {
			title: "标题不能为空",
			review: "文章简要不能为空",
			content: "文章内容不能为空"
		},

        highlight: function (element) { // hightlight error inputs
            $(element)
                .closest('.form-group').addClass('has-error'); // set error class to the control group
        },

        success: function (label) {
            label.closest('.form-group').removeClass('has-error');
            label.remove();
        },

		submitHandler: function(form) {
			var options = { 
				type: $(form).attr('method'),
		        success: function(){
		        	$("#modal").modal('hide');
		        	$('#articles-table').DataTable().ajax.reload( null, false );
		        }, 
 
		        clearForm: true ,       // clear all form fields after successful submit 
		        resetForm: true ,       // reset the form after successful submit 
	    	};	

			$(form).ajaxSubmit(options); 
		}
	 });

});
</script>
@endpush
