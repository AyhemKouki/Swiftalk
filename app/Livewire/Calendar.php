<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Calendar extends Component
{
    public $events = [];

    public function mount()
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $this->loadEvents();
    }

    public function loadEvents()
    {
        // Charger uniquement les événements de l'utilisateur connecté
        $this->events = Event::forUser(Auth::id())
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start->toISOString(),
                    'end' => $event->end ? $event->end->toISOString() : null,
                    'allDay' => $event->all_day,
                    'backgroundColor' => $event->color
                ];
            })->toArray();
    }

    public function addEvent($eventData)
    {
        // Vérifier que l'utilisateur est connecté
        if (!Auth::check()) {
            return;
        }

        $event = Event::create([
            'user_id' => Auth::id(), // Associer l'événement à l'utilisateur connecté
            'title' => $eventData['title'],
            'start' => Carbon::parse($eventData['start']),
            'end' => $eventData['end'] ? Carbon::parse($eventData['end']) : null,
            'all_day' => $eventData['allDay'] ?? false,
            'color' => '#3788d8'
        ]);

        $this->loadEvents();
        $this->dispatch('eventsUpdated');
    }

    public function deleteEvent($eventId)
    {
        // Supprimer uniquement si l'événement appartient à l'utilisateur connecté
        Event::where('id', $eventId)
            ->where('user_id', Auth::id())
            ->delete();

        $this->loadEvents();
        $this->dispatch('eventsUpdated');
    }

    public function render()
    {
        return view('livewire.calendar');
    }
}
