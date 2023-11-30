@extends('layout.dashboard')
<link rel="stylesheet" href="/css/admin/admindashboard.css">

@section('main')
<div class="content">
    <div class="overview">
        <div class="title">
            <i class='bx bx-tachometer'></i>
            <span class="text">Dashboard</span>
        </div>
        <div class="boxes">
            <div class="box box1">
                <i class='bx bx-like'></i>
                <span class="text">Total Likes</span>
                <span class="number">50,120</span>
            </div>
            <div class="box box2">
                <i class='bx bx-comment'></i>
                <span class="text">Comments</span>
                <span class="number">20,120</span>
            </div>
            <div class="box box3">
                <i class='bx bx-share'></i>
                <span class="text">Total Share</span>
                <span class="number">10,120</span>
            </div>
        </div>
    </div>
    <div class="activity">
       
            <div class="title">
                <i class='bx bx-time'></i>
                <span class="text">Recent Activity</span>
            </div>
            <div class="activity-data">
                <div class="data names">
                    <span class="data-title">Name</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                    <span class="data-list">Subham Kafle</span>
                </div>
                <div class="data email">
                    <span class="data-title">Email</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                    <span class="data-list">subhamkafle7@gmail.com</span>
                </div>
                <div class="data joined">
                    <span class="data-title">Joined</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                    <span class="data-list">2022-02-22</span>
                </div>
                <div class="data type">
                    <span class="data-title">Type</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                    <span class="data-list">New</span>
                </div>
                <div class="data status">
                    <span class="data-title">Status</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                    <span class="data-list">Liked</span>
                </div>
            </div>
    </div>
</div>
@endsection