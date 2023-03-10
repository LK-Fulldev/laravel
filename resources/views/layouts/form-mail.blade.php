<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div id="loadingError" style="display:none;">
                <div class="modal-body text-center mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor"
                        class="bi bi-exclamation-circle-fill" viewBox="0 0 16 16" style="color: #efab57;">
                        <path
                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                    </svg>
                    <p style="font-size: 22px;line-height: 2.2;color: #efab57;font-weight: 600;margin-bottom: -0.5rem;">
                        Failed to sending</p>
                    <p style="color: #373737;">Please try again later.</p>
                    <button type="button" onclick="window.location.reload();" class="btn btn-secondary"
                        data-dismiss="modal">Cloes</button>
                </div>
            </div>
            <div id="loadingComplete" style="display:none;">
                <div class="modal-body text-center mt-4">
                    <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor"
                        class="bi bi-check-circle" viewBox="0 0 16 16" style="color: #6bd098; ">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                        <path
                            d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z" />
                    </svg>
                    <div style="font-size: 22px;line-height: 2.2;color: #6bd098; font-weight: 600; ">Completed</div>
                    <button type="button" onClick="window.location.reload();" class="btn btn-success"
                        data-dismiss="modal">Cloes</button>
                </div>
            </div>
            <div id="loadingData" style="display: none;">
                <div class="modal-content">
                    <div class="modal-body text-center">
                        <div class="loading-spinner mb-2"></div>
                        <div>Loading</div>
                    </div>
                </div>
            </div>
            <div id="defaultContent">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirme Sending</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you like to send this email ?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-primary" id="ButtonConfirmeSending">Yes</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-user">
            <div class="card-header">
                <h5 class="card-title">Mail Sending</h5>
            </div>
            <hr>
            <div class="card-body">
                <form id="multipleMailSend">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label>To</label>
                                <input type="text" name="email" id="email" data-role="tagsinput"
                                    class="form-control" placeholder="example@gamil.com" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 pr-1">
                            <div class="form-group">
                                <label>Subject</label>
                                <input type="text" name="subject" id="subject" class="form-control"
                                    placeholder="subject.." required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-11">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" id="description" placeholder="description.." required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="update ml-auto mr-auto">
                            <button type="submit" id="confimreHidden" class="btn btn-primary btn-round">Send <i
                                    class="nc-icon nc-send"></i></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
