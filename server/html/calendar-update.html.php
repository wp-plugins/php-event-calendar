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

    .cal-color-box:hover {
        border: 0 solid;
    }

    .cal-color-box:active {
        border-radius: 0;
    }

    .color-box-selected {
        border-radius: 0;
    }

    .list-group-item-manage {
        position: relative;
        display: block;
        padding: 10px 15px;
        margin-bottom: -1px;
        background-color: #ffffff;
        border: 1px solid #dddddd;
    }

    .public {
        cursor: pointer;
        width: 100px;
        /*border-radius: 0px 5px 5px 0px;*/
        text-align: center;
        float: right;
        color: #FFFFFF;
    }

    .editCal {
        width: 50px;
        cursor: pointer;
        text-align: center;
        float: right;
        color: #FFFFFF;
    }

    .deleteCal {
        width: 60px;
        cursor: pointer;
        text-align: center;
        float: right;
        color: #FFFFFF;
    }

    .exportCal {
        width: 60px;
        cursor: pointer;
        text-align: center;
        float: right;
        color: #FFFFFF;
    }

    .cactionss div {
        margin-right: 3px;
    }

    #shareCalendar {
        margin-top: 10px;
    }

</style>
<div class="modal fade" id="myModalCalendarManage" tabindex="-1" role="dialog"
     aria-labelledby="myModalCalendarManageLabel" aria-hidden="true" style="text-align:left;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h3 class="modal-title" id="myModalCalendarManageLabel">Manage Calendar
                    <div style="float: right; margin-right: 15px;" id="gcal-block">
                        <!-- <button type="button" class="btn btn-default btn-xs" id="gcal-back-link" style="display: none">Back</button>&nbsp;<button type="button" class="btn btn-success btn-xs" id="gcal-add-link">Add Google Calendar Instead</button>&nbsp;<a href="http://screencast.com/t/WOpM2ohE" target="_new"><span style="font-size: 10px">How To?</span></a> -->
                    </div>
                </h3>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" role="form" id="myModalCalendarManageFrom">
                    <div class="list-group" id="calManagerHolder">

                        <?php if ($allCalendars != NULL) foreach ($allCalendars as $k => $v) { ?>
                            <?php
                            $public = ($v['public'] == 1) ? 'Make Private' : 'Make Public';
                            $val = ($v['public'] == 1) ? '0' : '1';
                            $color = ($v['public'] == 1) ? '#ffffff' : '#f3f3f3';
                            $txtcolor = ($v['public'] == 1) ? '#000000' : '#ffffff';
                            $icon = ($v['public'] == 1) ? 'glyphicon glyphicon-globe' : '';
                            ?>
                            <?php $exportStyle= ($v['type'] == 'url')? "style='display:none' " : "";?>
                            <div class="list-group-item-manage ladda-button" data-style="expand-left"
                                 style="background-color: <?php echo $color ?>; color:#787878;"
                                 id="calManager_<?php echo $v['id'] ?>">

                                <span class="cname"><?php echo $v['name'] ?></span>

                                <div class="cactionss" style="float: right;">
                                    <div class="editCal btn-xs btn-warning" data-type="<?php echo $v['type'] ?>"
                                         data-desc="<?php echo $v['description'] ?>" data-name="<?php echo $v['name'] ?>"
                                         data-clr="<?php echo $v['color'] ?>"
                                         data-privacy="<?php echo $v['public'] ?>"> Edit
                                    </div>
                                    <div class="deleteCal btn-xs btn-danger"> Delete</div>
                                    <div type="button" data-vid="<?php echo $v['id'] ?>"
                                         data-val="<?php echo $val ?>" class="public ladda-button btn-success btn-xs"
                                         data-style="expand-right"><span class="ladda-label"
                                                                         style="color: <?php echo $txtcolor ?>"><?php echo $public ?></span>
                                    </div>
                                    <div class="exportCal btn-xs btn-primary" data-vid="<?php echo $v['id'] ?>" <?php echo $exportStyle;?> > Export</div>
                                </div>
                                <span class="<?php echo $icon ?> share-icon" style="cursor: pointer;"
                                      title="Share this Calendar"></span>


                                <div id="shareCalendar">
                                    <!-- shareForm and editForm appear here -->
                                </div>

                            </div>
                        <?php } ?>
                        <!-- Public Calendar Share Form -->
                        <div id="shareForm">
                            <form class="share-form">
                                <input class="form-control" style="margin-bottom: 3px; margin-top: 5px;"
                                       type="text" name="link" id="link"
                                       value=""
                                       placeholder="Share Link" readonly>
                                <input class='form-control' style="margin-bottom: 3px;" type='email' id="email"
                                       name='email' placeholder='E-mail' required="required">
                                <textarea placeholder='Comment' id="message" style="margin-bottom: 3px;"
                                          class='form-control' name="comment"></textarea>

                                <button class='btn btn-primary btn-xs share-btn ladda-button' type="button"
                                        id="sendEmail" data-style="expand-left"><span class="ladda-label">Send</span>
                                </button>
                            </form>
                        </div>
                        <!-- Calendar Edit Form --->
                        <div id="calEditForm" style="background: none repeat scroll 0% 0% white; padding: 20px;">
                            <form class="form-horizontal" role="form" id="myModalCalendarEditFrom">
                                <div class="form-group" id="form-name">
                                    <label for="calName" class="col-sm-2 control-label"
                                           style="font-weight: normal; padding-right: 0px;">Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" id="calName" name="calName"
                                               placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group" id="cal-edit-desc-group">
                                    <label for="description" class="col-sm-2 control-label"
                                           style="font-weight: normal; padding-right: 0px;">Description</label>

                                    <div class="col-sm-10">
                                        <textarea name="description" id="calDescription"
                                                  style="width: 100%; padding:3px; color:#989898"></textarea>
                                    </div>
                                </div>
                                <div class="form-group" id="gcal-edit-desc-group" style="">
                                    <label for="gcal-description" class="col-sm-2 control-label"
                                           style="font-weight: normal; padding-right: 0px;">URL</label>

                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="description" id="gcalDescription"
                                               placeholder="Google Calendar URL"/>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cal-color" class="col-sm-2 control-label"
                                           style="font-weight: normal; padding-right: 0px;">Color</label>

                                    <div class="col-sm-10 colorBank" style="margin-top: 8px;">
                                        <span style="background-color: #3a87ad" id="clr_3a87ad" class="cal-color-box"
                                              data-color="#3a87ad">&nbsp;</span>
                                        <span style="background-color: #eaff00" id="clr_eaff00" class="cal-color-box"
                                              data-color="#eaff00">&nbsp;</span>
                                        <span style="background-color: #f903a5" id="clr_f903a5" class="cal-color-box"
                                              data-color="#f903a5">&nbsp;</span>
                                        <span style="background-color: #1a9b05" id="clr_1a9b05" class="cal-color-box"
                                              data-color="#1a9b05">&nbsp;</span>
                                        <span style="background-color: #0c2ddd" id="clr_0c2ddd" class="cal-color-box"
                                              data-color="#0c2ddd">&nbsp;</span>
                                        <span style="background-color: #ff4206" id="clr_ff4206" class="cal-color-box"
                                              data-color="#ff4206">&nbsp;</span>
                                        <span style="background-color: #17cccc" id="clr_17cccc" class="cal-color-box"
                                              data-color="#17cccc">&nbsp;</span>
                                        <span style="background-color: #0a0003" id="clr_0a0003" class="cal-color-box"
                                              data-color="#0a0003">&nbsp;</span>
                                        <span style="background-color: #a8a8a8" id="clr_a8a8a8" class="cal-color-box"
                                              data-color="#a8a8a8">&nbsp;</span>
                                    </div>
                                    <input type="hidden" name="color" id="cal-color" value=""/>
                                    <input type="hidden" name="color" id="cal-id" value=""/>
                                </div>
                                <div class="form-group">
                                    <label for="privacy" class="col-sm-2 control-label"
                                           style="font-weight: normal; padding-right: 0px;">Privacy</label>

                                    <div class="col-sm-10" style="margin-top: 8px;">
                                        <input type="radio" name="privacy" value="public" class="cal-public"><label
                                            for="public">&nbsp;Public</label>
                                        <input type="radio" name="privacy" value="private" class="cal-private"><label
                                            for="private">&nbsp;Private</label>
                                    </div>
                                </div>
                                <input type="hidden" name="update-calendar" id="update-calendar" value="0"/>
                                <input type="hidden" name="type" id="type" value="user"/>
                                <input type="hidden" name="create-update-calendar" id="create-update-calendar"
                                       value="1"/>
                                <button type="button" class="btn btn-primary ladda-button btn-xs"
                                        data-style="expand-right" id="updateCalendar">Update Calendar
                                </button>
                            </form>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div><!-- /.modal -->