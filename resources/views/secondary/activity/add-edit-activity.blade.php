@extends('secondary.layouts.master_new')
@section('title', 'Add Activity')
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

                            <h4 class="card-title"><i class="ion ion-md-add"></i> Add Activity</h4>
                            <br>


                            <div class="mb-4">
                                <label class="form-label">Title <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="title" placeholder="Enter a title">
                                    <span class="danger_color" id="error-title"> </span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Infomation <span class="danger_color">*</span></label>
                                <div>
                                    <textarea id="elm1" name="area"></textarea>
                                    <span class="danger_color" id="error-info"> </span>
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Details <span class="danger_color">*</span></label>
                                <div>
                                    <textarea id="elm2" name="area"></textarea>
                                    <span class="danger_color" id="error-details"> </span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="form-group">
                                    <label class="mb-1" for="filePhoto">Activity Images <span class="danger_color">*</span></label>
                                    <div class="mb-3">
                                        <input type="file" class="filestyle custom-file-input" name="activityimage" multiple data-buttonname="btn-primary" id="filePhoto">
                                        <span class="danger_color" id="image-error" ></span>
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="form-group">
                                    <div id="h2-add-magazine">
                                        <img id="output" style="height: 90px;">
                                    </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4" id="activity_images">
                                
                            </div>

                            <div class="mb-0">
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light me-1" id="add-button" onclick="addAndUpdateActivity();"> Add </button>
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
                        <h5 class="modal-title mt-0" id="myLargeModalLabel">Crop Activity Image</h5>
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
<script src="/secondary/assets/libs/tinymce/tinymce.min.js"></script>
<script src="/secondary/assets/js/pages/form-editor.init.js"></script>
<script src="/secondary/js/bs-custom-file-input.min.js"></script>
<script src="/secondary/js/cropper.min.js"></script>
<script src="/secondary/js/app/add-edit-activity.js"></script>
@endsection