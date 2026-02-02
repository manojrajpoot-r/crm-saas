<?php

namespace App\Mail;

use App\Models\Tenant\Leave;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
class LeaveAppliedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $leave;
    public $type; // applied | approved | rejected

    public function __construct(Leave $leave, $type = 'applied')
    {
        $this->leave = $leave;
        $this->type  = $type;
    }

    public function build()
    {
        $subject = match ($this->type) {
            'approved' => 'Leave Approved',
            'rejected' => 'Leave Rejected',
            default    => 'New Leave Applied',
        };

        return $this->subject($subject)
            ->view('tenant.admin.emails.leave_applied');
    }
}
