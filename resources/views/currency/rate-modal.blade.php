<div class="modal fade" id="rate-modal" tabindex="-1" role="dialog" aria-labelledby="deleteModalExample"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalExample">Change Exchange rate</h5>
                <button class="close" onclick="closeModal()" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
              <div class="modal-body">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="hidden" name="id_2" value="" id="id">
                    
                    <span style="color:red;">*</span>Exchange Rate Buying</label>
                     <input type="input" value="" name="currency_buying_rate"  id="rate_buying">
                     <span style="color:red;" >*</span>Exchange Rate Selling</label>
                     <input type="input" name="currency_selling_rate" value="{{$currency->currency_selling_rate}}" id="rate_selling">
                     <div class="modal-footer">
                     <button class="btn btn-secondary" onclick="closeModal()" type="button" data-dismiss="modal">Cancel</button>
                     <button type="submit" class="btn btn-success btn-user float-right mb-3">Save</button>

              </div>
            </div>

        </div>
    </div>
</div>
