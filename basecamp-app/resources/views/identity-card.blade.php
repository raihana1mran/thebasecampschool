<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Identity Card - {{ $user->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f1f5f9;
        }
        .card {
            width: 340px;
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0,0,0,0.25);
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .card-header {
            background: linear-gradient(135deg, #006479 0%, #40cef3 100%);
            padding: 24px 20px 20px;
            text-align: center;
            color: white;
            position: relative;
        }
        .card-header h1 {
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -0.5px;
            margin-bottom: 2px;
        }
        .card-header p {
            font-size: 10px;
            opacity: 0.8;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .photo-section {
            display: flex;
            justify-content: center;
            margin-top: -40px;
        }
        .photo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid white;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .photo span {
            font-size: 28px;
            color: #94a3b8;
        }
        .card-body {
            padding: 16px 20px 20px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #f1f5f9;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            font-size: 10px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-value {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
            text-align: right;
        }
        .info-value.highlight {
            color: #006479;
        }
        .card-footer {
            background: #f8fafc;
            padding: 12px 20px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
        .card-footer p {
            font-size: 8px;
            color: #94a3b8;
            font-weight: 600;
            letter-spacing: 0.5px;
        }
        .badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .badge-primary {
            background: rgba(0, 100, 121, 0.1);
            color: #006479;
        }
        @media print {
            body { background: white; }
            .card { box-shadow: none; border: 2px solid #e2e8f0; }
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <h1>BASECAMP</h1>
            <p>Student Identity Card</p>
        </div>
        <div class="photo-section">
            <div class="photo">
                @php
                    $photoUrl = null;
                    if ($admission && isset($admission->documents['photo']) && $admission->documents['photo']) {
                        $photoUrl = asset('storage/' . $admission->documents['photo']);
                    }
                @endphp
                @if($photoUrl)
                    <img src="{{ $photoUrl }}" alt="Photo">
                @else
                    <span class="material-symbols-outlined">person</span>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="info-row">
                <span class="info-label">Name</span>
                <span class="info-value">{{ $user->name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Enrollment No.</span>
                <span class="info-value highlight">{{ $user->enrollment_number ?? 'N/A' }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Course</span>
                <span class="info-value">
                    <span class="badge badge-primary">{{ $admission ? $admission->course_type . ' Grade' : 'N/A' }}</span>
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value" style="font-size:10px;">{{ $user->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Issue Date</span>
                <span class="info-value">{{ now()->format('d M Y') }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Valid Till</span>
                <span class="info-value">{{ now()->addYear()->format('d M Y') }}</span>
            </div>
        </div>
        <div class="card-footer">
            <p>This is a computer-generated identity card. <br> The Base Camp School, NIOS Study Centre</p>
        </div>
    </div>
    <script>window.print();</script>
</body>
</html>