<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowAttendanceNotification extends Notification
{
    use Queueable;

    protected $percantage;
    protected $courseName;

    /**
     * Create a new notification instance.
     */
    public function __construct($percentage, $courseName)
    {
         $this->percantage = $percentage;
        $this->courseName = $courseName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('⚠️ تنبيه حول حضورك')
            ->greeting('مرحباً ' . $notifiable->name)
            ->line("لقد انخفضت نسبة حضورك في دورة {$this->courseName} إلى {$this->percantage}%.")
            ->line('الحد الأدنى المسموح هو 70%. يرجى الالتزام بالحضور.')
            ->action('تسجيل الدخول للنظام', url('/'))
            ->line('شكراً لتعاونك معنا 🙏');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
