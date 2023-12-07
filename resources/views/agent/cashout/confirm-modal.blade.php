<div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Tell the customer what missing</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
              <div class="modal-body">
                <form name="add-blog-post-form" id="add-blog-post-form" method="post" action="{{route('cashout.comment')}}">
                    @csrf
                    <input type="hidden" name="cashout_id" id="cashout_id" value=""/>
                    <input type="hidden" name="status" value="Action"/>
                     @hasrole('Admin')
                     <input type="hidden" name="receiver_id" value="{{$cashout->receiver_id}}"/>
                     @endhasrole
                      @hasrole('Agent')
                      <input type="hidden" name="receiver_id" value="{{$cashout->receiver_id}}"/>
                     @endhasrole

                     <div class="form-group">
                       <label for="exampleInputEmail1">Description</label>
                       <textarea name="description" class="form-control" required=""></textarea>
                     </div>
                     <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-secondary float-right">Send</button>

                    </div>
                   </form>
              </div>

        </div>
    </div>
</div>
