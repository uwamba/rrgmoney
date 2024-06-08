<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Are you Sure You wanted to Reject this Transfer?</h5>
                <button class="close" type="button" data-dismiss="reject-modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="user-delete-form" method="POST" action="{{ route('send.reject', ['transfer' => $sent->id]) }}">
                @csrf
                @method('POST')
                       <input type="hidden" name="id" value="{{$sent->id}}"/>
                       <input type="hidden" name="agent_id" value="{{$sent->user_id}}"/>
                       <input type="hidden" name="sender_id" value="{{$sent->sender_id}}"/>
                       <input type="hidden" name="receiver_id" value="{{$sent->receiver_id}}"/>
                       <input type="hidden" name="status" value="Approved"/>
                <div class="modal-body">
                <p>Select "Reject" below if you want to reject this Transfer!.</p><div class="mb-3">
                    <label for="FormControlTextarea" class="form-label">Reason to reject</label>
                    <textarea class="form-control" id="message" name="message" rows="3"></textarea>
                  </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" type="submit">Reject</button>
            </div>
        </form>
        </div>
    </div>
</div>
