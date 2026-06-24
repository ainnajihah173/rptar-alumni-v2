<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resit Derma</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f9f9f9;
        }
        .receipt {
            max-width: 600px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 150px;
            margin-bottom: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .header p {
            margin: 5px 0;
            color: #777;
        }
        .details {
            margin-bottom: 20px;
        }
        .details p {
            margin: 10px 0;
            font-size: 16px;
            color: #333;
        }
        .details p strong {
            color: #000;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: #777;
        }
        .thank-you {
            text-align: center;
            margin: 30px 0;
            padding: 20px;
            background-color: #f0f8ff;
            border-radius: 10px;
        }
        .thank-you h2 {
            margin: 0;
            font-size: 20px;
            color: #333;
        }
        .thank-you p {
            margin: 10px 0;
            font-size: 16px;
            color: #555;
        }

        /* Responsive Styles */
        @media (max-width: 600px) {
            .receipt {
                padding: 15px;
            }
            .header h1 {
                font-size: 20px;
            }
            .details p {
                font-size: 14px;
            }
            .thank-you h2 {
                font-size: 18px;
            }
            .thank-you p {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <!-- Header with Company Logo -->
        <div class="header">
            <img src="{{ public_path('assets/images/logoo.jpg') }}" alt="Company Logo" class="mb-3">
            <h1>Resit Derma</h1>
            <p>Resit Rasmi untuk Sumbangan Anda</p>
        </div>

        <!-- Donation Details -->
        <div class="details">
            <p><strong>Nombor Resit:</strong> #123{{ $donation->users->id ?? 'N/A' }}</p>
            <p><strong>Nama Penderma:</strong> {{ $donation->users->profile->full_name }}</p>
            <p>
            <strong>Jumlah Derma:</strong> RM 
            @if(auth()->check() && in_array(auth()->user()->role, ['staff', 'admin']))
                ****
            @else
                {{ number_format($donation->amount, 2) }}
            @endif
        </p>
            <p><strong>Kempen:</strong> {{ $donation->campaign->title }}</p>
            <p><strong>Tarikh Derma:</strong> {{ $donation->created_at->format('d M Y') }}</p>
            <p><strong>Status Pembayaran:</strong> {{ ucfirst($donation->payment_status) }}</p>
        </div>

        <!-- Thank You Section -->
        <div class="thank-you">
            <h2>Terima Kasih atas Sokongan Anda!</h2>
            <p>Sumbangan anda yang murah hati akan memberi impak yang besar kepada misi kami. Kami sangat menghargai sumbangan dan komitmen anda untuk membuat perubahan.</p>
            <p>Bersama-sama, kita boleh mencapai kejayaan!</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Ini adalah resit rasmi untuk derma anda. Sila simpan untuk rujukan anda.</p>
            <p>Untuk sebarang pertanyaan, sila hubungi kami di <strong>support@example.com</strong>.</p>
        </div>
    </div>
</body>
</html>