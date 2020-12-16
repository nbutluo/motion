<div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">用户编辑</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">用户名</label>
                        <input type="email" name="name" class="form-control" id="recipient-name" disabled>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">邮箱:</label>
                        <input type="text" name="email" value="" class="form-control" id="recipient-email" disabled>
                    </div>
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">用户等级:</label>
                        <input type="text" name="email" class="form-control" id="recipient-level">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="control-label">申请理由:</label>
                        <textarea class="form-control" id="recipient-reason"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary">保存</button>
            </div>
        </div>
    </div>
</div>

@section('script')

<script>
    $('.btn-edit').click(function() {
        $('#modal-default').modal('show');
        return false;
    })

    // function userInfo($user) {
    //     console.log($user);
    //     $('#recipient-name').val($user.name)
    //     $('#recipient-email').val($user.email)
    //     $('#recipient-reason').val($user.reason)
    //     $('#recipient-level').val($user.level)
    // }
</script>
@endsection
