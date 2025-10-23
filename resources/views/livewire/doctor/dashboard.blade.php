<div>
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Doctor Dashboard</h2>
        <p class="text-gray-600">Welcome back, Dr. {{ auth()->user()->name }}</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Today's Appointments -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Today's Appointments</h3>
           {{-- @if($todayAppointments->count() > 0)
                <div class="space-y-3">
                    @foreach($todayAppointments as $appointment)
                        <div class="border-l-4 border-blue-500 pl-4 py-2">
                            <p class="font-medium">{{ $appointment->patient->name }}</p>
                            <p class="text-sm text-gray-600">{{ $appointment->appointment_date->format('H:i') }}</p>
                            <button wire:click="completeAppointment({{ $appointment->id }})"
                                    class="mt-2 bg-green-500 text-white px-3 py-1 rounded text-sm">
                                Complete
                            </button>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No appointments today</p>
            @endif--}}
        </div>

        <!-- Recent Appointments -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Recent Appointments</h3>
            <div class="space-y-3">
                {{--@foreach($appointments as $appointment)
                    <div class="border-b pb-3">
                        <p class="font-medium">{{ $appointment->patient->name }}</p>
                        <p class="text-sm text-gray-600">{{ $appointment->appointment_date->format('M d, Y H:i') }}</p>
                        <span class="inline-block px-2 py-1 text-xs rounded
                            {{ $appointment->status === 'scheduled' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                            {{ $appointment->status }}
                        </span>
                    </div>
                @endforeach--}}
            </div>
        </div>
    </div>
</div>
