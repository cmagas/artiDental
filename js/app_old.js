$(document).ready(function() {
    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },

        locales: 'es',

        defaultDate: new Date(),
        defaultView: 'agendaWeek',
        buttonIcons: true,
        weekNumbers: false,
        editable: false,
        eventLimit: true,
        timeFormat: 'H(:mm)',
        events: [
            {
                title: 'All Day Event',
                description: 'Lorem ipsum 1...',
                start: '2019-07-01',
                color: '#3A87AD',
                textColor: '#ffffff',
            }
        ],
        timeFormat: {
            agenda: 'h(:mm)tt { - h(:mm)tt}'
        },
        

        
    });
});