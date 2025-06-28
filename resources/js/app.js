import '../css/app.css';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Use dynamic imports to safely load FullCalendar
(async () => {
  const { Calendar } = await import('@fullcalendar/core');
  const dayGridModule = await import('@fullcalendar/daygrid');
  const interactionModule = await import('@fullcalendar/interaction');

  const dayGridPlugin = dayGridModule.default || dayGridModule;
  const interactionPlugin = interactionModule.default || interactionModule;

  // Example initialization (adjust selector as needed)
  document.addEventListener('DOMContentLoaded', () => {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
      new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin],
        initialView: 'dayGridMonth',
      }).render();
    }
  });
})();
