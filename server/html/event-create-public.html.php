<?php
//====Load all calendars
$allCals = new C_Calendar('LOAD_PUBLIC_CALENDARS');

//====Load calendar properties
$calendarProperties = $allCals->calendarProperties;

//====Load calendars
$allCalendars = $allCals->allCalendars;

?>
<style>
    .standard {
        display: none;
    }

    .repeat-box {
        display: none;
    }
    .well {
        background: transparent;
    }
    .event-form-break {
        margin-top: 10px;
    }
    .event-create-btn-input {
        background-image: none;
    }
    .color-box {
        display: inline-block;
        border: 0 solid;
        height: 18px;
        width: 18px;
        margin-right: 15px;
        cursor: pointer;
        border-radius: 10px;
        color: #ffffff;
        line-height: 22px;
    }
    .color-box:hover{
        border: 0 solid;
    }
    .color-box:active{
        border-radius: 0;
    }

    .color-box-selected {
        border-radius: 0;
    }

    .panel {
        margin: 0;
    }

    .col-sm-4, .col-xs-6, .col-lg-6, .col-xs-12, .col-lg-12 {
        padding-left: 0;
        padding-right: 0;
    }
    button .multiple-select-option-label {
        font-size: 9px;
        border: 1px solid darkgrey;
        border-radius: 5px;
        margin-top: 0;
        display: inline-block;
        padding-top: 4px;
        padding-bottom: 4px;
        padding-left: 2px;
        padding-right: 2px;
        background-color: #ffffff;
    }

    .time-panel {
        background: none repeat scroll 0 0 #FAFAFA;
        border: 1px solid #D4D4D4;
        height: 140px;
        overflow: auto;
        position: absolute;
        width: 100px;
        z-index: 99999;
        display: none;
    }

    .time-panel-ul {
        width: 100%;
    }
    .time-panel-ul li {
        border: 1px solid #F0F0F0;
        float: none;
        list-style: none outside none;
        margin:0;
        padding: 0;
        text-align: left;
        width: 81px;
        border-right: 0;
        cursor: pointer;
        padding-left: 12px;
    }
    .time-panel-ul li:hover{
        background-color: #3A87AD;
        color: #ffffff;
    }

    .guest-view {
        border: 0px none;
        box-shadow: none;
        padding-left: 0px;
        padding-right: 0px;
    }

    .form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
        background: none repeat scroll 0% 0% transparent;
        cursor: auto;
    }

    .form-group {
        margin-bottom:0;
    }

</style>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="text-align:left;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h5 class="modal-title" id="myModalLabel"></h5>
            </div>
            <div style="margin: 2px 20px 0px 4px; float: right; display: none" id="remove-block">
                <button type="button" class="btn btn-danger btn-xs ladda-button" data-style="expand-left" data-event-id="" id="remove-link"><span class="ladda-label">Remove This Event</span></button>
            </div>
            <div style="clear: both"></div>
            <form role="form" id="eventForm" class="form-horizontal">
                <div class="modal-body" style="padding-top: 10px">
                    <fieldset>
                        <div class="panel panel-default">
                            <div class="panel-body">

                                <div class="form-group">
                                    <label for="title" class="col-sm-3 control-label">Title</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control guest-view" id="title" name="title" placeholder="Event Title" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="start-date" class="col-sm-3 control-label">Start</label>
                                    <div class="input-group col-sm-3" data-date="" data-date-format="yyyy-mm-dd" data-link-field="start" data-link-format="yyyy-mm-dd" >
                                        <input type="text" class="form-control guest-view" id="start-date-guest" name="start-date" placeholder="Start Date" />
                                    </div>
                                    <div class="col-sm-3">
                                        <input name="start-time" id="start-time" class="form-control guest-view"/>
                                    </div>
                                </div>

                                <div class="form-group" id="end-group">
                                    <label for="end" class="col-sm-3 control-label">End</label>
                                    <div class="input-group col-sm-3" data-date="" data-date-format="yyyy-mm-dd" data-link-field="end" data-link-format="yyyy-mm-dd" >
                                        <input type="text" class="form-control guest-view" placeholder="End Date" name="end-date" id="end-date-guest" />
                                    </div>
                                    <div class="col-sm-3">
                                        <input name="end-time" id="end-time" class="form-control guest-view"/>
                                    </div>
                                </div>

                                <div class="form-group" id="loc_msg">
                                    <label for="location" class="col-sm-3 control-label">Location</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control guest-view" id="location" name="location" placeholder="Location" />
                                    </div>
                                </div>

                                <div class="form-group" id="url_msg">
                                    <label for="description" class="col-sm-3 control-label">URL</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control guest-view" id="url" name="url" />
                                    </div>
                                </div>

                                <div class="form-group" id="desc_msg">
                                    <label for="description" class="col-sm-3 control-label">Description</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control guest-view" id="description" name="description" />
                                    </div>
                                </div>

                                <div class="form-group" id="allday_msg">
                                    <label for="dayAll" class="col-sm-3 control-label">&nbsp;</label>

                                    <div class="col-sm-9">
                                        <span id="dayAll" style="font-size: 12px; font-weight: bold;"></span>
                                    </div>
                                </div>

                                <div class="form-group" id="repeat_msg">
                                    <label for="repeat_type" class="col-sm-3 control-label">&nbsp;</label>

                                    <div class="col-sm-9">
                                        <span id="repeat_type" style="font-size: 12px; font-weight: bold;"></span>
                                    </div>
                                </div>
                            </div>



                        </div>

                    </fieldset>
                </div>
                <div class="modal-footer">
                    <!--<input type="hidden" value="-1" name="update-event" id="update-event" />-->
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <!--<button type="button" class="btn btn-primary" id="create-event">Create Event</button>-->
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
    var forms = document.getElementById("eventForm");
    var elements = forms.elements;
    for (var i = 0, len = elements.length; i < len; ++i) {
        elements[i].readOnly = true;
    }
</script>