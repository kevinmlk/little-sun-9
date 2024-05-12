'use strict';

// Global variables

// Setup function - loads when the DOM content is loaded
const setup = () => {
  // Calendar
  const calendarEl = document.querySelector('#calendar');

  let calendar = new FullCalendar.Calendar(calendarEl, {
    themeSystem: 'bootstrap5',
    initialView: 'dayGridMonth',
    headerToolbar: {
      left: 'title',
      center: 'timeGridDay,timeGridWeek,dayGridMonth',
      right: 'today prev,next'
    },
    events: 'includes/get-user-shifts.inc.php',
  });

  calendar.render();
}

// Load setup when the DOM content is loaded
document.addEventListener('DOMContentLoaded', setup);