<?php require_once 'controller.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="assets/bootstrap.min.css">
    <link rel="stylesheet" href="assets/app.style.css">
    <script type="text/javascript" src="assets/jquery-3.1.0.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/app.js"></script>
<!--    <script type="application/javascript" src="assets/angular.min.js"></script>-->
</head>
<body ng-app="cloudflare-app">
<div class="container wrapper">
    <div class="row">
        <div class="col-lg-12 header">
            <div class="col-lg-6">
                <h1>Cloudflare Bulk IP Changer</h1>
            </div>
            <div class="col-lg-6 text-right menu">
                <button type="button" onclick="showDomainsList()" class="btn btn-warning">List All Domains</button>
                <button type="button" onclick="showReplaceTool()" class="btn btn-primary">Replace Toolbox</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="text-center main" id="replace-tool">
            <h4>
                Fill the form below with the IP addresses you wish to replace to proceed.
        </h4><br>
            <form >
            <div class="form-group input-box">
                <input class="form-control" id="originalIP" placeholder="SEARCH FOR">
            </div>
            <div class="form-group input-box">
                <input class="form-control" id="newIP" placeholder="REPLACE WITH">
            </div>
                <div class="form-group input-box">
                    <button class="btn btn-block btn-primary" type="button" onclick="dryRun()">Search and Replace</button>
                </div>
            </form>
        </div>
        <div id="domains-list" style="display:none">
            <table class="table table-striped">
                <tr>
                    <th>Domains</th>
                </tr>
                <?php
                    foreach ($cloudflare->getZones() as $zone) {
                        echo '<tr><td>'. $zone->name .'</td></tr>';
                    }
                ?>
            </table>
        </div>
    </div>
    <div class="footer">
        2016-2017 (C) <a href="http://hazaveh.net">Mahdi Hazaveh</a> 
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Please Confirm Changes.</h4>
            </div>
            <div class="modal-body" style="overflow-y: scroll; height: 700px;">
                <table class="table table-stripped" id="data-list">
                    <tr>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Current IP</th>
                        <th>New IP</th>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="doReplace()">Save changes</button>
            </div>
        </div>
    </div>
</div>
<div class="loading" id="loading" style="display: none">Loading&#8230;</div>
</body>
</html>
