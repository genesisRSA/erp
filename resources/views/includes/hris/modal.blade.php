<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Message</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            Are you sure you want to sign out?
        </div>
        <div class="modal-footer">
            <a href="{{ route('logout') }}" class="btn btn-success" 
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">Yes</a>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
        </div>
    </div>
</div>

<div class="modal fade" id="settingsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form method="POST" action="{{ route('account.changepassword') }}">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Account Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}"/>
                    <div class="form-group">
                        <label>Current Password <sup class="text-danger">*</sup></label>
                        <input type="password" name="current_password" class="form-control" placeholder="Enter Current Password" required/>
                        <div class="invalid-feedback">
                            Current password is required!
                        </div>
                    </div>
                    <div class="form-group">
                        <label>New Password <sup class="text-danger">*</sup></label>
                        <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter New Password" required/>
                        <div class="invalid-feedback">
                            Password mismatch!!
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Confirm New Password <sup class="text-danger">*</sup></label>
                        <input type="password" id="cnew_password" name="cnew_password" class="form-control" placeholder="Confirm New Password" required/>
                        <div class="invalid-feedback">
                            Password mismatch!!
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>