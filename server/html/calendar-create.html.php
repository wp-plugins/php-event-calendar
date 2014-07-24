<style>
    .cal-color-box {
        display: inline-block;
        border: 0 solid;
        height: 18px;
        width: 18px;
        margin-right: 16px;
        cursor: pointer;
        border-radius: 10px;
        color: #ffffff;
        line-height: 22px;
    }
    .cal-color-box:hover{
        border: 0 solid;
    }
    .cal-color-box:active{
        border-radius: 0;
    }
    .color-box-selected {
        border-radius: 0;
    }

</style>
<div class="modal fade" id="myModalCalendarCreate" tabindex="-1" role="dialog" aria-labelledby="myModalCalendarCreateLabel" aria-hidden="true" style="text-align:left;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalCalendarCreateLabel">New Calendar
                    <div style="float: right; margin-right: 15px;" id="gcal-block">
                        <button type="button" class="btn btn-default btn-xs" id="gcal-back-link" style="display: none">Back</button>&nbsp;<button type="button" class="btn btn-success btn-xs" id="gcal-add-link">Add Google Calendar Instead</button>&nbsp;<a href="http://screencast.com/t/WOpM2ohE" target="_new"><span style="font-size: 10px">How To?</span></a>
                    </div>
                </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="myModalCalendarCreateFrom">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="form-group" id="cal-add-desc-group">
                        <label for="description" class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10">
                            <textarea name="description" id="cal-description" style="width: 100%"></textarea>
                        </div>
                    </div>
                    <div class="form-group"  id="gcal-add-desc-group" style="display: none">
                        <label for="gcal-description" class="col-sm-2 control-label">URL</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="description" id="gcal-description" placeholder="Google Calendar URL" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="cal-color" class="col-sm-2 control-label">Color</label>
                        <div class="col-sm-10" style="margin-top: 8px;">
                            <span style="background-color: #3a87ad" class="cal-color-box color-box-selected" data-color="#3a87ad">&nbsp;✔</span>
                            <span style="background-color: #eaff00" class="cal-color-box" data-color="#eaff00">&nbsp;</span>
                            <span style="background-color: #f903a5" class="cal-color-box" data-color="#f903a5">&nbsp;</span>
                            <span style="background-color: #1a9b05" class="cal-color-box" data-color="#1a9b05">&nbsp;</span>
                            <span style="background-color: #0c2ddd" class="cal-color-box" data-color="#0c2ddd">&nbsp;</span>
                            <span style="background-color: #ff4206" class="cal-color-box" data-color="#ff4206">&nbsp;</span>
                            <span style="background-color: #17cccc" class="cal-color-box" data-color="#17cccc">&nbsp;</span>
                            <span style="background-color: #0a0003" class="cal-color-box" data-color="#0a0003">&nbsp;</span>
                            <span style="background-color: #a8a8a8" class="cal-color-box" data-color="#a8a8a8">&nbsp;</span>
                        </div>
                        <input type="hidden" name="color" id="cal-color" value="#3a87ad" />
                    </div>
                    <input type="hidden" name="update-calendar" id="update-calendar" value="0" />
                    <input type="hidden" name="type" id="type" value="user" />
                    <input type="hidden" name="create-update-calendar" id="create-update-calendar" value="1" />
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="create-calendar">Create Calendar</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->