<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>{{ $news->title }}</title>
</head>
<body style="font-family: Arial, sans-serif; background:#f6f6f6; padding:20px;">
<table width="100%" cellpadding="0" cellspacing="0">
    <tr>
        <td align="center">
            <table width="600" style="background:#ffffff; padding:20px; border-radius:8px;">
                <tr>
                    <td>
                        <h2 style="color:#111;">
                            {{ $news->title }}
                        </h2>
                        @php
                            $textContent = is_string($news->content) ? $news->content : '';
                        @endphp
                        <p style="color:#444; line-height:1.6;">
                            {!! nl2br(e(Str::limit($textContent, 1000))) !!}
                        </p>

                        <p style="margin-top:30px;">
                            <a href="{{ url('/news/' . $news->slug) }}"
                               style="background:#22c55e;color:#fff;padding:12px 20px;
                                   text-decoration:none;border-radius:6px;">
                                {{__('Читати повністю')}}
                            </a>
                        </p>

                        <hr style="margin:30px 0">

                        <p style="font-size:12px;color:#888;">
                            {{__('Ви отримали цей лист, тому що підписані на новини.')}}
                        </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
