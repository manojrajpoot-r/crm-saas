<div class="modal fade" style="" id="globalModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="universalForm" method="POST" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="modalTitle">Modal Title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="modalBody">
          <!-- Form fields dynamically added here -->
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary" id="formSubmitBtn">Save</button>
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



<div class="modal fade" id="openModalBody" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Comments</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" id="commentsModalBody">
                <div class="text-center text-muted">
                    Loading comments...
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
    </div>
</div>
