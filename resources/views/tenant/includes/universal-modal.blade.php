<div class="modal fade" id="globalModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog modal-md modal-dialog-centered">
    <div class="modal-content">

      <form id="universalForm" method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Modal Title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body" id="modalBody">
          <div id="profilePreview" class="mt-2 text-center"></div>
        </div>

        <div class="modal-footer">
          <button type="submit" id="formSubmitBtn" class="btn btn-primary">
                <span class="btn-text">Save</span>
                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>

          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>

      </form>

    </div>
  </div>
</div>



<div class="modal fade" id="globalStatusModal"  tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">>
      <div class="modal-dialog">
    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Status</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <select class="form-select" id="globalStatusSelect"></select>
            </div>
                 <div class="modal-body">
                <div  id="global_dyanmic_data"></div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary" id="globalStatusSave">Save</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="commonDetailsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="commonModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="commonModalBody"></div>
        </div>
    </div>
</div>



