<!DOCTYPE html>
<html>
<head>
    <title>Access Logs PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .header { text-align: center; margin-bottom: 20px; }
        .badge { padding: 3px 6px; border-radius: 4px; color: white; }
        .success { background-color: #28a745; }
        .danger { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h2>Access Logs Report</h2>
        <p>Date: {{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i:s') }} WIB</p>
        @if(request('start_date'))
    <p>
        Periode: 
        {{ \Carbon\Carbon::parse(request('start_date'))->translatedFormat('d F Y') }} 
        s/d 
        {{ \Carbon\Carbon::parse(request('end_date'))->translatedFormat('d F Y') }}
    </p>
@endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Card UID</th>
                <th>Action</th>
                <th>Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $index => $log)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $log->member->name }}</td>
                <td>{{ $log->card_uid }}</td>
                <td> 
                    <span class="badge {{ $log->action == 'entry' ? 'success' : 'danger' }}">{{ $log->action == 'entry' ? 'Entry' : 'Exit' }}</span>
                </td>
                <td>{{ date('d/M/Y, H:i', strtotime($log->logged_at)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>