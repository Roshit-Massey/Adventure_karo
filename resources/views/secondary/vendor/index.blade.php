@extends('secondary.layouts.master_new')
@section('title', 'All Vendors')
@section('container') 
@section('styles')
<link rel="stylesheet" type="text/css" href="/secondary/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
<link href="/secondary/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet"  type="text/css">
@endsection
<div class="main-content" id="result">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">All Vendors</h4>
                            <table id="datatable" class="table table-bordered dt-responsive"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">

                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Profile Image</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Verified</th>
                                        <th>Created At</th>
                                        <th>Updated At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                </tbody>
                            </table>

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
<script src="/secondary/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="/secondary/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="/secondary/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
<script src="/secondary/js/app/list-vendor.js"></script>
@endsection