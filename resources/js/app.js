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
        timeZone: 'Asia/Riyadh',
        initialView: 'timeGridWeek',
        slotMinTime: '07:00:00',
        slotMaxTime: '17:00:00',
        firstDay: 0,
        hiddenDays: [5, 6],
        eventDisplay: 'block',
        eventTimeFormat: {
            hour: 'numeric',
            minute: '2-digit',
            meridiem: 'short',
            hour12: false
        },
        events: function(fetchInfo, successCallback, failureCallback) {
            fetch(`/events?start=${fetchInfo.startStr}&end=${fetchInfo.endStr}`)
                .then(res => res.json())
                .then(events => {
                    console.log("Fetched events:", events);
                    const enhancedEvents = events.map(event => ({
                        ...event,
                        extendedProps: {
                            provision_id: event.provision_id
                        }
                    }));
                    successCallback(enhancedEvents);
                })
                .catch(failureCallback);
        },
        selectable: false,
        eventDidMount: function(info) {
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.height = '100%';
            wrapper.style.width = '100%';

            const logButton = document.createElement('button');
            logButton.textContent = info.event.extendedProps.logged ? 'Logged' : 'Log';
            logButton.className = 'absolute right-1 top-1 px-1 py-0.5 bg-blue-500 text-white text-xs rounded hover:bg-blue-600';

            logButton.style.display = 'block';
            logButton.style.position = 'absolute';
            logButton.style.bottom = '2px';
            logButton.style.right = '2px';

            logButton.onclick = function(e) {
                e.stopPropagation();
                const modal = document.getElementById('log-modal');
                if (!modal) return;

                modal.querySelector('[name="title"]').value = info.event.title;
                modal.querySelector('[name="start_time"]').value = info.event.start.toISOString();
                modal.querySelector('[name="end_time"]').value = info.event.end.toISOString();
                modal.querySelector('[name="provision_id"]').value = info.event.extendedProps.provision_id;

                if (info.event.extendedProps.logged) {
                    modal.querySelector('[name="entry"]').value = info.event.extendedProps.log_entry;
                    modal.querySelector('[name="entry"]').setAttribute('readonly', true);
                    modal.querySelector('#log-form button[type="submit"]').style.display = 'none';
                } else {
                    modal.querySelector('[name="entry"]').value = '';
                    modal.querySelector('[name="entry"]').setAttribute('readonly', true); // readonly even when no log yet
                    modal.querySelector('#log-form button[type="submit"]').style.display = 'none'; // hide save button
                }

                modal.classList.remove('hidden');

                const existingDelete = modal.querySelector('#delete-log-btn');
                if (existingDelete) existingDelete.remove();

                if (info.event.extendedProps.logged) {
                    const deleteBtn = document.createElement('button');
                    deleteBtn.id = 'delete-log-btn';
                    deleteBtn.textContent = 'Delete';
                    deleteBtn.className = 'mt-4 px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700';

                    deleteBtn.onclick = async function() {
                        if (confirm('Are you sure you want to delete this log?')) {
                            const response = await fetch(`/provision-logs/delete`, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                },
                                body: JSON.stringify({
                                    provision_id: info.event.extendedProps.provision_id,
                                    start_time: info.event.start.toISOString()
                                })
                            });

                            if (response.ok) {
                                alert('Log deleted.');
                                modal.classList.add('hidden');
                                calendar.refetchEvents();
                            } else {
                                alert('Error deleting log.');
                            }
                        }
                    };

                    modal.querySelector('form').appendChild(deleteBtn);
                }
            };

            const content = document.createElement('div');
            while (info.el.firstChild) {
                content.appendChild(info.el.firstChild);
            }
            wrapper.appendChild(content);
            wrapper.appendChild(logButton);
            info.el.appendChild(wrapper);
        },
    });

    calendar.render();

    // Insert "Log" button above the calendar
    const logButton = document.createElement('button');
    logButton.textContent = 'Log';
    logButton.className = 'mb-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700';
    logButton.style.display = 'inline-block';
    logButton.onclick = function () {
        window.location.href = '/logs/create';
    };

    calendarEl.parentElement.insertBefore(logButton, calendarEl);
})
