<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Course;

class CourseCreated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(public Course $course) {}

    public function broadcastOn()
    {
        return new Channel('courses');
    }

    public function broadcastWith()
    {
        return [
            'course' => $this->course->load('instructor'),
            'message' => 'New course created: ' . $this->course->title,
            'timestamp' => now()->toISOString()
        ];
    }

    public function broadcastAs()
    {
        return 'course.created';
    }
}

