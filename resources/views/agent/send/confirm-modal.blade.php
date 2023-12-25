<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
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
                       <td><h4>Sender Names: </h4></td>
                       <td><h5  id="sender_names"></h5></td>
                      </tr>
                      <tr>
                        <td><h4>Receiver Names: </h4></td>
                        <td><h5  id="receiver_names"></h5></td>
                      </tr>
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
