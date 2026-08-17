<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #222; }
        h2 { margin: 0 0 6px; font-size: 16px; }
        .meta { margin-bottom: 12px; color: #555; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 5px 6px; text-align: left; }
        th { background: #f3f4f8; }
        td.num, th.num { text-align: right; }
        .summary { margin-bottom: 12px; }
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
    <div class="meta">
        @if(!empty($from) || !empty($to))
            {{ __('admin.From Date') }}: {{ $from ?? '-' }} &nbsp; {{ __('admin.To Date') }}: {{ $to ?? '-' }}
        @endif
        &nbsp; {{ now()->format('d M Y H:i') }}
    </div>
    @if(!empty($summary))
    <table class="summary">
        @foreach($summary as $label => $value)
        <tr><th>{{ $label }}</th><td class="num">{{ $value }}</td></tr>
        @endforeach
    </table>
    @endif
    <table>
        <thead>
            <tr>
                @foreach($headings as $heading)
                <th>{{ $heading }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $row)
            <tr>
                @foreach($row as $cell)
                <td>{{ $cell }}</td>
                @endforeach
            </tr>
            @empty
            <tr><td colspan="{{ max(1, count($headings)) }}">{{ __('admin.No data found') }}</td></tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
