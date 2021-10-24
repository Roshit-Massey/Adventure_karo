@extends('secondary.layouts.master_new')
@section('title', 'Add Vendor')
@section('container') 
@section('styles')
<link href="/secondary/assets/css/cropper.min.css" rel="stylesheet" type="text/css">
@endsection
<div class="main-content" id="result">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"><i class="ion ion-md-add"></i> Add Vendor</h4>
                            <br>

                            <div class="row">
                                <div class="mb-4 col-md-4">
                                    <label class="form-label">First Name <span class="danger_color">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="first_name" placeholder="Enter a first name">
                                        <span class="danger_color" id="error-first-name"> </span>
                                    </div>
                                </div>

                                <div class="mb-4 col-md-4">
                                    <label class="form-label">Last Name <span class="danger_color">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="last_name" placeholder="Enter a last name">
                                        <span class="danger_color" id="error-last-name"> </span>
                                    </div>
                                </div>

                                <div class="mb-4 col-md-4">
                                    <label class="form-label">Email <span class="danger_color">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="email" placeholder="Enter a email">
                                        <span class="danger_color" id="error-email"> </span>
                                    </div>
                                </div>

                                <div class="mb-4 col-md-4">
                                    <label class="form-label">Phone <span class="danger_color">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" id="phone" placeholder="Enter a phone" maxlength="10" onkeypress="return isNumber(event)">
                                        <span class="danger_color" id="error-phone"> </span>
                                    </div>
                                </div>
                           
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <label class="mb-1" for="filePhoto">Profile Image <span class="danger_color">*</span></label>
                                    <div class="mb-3">
                                        <input type="file" class="filestyle custom-file-input" name="vendorimage" data-buttonname="btn-primary" id="filePhoto">
                                        <span class="danger_color" id="image-error" ></span>
                                    </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="form-group">
                                    <div id="h2-add-magazine">
                                        <img id="output" style="height: 90px;">
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-0">
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light me-1" id="add-button" onclick="addAndUpdateVendor();"> Add </button>
                                    <button type="button" class="btn btn-warning waves-effect" id="verifiedOrNot" style="display:none;" onclick="verifiedOrUnverified();"> Unverified </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->


            <div class="row" id="company_information" style="display :none;">

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title"><i class="ion ion-md-add"></i> Company Information</h4>
                        <br>

                        <div class="row">
                            <div class="mb-4 col-md-6">
                                <label class="form-label">Company Name <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="company_name" placeholder="Enter a company name">
                                    <span class="danger_color" id="error-company-name"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">Legal Company Name <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="legal_company_name" placeholder="Enter a legal company name">
                                    <span class="danger_color" id="error-legal-company-name"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">Company Website <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="company_website" placeholder="Enter a company website">
                                    <span class="danger_color" id="error-company-website"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">Contact Number <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="contact_number" placeholder="Enter a contact number" maxlength="10" onkeypress="return isNumber(event)">
                                    <span class="danger_color" id="error-contact-number"> </span>
                                </div>
                            </div>
                    
                            <div class="mb-4 col-md-6">
                                <label class="form-label">Registered Address<span class="danger_color">*</span></label>
                                <div>
                                    <textarea type="text" class="form-control"  rows="5" id="registered_address" placeholder="Enter a registered address"></textarea>
                                    <span class="danger_color" id="error-registered-address"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">Registered Address 2 (Optional) </label>
                                <div>
                                    <textarea type="text" class="form-control"  rows="5" id="registered_address_2" placeholder="Enter a registered address 2"></textarea>
                                    <input type="hidden" class="form-control" id="company_id" value="">
                                    <span class="danger_color" id="error-registered-address-2"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">Country <span class="danger_color">*</span></label>
                                <div>
                                    <select class="form-select" aria-label="Default select example" id="country_id"  onchange="states(this.value)">
                                        <option value="">Select Country</option>
                                    </select>
                                    <span class="danger_color" id="error-country-id"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">State <span class="danger_color">*</span></label>
                                <div>
                                    <select class="form-select" aria-label="Default select example" id="state_id"  onchange="city(this.value)">
                                        <option value="">Select State</option>
                                    </select>
                                    <span class="danger_color" id="error-state-id"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">City <span class="danger_color">*</span></label>
                                <div>
                                    <select class="form-select" aria-label="Default select example" id="city">
                                        <option value="">Select City</option>
                                    </select>
                                    <span class="danger_color" id="error-city"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">Postal Code <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="postal_code" placeholder="Enter a postal code" maxlength="6" onkeypress="return isNumber(event)">
                                    <span class="danger_color" id="error-postal-code"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">Bank Name <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="bank_name" placeholder="Enter a bank name">
                                    <span class="danger_color" id="error-bank-name"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">Bank A/c No. <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="acc_no" placeholder="Enter a A/c No.">
                                    <span class="danger_color" id="error-acc-no"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">A/c Holder Name <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="acc_holder_name" placeholder="Enter a A/c holder name">
                                    <span class="danger_color" id="error-acc-holder-name"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-6">
                                <label class="form-label">IFSC Code <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="ifsc" placeholder="Enter a IFSC code">
                                    <span class="danger_color" id="error-ifsc"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-12">
                                <label class="form-label">About Us (Optional)</label>
                                <div>
                                    <textarea type="text" class="form-control"  rows="5" id="hear_about_us" placeholder="Enter a about us"></textarea>
                                    <span class="danger_color" id="error-hear-about-us"> </span>
                                </div>
                            </div>

                            <div class="mb-4 col-md-12">
                                <label class="form-label">Terms & Conditions (Optional)</label>
                                <div>
                                    <textarea type="text" class="form-control"  rows="5" id="terms_condition" placeholder="Enter a terms & conditions"></textarea>
                                    <span class="danger_color" id="error-terms-condition"> </span>
                                </div>
                            </div>
                            
                        </div>

                        <div class="mb-0">
                            <div>
                                <button type="button" class="btn btn-primary waves-effect waves-light me-1" id="add-button-company" onclick="addAndUpdateVendorCompany();"> Add </button>
                                <!-- <button type="reset" class="btn btn-secondary waves-effect">
                                    Cancel
                                </button> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->

        <!--  Modal content for the above example -->
        <div class="modal fade bs-example-modal-lg" tabindex="-1" id="modal_crop"
            aria-labelledby="myLargeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Crop Profile Image</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close" onclick="cancelPopup()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">  
                                    <img class="crop_image" id="image">
                                </div>
                                <div class="col-md-4">
                                    <div class="crop_preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="cancelPopup()" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop">Crop</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div>
</div>
<!-- End Page-content -->
@endsection
@section('scripts')
<script> var id = "{{$id}}";</script>
<script src="/secondary/js/bs-custom-file-input.min.js"></script>
<script src="/secondary/js/cropper.min.js"></script>
<script src="/secondary/js/app/add-edit-vendor.js"></script>
@endsection