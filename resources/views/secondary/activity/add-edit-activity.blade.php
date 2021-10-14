@extends('secondary.layouts.master_new')
@section('title', 'Add Activity')
@section('container') 
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
    </div>
</div>
<!-- End Page-content -->
@endsection
@section('scripts')
<script> var id = "{{$id}}";</script>
<script src="/secondary/assets/libs/tinymce/tinymce.min.js"></script>
<script src="/secondary/assets/js/pages/form-editor.init.js"></script>
<script src="/secondary/js/app/add-edit-activity.js"></script>
@endsection