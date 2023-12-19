<div class="modal fade" id="confirm-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">You are going to increase capital in system by the below details</h5>
                <button class="close" onclick="closeModal()" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
              <div class="modal-body">
                      <table class="table table-striped">
                      <tr>
                       <td><h4>Amount: </h4></td>
                       <td><h5  id="amountH"></h5></td>
                      </tr>
                      <tr>
                        <td><h4>Description:</h4></td>
                        <td><h5  id="descriptionH"></h5></td>
                      </tr>

                      </table>

                     <div class="modal-footer">
                        <button class="btn btn-secondary btn-user float-right mb-3" onclick="closeModal()" type="button" data-dismiss="modal">Cancel</button>
                         <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>

                    </div>
                   </form>
              </div>

        </div>
    </div>
</div>
