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
                      <tr>
                       <td><h4>Sender Names: </h4></td>
                       <td><h5  id="sender_names"></h5></td>
                      </tr>
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
                        <button class="btn btn-secondary" onclick="closeModal()" type="button" data-dismiss="modal">Cancel</button>
                         <button type="submit" class="btn btn-success ">Submit</button>

                    </div>
                   </form>
              </div>

        </div>
    </div>
</div>
