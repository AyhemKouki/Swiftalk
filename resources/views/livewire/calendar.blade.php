<div>
    @auth
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="display-4">My Calendar</h1>
                <p class="lead">Hello {{ Auth::user()->name }}, manage your personal events</p>
            </div>
            <div>
                <span class="badge bg-primary">{{ count($events) }} event(s)</span>
            </div>
        </div>
        <hr class="my-4">

        <div id='calendar'></div>

        @script
        <script type="text/javascript">
            document.addEventListener('livewire:initialized', function () {
                var calendarEl = document.getElementById('calendar');
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    selectable: true,
                    events: @json($this->events),
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    select: function(info) {
                        var title = prompt('Event title:');
                        if (title && title.trim()) {
                            // Ajouter l'événement temporairement à l'interface
                            var tempEvent = calendar.addEvent({
                                title: title,
                                start: info.start,
                                end: info.end,
                                allDay: info.allDay,
                                backgroundColor: '#3788d8'
                            });

                            // Envoyer les données au serveur
                            $wire.addEvent({
                                title: title,
                                start: info.startStr,
                                end: info.endStr,
                                allDay: info.allDay
                            }).then(() => {
                                // Recharger le calendrier avec les données du serveur
                                calendar.refetchEvents();
                            }).catch(() => {
                                // Supprimer l'événement temporaire en cas d'erreur
                                tempEvent.remove();
                                alert('Error creating event');
                            });
                        }
                        calendar.unselect();
                    },
                    eventClick: function(info) {
                        if (confirm('Do you want to delete this event: "' + info.event.title + '" ?')) {
                            var eventId = info.event.id;
                            info.event.remove();

                            // Supprimer du serveur
                            $wire.deleteEvent(eventId).catch(() => {
                                alert('Error deleting event');
                                calendar.refetchEvents();
                            });
                        }
                    },
                    eventMouseEnter: function(info) {
                        info.el.style.cursor = 'pointer';
                        info.el.title = 'Click to delete: ' + info.event.title;
                    }
                });
                calendar.render();

                // Écouter les mises à jour Livewire
                $wire.on('eventsUpdated', () => {
                    calendar.refetchEvents();
                });
            });
        </script>
        @endscript
    @else
        <div class="text-center py-5">
            <h2>Restricted Access</h2>
            <p class="lead">You must be logged in to access your personal calendar.</p>
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
        </div>
    @endauth
</div>
