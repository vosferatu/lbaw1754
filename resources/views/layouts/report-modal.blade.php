<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">


        <h5 class="modal-title" id="reportModalCenterTitle">Report Content</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
              <div class="form-group">
               <textarea class="form-control" rows="10" id="reason" name="reason" placeholder="Please explain the reason for your report. Moderation will act if justified."></textarea>
              </div>            
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary sendReportButton" id="sendReportButton">Send Report</button>
      </div>
    </div>
  </div>
</div>