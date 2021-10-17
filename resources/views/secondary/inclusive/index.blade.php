@extends('secondary.layouts.master_new')
@section('title', 'Add Inclusive')
@section('container') 
@section('styles')
<link rel="stylesheet" type="text/css" href="/secondary/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link href="/secondary/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"  type="text/css">
@endsection
<div class="main-content" id="result">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"><i class="ion ion-md-add"></i> <b id="add-edit-text">Add Inclusive</b></h4>
                            <br>


                            <div class="mb-4">
                                <label class="form-label">Title <span class="danger_color">*</span></label>
                                <div>
                                    <input type="text" class="form-control" id="title" placeholder="Enter a title">
                                    <span class="danger_color" id="error-title"> </span>
                                </div>
                            </div>
                            <div class="mb-0">
                                <div>
                                    <button type="button" class="btn btn-primary waves-effect waves-light me-1" id="add-button" onclick="addInclusive();"> Add </button>
                                    <button type="button" class="btn btn-secondary waves-effect" onclick="clearInclusiveFields();" id="cancel-button" style="display:none;"> Cancel </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- end col -->
                <div class="col-7">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">All Inclusives</h4>
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Title</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
</div>
<!-- End Page-content -->
@endsection
@section('scripts')
<script src="/secondary/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/secondary/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/secondary/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="/secondary/js/app/add-list-inclusives.js"></script>
@endsection