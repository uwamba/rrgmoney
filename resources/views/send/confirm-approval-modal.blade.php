<div class="modal fade" id="confirm-approval-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">You are about to transfer up with below details</h5>
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
                        name="receiver_currency" id="receiver_currency">
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
                      <tr>
                         <td><h4>Amount Local: </h4></td>
                         <td><h5  id="amount_local"></h5></td>
                      </tr>
                      <tr>
                        <td><h4>Amount Foreign: </h4></td>
                        <td><h5  id="amount_foreign"></h5></td>
                      </tr>
                      <tr>
                        <td><h4>Payment Method:</h4></td>
                        <td><h5  id="method"></h5></td>
                      </tr>
                      <tr>
                       <td><h4>Details: </h4></td>
                       <td><h5  id="details_h"></h5></td>
                      </tr>
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
