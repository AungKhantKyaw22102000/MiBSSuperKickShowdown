@extends('users.layouts.master')

@section('title', 'Player Stats')

@section('search')
<!-- search -->
<div id="modal1" class="modal">
    <div class="modal-content">
        <form id="player-search-form" method="get">
            @csrf
            <input type="text" name="key" value="{{ request('key') }}" id="search-input" placeholder="Search">
            <button class="button" id="search-button">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>
<!-- end search -->
@endsection

@section('content')
    <!-- stats -->
    <div class="stats segments-page">
        <div class="container">
            <div class="wrappers">
                <div class="wrap-title">
                    <h4>Player Statistics</h4>
                </div>
                <div class="wrap-title-two">
                    <h6>Goals</h6>
                </div>
                <div class="wrap-content">
                    <div class="wrap-header">
                        <div class="row">
                            <div class="col s8">
                                <div class="content-left">
                                    <h6>Player</h6>
                                </div>
                            </div>
                            <div class="col s4">
                                <div class="content-right">
                                    <h6>Goals</h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href=''>
                        <div class='wrap-player bg-grey'>
                            <div class='row'>
                                <div class='col s8'>
                                    <div class='content-left'>
                                        <ul>
                                            <li></li>
                                            <li><img src='photo/"' style='width: 13px; height: 14px;'></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class='col s4'>
                                    <div class='content-right'>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="wrappers">
                <div class="wrap-title-two">
                    <h6>Assist</h6>
                </div>
                <div class="wrap-content wrap-assist">
                    <div class="wrap-header">
                        <div class="row">
                            <div class="col s8">
                                <div class="content-left">
                                    <h6>Player</h6>
                                </div>
                            </div>
                            <div class="col s4">
                                <div class="content-right">
                                    <h6>Assists</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href=''>
                        <div class='wrap-player no-bdr'>
                            <div class='row'>
                                <div class='col s8'>
                                    <div class='content-left'>
                                        <ul>
                                            <li></li>
                                            <li><img src='photo/"' style='width: 13px; height: 14px;'></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class='col s4'>
                                    <div class='content-right'>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- end stats -->
@endsection
