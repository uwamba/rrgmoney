<div class="modal fade" id="more-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">You are about to transfer up with below details</h5>
                <button class="close" onclick="closeModal()" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
              <div class="modal-body">
                      <table class="table table-striped">

                      <tr>
                       <td><h6>Sender Names: </h6></td>
                       <td><h6  id="sender_names">{{ $sent->first_name." ".$sent->last_name }}</h6></td>
                      </tr>
                      <tr>
                        <td><h6>Receiver Names: </h6></td>
                        <td><h6  id="receiver_names">{{$sent->names}}</h6></td>
                      </tr>
                      <tr>
                         <td><h6>Send/Receieve: </h6></td>
                         <td><h6  id="amount_local">{{$sent->class}}</h6></td>
                      </tr>
                      <tr>
                        <td><h6>Amount Local: </h6></td>
                          <td><h6  id="amount_local">{{$sent->amount_local_currency." ".$sent->local_currency}}</h6></td>
                        </tr>
                      <tr>
                        <td><h6>Amount Foreign: </h6></td>
                        <td><h6  id="amount_foreign">{{$sent->amount_foregn_currency." ".$sent->currency}}</h6></td>
                      </tr>
                      <tr>
                        <td><h6>Payment Method:</h6></td>
                        <td><h6  id="method"></h6>{{$sent->reception_method}}</td>
                      </tr>
                      <tr>
                        <td><h6>Payment Account:</h6></td>
                          <td><h6  id="method"></h6>{{$sent->bank_account}}</td>
                       </tr>
                      <tr>
                       <td><h6>Details: </h6></td>
                       <td><h6  id="details_h">{{$sent->description}}</h6></td>
                      </tr>
                      </table>

                     <div class="modal-footer">
                        <button class="btn btn-secondary" onclick="closeModal()" type="button" data-dismiss="modal">Ok</button>


                    </div>
                   </form>
              </div>

        </div>
    </div>
</div>
