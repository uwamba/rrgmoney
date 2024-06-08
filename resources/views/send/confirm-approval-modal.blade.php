<div class="modal fade" id="confirm-approval-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Are you sure you want to approve this transfer? select account and click on Submit button</h5>
                <button class="close" onclick="closeConfirmModal()" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
              <div class="modal-body">
                      <table class="table table-striped">
                        <form method="POST" action="{{ route('send.approve') }}">
                            @csrf
                               <input type="hidden" name="id" value="{{$sent->id}}"/>
                               <input type="hidden" name="names" value="{{$sent->names}}"/>
                               <input type="hidden" name="account" value="{{$sent->bank_account}}"/>
                               <input type="hidden" name="phone" value="{{$sent->phone}}"/>
                               <input type="hidden" name="first_name" value="{{$sent->first_name}}"/>
                               <input type="hidden" name="last_name" value="{{$sent->last_name}}"/>
                               <input type="hidden" name="amount_rw_currency" value="{{$sent->amount_rw}}"/>
                               <input type="hidden" name="amount_local_currency" value="{{$sent->amount_local_currency}}"/>
                               <input type="hidden" name="currency" value="{{$sent->currency}}"/>
                                <input type="hidden" name="amount_foregn_currency" value="{{$sent->amount_foregn_currency}}"/>
                               <input type="hidden" name="agent_id" value="{{$sent->user_id}}"/>
                               <input type="hidden" name="sender_id" value="{{$sent->sender_id}}"/>
                               <input type="hidden" name="receiver_id" value="{{$sent->receiver_id}}"/>
                               <input type="hidden" name="status" value="Approved"/>
                      <div class="input-group " style="margin-bottom:2px;">
                        <span style="color:red;">*</span>Receiver Currency</label>
                    </div>

                    <select
                        class="form-control form-control-user @error('receiver_currency') is-invalid @enderror"
                        name="account" id="account">
                        <option selected disabled>Select Account</option>

                        @foreach ($accounts as $account)
                            <option value="{{ $account->name }}"
                                data-rate="{{ $account->name }}" data-charges="{{ $account->currency }}">
                                {{ $account->name}}
                            </option>
                        @endforeach

                    </select>
                    @error('receiver_currency')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                      </table>

                     <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeConfirmModal()" type="button" data-dismiss="modal">Cancel</button>
                         <button type="submit" class="btn btn-success ">Confirm</button>

                    </div>
                   </form>
              </div>

        </div>
    </div>
</div>
