
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
				    <!-- <div class="form-group">
					    <label for="review">简要</label>
					    <textarea class="form-control" rows="3" name="review" id="review" placeholder="Review..."></textarea>
					    <span id="helpBlock" class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
				    </div>
				    <div class="form-group">
					    <label for="review">内容</label>
					    <textarea id="content" name="content" rows="15" cols="80" style="width: 100%"></textarea>
					    <span id="helpBlock" class="help-block">A block of help text that breaks onto a new line and may extend beyond one line.</span>
				    </div> -->
					
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
<!-- validate -->
<script src="http://malsup.github.com/jquery.form.js"></script> 
<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>
<script type="text/javascript">
$(function() {

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
	    validator.resetForm();
	    $('.form-group').removeClass('has-error has-feedback');
	});
    
    var validator = $("#myform").validate({
    	errorElement: 'span', //default input error message container
        errorClass: 'help-block help-block-error', // default input error message class
        focusInvalid: false, // do not focus the last invalid input
        ignore: '',
		rules: {
			title: "required",
		},
		messages: {
			title: "标题不能为空",
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
		        	$('#cats-table').DataTable().ajax.reload( null, false );
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
