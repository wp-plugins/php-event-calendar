<?php
/**
 * Created by PhpStorm.
 * User: highpitch1204
 * Date: 9/8/14
 * Time: 1:54 PM
 */
?>
<style>
    .pec-addon {
        display: inline-block;
        margin-right: 10px;
        overflow: hidden;
        padding: 5px 20px 20px 0;
        vertical-align: top;
        width: 300px;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
        box-sizing: border-box;
    }

    .pec-addon .thumb img {
        width: 100%;
        max-width: 300px;
        max-width: 100%;
    }

    .pec-addon h4 {
        padding-top: 10px;
        font-size: 1.17em;
    }

    .pec-addon h4 a {
        text-decoration: none;
    }

    .addon-grid{
        width: 100%;
    }

    .caption{
        min-height: 120px;
        max-height: 250px;
    }

    .category-title {
        display       : block;
        clear         : both;
        margin-bottom : 10px;
    }

    .pec-addon.featured {
        width: 100%;
        margin: 20px 0 10px;
        padding: 0 0 0px 330px;
        border-bottom: 1px solid #dfdfdf;
        overflow: hidden;
        background:#F9F9F9;
        border:1px solid lightgrey;
    }

    .pec-addon.featured h4 {
        font-size: 20px;
        margin: 0;
        line-height: 1.4;
    }

    .pec-addon.featured .thumb {
        width: 400px;
        float: left;
        margin-left: -330px;
    }

    .pec-addon.featured .caption{
        padding: 0px 10px 0px 90px;
        font-size: larger;
    }

    .pec-addon.featured .description {
        max-width: 600px;
    }

    .pec-addon.featured .button.button-primary{
        font-size:16pt;
        padding-top:10px;
        height:50px
    }

</style>
<h2><img class="pec-logo" src="<?php echo plugins_url( 'images/pec-logo.png',  __FILE__ ) ?>" /> Premium Add-Ons</h2>

<div class="addon-grid">

    <div class="pec-addon featured pec-clearfix">
        <div class="thumb">
            <a href="http://phpeventcalendar.com/50-off-limited-time-offer-complete-add-on-bundle/"><img src="<?php echo plugins_url( 'images/addon-all.jpg',  __FILE__ ) ?>"></a>
        </div>
        <div class="caption">
            <h4><a href="http://phpeventcalendar.com/50-off-limited-time-offer-complete-add-on-bundle/"><span style="color:red">Introductory offer!</span> Save 50% on Complete Add-Ons Bundle!</a></h4>

            <div class="description">
                <p></p><p>All 6 Premium add-ons including recurring events, multiple user calendars, email reminder, agenda view, overlap/double-booking prevention, and event synchronizing; free update; and priority support.<br /><br /> </p>
                <p></p>
            </div>
            <div class="meta">
            </div>
            <a class="button button-primary" href="http://phpeventcalendar.com/50-off-limited-time-offer-complete-add-on-bundle/">Get Complete Add-on Bundle!</a>
        </div>
    </div>

    <div class="pec-addon">
        <div class="thumb">
            <a href="http://phpeventcalendar.com/recurring-events-add-on/"><img src="<?php echo plugins_url( 'images/addon-recurring-events.jpg',  __FILE__ ) ?>"></a>
        </div>
        <div class="caption" >
            <h4><a href="http://phpeventcalendar.com/recurring-events-add-on/">Recurring Events</a></h4>

            <div class="description">
                <p></p><p>Fully customizable daily, weekly, monthly repeating events.</p>
                <p></p>
            </div>
            <div class="meta">
            </div>
            <a class="button button-primary" href="http://phpeventcalendar.com/recurring-events-add-on/">Get This Add-on</a>
        </div>
    </div>



    <div class="pec-addon">
        <div class="thumb">
            <a href="http://phpeventcalendar.com/multiple-calendars-add/"><img src="<?php echo plugins_url( 'images/addon-multiple-calendars.jpg',  __FILE__ ) ?>"></a>
        </div>
        <div class="caption" >
            <h4><a href="http://phpeventcalendar.com/multiple-calendars-add/">Multiple Calendars</a></h4>

            <div class="description">
                <p></p><p>Multiple calendars with different colors, toggled with one click. You can have a calendar for each user in your organization.</p>
                <p></p>
            </div>
            <div class="meta">
            </div>
            <a class="button button-primary" href="http://phpeventcalendar.com/multiple-calendars-add/">Get This Add-on</a>
        </div>
    </div>



    <div class="pec-addon">
        <div class="thumb">
            <a href="http://phpeventcalendar.com/overlapdouble-booking-prevention-add/"><img src="<?php echo plugins_url( 'images/addon-doublebook.jpg',  __FILE__ ) ?>"></a>
        </div>
        <div class="caption" >
            <h4><a href="http://phpeventcalendar.com/overlapdouble-booking-prevention-add/">Overlap/Double-booking Prevention</a></h4>

            <div class="description">
                <p></p><p>Automatically checks your calendars and prevents overlap/double booking when submit an event.</p>
                <p></p>
            </div>
            <div class="meta">
            </div>
            <a class="button button-primary" href="http://phpeventcalendar.com/overlapdouble-booking-prevention-add/">Get This Add-on</a>
        </div>
    </div>


    <div class="pec-addon">
        <div class="thumb">
            <a href="http://phpeventcalendar.com/event-agenda-view-add/"><img src="<?php echo plugins_url( 'images/addon-agenda-view.jpg',  __FILE__ ) ?>"></a>
        </div>
        <div class="caption" >
            <h4><a href="http://phpeventcalendar.com/event-agenda-view-add/">Event Agenda View</a></h4>

            <div class="description">
                <p></p><p>A quick glance at your calendar with a list of upcoming appointments, all-day and multiple day events.</p>
                <p></p>
            </div>
            <div class="meta">
            </div>
            <a class="button button-primary" href="http://phpeventcalendar.com/event-agenda-view-add/">Get This Add-on</a>
        </div>
    </div>

    <div class="pec-addon">
        <div class="thumb">
            <a href="http://phpeventcalendar.com/emailpopup-reminder-add/"><img src="<?php echo plugins_url( 'images/addon-email-reminder.jpg',  __FILE__ ) ?>"></a>
        </div>
        <div class="caption" >
            <h4><a href="http://phpeventcalendar.com/emailpopup-reminder-add/">Email Reminder</a></h4>

            <div class="description">
                <p></p><p>Automatically send out email reminders to any events.</p>
                <p></p>
            </div>
            <div class="meta">
            </div>
            <a class="button button-primary" href="http://phpeventcalendar.com/emailpopup-reminder-add/">Get This Add-on</a>
        </div>
    </div>

    <div class="pec-addon">
        <div class="thumb">
            <a href="http://phpeventcalendar.com/subscribe-calendar-add/"><img src="<?php echo plugins_url( 'images/addon-event-sync.jpg',  __FILE__ ) ?>"></a>
        </div>
        <div class="caption" >
            <h4><a href="http://phpeventcalendar.com/subscribe-calendar-add/">Subscribe & Synchronize Events</a></h4>

            <div class="description">
                <p></p><p>With this premium add-on, no longer you need to manually enter events from another calendar application. Simply subscribe to public calendars such as Google Calendar. </p>
                <p></p>
            </div>
            <div class="meta">
            </div>
            <a class="button button-primary" href="http://phpeventcalendar.com/subscribe-calendar-add/">Get This Add-on</a>
        </div>
    </div>

</div>