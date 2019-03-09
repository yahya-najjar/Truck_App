
!function($) {
    "use strict";

    var CalendarApp = function() {
        this.$body = $("body")
        this.$calendar = $('#calendar'),
        this.$event = ('#calendar-events div.calendar-events'),
        this.$categoryForm = $('#add-new-event form'),
        this.$extEvents = $('#calendar-events'),
        this.$modal = $('#my-event'),
        this.$saveCategoryBtn = $('.save-category'),
        this.$calendarObj = null
    };


    /* on drop */
    CalendarApp.prototype.onDrop = function (eventObj, date) { 
        var $this = this;
            // retrieve the dropped element's stored Event Object
            var originalEventObject = eventObj.data('eventObject');
            var $categoryClass = eventObj.attr('data-class');
            // we need to copy it, so that multiple events don't have a reference to the same object
            var copiedEventObject = $.extend({}, originalEventObject);
            // assign it the date that was reported
            copiedEventObject.start = date;
            if ($categoryClass)
                copiedEventObject['className'] = [$categoryClass];
                // copiedEventObject['color'] = ["#f2653a"];
            // render the event on the calendar
            $this.$calendar.fullCalendar('renderEvent', copiedEventObject, true);
            // is the "remove after drop" checkbox checked?
            console.log('drop');
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                eventObj.remove();
            }
    },
    /* on click on event */
    CalendarApp.prototype.onEventClick =  function (calEvent, jsEvent, view) {
        var $this = this;
            var form = $("<form></form>");
            form.append("<label>Change event name</label>");
            form.append("<div class='input-group'><input class='form-control' type=text value='" + calEvent.title + "' /><span class='input-group-btn'><button type='submit' class='btn btn-success waves-effect waves-light'><i class='fa fa-check'></i> Save</button></span></div>");
            $this.$modal.modal({
                backdrop: 'static'
            });
            $this.$modal.find('.delete-event').show().end().find('.save-event').hide().end().find('.modal-body').empty().prepend(form).end().find('.delete-event').unbind('click').click(function () {
                $this.$calendarObj.fullCalendar('removeEvents', function (ev) {
                    return (ev._id == calEvent._id);
                });
                deleteShift(calEvent);
                $this.$modal.modal('hide');
            });
            $this.$modal.find('form').on('submit', function () {
                calEvent.title = form.find("input[type=text]").val();
                $this.$calendarObj.fullCalendar('updateEvent', calEvent);
                $this.$modal.modal('hide');
                return false;
            });
    },
    CalendarApp.prototype.onResize = function (event, end, allDay) {
        var $period = {};
        $period['truck_id'] = event.truck_id;
        $period['driver_id'] = event.driver_id;
        $period['start_time'] = $.fullCalendar.moment(event.start).format('YYYY-MM-DD HH:mm:ss');
        $period['end_time'] = $.fullCalendar.moment(event.end).format('YYYY-MM-DD HH:mm:ss');
        update_user_working_hours($period);
        // updateShift()
    },
    /* on select */
    CalendarApp.prototype.onSelect = function (start, end, allDay) {
        var $this = this;
            $this.$modal.modal({
                backdrop: 'static'
            });


                    var form = $("<form></form>");
                    form.append("<div class='row'></div>");
                    form.find(".row")
                    .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Admin Note</label><input class='form-control' placeholder='Insert Your Note' type='text' name='title'/></div></div>")
                    .append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Driver</label><select class='form-control' name='category'></select></div></div>");
                    var html = get_drivers(form);
                    $this.$modal.find('.delete-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                        form.submit();
                    });
                    $this.$modal.find('form').on('submit', function () {
                        var title = "Driver Name : " + form.find("select[name='category'] option:checked").text() + "   | Admin Note : " + form.find("input[name='title']").val();
                        var note = form.find("input[name='title']").val();
                        var beginning = form.find("input[name='beginning']").val();
                        var ending = form.find("input[name='ending']").val();
                        var categoryClass = form.find("select[name='category'] option:checked").val();
                        var driver_id = form.find("select[name='category'] option:checked").val();
                        var truck_id = $('#truck_id').val();
                        if (drivers.includes(categoryClass)) {
                            alert('You Cannot add 2 shifts for the same driver');
                        }else
                        if (note !== null && note.length != 0 && driver_id != null) {
                            $this.$calendarObj.fullCalendar('renderEvent', {
                                title: title,
                                description: categoryClass,
                                start:start,
                                end: end,
                                driver_id: driver_id,
                                truck_id: truck_id,
                                allDay: false,
                                color:colors[categoryClass%4],
                                className: categoryClass
                            }, true);  
                                $this.$modal.modal('hide');
                                var $period = {};
                                    $period['truck_id'] = truck_id;
                                    $period['note'] = note;
                                    $period['driver_id'] = driver_id;
                                    $period['start_time'] = moment(start).format('YYYY-MM-DD HH:mm:ss');
                                    $period['end_time'] = moment(end).format('YYYY-MM-DD HH:mm:ss');
                                    add_user_working_hours($period);
                            }
                            else{
                                if (driver_id == null) {
                                    alert("Please select a driver");
                                }else {
                                    alert('You have to give a note to your event');
                                }
                            }
                        return false;
                        
                    });
                $this.$calendarObj.fullCalendar('unselect');  
    },
    CalendarApp.prototype.enableDrag = function() {
        //init events
        $(this.$event).each(function () {
            // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
            // it doesn't need to have a start or end
            var eventObject = {
                title: $.trim($(this).text()) // use the element's text as the event title
            };
            // store the Event Object in the DOM element so we can get to it later
            $(this).data('eventObject', eventObject);
            // make the event draggable using jQuery UI
            $(this).draggable({
                zIndex: 999,
                revert: true,      // will cause the event to go back to its
                revertDuration: 0  //  original position after the drag
            });
        });
    }
    /* Initializing */
    CalendarApp.prototype.init = function() {
        this.enableDrag();
        /*  Initialize the calendar  */
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var form = '';
        var today = new Date($.now());
        var my_events = [];

        my_events = get_events();
        var defaultEvents =  my_events;
        console.log(defaultEvents);

        var $this = this;
        $this.$calendarObj = $this.$calendar.fullCalendar({
            slotDuration: '00:30:00', /* If we want to split day time each 15minutes */
            minTime: '00:00:00',
            maxTime: '24:00:00',  
            defaultView: 'agendaDay',
            handleWindowResize: true,
            eventOverlap: false,
            columnHeader:true,
            allDaySlot:false,
            columnHeaderText:function(mom){
              return 'Pick a period';
            },
            header: {
                right: 'agendaDay'
            },
            events: defaultEvents,
            editable: true,
            eventDrop: function(event, delta, revertFunc) {

                // alert(event.title + " was dropped on " + event.start.format());
                alert(event.title + " can't dropped . If you want to change shift start time you can delete it and create new one");
                revertFunc();

                // if (!confirm("Are you sure about this change?")) {
                //   revertFunc();
                // }

              },
            droppable: true, // this allows things to be dropped onto the calendar !!!
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            selectOverlap : false,
            drop: function(date) { $this.onDrop($(this), date); },
            select: function (start, end, allDay) { $this.onSelect(start, end, allDay); },
            eventClick: function(calEvent, jsEvent, view) { $this.onEventClick(calEvent, jsEvent, view); },
            eventResize:function(event, end, allDay) { $this.onResize(event, end, allDay);}

        });

        for (var i = defaultEvents.length - 1; i >= 0; i--) {
        // $this.$calendar.fullCalendar('renderEvent', defaultEvents[i], true);
        console.log("periods");

        }

        //on new event
        this.$saveCategoryBtn.on('click', function(){
            var categoryName = $this.$categoryForm.find("input[name='category-name']").val();
            var categoryColor = $this.$categoryForm.find("select[name='category-color']").val();
            if (categoryName !== null && categoryName.length != 0) {
                $this.$extEvents.append('<div class="calendar-events" data-class="bg-' + categoryColor + '" style="position: relative;"><i class="fa fa-circle text-' + categoryColor + '"></i>' + categoryName + '</div>')
                $this.enableDrag();
            }
        });
    },

   //init CalendarApp
    $.CalendarApp = new CalendarApp, $.CalendarApp.Constructor = CalendarApp
    
}(window.jQuery),

//initializing CalendarApp
function($) {
    "use strict";
    $.CalendarApp.init()
}(window.jQuery);

var periods = [];
var drivers = [];
var colors = ["#23b8d1", "#f2653a", "#47b85d", "#f89732"];

function add_user_working_hours($period) {
    var Data = {};
    Data['truck_id'] = $period.truck_id;
    Data['driver_id'] = $period.driver_id;
    Data['note'] = $period.note;
    Data['start_time'] = $period.start_time;
    Data['end_time'] = $period.end_time;
    drivers[$period.driver_id] = $period.driver_id;
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
        url: '/admin/drivers/shift',
        type: 'POST',
        dataType: 'json',
        data: Data,
        async: false,
        success: function (response) {
            if (response.status == true) {
                result = response.data;
                // add_period_to_calander(result);
                periods.push(result);
                $("#eventContent").dialog('close');

            } else{
                alert(response.data);
                location.reload();
            }
        }
    });
}

function update_user_working_hours($period) {
    var Data = {};
    Data['truck_id'] = $period.truck_id;
    Data['driver_id'] = $period.driver_id;
    Data['start_time'] = $period.start_time;
    Data['end_time'] = $period.end_time;

    console.log(Data);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
        url: '/admin/drivers/shift/update',
        type: 'POST',
        dataType: 'json',
        data: Data,
        async: false,
        success: function (response) {
            if (response.status == true) {
                result = response.data;
                console.log("resized");
                console.log(result);
            } else{
                alert(response.data);
                location.reload();
            }
        }
    });
}

function get_drivers(form){
    var url = '/admin/drivers';
    var html = '';
    $.ajax({
    type: 'ajax',
    method: 'get',
    url: url,
    success: function (response) {
        if (response.status) {
            var first_sub=true;
            // $('.category-products').html('');
            var drivers = response['drivers'];
            for (var i = 0; i < drivers.length; i++) {
                var driver = drivers[i];
                html += ' <option value="'+driver['id']+'">'+ driver['first_name']+ ' ' + driver['last_name'] +'</option> '
            }   

            form.find("select[name='category']")
                    .append(html)
                    .append("</div></div>");
        }
    },
    error: function (response) {}
    });

    return html;
}

function deleteShift(event) {
    var Data = {};
    Data['truck_id'] = event.truck_id;
    Data['driver_id'] = event.driver_id;
    drivers.splice(event.driver_id,1);
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $.ajax({
        url: '/admin/drivers/shift/delete',
        type: 'POST',
        dataType: 'json',
        data: Data,
        async: false,
        success: function (response) {
            if (response.status == true) {
                result = response.data;
                periods.push(result);
                $("#eventContent").dialog('close');

            } else
                alert("Error in add new calander event");
        }
    });
}

$(document).ready(function () {
});

function get_driver_working_hours() {
    $('#calendar').fullCalendar('removeEvents');
    var truck_id = $('#truck_id').val();
    $.ajax({
        url:'/admin/drivers/get_driver_working_hours/'+truck_id ,
        type: 'GET',
        async: false,
        success: function (response) {
            if (response.status == true) {
                result = response.data;
                for (var i = 0; i < result.length; i++) {
                    add_period_to_calander(result[i]);
                }
            } else
                alert("Error in loading calander events");
        }
    });
}

function add_period_to_calander(period) {

    var title = "";
    title += "Driver Name :"+ period.first_name +" "+ period.last_name + " Note: #" + period.note;
    start = new Date(period.from);
    end = new Date(period.to);
    if (end == "00:00:00")
        end = "24:00:00";
    new_event = {
        id: period.id,
        driver_id: period.customer_id,
        position: periods.length,
        truck_id: period.truck_id,
        start: start,
        end: end,
        color: colors[period.customer_id % 4],
        title: title
    };

    return new_event;
}

function get_events_objects(periods){
var colors = ["#23b8d1", "#f2653a", "#47b85d", "#f89732"];
//full calender show the period by exact day and we want to show same data for all the days

var day = moment().date();
var month = moment().month();
var year = moment().year();
    var my_events = [];
    for (var i = 0; i < periods.length; i++) {
        var title = "";
        title += "Driver Name :"+ periods[i].first_name +" "+ periods[i].last_name + " |  Admin Note: #" + periods[i].note;
        start = $.fullCalendar.moment(periods[i].from).date(day).month(month).year(year);
        end = $.fullCalendar.moment(periods[i].to).date(day).month(month).year(year);
        if (end == "00:00:00")
            end = "24:00:00";
        var  new_event = {
            id: periods[i].id,
            title: title,
            driver_id: periods[i].customer_id,
            position: periods.length,
            truck_id: periods[i].truck_id,
            start: start,
            end: end,
            color: colors[periods[i].customer_id % 4],
            allDay: false,
            className:title

        };

        my_events.push(new_event);
    }

    return my_events;
}

function get_events() {
    var my_events = [];
    var truck_id = $('#truck_id').val();

    $.ajax({
        url:'/admin/drivers/get_driver_working_hours/'+truck_id ,
        type: 'GET',
        async: false,
        success: function (response) {
            if (response.status == true) {
                result = response.data;
               my_events = get_events_objects(result)
            } else
                alert("Error in loading calander events");
        }
    });

    return my_events;
}