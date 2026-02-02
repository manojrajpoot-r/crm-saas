<div style="max-width:650px;margin:auto;background:#ffffff;border-radius:10px;
            box-shadow:0 8px 30px rgba(0,0,0,0.08);
            font-family:'Segoe UI',sans-serif;overflow:hidden">

    {{-- Header --}}
    <div style="background:#0d6efd;padding:20px;color:#fff">
        <h2 style="margin:0;font-size:22px">Leave Application</h2>
        <p style="margin:5px 0 0;font-size:14px;opacity:.9">
            Applied by {{ $leave->user->name }}
        </p>
    </div>

    {{-- Body --}}
    <div style="padding:25px">

        <table width="100%" cellpadding="0" cellspacing="0" style="font-size:14px">
            <tr>
                <td style="padding:8px 0;color:#666;width:35%">Leave Type</td>
                <td style="padding:8px 0;font-weight:600">
                    {{ $leave->leaveType->name }}
                </td>
            </tr>

            <tr>
                <td style="padding:8px 0;color:#666">Start Date</td>
                <td style="padding:8px 0;font-weight:600">
                    {{ format_date($leave->start_date) }}
                </td>
            </tr>

            <tr>
                <td style="padding:8px 0;color:#666">End Date</td>
                <td style="padding:8px 0;font-weight:600">
                    {{ format_date($leave->end_date) }}
                </td>
            </tr>

            <tr>
                <td style="padding:8px 0;color:#666">Total Days</td>
                <td style="padding:8px 0;font-weight:600">
                    {{ $leave->total_days }}
                </td>
            </tr>

            <tr>
                <td style="padding:8px 0;color:#666;vertical-align:top">Reason</td>
                <td style="padding:8px 0">
                    {!! $leave->reason !!}
                </td>
            </tr>
        </table>

        {{-- Status --}}
        <div style="margin-top:25px">
            <span style="
                padding:6px 14px;
                border-radius:20px;
                font-size:13px;
                font-weight:600;
                color:#fff;
                background:
                {{ $leave->status === 'approved' ? '#198754' :
                   ($leave->status === 'rejected' ? '#dc3545' : '#ffc107') }};
            ">
                {{ ucfirst($leave->status) }}
            </span>
        </div>

    </div>

    {{-- Footer --}}
    <div style="background:#f8f9fa;padding:15px;text-align:center;
                font-size:12px;color:#888">
        This is an automated message. Please do not reply.
    </div>

</div>
