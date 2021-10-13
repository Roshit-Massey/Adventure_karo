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

                            <form action="#" class="custom-validation">

                                <div class="mb-4">
                                    <label class="form-label">Title <span style="color:red;">*</span></label>
                                    <div>
                                        <input type="text" class="form-control" required placeholder="Enter a title">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Infomation <span style="color:red;">*</span></label>
                                    <div>
                                        <textarea id="elm1" name="area"></textarea>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label">Description <span style="color:red;">*</span></label>
                                    <div>
                                        <textarea id="elm2" name="area"></textarea>
                                    </div>
                                </div>
                                

                                <div class="mb-0">
                                    <div>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light me-1">
                                            Add Activity
                                        </button>
                                        <!-- <button type="reset" class="btn btn-secondary waves-effect">
                                            Cancel
                                        </button> -->
                                    </div>
                                </div>
                            </form>
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
<script src="{{asset('/secondary/assets/libs/tinymce/tinymce.min.js')}}"></script>
<script src="{{asset('/secondary/assets/js/pages/form-editor.init.js')}}"></script>
@endsection