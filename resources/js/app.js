import './bootstrap';

import Alpine from 'alpinejs';
import { Calendar } from '@fullcalendar/core'
import timeGridPlugin from '@fullcalendar/timegrid'
import interactionPlugin from '@fullcalendar/interaction'

window.Alpine = Alpine;

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar');
    if (!calendarEl) return;

    const calendar = new Calendar(calendarEl, {
        plugins: [timeGridPlugin, interactionPlugin],
        initialView: 'timeGridWeek',
        slotMinTime: '07:00:00',
        slotMaxTime: '17:00:00',
        firstDay: 0,
        hiddenDays: [5, 6],
        selectable: true,
        select(info) {
            const title = prompt('Enter Event Title:');
            if (title) {
                fetch('/events', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        title: title,
                        start: info.startStr,
                        end: info.endStr,
                        allDay: info.allDay
                    })
                })
                .then(response => response.json())
                .then(event => {
                    calendar.addEvent({
                        id: event.id,
                        title: event.title,
                        start: event.start,
                        end: event.end,
                        allDay: event.allDay
                    });
                });
            }
            calendar.unselect();
        },
    });

    calendar.render();
})
