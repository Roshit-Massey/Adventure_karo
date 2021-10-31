@extends('secondary.layouts.master_new')
@section('title', 'Add Activity')
@section('container') 
@section('styles')
<link rel="stylesheet" href="/secondary/assets/css/bootstrap1.min.css" />
<link rel="stylesheet" href="/secondary/assets/css/bootstrap-select.css" />
@endsection
<div class="main-content" id="result">
    <div class="page-content">
        <div class="container-fluid">

            <div class="row">

                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title"><i class="ion ion-md-add"></i> Add Activity Details</h4>
                            <br>

                            <div class="row mb-4">
                                <div class="col-sm-4 mb-4">
                                    <label class="col-form-label">Activities <span class="danger_color">*</span></label>
                                    <select class="form-select" id="activity">
                                        <option value="">Select Activity</option>
                                        @if(isset($activities))
                                            @foreach($activities as $activity)
                                                <option value="{{$activity->id}}">{{$activity->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="danger_color" id="error-activity"> </span>
                                </div>
                                <div class="col-sm-4 mb-4">
                                    <label class="col-form-label">Inclusives <span class="danger_color">*</span></label>
                                    <select class="form-control selectpicker" id="inclusives" multiple data-live-search="true">
                                        @if(isset($inclusives))
                                            @foreach($inclusives as $inclusive)
                                                <option value="{{$inclusive->id}}">{{$inclusive->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="danger_color" id="error-inclusives"> </span>
                                </div>
                                <div class="col-sm-4 mb-4">
                                    <label class="col-form-label">Exclusives <span class="danger_color">*</span></label>
                                    <select class="form-control selectpicker" id="exclusives" multiple data-live-search="true" >
                                        @if(isset($exclusives))
                                            @foreach($exclusives as $exclusive)
                                                <option value="{{$exclusive->id}}">{{$exclusive->title}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <span class="danger_color" id="error-exclusives"> </span>
                                </div>

                                <div class="col-sm-12 mb-4">
                                    <label class="col-form-label">Information <span class="danger_color">*</span></label>
                                    <textarea id="elm1" name="area"></textarea>
                                    <span class="danger_color" id="error-info"> </span>
                                </div>

                                <div class="col-sm-4 mb-4">
                                    <label class="col-form-label">Days <span class="danger_color">*</span></label>
                                    <div class="weekDays-selector">
                                        <input type="checkbox" id="weekday-mon" class="weekday" value="Mon" />
                                        <label for="weekday-mon">Mon</label>
                                        <input type="checkbox" id="weekday-tue" class="weekday" value="Tue" />
                                        <label for="weekday-tue">Tue</label>
                                        <input type="checkbox" id="weekday-wed" class="weekday" value="Wed" />
                                        <label for="weekday-wed">Wed</label>
                                        <input type="checkbox" id="weekday-thu" class="weekday" value="Thu" />
                                        <label for="weekday-thu">Thu</label>
                                        <input type="checkbox" id="weekday-fri" class="weekday" value="Fri" />
                                        <label for="weekday-fri">Fri</label>
                                        <input type="checkbox" id="weekday-sat" class="weekday" value="Sat" />
                                        <label for="weekday-sat">Sat</label>
                                        <input type="checkbox" id="weekday-sun" class="weekday" value="Sun" />
                                        <label for="weekday-sun">Sun</label>
                                    </div>
                                    <span class="danger_color" id="error-days"> </span>
                                </div>

                                <div class="col-sm-4 mb-4">
                                    <label class="col-form-label">Start Time <span class="danger_color">*</span></label>
                                    <input type="time" id="start-time" class="form-control">
                                    <span class="danger_color" id="error-start-time"> </span>
                                </div>

                                <div class="col-sm-4 mb-4">
                                    <label class="col-form-label">End Time <span class="danger_color">*</span></label>
                                    <input type="time" id="end-time" class="form-control">
                                    <span class="danger_color" id="error-end-time"> </span>
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
    </div>
</div>
<!-- End Page-content -->
@endsection
@section('scripts')
<script> var id = "{{$id}}";</script>
<script src="/secondary/assets/libs/tinymce/tinymce.min.js"></script>
<script src="/secondary/assets/js/pages/form-editor.init.js"></script>
<script src="/secondary/assets/js/bootstrap.bundle.min.js"></script>
<script src="/secondary/assets/js/bootstrap-select.min.js"></script>
<script src="/secondary/js/vapp/add-edit-activity.js"></script>
@endsection