<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        .email-content {
            font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
        }
        .email-content p {
            margin-top: 0;
            margin-bottom: 10px;
            line-height: 1.5;
        }

        .email-content h1,
        .email-content h2,
        .email-content h3,
        .email-content h4,
        .email-content h5 {
            font-size: 18px;
            font-weight: 700;
            margin: 0 0 15px 0;
            line-height: 1.5;
        }

        .email-content ol,
        .email-content ul {
            padding: 0 0 10px 0;
            margin: 0 0 10px 0;
            list-style-position: inside;
        }
        /* CLIENT-SPECIFIC STYLES */
        p {
            font-size: 16px;
        }
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol';
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>
@php
    const STATUS = [
        0 => '??ang x??? l??',
        1 => '???? x??? l??',
        2 => 'Ho??n th??nh',
        3 => '???? h???y'
    ];

    const METHODS_PAYMENT = [
        1 => 'Chuy???n kho???n qua TK ng??n h??ng',
        2 => 'Thanh to??n b???ng Pcoin',
        3 => 'Thanh to??n b???ng QR MOMO',
        4 => 'Thanh to??n b???ng QR VNPAY',
        5 => 'Thanh to??n b???ng QR VIETTEL PAY',
    ];

@endphp
<body style="background-color: #f4f4f4; padding: 60px 0 !important;">
<div style="max-width: 600px; margin: auto; background-color: #fff; border-radius: 5px">
    <table border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <img src="{{ asset('assets/img/logo.png') }}" style="display: block; border: 0; margin: auto; width: 200px; height: auto" />
            </td>
        </tr>
        <tr>
            <td>
                <p style="margin-bottom: 15px; padding: 0 20px">Thanh to??n ????n h??ng th??nh c??ng. D?????i ????y l?? th??ng tin s???n ph???m c???a b???n</p>
                <p style="margin-bottom: 15px; padding: 0 20px">N???u c?? th???c m???c, vui l??ng li??n h??? fanpage <a href="https://www.facebook.com/PaimonTopup/">Paimonshop</a>, ????? ???????c h??? tr???</p>
            </td>
        </tr>
    </table>

    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="border-bottom: 1px solid #ccc; padding-bottom: 10px" colspan="2">
                <p style="margin: 0; padding: 0 20px; font-weight: 800; font-size: 22px;">
                    Th??ng tin ????n h??ng #{{ $order->id }} - {{ date('d/m/Y H:i', strtotime($order->created_at)) }}
                </p>
            </td>
        </tr>

        <tr>
            <td><p style="padding: 10px 0 0 20px; margin: 0"><b>Kh??ch h??ng:</b> {{ $order->name }}</p></td>
        </tr>

        <tr>
            <td><p style="padding: 10px 0 0 20px; margin: 0"><b>S??? ??i???n tho???i: </b> {{ $order->phone }}</p></td>
        </tr>
        <tr>
            <td><p style="padding: 10px 0 0 20px; margin: 0"><b>?????a ch???:</b> {{ $order->address }}</p></td>
        </tr>

        <tr>
            <td><p style="padding: 10px 0 0 20px; margin: 0"><b>Email: </b> {{ $order->email }}</p></td>
        </tr>
        <tr>
            <td><p style="padding: 10px 0 10px 20px; margin: 0"><b>T??nh tr???ng ????n h??ng:</b> {{ STATUS[$order->status] }}</p></td>
        </tr>

        @if (!empty($order->facebook))
            <tr>
                <td><p style="padding: 10px 0 10px 20px; margin: 0"><b>Facebook: </b> {{ ($order->facebook) }}</p></td>
            </tr>
        @endif


    </table>
</div>

@php
    $accInfo = (array) json_decode($order->acc_info);
@endphp

@if(!empty($accInfo))
    <!-- th??ng tin t??i kho???n -->
    <div style="max-width: 600px; margin: 20px auto 0 auto; background-color: #fff; border-radius: 5px">

        <table border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="border-bottom: 1px solid #ccc; padding: 20px 0 10px 0;" colspan="2">
                    <p style="margin: 0; padding: 0 20px; font-weight: 800; font-size: 22px;">
                        Th??ng tin t??i kho???n ingame
                    </p>
                </td>
            </tr>

            @foreach($accInfo as $key => $item)
                <tr>
                    <td colspan="2" style="padding: 10px 20px 10px 20px; display: block; margin-bottom: 10px; background-color: #4267B2; color: #f1f1f1; text-transform: uppercase; font-weight: 700; font-size: 14px">T??i kho???n {{ $key + 1 }}</td>
                </tr>
                <tr>
                    <td>
                        <p style="padding: 0px 0 0 30px; margin: 0">
                            <b>T??n t??i kho???n:</b> {{ !empty($item->username) ? $item->username : '' }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="padding: 10px 0 0 30px; margin: 0">
                            <b>M???t kh???u:</b> {{ !empty($item->password) ? $item->password : '' }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="padding: 10px 0 0 30px; margin: 0">
                            <b>N???n t???ng:</b> {{ !empty($item->platform) ? $item->platform : '' }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="padding: 10px 0 0 30px; margin: 0">
                            <b>Server:</b> {{ !empty($item->server) ? $item->server : '' }}
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="padding: 10px 0 10px 30px; margin: 0">
                            <b>T??n nh??n v???t - c???p ?????:</b> {{ !empty($item->charactername) ? $item->charactername : '' }}
                        </p>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endif
<div class="email-content" style="max-width: 600px; margin: 20px auto 0 auto; background-color: #fff; border-radius: 5px">
    <p style="margin: 0; padding: 0 20px; font-weight: 800; font-size: 22px;">Th??ng tin s???n ph???m</p>
    <div style="padding: 1rem;">
        {!! $order->email_content !!}
    </div>
</div>
<div style="max-width: 600px; margin: 20px auto 0 auto; background-color: #fff; border-radius: 5px">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td bgcolor="#d25645" align="center" style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #f1f1f1; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 18px; font-weight: 400; line-height: 25px;">
                <h2 style="font-size: 20px; font-weight: 400; color: #f1f1f1; margin: 0;">Th??ng tin li??n h???</h2>
                <p style="margin: 0;">Paimonshop - H??? th???ng n???p game chi???t kh???u</p>
                <p style="margin: 0;">?????a ch???: L???i Xu??n, Th???y Nguy??n, H???i Ph??ng</p>
                <p style="margin: 0;">S??? ??T: <a href="tel:0329141615" style="color: #f1f1f1;">0329141615</a></p>
                <p style="margin: 0;">Fanpage FB: <a href="https://www.facebook.com/PaimonTopup" style="color: #f1f1f1;">Click v??o ????y</a></p>
                <p style="margin: 0;">Discord Group: <a href="https://discord.gg/7KrR7W37" style="color: #f1f1f1;">discord.gg/7KrR7W37</a></p>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="left" style="color: #666666; font-family: -apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif,'Apple Color Emoji','Segoe UI Emoji','Segoe UI Symbol'; font-size: 14px; font-weight: 400; line-height: 18px;"> <br>
                <p style="margin: 0;">Email n??y ???????c g???i t??? ?????ng t??? h??? th???ng website <a href="{{ url('/') }}" target="_blank" style="color: #111111; font-weight: 700;">Paimonshop.com</a>. Vui l??ng kh??ng tr??? l???i email n??y</p>
            </td>
        </tr>
    </table>
</div>
</body>

</html>
