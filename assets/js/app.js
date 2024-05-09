'use strict';

// Global variables

// Setup function - loads when the DOM content is loaded
const setup = () => {

  var calendar = new Calendar(calendarEl, {
    // Use bootstrap 5 theme for the styling
    themeSystem: 'bootstrap5',
    views: {
      dayGrid: {
        // options apply to dayGridMonth, dayGridWeek, and dayGridDay views
        titleFormat: { year: 'numeric', month: '2-digit', day: '2-digit' }
      },
      timeGrid: {
        // options apply to timeGridWeek and timeGridDay views
      },
      week: {
        // options apply to dayGridWeek and timeGridWeek views
      },
      day: {
        // options apply to dayGridDay and timeGridDay views
      }
    }
  });

  // Render the calendar and show it on the front end
  calendar.render();
}

// Load setup when the DOM content is loaded
document.addEventListener('DOMContentLoaded', setup);