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
                <form method="POST" action="{{ route('send.approve') }}">
                        @csrf
                        <input type="hidden" id="id" name="id"/>
                        <input type="hidden" id="amount_rw_currency" name="amount_rw_currency" />
                        <input type="hidden" id="amount_local_currency" name="amount_local_currency" />
                        <input type="hidden" id="currency" name="currency" />
                        <input type="hidden" id="sender_currency" name="sender_currency"   />
                        <input type="hidden" id="amount_foregn_currency" name="amount_foregn_currency" />
                        <input type="hidden" id="agent_id" name="agent_id" />
                        <input type="hidden" id="sender_id" name="sender_id" />
                        <input type="hidden" id="receiver_id" name="receiver_id" />
                        <input type="hidden" id="status" name="status" value="Approved"/>

                        <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="input-group " style="margin-bottom:2px;">
                          <span style="color:red;">*</span>Receiver Currency</label>
                        </div>
                        <div class="input-group " style="margin-bottom:2px;">
                          <select class="form-control form-control-user @error('account') is-invalid @enderror" name="account_name" id="account_name">
                                 <option selected disabled>Select Account</option>

                                 @foreach ($accounts as $account)
                                 <option value="{{ $account->name }}">
                                    {{ $account->name}}
                                 </option>
                                 @endforeach

                            </select>
                       <div/>
                       <div class="input-group " style="margin-bottom:2px;">
                           <button class="btn btn-secondary" onclick="closeConfirmModal()" type="button" data-dismiss="modal">Cancel</button>
                           <button type="submit" class="btn btn-success ">Confirm</button>
                       </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
