<?php

namespace App\Notifications\Shop;

use App\Models\Shop\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskFailed extends Notification implements ShouldQueue
{
    use Queueable;

    private Task $task;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via(mixed $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

//    public function toBroadcast($notifiable): BroadcastMessage
//    {
//        return new BroadcastMessage([
//            'task_id' => $notifiable->task->task_id
//        ]);
//    }
//
//    public function toDatabase($notifiable)
//    {
//        return [
//            'task_id' => $notifiable->task->task_id
//        ];
//    }
}
