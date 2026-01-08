@extends('saas.layouts.app')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="card shadow">
                <div class="card-header text-center">
                    <h4>Two Factor Authentication</h4>
                </div>

                <div class="card-body">

                    <div class="text-center mb-3">
                        <button class="btn btn-primary btn-sm" id="sendOtp">
                            Send OTP
                        </button>
                    </div>

                    <div class="form-group">
                        <label>Enter OTP</label>
                        <input type="text" id="otp" class="form-control" placeholder="6 digit OTP">
                    </div>

                    <button class="btn btn-success w-100 mt-3" id="verifyOtp">
                        Verify OTP
                    </button>

                    <hr>

                    <div class="form-group mt-3">
                        <label>Recovery Code</label>
                        <input type="text" id="recovery" class="form-control" placeholder="Use recovery code">
                    </div>

                    <button class="btn btn-warning w-100 mt-2" id="verifyRecovery">
                        Verify Recovery Code
                    </button>

                </div>
            </div>

        </div>
    </div>
</div>



